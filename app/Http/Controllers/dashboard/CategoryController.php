<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function CategoryPage(){
        return view('dashboard.pages.categoryList');
    }
    public function CreatePage(){
        return view('dashboard.pages.categoryCreate ');
    }
    public function UpdatePage($id){
     $data =  Category::where('id',$id)->first();
     return view('dashboard.pages.categoryUpdate',['data'=>$data]);
    }
    public function listCategory(){
        $catgoris = Category::all();
        return response()->json([
            'status'=>'success',
            'data'=>$catgoris
        ],200);
    }
    public function itemCategory(Request $request){
        $catgoris = Category::where('id',$request['id'])->first();
        if ($catgoris){
            return response()->json([
                'status'=>'success',
                'data'=>$catgoris
            ],200);
        }else{
            return response()->json([
                'status'=>'failed',
                'massage'=>'Category data not found'
            ]);
        }
    }
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required',
            'image' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()
            ]);
        }
        if ($request->hasFile('image'))
        {
            $image = $request->file('image');
            $fileSize = $image->getSize();
            $fileSizeMB = round($fileSize / 1048576,2);
            if ($fileSizeMB > 2){
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Image size must be less than 2MB'
                ]);
            }
            if ($image->getClientOriginalExtension() == 'jpg' || $image->getClientOriginalExtension() == 'png' || $image->getClientOriginalExtension() == 'jpeg')
            {
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/category');
                $imageSave = $image->move($destinationPath, $imageName);
                if ($imageSave)
                {
                    $category = new Category();
                    $category->name = $request['name'];
                    $category->status = $request['status'];
                    $category->image = $imageName;
                    if ($category->save()) {
                        return response()->json([
                            'status' => 'success',
                            'message' => 'Category Added Successfully'
                        ],200);
                    }else{
                        return response()->json([
                            'status' => 'failed',
                            'message' => 'Category Not saved. something went wrong'
                        ]);
                    }
                }else{
                    return response()->json([
                        'status' => 'failed',
                        'message' => 'Image Upload Failed'
                    ]);
                }
            }else{
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Image must be jpg,jpeg or png'
                ]);
            }

        }else{
            return response()->json([
                'status' => 'failed',
                'message' => 'please upload image'
            ]);
        }
    }

    public function updateCategory(Request $request){
        $validation = Validator::make($request->all(),[
            'name' => 'required',
            'status' => 'required'
        ]);
        if ($validation->fails()){
            return response()->json([
                'status' => 'failed',
                'message' => $validation->errors()
            ]);
        }

        $category = Category::where('id',$request['id'])->first();

        if ($request->hasFile('image')){

            //add new file
            $image = $request->file('image');
            $fileSize = $image->getSize();
            $fileSizeMB = round($fileSize / 1048576,2);
            if ($fileSizeMB > 2){
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Image size must be less than 2MB'
                ]);
            }
            if ($image->getClientOriginalExtension() == 'jpg' || $image->getClientOriginalExtension() == 'png' || $image->getClientOriginalExtension() == 'jpeg')
            {
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/category');
                $imageSave = $image->move($destinationPath, $imageName);
                if ($imageSave) {
                    //remove the old image
                    if (file_exists(public_path('/uploads/category/'.$category->image))){
                        unlink(public_path('/uploads/category/'.$category->image));
                    }

                    //update the new image in database
                    $category->image = $imageName;
                }
            }else{
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Image must be jpg,jpeg or png'
                ]);
            }
        }

        $category->name = $request['name'];
        $category->status = $request['status'];
        if ($category->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Category Updated Successfully'
            ],200);
        }else{
            return response()->json([
                'status' => 'failed',
                'message' => 'Category Not Updated'
            ]);
        }
    }

    public function deleteCategory(Request $request){
        $category = Category::where('id',$request['id'])->first();
        if ($category->delete()){
            unlink(public_path('/uploads/category/'.$category->image));
            return response()->json([
                'status'=>'success',
                'message'=>'Category Deleted Successfully'
            ],200);
        }else{
            return response()->json([
                'status'=>'failed',
                'message'=>'Category Not Deleted'
            ]);
        }
    }

    public function updateStatus(Request $request){
        $category = Category::where('id', $request['id'])->first();
        $category->status = $request['status'];
        if ($category->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Category Status Changed Successfully'
            ],200);
        }
    }

}
