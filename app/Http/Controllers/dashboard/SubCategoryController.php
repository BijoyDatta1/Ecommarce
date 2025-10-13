<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    public function subCateogoryPage(){
        return view('dashboard.pages.SubCategory.subCategoryList');
    }
    public function subCateogoryCreatePage(){
        return view('dashboard.pages.SubCategory.SubCategoryCreate');
    }
    public function subCateogoryGet(){
        $subCategories = SubCategory::all();
        if (count($subCategories) > 0){
            return response()->json([
                'status' => 'success',
                'data' => $subCategories
            ],200);
        }
    }
    public function subCategoryCreate(Request $request){
        $validation = Validator::make($request->all(),[
            'name' => 'required|unique:sub_categoris,name',
            'category_id' => 'required|exists:categoris,id',
            'status' => 'required'
        ]);
        if($validation->fails()){
            return response()->json([
                'status'=>'failed',
                'message'=>$validation->errors()
            ]);
        }
        $subCategoris = new SubCategory();
        $subCategoris->name = $request['name'];
        $subCategoris->category_id = $request['category_id'];
        $subCategoris->status = $request['status'];
        if($subCategoris->save()){
            return response()->json([
                'status'=>'success',
                'message'=>'Sub Category Added Successfully'
            ], 200);
        }else{
            return response()->json([
                'status'=>'failed',
                'message'=>'Something Went Wrong'
            ]);
        }
    }
    public function subCategoryUpdate(){

    }
    public function subCategoryDelete(Request $request){
        $subCategory = SubCategoryController::where('id',$request['id'])->first();
        if ($subCategory->delete()){
            return response()->json([
                'status'=>'success',
                'message'=>'SubCategory Deleted Successfully'
            ],);
        }else{
            return response()->json([
                'status'=>'failed',
                'message'=>'SubCategory Not Deleted'
            ]);
        }
    }

    public function updateStatus(Request $request){
        $category = SubCategory::where('id', $request['id'])->first();
        $category->status = $request['status'];
        if ($category->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Category Status Changed Successfully'
            ],200);
        }
    }
}
