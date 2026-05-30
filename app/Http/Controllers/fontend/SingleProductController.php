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
}
