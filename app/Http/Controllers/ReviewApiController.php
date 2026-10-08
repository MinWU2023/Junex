<?php

namespace App\Http\Controllers;

use App\Modules\User\Models\CustomerReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewApiController extends Controller
{
    public function index(Request $request)
    {
        $page = (int)$request->get('page', 1);
        if ($page <= 0) {
            $page = 1;
        }

        $perPage = (int)$request->get('per_page', 10);
        if ($perPage <= 0) {
            $perPage = 10;
        }
        if ($perPage > 50) {
            $perPage = 50;
        }

        $paginator = CustomerReview::query()
            ->with(['translations'])
            ->orderByDesc('id')
            ->paginate($perPage, ['*'], 'page', $page);

        $items = $paginator->getCollection()->map(function (CustomerReview $r) {
            $username = (string)($r->username ?? '');
            $initial = $username !== '' ? mb_strtoupper(mb_substr($username, 0, 1)) : '';
            $imgs = is_array($r->imgs) ? $r->imgs : [];
            $imgs = array_values(array_filter(array_map(function ($v) {
                if (!is_string($v)) {
                    return '';
                }
                $v = trim($v);
                return $v !== '' ? front_webp_url($v) : '';
            }, $imgs)));

            return [
                'id' => (int)$r->id,
                'username' => $username,
                'initial' => $initial,
                'score' => (int)($r->score ?? 0),
                'subject' => (string)($r->subject ?? ''),
                'content' => (string)($r->content ?? ''),
                'imgs' => $imgs,
            ];
        })->values()->toArray();

        $hasMore = $paginator->hasMorePages();

        return response()->json([
            'success' => true,
            'data' => [
                'items' => $items,
                'current_page' => (int)$paginator->currentPage(),
                'last_page' => (int)$paginator->lastPage(),
                'next_page' => $hasMore ? ((int)$paginator->currentPage() + 1) : null,
                'has_more' => $hasMore,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['nullable', 'integer', 'min:0'],
            'product_id' => ['required', 'integer', 'min:1'],
            'subject' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'score' => ['nullable', 'integer', 'min:0', 'max:5'],
            'imgs' => ['nullable'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $imgs = $request->get('imgs');
        if (is_string($imgs)) {
            $decoded = json_decode($imgs, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $imgs = $decoded;
            }
        }
        if (!is_array($imgs)) {
            $imgs = [];
        }

        $comment = CustomerReview::create([
            'user_id' => (int)$request->get('user_id', 0),
            'product_id' => (int)$request->get('product_id'),
            'subject' => $request->get('subject'),
            'email' => $request->get('email'),
            'username' => $request->get('username'),
            'content' => $request->get('content'),
            'imgs' => $imgs,
            'score' => (int)$request->get('score', 0),
        ]);

        return response()->json([
            'success' => true,
            'data' => $comment,
        ]);
    }
}
