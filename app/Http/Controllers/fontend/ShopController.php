<?php

namespace App\Http\Controllers\fontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    //
    public function index(){
        return view('frontend.shop');
    }

    public function getProduct(Request $request, $categorySlug = null, $subCategorySlug = null){

        $products = Product::where('status','active');
        return response()->json([
            'data' => $request->all()
        ]);


        //applied fillter for category
        if(!empty($categorySlug)){
            $category = Category::where('slug', $categorySlug)->first();
            if($category){
                $products->where('category_id', $category->id);
                if(!empty($subCategorySlug)){
                    $subCategory = SubCategory::where('slug', $subCategorySlug)->first();
                    if($subCategory){
                        $products->where('sub_category_id', $subCategory->id);
                    }
                }
            }
        }

        //applied fillter for brand
        if($request->has('brands')){
            $brands = $request->brands;
            if (!is_array($brands)){
                $brands = explode(',', $brands);
            }
            $products->whereIn('brand_id', $brands);
        }

//        //applyed fillter for price
//        if($request->has('subcategories')){
//
//        }


        $products =$products->orderBy('id','desc')->with('images')->get();


        return response()->json([
            'status' => 'success',
            'data' => $products,
        ],200);
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

    public function getBrand(){
        $brand = Brand::orderBy('id','asc')->get();
        if($brand->isNotEmpty()){
            return response()->json([
                'status' => 'success',
                'data' => $brand
            ],200);
        }
    }
}
