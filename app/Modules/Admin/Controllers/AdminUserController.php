<?php


namespace App\Modules\Admin\Controllers;


use App\Models\EmailSend;
use App\Http\Requests\InquiryRequest;
use App\Models\LoginLog;
use App\Modules\Admin\Models\AdminLog;
use App\Modules\Admin\Models\LoginAccessToken;
use App\Modules\Admin\Models\User;
use App\Modules\Admin\Models\UserSession;
use App\Modules\Common\Controllers\BaseController;
use App\Modules\Inquiry\Models\Inquiry;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductCategory;
use App\Modules\Setting\Models\Setting;
use App\Services\GeoLiteService;
use App\Modules\Download\Models\Download;
use App\Models\DownloadUser;
use App\Services\ProductService;
use App\Services\GibberishDetectionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Mail\Message;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Jenssegers\Agent\Facades\Agent;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class AdminUserController extends BaseController
{
    public function __construct(User $user)
    {
        $this->modelName = 'User';
        $this->model = $user->with(['roles']);
        $this->viewPath = 'Admin.Views.User';
        \request()->getMethod() === 'POST' ?
            $this->validatorData = [
                'name' => 'required',
                'email' => 'required|email|Unique:users,email',
                'password' => 'required|confirmed',
            ] :
            $this->validatorData = [
                'name' => 'required',
                'email' => 'required|email|exists:users,email',
            ];
    }


    public function inquirySuccess(Request $request)
    {
        $email = $request->get('email');
        if ($this->validEmail($email)) {
            return view('layouts.front.success-high-risk', [
                'email' => $request->get('email')
            ]);
        }
        abort(404);
    }

    protected function validEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }



    public function download($token)
    {
        $download = Download::where('download_key', $token)->first();
        if (!$download) {
            abort(404);
        }

        $ip = GetUserIP();
        $geoLiteService = new GeoLiteService();
        $ipAddress = $geoLiteService->getLocationByIp($ip);

        $record = DownloadUser::firstOrNew([
            'download_id' => $download->id,
            'ip' => $ip,
        ]);

        if ($record->exists) {
            $record->increment('download_count');
        } else {
            $record->ip_address = $ipAddress;
            $record->download_count = 1;
            $record->save();
        }

        // If it's a file path, serve the file directly with the name from database
        if ($download->getRawOriginal('filepath') && file_exists(public_path($download->getRawOriginal('filepath')))) {
            $filePath = public_path($download->getRawOriginal('filepath'));
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
            $fileName = $download->name . '.' . $extension;

            // 如果是PDF文件，使用streamDownload
            if (strtolower($extension) === 'pdf') {
                return response()->streamDownload(
                    function () use ($filePath) {
                        echo file_get_contents($filePath);
                    },
                    $fileName
                );
            }

            // 其他文件类型使用普通download
            return response()->download($filePath, $fileName);
        }

        // If it's a URL, redirect to it
        if ($download->url) {
            return redirect($download->url);
        }

        abort(404);
    }

    public function chatGpt(Request $request)
    {
        $res = Http::asForm()->post('http://gpt.dyyyun.com/api/getLoginUrl', [
            'username' => auth()->user()->email,
            'token' => app('settings')['setting']->website_id
        ]);
        $result = $res->json();
        return  $this->data([
            'status' => $result['status'],
            'url' => 'http://gpt.dyyyun.com/user/' . $result['result'],
        ]);
    }

    public function store(Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->all(), $this->validatorData);

        if (!$validator->passes()) {
            return response()->json([
                'code' => 422,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $translate = $request->get('translate');
        is_array($translate) ? $add = array_merge($translate, $request->all()) : $add = $request->all();
        try {
            $add['password'] = Hash::make($add['password']);
            $model = $this->model->create($add);
            $this->assignRole($request->get('role'), $model);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':store，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

    public function update($id, Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->all(), $this->validatorData);
        if (!$validator->passes()) {
            return response()->json([
                'code' => 422,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $model = $this->model->find($id);
        $translate = $request->get('translate');
        is_array($translate) ? $update = array_merge($translate, $request->all()) : $update = $request->all();
        try {
            if ($update['password'] && !is_null($update['password'])) {
                $update['password'] = Hash::make($update['password']);
            } else {
                unset($update['password']);
            }
            $model->update($update);
            $this->assignRole($request->get('role'), $model);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':update:更新失败，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

    public function destroy($id)
    {
        $model = $this->model->find($id);
        if ($model->id === 1) {
            return $this->badRequest('此用户无法被删除');
        }
        try {
            $model->delete();
        } catch (\PDOException $exception) {
            Log::error($this->model . ':destroy，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

    private function assignRole($id, User $user)
    {
        $role = Role::find($id);
        if ($role) {
            $user->syncRoles($role);
        }
    }


    public function apiLogin(Request $request)
    {
        LoginAccessToken::where('deadline_time', '<', date('Y-m-d H:i:s'))->delete();
        $access_token = $request->get('access_token');
        $login = LoginAccessToken::where(['access_token' => $access_token, 'status' => 0])->where('deadline_time', '>=', date('Y-m-d H:i:s'))->first();
        if ($login) {
            $login->status = 1;
            $login->save();
            Auth::loginUsingId($login->user_id);
            LoginLog::login();

            $login->user->login_token = Str::random(100);
            $request->session()->put('login_token', $login->user->login_token);
            $login->user->save();

            return redirect()->route('admin.dashboard');
        } else {
            abort('401', '授权失败');
        }
    }

    public function wechatLogin(Request $request)
    {
        $response = [];
        $response['status'] = false;
        $token = $request->get('token');
        $userSession = UserSession::with(['user'])->where('token', $token)
            ->where('deadline_time', '>=', date('Y-m-d H:i:s'))
            ->first();

        if ($userSession->user_id > 1) {
            DB::table('admin_logs')->insert([
                'user_id' => $userSession->user_id,
                'ip' => GetUserIP(),
                'browser' => Agent::getUserAgent(),
                'modelName' => 'login',
                'path' => \request()->path(),
                'name' => date('Y-m-d H:i:s') . ' 用户' . $userSession->user->email . '扫码登陆网站',
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        if ($userSession) {
            Auth::loginUsingId($userSession->user_id);
            LoginLog::login();
            $response['status'] = true;
            $response['code'] = 0;
            $userSession->delete();

            $userSession->user->login_token = Str::random(100);
            $request->session()->put('login_token', $userSession->user->login_token);
            $userSession->user->save();
        }
        return $response;
    }

    public function syncWebsiteId(Request $request)
    {
        $response = [];
        $response['status'] = false;
        if ($request->get('value') === 'dyyseo2021') {
            $setting = Setting::first();
            if (!$setting->website_id || !($request->get('id'))) {
                $setting->website_id = $request->get('id');
                $setting->save();
            }
            $response['status'] = true;
        } else {
            $response['error_msg'] = '参数错误，请联系网站管理人员';
        }
        return $response;
    }

    public function pullUserName(Request $request)
    {
        $response = [];
        if ($request->get('value') === 'dyyseo2018') {
            $users = User::all();
            foreach ($users as $key => $user) {
                $response[$key]['id'] = $user->id;
                $response[$key]['user_name'] = $user->email;
            }
            return $response;
        } else {
            return [];
        }
    }

    public function loginCrm(Request $request)
    {
        $response = [];
        $response['status'] = false;
        if ($request->get('id') && $request->get('token') && $request->get('web_user_id')) {
            if (Setting::where('website_id', $request->get('id'))->first()) {
                $user = User::where('id', $request->get('web_user_id'))->first();
                if ($user) {
                    UserSession::where('deadline_time', '<', date('Y-m-d H:i:s'))->delete();
                    UserSession::create(
                        [
                            'user_id' => $user->id,
                            'token' => $request->get('token'),
                            'deadline_time' => date('Y-m-d H:i:s', time() + 60)
                        ]
                    );
                    $response['status'] = true;
                } else {
                    $response['error_msg'] = '参数不正确，请检查';
                }
            } else {
                $response['error_msg'] = '参数不正确，请检查';
            }
        } else {
            $response['error_msg'] = '参数不正确，请检查';
        }
        return $response;
    }

    public function preProduct($id)
    {
        if (!config('app.pre_product')) {
            abort(404);
        }
        $product = Product::query()->findOrFail($id);
        $product->load(['translations', 'productImages' => function ($query) {
            $query->orderByDesc('is_main')->orderByDesc('sort');
        }, 'productTags' => function ($query) {
            $query->with(['translations']);
        }, 'productCategory', 'productFiles']);
        $service = new ProductService();
        $productAttributes = $service->getAttributes($product);
        $productCategories = ProductCategory::with(['translations', 'children' => function ($query) {
            $query->with(['translations'])->where('is_show', 1)->orderByDesc('sort');
            $query->with(['children' => function ($q) {
                $q->with(['translations'])->where('is_show', 1)->orderByDesc('sort');
            }]);
        }])->where('parent_id', 0)->where('is_show', 1)->orderByDesc('sort')->get();
        $newProducts = Product::with(['translations', 'productMainImage'])->active()->where('is_new', 1)->orderByDesc('sort')->limit(app('settings')['setting']->sidebar_new_product_num)->get();

        return view('layouts.front.pre', compact('product', 'productAttributes', 'productCategories', 'newProducts'));
    }

    public function inquiry(InquiryRequest $request, GeoLiteService $geoLiteService, UrlGenerator $urlGenerator, GibberishDetectionService $gibberishDetectionService)
    {
        $rules = [
            'msg_content' => 'required',
            'msg_email' => 'required|email',
        ];
        if (app('settings')['setting']['chat_token'] === 'google captcha') {
            $rules['g-recaptcha-response'] = 'required|noCaptcha';
        }
        if (intval($request->get('product_id'))) {
            $rules['product_id'] = 'exists:products,id';
        }


        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            if ($request->get('redirect_back')) {
                return redirect()->back()->withErrors($validate)
                    ->withInput();
            } else {
                return view('layouts.front.success')->withErrors($validate->errors());
            }
        }
        $is_repeat = Inquiry::query()->where([
            'email' => $request->get('msg_email'),
            'content' => $request->get('msg_content')
        ])->first();
        if ($is_repeat) {
            return view('layouts.front.success', [
                'email' => $request->get('msg_email')
            ])->with('success', 'Message successfully！');
        }
        $add = [];
        $add['product_id'] = intval($request->get('product_id'));
        $add['title'] = 'Leave a message';
        $previousUrl = $request->headers->get('referer');
        if (strstr($previousUrl, 'contact')) {
            $add['title'] = 'Contact us';
        }
        if ($add['product_id']) {
            $add['title'] = Product::find($add['product_id'])->name;
        }
        $add['content'] = $request->get('msg_content');
        $add['email'] = $request->get('msg_email');
        $add['tel'] = $request->get('msg_phone');

        $add['msg_name'] = $request->get('msg_name');
        $add['msg_company'] = $request->get('msg_company');
        $add['msg_country1'] = $request->get('msg_country1');
        $add['ip'] = GetUserIP();
        $add['location'] = $geoLiteService->getLocationByIp($add['ip']);
        if (app('settings')['setting']->inquiry_source_on) {
            $add['source_url'] = Session::get('first_visit_url');
            $pay = (strpos($add['source_url'], 'gad_source') || strpos($add['source_url'], 'gclid')) ? '广告点击' : '自然点击';
            if (isset($add['source_url'])) {
                $add['source_url'] = $pay . '—' . $add['source_url'];
            }
            $add['client'] = ismobile() ? '[mobile] ' . $add['source_url'] : '[pc] ' . $add['source_url'];
        } else {
            $add['source_url'] = $urlGenerator->previous();
            $add['client'] = ismobile() ? 'mobile' : 'pc';
        }
        $add['add_date'] = date('Ym');
        $add['msg_country'] = $geoLiteService->getCountry($add['ip']);
        // 垃圾检测
        $gibberishResult = $gibberishDetectionService->calculateGibberishScore($add['content']);
        $add['gibberish_score'] = $gibberishResult['score'];
        $add['gibberish_details'] = $gibberishResult['details'];

        // 获取垃圾指数阈值
        $gibberishThreshold = app('settings')['setting']->gibberish_threshold ?? 100;
        $isHighRisk = $add['gibberish_score'] >= $gibberishThreshold;

        $inquiry_status =  Inquiry::create($add);
        if ($inquiry_status->id) {
            // 如果垃圾指数超过阈值，不转发邮件
            if ($isHighRisk) {
                // 记录日志但不发送邮件
                Log::info('High risk inquiry detected, skipping email notification', [
                    'inquiry_id' => $inquiry_status->id,
                    'gibberish_score' => $add['gibberish_score'],
                    'threshold' => $gibberishThreshold,
                    'email' => $add['email']
                ]);
                $this->sendProductSimilarityEmail($inquiry_status);
                remember_inquiry_success((string)($add['email'] ?? ''));
                return redirect()->route('inquirysuccess');
            } else {
                // 正常发送邮件
                $contract_emails = str_replace('，', ',', app()['settings']['setting']->contract_email);
                $contract_emails = explode(',', $contract_emails);
                $product = [];
                if ($add['product_id']) {
                    $product = Product::with(['translations', 'productMainImage', 'admin' => function ($query) {
                        $query->where('is_send', 1);
                    }])->find($add['product_id']);
                    if ($product && $product->admin && !in_array($product->admin->email, ['admin@dyyseo.com', 'website@dyyseo.com'])) {
                        $contract_emails[] = $product->admin->email;
                    }
                }
                $subject = isset($product->name) ? $product->name : '普通询盘';
                $contract_emails = array_values(array_unique($contract_emails));
                if ($contract_emails[0] && app()['settings']['setting']->mail_mailer) {
                    $to_email =  array_shift($contract_emails);
                    $reply_email = $add['email'];
                    $cc_emails = $contract_emails;
                    $send_content = View::make('front.send', [
                        'product' => $product,
                        'ip' => $add['ip'],
                        'msg_name' => $add['msg_name'],
                        'msg_company' => $add['msg_company'],
                        'msg_country1' => $add['msg_country1'],
                        'email' => $add['email'],
                        'tel' => $add['tel'],
                        'content' => $add['content'],
                        'country' => $add['location'],
                        'created_at' => date('Y-m-d H:i:s'),
                    ])->render();
                    $send_log = EmailSend::query()->create([
                        'subject' => $subject,
                        'content' => $send_content,
                        'to_email' => $to_email,
                        'cc_emails' => json_encode($cc_emails),
                        'from_email' => config('mail.from.address'),
                        'reply_to' => $reply_email,
                        'type' => 'inquiry',
                        'source_id' => $inquiry_status->id,
                        'sort' => 9,
                    ]);
                    try {
                        Mail::html($send_content, function (Message $message) use ($subject, $to_email, $cc_emails, $reply_email) {
                            $message->to($to_email)->cc($cc_emails)->replyTo($reply_email)->subject($subject);
                        });
                        $inquiry_status->send_emails = implode(',', array_merge($cc_emails, [$to_email]));
                        $inquiry_status->save();

                        $send_log->status =  1;
                        $send_log->save();
                    } catch (\Swift_TransportException $exception) {
                        // 邮件发送失败
                        $send_log->status =  2;
                        $send_log->error_message = $exception->getMessage();
                        $send_log->save();
                        $send_log->refresh();
                        $this->sendFailEmail($send_log);
                    }
                }
            }
        }
        if ($request->get('redirect_back')) {
            return back()->with('success', 'Message successfully！');
        }

        remember_inquiry_success((string)($add['email'] ?? $request->get('msg_email')));
        return redirect()->route('inquirysuccess');
    }

    public function sendFailEmail(EmailSend  $emailSend)
    {
        $request_url = trim(env("MIX_API_CLOUD"), '/') . '/api/customerWebsite/failEmail';
        $token = app()['settings']['setting']->website_token;
        try {
            $res = Http::withHeaders(['token' => $token])->withoutVerifying()->post($request_url, $emailSend->toArray());
            if ($res->successful()) {
                $emailSend->is_fail_send = 1;
            } else {
                $emailSend->error_message = $emailSend->error_message . '(发送云平台异常,返回状态码:' . $res->status() . ')';
            }
            $emailSend->save();
        } catch (\Exception $e) {
            Log::error('Failed to send fail email: ' . $e->getMessage());
        }
    }

    public function sendProductSimilarityEmail($inquiry)
    {
        $request_url = trim(env("MIX_API_CLOUD"), '/') . '/api/customerWebsite/blackInquiry';
        $token = app()['settings']['setting']->website_token;
        try {
            Http::withHeaders(['token' => $token])->withoutVerifying()->post($request_url, [
                'title' => $inquiry->title,
                'email' => $inquiry->email,
                'phone' => $inquiry->tel,
                'content' => $inquiry->content,
                'source_id' => $inquiry->id,
                'ip'  => $inquiry->ip,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send product similarity email: ' . $e->getMessage());
        }
    }
}
