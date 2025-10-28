<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //

    public function activeCategories(){
        $category = Category::where('status', 'active')->orderBy('id', 'desc')->get();
        if ($category->count() > 0){
            return response()->json([
                'status' => 'success',
                'data' => $category
            ],200);
        }else{
            return response()->json([
                'status' => 'failed',
                'message' => 'No data found'
            ]);
        }
    }
    public  function activeSubCategories(Request $request){
        $subcategory = Subcategory::where('status', 'active')->where('category_id', $request->id)->orderBy('id', 'desc')->get();
        if ($subcategory->count() > 0){
            return response()->json([
                'status' => 'success',
                'data' => $subcategory
            ],200);
        }else{
            return response()->json([
                'status' => 'failed',
                'message' => 'No Sub Category Found'
            ]);
        }
    }

    public function activeBrands(){
        $brand = Brand::where('status', 'active')->orderBy('id', 'desc')->get();
        if ($brand->count() > 0){
            return response()->json([
                'status' => 'success',
                'data' => $brand
            ],200);
        }else{
            return response()->json([
                'status' => 'failed',
                'message' => 'No Brands Found'
            ]);
        }
    }

    public function productsListPage(){

    }
    public function productCreatePage(){
        return view('dashboard.pages.product.productCreate');
    }
    public function productUpdatePage(){

    }

}
