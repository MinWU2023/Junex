<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class CollectController extends Controller{
    public function toggle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'integer', 'min:1'],
            'product_id' => ['required', 'integer', 'min:1'],
            'collect' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $userId = (int)$request->get('user_id');
        $productId = (int)$request->get('product_id');
        $collectRaw = $request->get('collect');
        $collect = in_array($collectRaw, [1, '1', true, 'true', 'yes', 'on'], true);

 

        return response()->json([
            'success' => true,
            'collected' => $isCollected,
        ]);
    }
}
