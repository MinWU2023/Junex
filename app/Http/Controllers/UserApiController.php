<?php

namespace App\Http\Controllers;

use App\Modules\User\Models\Customer;
use App\Modules\User\Models\CustomerPrefer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserApiController extends Controller
{
    public function getUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ip' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $ip = $request->get('ip');

        $customer = Customer::query()->where('ip', $ip)->orderByDesc('id')->first();

        if (!$customer) {
            return response()->json([
                'success' => false,
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $customer,
        ]);
    }

    public function prefer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => ['required', 'integer', 'min:1'],
            'product_ids' => ['required', 'array', 'min:1'],
            'product_ids.*' => ['integer', 'min:1'],
            'type' => ['required', 'integer', 'in:0,1'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $customerId = (int)$request->get('customer_id');
        $type = (int)$request->get('type');
        $productIds = array_values(array_unique(array_map('intval', (array)$request->get('product_ids'))));
        $productIds = array_values(array_filter($productIds, fn ($id) => $id > 0));

        if (empty($productIds)) {
            return response()->json([
                'success' => false,
                'errors' => ['product_ids' => ['The product_ids field is required.']],
            ], 422);
        }

        if ($type === 1) {
            foreach ($productIds as $productId) {
                CustomerPrefer::query()->firstOrCreate([
                    'customer_id' => $customerId,
                    'product_id' => $productId,
                ]);
            }
        } else {
            CustomerPrefer::query()
                ->where('customer_id', $customerId)
                ->whereIn('product_id', $productIds)
                ->delete();
        }

        return response()->json([
            'success' => true,
        ]);
    }
}
