<?php

namespace App\Modules\Product\Controllers;

use App\Modules\Common\Controllers\BaseController;
use App\Modules\User\Models\CustomerReview;
use Illuminate\Http\Request;

class CustomerReviewController extends BaseController
{
    public function __construct(CustomerReview $review)
    {
        $this->modelName = 'CustomerReview';
        $this->model = $review;
        $this->viewPath = 'Product.Views.customerReview';
        $this->orderBy = 'id';
    }

    public function index()
    {
        $request = request();

        $product = trim((string)$request->get('product', ''));
        $email = trim((string)$request->get('email', ''));
        $username = trim((string)$request->get('username', ''));

        $query = CustomerReview::query();

        if ($product !== '') {
            $query->where('product', 'like', '%' . $product . '%');
        }
        if ($email !== '') {
            $query->where('email', 'like', '%' . $email . '%');
        }
        if ($username !== '') {
            $query->where('username', 'like', '%' . $username . '%');
        }

        $reviews = $query
            ->orderByDesc('id')
            ->paginate(15)
            ->appends($request->query());

        return view($this->viewPath . '.index', compact('reviews', 'product', 'email', 'username'));
    }

    public function create()
    {
        return view($this->viewPath . '.create');
    }

    public function store(Request $request)
    {
        $locale = (string)config('app.locale');
        if ($locale === '') {
            $locale = 'en';
        }

        $validator = $this->getValidationFactory()->make($request->all(), [
            'product' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'score' => ['nullable', 'integer', 'min:0', 'max:5'],
            'imgs' => ['array'],
            'imgs.imgPath' => ['array'],
            'imgs.imgPath.*' => ['string', 'max:2048'],
            'translate' => ['array'],
            'translate.' . $locale . '.subject' => ['required', 'string', 'max:255'],
            'translate.' . $locale . '.content' => ['required', 'string'],
            'translate.*.subject' => ['nullable', 'string', 'max:255'],
            'translate.*.content' => ['nullable', 'string'],
        ]);

        if (!$validator->passes()) {
            return back()->withErrors($validator)->withInput();
        }

        $imgPaths = (array)($request->input('imgs.imgPath', []));
        $imgPaths = array_values(array_filter(array_map('trim', $imgPaths)));

        $translate = (array)$request->get('translate', []);

        CustomerReview::create(array_merge([
            'product' => trim((string)$request->get('product')),
            'email' => trim((string)$request->get('email')),
            'username' => trim((string)$request->get('username')),
            'score' => (int)$request->get('score', 0),
            'imgs' => $imgPaths,
        ], $translate));

        return redirect()->route('admin.customerReview.index')->with('success', 'Created');
    }

    public function edit($id)
    {
        $model = CustomerReview::query()->with(['translations'])->findOrFail($id);

        $images = [];
        $paths = is_array($model->imgs) ? $model->imgs : [];
        foreach ($paths as $p) {
            $images[] = [
                'path' => ltrim((string)$p, '/'),
                'sort' => 0,
                'alt' => '',
                'is_main' => 0,
            ];
        }

        return view($this->viewPath . '.edit', compact('model', 'images'));
    }

    public function update($id, Request $request)
    {
        $locale = (string)config('app.locale');
        if ($locale === '') {
            $locale = 'en';
        }

        $validator = $this->getValidationFactory()->make($request->all(), [
            'product' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'score' => ['nullable', 'integer', 'min:0', 'max:5'],
            'imgs' => ['array'],
            'imgs.imgPath' => ['array'],
            'imgs.imgPath.*' => ['string', 'max:2048'],
            'translate' => ['array'],
            'translate.' . $locale . '.subject' => ['required', 'string', 'max:255'],
            'translate.' . $locale . '.content' => ['required', 'string'],
            'translate.*.subject' => ['nullable', 'string', 'max:255'],
            'translate.*.content' => ['nullable', 'string'],
        ]);

        if (!$validator->passes()) {
            return back()->withErrors($validator)->withInput();
        }

        $model = CustomerReview::query()->findOrFail($id);

        $imgPaths = (array)($request->input('imgs.imgPath', []));
        $imgPaths = array_values(array_filter(array_map('trim', $imgPaths)));

        $translate = (array)$request->get('translate', []);

        $model->update(array_merge([
            'product' => trim((string)$request->get('product')),
            'email' => trim((string)$request->get('email')),
            'username' => trim((string)$request->get('username')),
            'score' => (int)$request->get('score', 0),
            'imgs' => $imgPaths,
        ], $translate));

        return redirect()->route('admin.customerReview.index')->with('success', 'Updated');
    }

    public function destroy($id)
    {
        $model = CustomerReview::query()->findOrFail($id);
        $model->delete();
        return redirect()->route('admin.customerReview.index')->with('success', 'Deleted');
    }
}
