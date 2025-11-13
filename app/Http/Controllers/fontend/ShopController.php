<?php

namespace App\Http\Controllers\fontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    //
    public function index(){
        return view('frontend.shop');
    }

    public function getProduct(){
        $products = Product::orderBy('id','desc')->with('images')->get();
        if($products->isNotEmpty()){
            return response()->json([
                'status' => 'success',
                'data' => $products
            ],200);
        }
    }

    public function getCategory(){
        $category = Category::orderBy('id','asc')->with('subCategoris')->get();
        if($category->isNotEmpty()){
            return response()->json([
                'status' => 'success',
                'data' => $category
            ],200);
        }
    }
}
