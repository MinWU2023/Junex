<?php

namespace App\Services;

use App\Modules\AddonsMarket\Models\Addon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use PhpZip\ZipFile;


class AddonsService
{
    public $remoteUrl = 'https://api.dyycloud.com';
    public $loginUrlKey = '/api/auth/login';
    public $getAddonsListUrlKey = '/api/admin/extensionMarket/getFavorite';
    public $path;
    /**
     * @var Filesystem
     */
    public $file;

    public $providersMapFile;

    const ADDONS_TOKEN = 'addons_access_token';

    public function __construct()
    {
        $this->path = base_path('addons');
        $this->providersMapFile = base_path('addons/addons_service_provider.json');
        $this->file = app()->make(Filesystem::class);
    }


    public function isLogin()
    {
        if ($this->getAccessToken()) {

            return true;
        }

        return false;
    }

    public function login($username, $password)
    {
        $url = $this->remoteUrl . $this->loginUrlKey;
        $data = [
            'username' => $username,
            'password' => $password,
            'provider' => 'admin'
        ];
        $response = Http::withOptions(['verify' => false])->withHeaders([
            'Accept' => 'application/json, text/plain, */*',
        ])->post($url, $data);
        return $response;
    }

    /**
     * 获取全部插件.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function addons()
    {
        $url = $this->remoteUrl . $this->getAddonsListUrlKey;
        $addons = Addon::all();
        $myAddons = [];
        foreach ($addons as $addon) {
            $myAddons[$addon->sign] = $addon->toArray();
        }
        $response = Http::withOptions(['verify' => false])->withHeaders(['authorization' => 'Bearer ' . $this->getAccessToken()])->get($url);
        $response = json_decode($response, true);
        foreach ($response['data'] as $key => $value) {
            $response['data'][$key]['is_upgrade'] = false;
            if (isset($myAddons[$value['theCode']])) {
                $response['data'][$key]['inject'] = $myAddons[$value['theCode']];
                if (version_compare($value['version'], $myAddons[$value['theCode']]['version'])) {
                    $response['data'][$key]['is_upgrade'] = true;
                }
            }
        }
        return $response;
    }

    /**
     * 生成ServiceProviderMapping.
     * @param string $except
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function reGenProvidersMap($except = '')
    {
        $addons = $this->addons();
        if (!$addons) {
            return;
        }
        $providersBox = [];
        foreach ($addons as $dir => $addon) {
            $sign = pathinfo($dir, PATHINFO_FILENAME);
            $providersBox = array_merge($providersBox, $this->getAddonsServiceProvider($sign, $except));
        }
        if (!$providersBox) {
            return;
        }
        $this->file->put($this->providersMapFile, json_encode($providersBox));
    }

    /**
     * 获取插件的ServiceProvider
     * @param $sign
     * @param string $except
     * @return array
     */
    public function getAddonsServiceProvider($sign, $except = '')
    {
        $dir = base_path('addons/' . $sign);
        $providers = $this->file->glob($dir . DIRECTORY_SEPARATOR . '*ServiceProvider.php');
        if (!$providers) {
            return [];
        }
        $providersBox = [];
        foreach ($providers as $provider) {
            $providerName = pathinfo($provider, PATHINFO_FILENAME);
            $namespace = "\\Addons\\{$sign}\\{$providerName}";
            if ($except && Str::contains($namespace, $except)) {
                continue;
            }
            $providersBox[] = $namespace;
        }
        return $providersBox;
    }

    /**
     * @return array|mixed
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getProvidersMap()
    {
        if (!$this->file->exists($this->providersMapFile)) {
            return [];
        }

        return json_decode($this->file->get($this->providersMapFile), true);
    }

    public function upgradeAddons(Request $request)
    {
        $response = [];
        $response['status'] = false;
        $theCode = $request->get('theCode');
        $addon = Addon::where('sign', $theCode)->first();
        if ($addon) {
            $this->downloadAddons($theCode, $request->zip);
            try {
                $this->enabled($theCode);
                $this->upgrade($theCode);
                $addon->version = $request->version;
                $response['status'] = true;
            } catch (\Exception $exception) {
                $addon->error_msg = $exception->getMessage();
                $response['error_msg'] = $exception->getMessage();
            } finally {
                $addon->save();
            }
        } else {
            $response['error_msg'] = '插件标识码不正确，请检查';
        }
        return $response;
    }

    public function uninstallAddons(Request $request)
    {
        $response = [];
        $response['status'] = false;
        $theCode = $request->get('sign');
        try {
            $this->disabled($theCode);
            $this->uninstall($theCode);
            Storage::disk('disk')->deleteDirectory('/addons/' . $theCode);
            DB::table('addons')->where('sign', $theCode)->delete();
            $response['status'] = true;
        } catch (\Exception $exception) {
            $response['error_msg'] = $exception->getMessage();
        }
        return $response;
    }

    public function installAddons(Request $request)
    {
        $response = [];
        $response['status'] = false;
        if ($theCode = $request->get('theCode')) {
            Addon::where('sign', $theCode)->first();
            if (DB::table('addons')->where('sign', $theCode)->exists()) {
                $response['error_msg'] = '插件已被安装，请检查';
            } else {
                $add = [];
                $add['name'] = $request->get('name');
                $add['sign'] = $theCode;
                $add['version'] = $request->get('version');
                $add['status'] = 0;
                try {
                    $addon = Addon::create($add);

                    $this->downloadAddons($add['sign'], $request->zip);
                    $this->enabled($add['sign']);
                    $this->install($add['sign']);
                    $addon->status = 1;
                    $addon->configuration = $this->getConfiguration($request->get('theCode'));
                    $response['status'] = true;
                } catch (\PDOException $exception) {
                    $response['error_msg'] = $exception->getMessage();
                    $addon->error_msg = $exception->getMessage();
                } catch (\Exception $exception) {
                    $addon->status = 2;
                    $addon->error_msg = $exception->getMessage();
                    $response['error_msg'] = $exception->getMessage();
                }
                $addon->save();
            }
        }
        return $response;
    }

    /**
     * 启用插件
     *
     * @param $sign
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function enabled($sign)
    {
        $path = base_path('addons/' . $sign);
        if (!$this->file->isDirectory($path)) {
            throw new \Exception('插件不存在');
        }
        $providers = $this->file->glob($path . DIRECTORY_SEPARATOR . '*ServiceProvider.php');
        if (empty($providers)) {
            throw new \Exception('插件完整');
        }
        $providersBox = [];
        foreach ($providers as $provider) {
            $providerName = pathinfo($provider, PATHINFO_FILENAME);
            $namespace = "\\Addons\\{$sign}\\{$providerName}";
            $providersBox[] = $namespace;
        }
        $loadedProviders = $this->getProvidersMap();
        $loadedProviders = array_unique(array_merge($loadedProviders, $providersBox));
        $this->file->put($this->providersMapFile, json_encode($loadedProviders));
    }

    /**
     * 禁用插件
     *
     * @param $sign
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function disabled($sign)
    {
        $loadedProviders = $this->getProvidersMap();
        $data = [];
        foreach ($loadedProviders as $loadedProvider) {
            $arr = explode('\\', $loadedProvider);
            if ($arr[2] != $sign) {
                $data[] = $loadedProvider;
            }
        }

        $this->file->put($this->providersMapFile, json_encode($data));
    }

    public function install($sign)
    {
        $this->registerAddonsServiceProvidersNow($sign);
        Artisan::call($sign . ' install');
    }

    public function uninstall($sign)
    {
        $this->registerAddonsServiceProvidersNow($sign);
        Artisan::call($sign, ['action' => 'uninstall']);
    }

    public function upgrade($sign)
    {
        $this->registerAddonsServiceProvidersNow($sign);
        Artisan::call($sign, ['action' => 'upgrade']);
    }

    /**
     * 立刻注册插件的服务
     * @param $sign
     */
    public function registerAddonsServiceProvidersNow($sign)
    {
        $services = $this->getAddonsServiceProvider($sign);
        if ($services) {
            foreach ($services as $service) {
                app()->register($service);
            }
        }
    }

    public function getAccessToken()
    {
        return session(self::ADDONS_TOKEN);
    }

    public function setAccessToken($token)
    {
        return session([self::ADDONS_TOKEN => $token]);
    }

    private function getConfiguration($sign): string
    {
        $file_path = 'addons/' . $sign . '/dyyseo.json';
        $jsonData = json_decode(Storage::disk('disk')->get($file_path), true);
        return isset($jsonData['field']) ? json_encode($jsonData['field']) : '';
    }

    private function downloadAddons($sign, $zipPath)
    {
        $storagePath = storage_path('app/addons/' . $sign . '_' . time() . random_int(0, 100) . '.zip');
        $http = new Client(['verify'=> false]);
        $http->get($zipPath, [
            'sink' => $storagePath,
        ]);
        try {
            $zip = new ZipFile();
            $zip->openFile($storagePath)->extractTo(base_path('addons'));
        } catch (\Exception $exception) {
        }
    }
}
