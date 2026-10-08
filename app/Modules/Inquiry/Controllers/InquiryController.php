<?php

namespace App\Modules\Inquiry\Controllers;

use App\Modules\Admin\Models\User;
use App\Modules\Common\Collections\CommonCollection;
use App\Modules\Common\Collections\CommonResourceCollection;
use App\Modules\Common\Controllers\BaseController;
use App\Modules\Inquiry\Models\Inquiry;
use App\Modules\Inquiry\Models\InquiryAttachment;
use App\Modules\Inquiry\Models\InquiryRemark;
use App\Modules\Inquiry\Models\InquiryUserRead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\GibberishDetectionService;

class InquiryController extends BaseController
{
    public function __construct(Inquiry $inquiry)
    {
        $this->modelName = 'Inquiry';
        $this->model = $inquiry;
        $this->viewPath = 'Inquiry.Views';
        $this->orderBy = 'created_at';
    }

    public function remark(Request $request)
    {
        $add = [];
        $add['admin_user_id'] = $request->user()->id;
        $add['inquiry_id'] = $request->get('inquiry_id');
        $add['content'] = $request->get('content');
        InquiryRemark::create($add);
        return back();
    }

    public function index()
    {
        // $models = Inquiry::get();
        // foreach($models as $model){
        //     $gibberishService = app(GibberishDetectionService::class);
        //     $score = $gibberishService->calculateGibberishScore($model->content);
        //     $model->gibberish_score = $score['score'];
        //     $model->gibberish_details = $score['details'];
        //     $model->save();
        // }
        // dd('ok');

        $request = \request();
        if ($request->ajax() || $request->wantsJson()) {
            $condition = [];
            if ($inquiry_cate = $request->get('cate')) {
                $condition = [$inquiry_cate => $request->get('search_q')];
            }
            $query = Inquiry::query()
                ->select(['id', 'title', 'ip', 'client', 'email', 'send_emails', 'created_at', 'msg_country', 'gibberish_score', 'gibberish_details'])
                ->with(['reads' => function ($query) {
                    $query->where('user_id', auth()->id());
                }]);

            if (!auth()->user() || !auth()->user()->hasRole('超级管理员')) {
                $query->whereHas('users', function ($query) {
                    $query->where(['is_del' => 0, 'user_id' => auth()->id()]);
                });
            }

            $data = tap($query->where($condition), function ($query) use ($request) {
                if ($start_time = $request->get('start_time')) {
                    $query->where('created_at', '>', $start_time);
                }
                if ($end_time = $request->get('end_time')) {
                    $query->where('created_at', '<', $end_time);
                }
                if($request->get('show_high_risk')){
                    $query->where('gibberish_score', '>=', app('settings')['setting']->gibberish_threshold);
                }else{
                    $query->where('gibberish_score', '<', app('settings')['setting']->gibberish_threshold);
                }
            })->orderByDesc($this->orderBy)->paginate($request->input('limit', 15));
            if ($collection = $this->collection) {
                return new $collection($data);
            } else {
                return new CommonResourceCollection($data);
            }
        }
        return view($this->viewPath . '.index');
    }


    public function listing(Request  $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $condition = [];
            if ($inquiry_cate = $request->get('cate')) {
                $condition = [$inquiry_cate => $request->get('search_q')];
            }
            $query = Inquiry::query()
                ->where('title', 'like', '%【First Page TL Inquiry】%')
                ->select(['id', 'title', 'ip', 'client', 'email', 'send_emails', 'created_at', 'msg_country', 'gibberish_score', 'gibberish_details'])
                ->with(['reads' => function ($query) {
                    $query->where('user_id', auth()->id());
                }]);

            if (!auth()->user() || !auth()->user()->hasRole('超级管理员')) {
                $query->whereHas('users', function ($query) {
                    $query->where(['is_del' => 0, 'user_id' => auth()->id()]);
                });
            }

            $data = tap($query->where($condition), function ($query) use ($request) {
                if ($start_time = $request->get('start_time')) {
                    $query->where('created_at', '>', $start_time);
                }
                if($request->get('show_high_risk')){
                    $query->where('gibberish_score', '>=', app('settings')['setting']->gibberish_threshold);
                }else{
                    $query->where('gibberish_score', '<', app('settings')['setting']->gibberish_threshold);
                }
                if ($end_time = $request->get('end_time')) {
                    $query->where('created_at', '<', $end_time);
                }
            })->orderByDesc($this->orderBy)->paginate($request->input('limit', 15));
            if ($collection = $this->collection) {
                return new $collection($data);
            } else {
                return new CommonResourceCollection($data);
            }
        }
        return view($this->viewPath . '.listing');
    }

    public function show($id)
    {
        $model = $this->model->with(['inquiryRemark.user', 'products.productMainImage', 'attachments'])->where('id', $id)->first();
        $read = InquiryUserRead::where(['user_id' => Auth::id(), 'inquiry_id' => $id])->first();
        if (!$read) {
            $model->reads()->save(new InquiryUserRead(['user_id' => Auth::id()]));
        }
        return view(
            $this->viewPath . '.show',
            [
                'model' => $model,
            ]
        );
    }

    public function downloadAttachment($attachment)
    {
        $file = InquiryAttachment::query()->findOrFail($attachment);
        if (!$file->existsOnDisk()) {
            abort(404, __('附件文件不存在'));
        }

        return response()->download($file->absolute_path, $file->original_name);
    }


    public function export(Request $request)
    {
        if(!$request->user()->hasRole('超级管理员')){
            abort(503);
        }
        $ids = $request->post('ids');
        $data = [
            [
                '询盘id',
                '标题',
                'email',
                'ip',
                '时间',
                '电话',
                '国家',
                '内容'
            ],
        ];
        if ($ids) {
            $inquiries = Inquiry::whereIn('id', $ids)
                ->select(['id', 'title', 'email', 'ip', 'created_at', 'tel', 'msg_country', 'content'])
                ->get()
                ->toArray();
        } else {
            $inquiries = Inquiry::select(['id', 'title', 'email', 'ip', 'created_at', 'tel', 'msg_country', 'content'])
                ->get()
                ->toArray();
        }
        foreach ($inquiries as $inquiry) {
            $data[] = array_values($inquiry);
        }
        return new CommonCollection($data);
    }


    public function editUser(Inquiry $inquiry)
    {
        $inquiry->load('users');
        $inquiryUsers = $inquiry->toArray()['users'];
        if ($inquiryUsers) {
            $inquiryUsers = array_column($inquiryUsers, 'id');
        }
        $allUsers = User::whereHas('roles', function ($query) {
            $query->whereNotIn('role_id', User::ALLOW_ADMIN_ID);
        })->get();
        $id = $inquiry->id;
        return view($this->viewPath . '.editUser', compact('inquiryUsers', 'allUsers', 'id'));
    }

    public function updateUser(Inquiry $inquiry, Request $request)
    {
        $userIds = $request->post('users');
        $userIds = array_keys($userIds);
        $inquiry->users()->sync(array_merge($userIds, User::ALLOW_ADMIN_ID));
        return $this->success();
    }


    //恢复询盘
    public function restore($id)
    {
        try {
            $inquiry = Inquiry::with(['users'])->find($id);
            $inquiry->users()->where(['user_id' => Auth::id()])->update(['is_del' => 0]);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . '（' . $id . '）恢复失败，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }


    //删除询盘
    public function remove(Request $request)
    {
        $id = $request->get('id');
        try {
            DB::table('inquiry_user')->where(['inquiry_id' => $id, 'user_id' => \auth()->id()])->update([
                'is_del' => 1
            ]);
            //            $inquiry = Inquiry::with(['users'])->find($id);
            //            $inquiry->users()->where(['user_id'=>Auth::id()])->update(['is_del'=>1]);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . '（' . $id . '）软删除失败，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }


    //批量移入回收站
    public function multipleRemove(Request $request)
    {
        $ids = $request->get('ids');
        $inquiries = Inquiry::whereIn('id', $ids)->with(['users'])->get();
        foreach ($inquiries as $inquiry) {
            $inquiry->users()->where(['user_id' => Auth::id()])->update(['is_del' => 1]);
        }
        return $this->success();
    }

    //询盘批量收回
    public function multipleRestore(Request $request)
    {
        $ids = $request->get('ids');
        $inquiries = Inquiry::whereIn('id', $ids)->with(['users'])->get();
        foreach ($inquiries as $inquiry) {
            $inquiry->users()->where(['user_id' => Auth::id()])->update(['is_del' => 0]);
        }
        return $this->success();
    }


    //询盘批量删除
    public function multipleDestroy(Request $request)
    {
        $ids = $request->get('ids');
        $inquiries = Inquiry::whereIn('id', $ids)->with(['users'])->get();
        foreach ($inquiries as $inquiry) {
            $inquiry->users()->detach(['user_id' => Auth::id()]);
        }
        return $this->success();
    }


    public function trash()
    {
        $request = \request();
        if ($request->ajax() || $request->wantsJson()) {
            $condition = [];
            $data = tap(Inquiry::whereHas('users', function ($query) {
                $query->where(['user_id' => Auth::id(), 'is_del' => 1]);
            })->with(['reads' => function ($query) {
                $query->where('user_id', Auth::id());
            }])->where($condition), function ($query) use ($request) {
                if ($start_time = $request->get('start_time')) {
                    $query->where('created_at', '>', $start_time);
                }
                if ($end_time = $request->get('end_time')) {
                    $query->where('created_at', '<', $end_time);
                }
            })->orderByDesc($this->orderBy)->paginate($request->input('limit', 15));
            if ($collection = $this->collection) {
                return new $collection($data);
            } else {
                return new CommonResourceCollection($data);
            }
        }
        return view($this->viewPath . '.trash');
    }


    public function destroy($id)
    {
        try {
            $inquiry = Inquiry::with(['users'])->find($id);
            $inquiry->users()->detach(['user_id' => Auth::id()]);
        } catch (\PDOException $exception) {
            Log::error('inquiry:destroy，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

    /**
     * 批量设置为有效询盘（垃圾指数分为0）
     */
    public function setValidInquiry(Request $request)
    {
        $ids = $request->get('ids');
        if (!$ids || !is_array($ids)) {
            return $this->badRequest('请选择要操作的询盘');
        }

        try {
            Inquiry::whereIn('id', $ids)->update([
                'gibberish_score' => 0,
                'gibberish_details' => json_encode([])
            ]);
        } catch (\PDOException $exception) {
            Log::error('inquiry:setValidInquiry，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

    /**
     * 批量设置为垃圾询盘（垃圾指数分为100）
     */
    public function setSpamInquiry(Request $request)
    {
        $ids = $request->get('ids');
        if (!$ids || !is_array($ids)) {
            return $this->badRequest('请选择要操作的询盘');
        }

        try {
            Inquiry::whereIn('id', $ids)->update([
                'gibberish_score' => 100,
                'gibberish_details' => json_encode(['手动标记为垃圾询盘'])
            ]);
        } catch (\PDOException $exception) {
            Log::error('inquiry:setSpamInquiry，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }
}
