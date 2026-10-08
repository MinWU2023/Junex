<?php


namespace App\Modules\Search\Controllers;


use App\Modules\Admin\Models\Permission;
use App\Modules\Search\Models\Search;
use App\Modules\Search\Models\SearchDetail;
use App\Modules\Url\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{
    private $search_id;
    private $deadline_time;

    public function index(Request $request)
    {
        if ($keywords = $request->get('keywords')) {
            $this->deadline_time = date('Y-m-d H:i:s', time() + 3600);
            $this->truncateDeadline();
            $search = Search::where('name', $keywords)->where('deadline_time', '>', date('Y-m-d H:i:s'))
                ->first();
            if (!$search) {
                $search = Search::create(
                    [
                        'name' => $keywords,
                        'deadline_time' => $this->deadline_time
                    ]
                );

                $this->createSearchDetail($request, $search);
            }
            $this->search_id = $search->id;
            $searchDetails = SearchDetail::where('search_id', $this->search_id)->paginate(6);
            return view('Search.Views.index', compact('searchDetails', 'keywords'));
        } else {
            abort('404');
        }
    }

    private function truncateDeadline()
    {
        $searchs = Search::where('deadline_time', '<=', date('Y-m-d H:i:s'))->get();
        foreach ($searchs as $search) {
            DB::table('search_details')->where('search_id', $search->id)->delete();
            $search->delete();
        }
    }

    private function createSearchDetail($request, Search $search)
    {
        $validator = Validator::make($request->all(), [
            'keywords' => 'required|url',
        ]);
        if ($validator->fails()) {
            $models = DB::table('urls')->distinct()->pluck('urlable_type')->toArray();
            foreach ($models as $model) {
                $contents = (new $model)->whereTranslationLike('name', '%' . $request->keywords . '%')->get();
                foreach ($contents as $content) {
                    $add = [];
                    $add['search_id'] = $search->id;
                    $types = explode("\\", $model);
                    $add['type'] = $types[count($types) - 1];
                    $add['name'] = $content->name;
                    $add['active'] = isset($content->active) ? $content->active : 1;
                    $add['created_at'] = $content->created_at;
                    $add['updated_at'] = $content->updated_at;
                    SearchDetail::create($add);
                }
            }
            return DB::table('urls')->distinct()->pluck('urlable_type');
        } else {
            $parseUrl = parse_url($request->keywords);
            $path = str_replace('/', '', $parseUrl['path']);
            $url = Url::where('url', $path)->first();
            if ($url) {
                $add = [];
                $add['search_id'] = $search->id;
                $types = explode("\\", $url->urlable_type);
                $add['type'] = $types[count($types) - 1];
                $content = (new $url->urlable_type)->find($url->urlable_id);
                $add['name'] = $content->name;
                $add['created_at'] = $content->created_at;
                $add['updated_at'] = $content->updated_at;
                SearchDetail::create($add);
            }
        }
    }
}
