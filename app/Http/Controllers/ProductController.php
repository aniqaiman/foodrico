<?php

namespace App\Http\Controllers;

use App\Product;
use App\Wastage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function updateDemand(Request $request)
    {
        $product = Product::find($request->input('id'));

        if ($request->input('grade') === 'A') {
            $product->demand_a = $request->input('demand');
        } else if ($request->input('grade') === 'B') {
            $product->demand_b = $request->input('demand');
        }

        return response()->json($product);
    }
    public function updateWastage(Request $request)
    {
        $wastage = Wastage::where($product_id,$request->input('product_id'))->get();

        if (!$wastage) {
            $wastage = new Wastage;
            $wastage->storage_wastage = 0;
            $wastage->promo_wastage = 0;

       }
       $wastage->product_id = $request->input('product_id');
       $wastage->storage_wastage += $request->input('wastage');
       $wastage->save();
        return response()->json($wastage);
    }
}
