<?php


namespace App\Modules\AddonsMarket\Controllers;

use App\Modules\AddonsMarket\Models\Addon;
use App\Modules\Setting\Models\Setting;
use App\Services\AddonsService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpZip\ZipFile;
use Illuminate\Support\Facades\Storage;
use Addons\Cloud\Http\Middleware\CheckWebsiteTokenMiddleware;

class AddonsMarketController extends Controller
{

    use ResponseTrait;

    private $addonsService;
    private $file;

    /**
     * AddonMarketController constructor.
     */
    public function __construct(AddonsService $addonsService)
    {
        $this->middleware(CheckWebsiteTokenMiddleware::class)->only('tagManagerCodePull');
        $this->addonsService = $addonsService;
        $this->file = Storage::disk('disk');
    }

    public function index(Request $request)
    {
//        return redirect('http://tg.dyycloud.com/addons');
        $data = [];
        $data['guest'] = false;
        if (!$this->addonsService->isLogin()) {
            $data['guest'] = true;
        } else {
            if ($request->ajax() || $request->wantsJson()) {
                $response = $this->addonsService->addons();
                return $response;
            }
        }
        return view('AddonsMarket.Views.AddonsMarket.index', compact('data'));
    }

    public function login()
    {
        return view('AddonsMarket.Views.AddonsMarket.login');
    }

    public function doLogin(Request $request)
    {
        $response = $this->addonsService->login($request->username, $request->password);
        if (isset($response['errors'])) {
            return $this->badRequest($response['message']);
        }
        $this->addonsService->setAccessToken($response['data']['token']);
        return $this->success();
    }

    public function uninstall(Request $request)
    {
        $request->offsetSet('sign', $request->get('theCode'));
        $response = $this->addonsService->uninstallAddons($request);
        if ($response['status']) {
            return $this->success();
        } else {
            return $this->badRequest($response['error_msg']);
        }
    }

    public function installCloud(Request $request)
    {
        $response = [];
        $response['status'] = false;
        $sign = $request->get('sign');
        $addon = Addon::query()->where('sign', $sign)->first();
        if ($addon) {
            $response['error_msg'] = '插件已经安装，请检查';
        } else {
            $result = $this->addonsService->installAddons($request);
            if ($result['status']) {
                $setting = Setting::first();
                $setting->website_token = $request->get('token');
                $setting->save();
                $response['status'] = true;
            } else {
                $response['error_msg'] = $result['error_msg'];
            }
        }
        return $response;
    }

    public function install(Request $request)
    {
        $response = $this->addonsService->installAddons($request);
        if ($response['status']) {
            return $this->success();
        } else {
            return $this->badRequest($response['error_msg']);
        }
    }

    public function upgrade(Request $request)
    {
        $response = $this->addonsService->upgradeAddons($request);
        if ($response['status']) {
            return $this->success();
        } else {
            return $this->badRequest($response['error_msg']);
        }
    }


    public function edit($id)
    {
        $addon = Addon::where(['id' => $id])->first();
        $configuration = json_decode($addon['configuration'], true);
        return view('AddonsMarket.Views.AddonsMarket.edit', compact('configuration', 'id'));
    }

    public function update($id, Request $request)
    {
        try {
            $addon = Addon::find($id);
            $data = $request->post();
            unset($data['_token']);
            $addon->configuration = json_encode($data);
            $addon->save();
        } catch (\PDOException $PDOException) {
            Log::error($this->modelName . ':update:更新失败，错误原因为：' . $PDOException->getMessage());
            return $this->badRequest();
        }

        return $this->success();
    }

    public function getConfiguration($sign): string
    {
        $file_path = 'addons/' . $sign . '/dyyseo.json';
        $jsonData = json_decode(Storage::disk('disk')->get($file_path), true);
        return isset($jsonData['field']) ? json_encode($jsonData['field']) : '';
    }


    public function tagManagerCodePull(Request $request)
    {
        $head_code = $request->post('head_code');
        $response = ['status' => false];
        if (!empty($head_code)) {
            $setting = Setting::first();
            $setting->head_code = $head_code;
            $setting->save();

            $reportInstall = Addon::where('sign', 'WebsiteReport')->first();
            if ($reportInstall) {
                $response['status'] = true;
            }
        }
        return $response;

    }
}
