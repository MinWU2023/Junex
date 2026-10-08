<?php
namespace App\Modules\Inquiry\Controllers;


use App\Modules\Common\Collections\CommonResourceCollection;
use App\Modules\Common\Controllers\BaseController;
use App\Modules\Inquiry\Models\Newsletter;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Modules\Common\Collections\CommonCollection;

class NewsLetterController extends BaseController
{
    public function __construct(Newsletter $newsLetter)
    {
        $this->model = $newsLetter;
        $this->modelName = 'NewsLetter';
        $this->viewPath = 'Inquiry.Views.newsletter';
        $this->validatorData = [
            'email' => 'required|email',
        ];
    }

    public function index()
    {
        $request = \request();
        $name = $request->get('name');
        if ($request->ajax() || $request->wantsJson()) {
            $data = tap($this->model->orderByDesc($this->orderBy), function ($query) use ($request) {
                    if($email = $request->get('email')){
                        $query->where('email','like','%'.$email.'%');
                    }
                    if ($start_time = $request->get('start_time')) {
                        $query->where('created_at', '>', $start_time);
                    }
                    if ($end_time = $request->get('end_time')) {
                        $query->where('created_at', '<', $end_time);
                    }
            })->paginate($request->input('limit', 15));
            foreach ($data as $datum){
                DB::table('newsletter_user')->updateOrInsert([
                    'newsletter_id' => $datum['id'],
                    'user_id' => auth()->id(),
                ]);
            }
            if ($collection = $this->collection) {
                return new $collection($data);
            } else {
                return new CommonResourceCollection($data);
            }
        }
        return view($this->viewPath . '.index', compact('name'));
    }


    public function export(Request $request)
    {
        $ids = $request->post('ids');
        $data = [
            [
                'email',
            ],
        ];
        if ($ids) {
            $inquiries = Newsletter::query()->whereIn('id', $ids)->select(['email'])->get()->toArray();
        } else {
            $inquiries = Newsletter::query()->select(['email'])->get()->toArray();
        }
        foreach ($inquiries as $inquiry) {
            $data[] = array_values($inquiry);
        }
        return new CommonCollection($data);
    }

}
