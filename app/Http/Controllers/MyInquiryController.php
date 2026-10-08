<?php

namespace App\Http\Controllers;

use App\Modules\Inquiry\Models\Inquiry;
use App\Modules\Product\Models\Product;
use App\Services\InquiryAttachmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MyInquiryController extends Controller
{
    public function index(Request $request)
    {
        $injectToView = (bool)$request->get('inject', true);
        $pageBanner = $this->getBannersByArea('Inquiry');
        $setting = app('settings')['setting'];
        $tdk = $this->resolveCmsPageTdkByPath($setting, 'myinquirys');

        $data = [
            'productsData' => [],
            'tdk' => $tdk,
            'pageBanner' => $pageBanner,
            'injectToView' => $injectToView,
        ];

        if (!$injectToView) {
            return response()->json($data);
        }

        return view('front.myinquirys', $data);
    }

    public function store(Request $request)
    {
        $injectToView = (bool)$request->get('inject', true);

        $validated = $request->validate(array_merge([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'tel' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'quantity' => ['nullable', 'string', 'max:255'],
            'source_url' => ['nullable', 'string', 'max:2048'],
            'products' => ['nullable', 'array'],
            'products.*.id' => ['required_with:products', 'integer', 'min:1'],
            'products.*.quantity' => ['nullable', 'string', 'max:255'],
            'product_ids' => ['nullable', 'array'],
            'product_ids.*' => ['integer', 'min:1'],
        ], InquiryAttachmentService::validationRules()), [
            'name.required' => 'Please enter your name.',
            'email.required' => 'Please enter your email.',
            'email.email' => 'Please enter a valid email address.',
            'tel.required' => 'Please enter your phone number.',
            'content.required' => 'Please enter the content.',
            'attachments.max' => 'You can upload up to ' . InquiryAttachmentService::MAX_FILES . ' files.',
            'attachments.*.max' => 'Each file must be smaller than 10MB.',
        ]);

        $syncData = [];
        if (!empty($validated['products']) && is_array($validated['products'])) {
            foreach ($validated['products'] as $row) {
                $pid = (int)($row['id'] ?? 0);
                if ($pid <= 0) {
                    continue;
                }
                $qty = trim((string)($row['quantity'] ?? '1'));
                if ($qty === '') {
                    $qty = '1';
                }
                $syncData[$pid] = ['quantity' => mb_substr($qty, 0, 255)];
            }
        } elseif (!empty($validated['product_ids']) && is_array($validated['product_ids'])) {
            foreach ($validated['product_ids'] as $pid) {
                $pid = (int)$pid;
                if ($pid > 0) {
                    $syncData[$pid] = ['quantity' => '1'];
                }
            }
        }

        if (!empty($syncData)) {
            $validIds = Product::query()->active()->whereIn('id', array_keys($syncData))->pluck('id')->all();
            $syncData = array_intersect_key($syncData, array_flip($validIds));
        }

        $content = (string)$validated['content'];
        if (!empty($validated['quantity'])) {
            $content .= "\n\nOverall Quantity: " . $validated['quantity'];
        }

        $sourceUrl = trim((string)($validated['source_url'] ?? ''));
        if ($sourceUrl === '') {
            $sourceUrl = $request->headers->get('referer') ?: $request->fullUrl();
        }
        if (!preg_match('#^https?://#i', $sourceUrl)) {
            $sourceUrl = $request->getSchemeAndHttpHost() . '/' . ltrim($sourceUrl, '/');
        }

        try {
            DB::beginTransaction();

            $inquiry = Inquiry::create([
                'title' => 'Inquiry List',
                'content' => $content,
                'email' => (string)$validated['email'],
                'tel' => (string)$validated['tel'],
                'ip' => $request->ip(),
                'client' => $request->header('User-Agent'),
                'add_date' => date('Y-m-d H:i:s'),
                'msg_name' => (string)$validated['name'],
                'source_url' => $sourceUrl,
            ]);

            if (!empty($syncData)) {
                $inquiry->products()->sync($syncData);
            }

            app(InquiryAttachmentService::class)->storeForInquiry($inquiry, null, $request);

            DB::commit();

            remember_inquiry_success((string)($inquiry->email ?? ''));

            if (!$injectToView || $request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'inquiry_id' => $inquiry->id,
                    'redirect' => route('inquirysuccess'),
                ]);
            }

            return redirect()->route('inquirysuccess');
        } catch (\Throwable $e) {
            DB::rollBack();
            if (!$injectToView || $request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 500);
            }
            return back()->withErrors(['msg' => $e->getMessage()])->withInput();
        }
    }

    private function isNeedAuth(): bool
    {
        $path = base_path('needauth.txt');
        if (!file_exists($path)) {
            return false;
        }
        return trim((string)@file_get_contents($path)) === '1';
    }
}
