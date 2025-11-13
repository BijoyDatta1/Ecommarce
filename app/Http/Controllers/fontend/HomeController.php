<?php

namespace App\Http\Controllers\fontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index(){
        return view('frontend.home');
    }

    public function getMenu(){
        $categories = Category::where('display', 'yes')->with(['subCategoris' => function ($query) {
            $query->where('display', 'yes');
        }])->orderBy('id','ASC')->take(8)->get();
        if($categories->isNotEmpty()){
            return response()->json([
                'status' => 'success',
                'categories' => $categories,
            ],200);
        }
    }

    public function featuredProduct(){
        $products = Product::where('featured', 'yes')->with('images')->take(12)->get();
        if($products->isNotEmpty()){
            return response()->json([
                'status' => 'success',
                'products' => $products,
            ],200);
        }
    }

    public function latestProduct(){
        $products = Product::orderBy('id', 'DESC')->with('images')->take(12)->get();
        if($products->isNotEmpty()){
            return response()->json([
                'status' => 'success',
                'products' => $products,
            ],200);
        }
    }

}
