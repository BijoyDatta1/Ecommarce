<?php

namespace App\Http\Controllers\fontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use View;

class SingleProductController extends Controller
{
    //
    public function index($id,$slug){
        $product = Product::where('id',$id)->where('slug',$slug)->with('images')->first();
        if($product){
            return view('frontend.product')->with('data', $product);
        }else{
            abort(404);
        }
    }

    public function getRelatedProduct(Request $request){
        $product = Product::where('id', $request->id)->first();

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ]);
        }

        if($product->related_products != null){
            $relatedProductId = json_decode($product->related_products, true);
            $relatedProduct = Product::whereIn('id', $relatedProductId)->with('images')->take(4)->get();
            return response()->json([
                'status' => 'success',
                'data' => $relatedProduct
            ]);
        }



    }
}
