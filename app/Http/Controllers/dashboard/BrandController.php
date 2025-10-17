<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    //
    public function BrandPage(){
        return view('dashboard.pages.brand.brandList');
    }
    public function BrandCreatePage(){
        return view('dashboard.pages.brand.brandCreate');
    }
    public function brandUpdatePage($id){
        $brands = Brand::where('id',$id)->first();
        if($brands){
            return view('dashboard.pages.brand.brandUpdate',compact('brands'));
        }else{
            return response()->json([
                'status' => 'failed',
                'message' => 'Updatable Brand not found'
            ]);
        }
    }
    public function getAllBrand(){
        $brand = Brand::all();
        if(count($brand)>0){
            return response()->json([
                'status' => 'success',
                'data' => $brand
            ],200);
        }else{
            return response()->json([
                'status' => 'failed',
                'message' => 'Brand Not Found'
            ]);
        }
    }
    public function createBrand(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:brands,name',
            'status' => 'required',
            'image' => 'required',
            'display' => 'required'
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
                $destinationPath = public_path('/uploads/brand');
                $imageSave = $image->move($destinationPath, $imageName);
                if ($imageSave)
                {
                    $brand = new Brand();
                    $brand->name = $request['name'];
                    $brand->status = $request['status'];
                    $brand->display = $request['display'];
                    $brand->image = $imageName;
                    if ($brand->save()) {
                        return response()->json([
                            'status' => 'success',
                            'message' => 'Brand Added Successfully'
                        ],200);
                    }else{
                        return response()->json([
                            'status' => 'failed',
                            'message' => 'Brand Not saved. something went wrong'
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

    public function updateBrand(Request $request){
        $validation = Validator::make($request->all(),[
            'name' => 'required|unique:brands,name,'.$request['id'],
            'status' => 'required',
            'display' => 'required'
        ]);
        if ($validation->fails()){
            return response()->json([
                'status' => 'failed',
                'message' => $validation->errors()
            ]);
        }

        $brand = Brand::where('id',$request['id'])->first();

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
                $destinationPath = public_path('/uploads/brand');
                $imageSave = $image->move($destinationPath, $imageName);
                if ($imageSave) {
                    //remove the old image
                    if (file_exists(public_path('/uploads/brand/'.$brand->image))){
                        unlink(public_path('/uploads/brand/'.$brand->image));
                    }

                    //update the new image in database
                    $brand->image = $imageName;
                }
            }else{
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Image must be jpg,jpeg or png'
                ]);
            }
        }

        $brand->name = $request['name'];
        $brand->status = $request['status'];
        $brand->display = $request['display'];
        if ($brand->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Brand Updated Successfully'
            ],200);
        }else{
            return response()->json([
                'status' => 'failed',
                'message' => 'Brand Not Updated'
            ]);
        }
    }

    public function deleteBrand(Request $request){
        $brand = Brand::where('id',$request['id'])->first();
        if ($brand->delete()){
            unlink(public_path('/uploads/brand/'.$brand->image));
            return response()->json([
                'status'=>'success',
                'message'=>'Brand Deleted Successfully'
            ],200);
        }else{
            return response()->json([
                'status'=>'failed',
                'message'=>'Brand Not Deleted'
            ]);
        }
    }
    public function updateStatus(Request $request){
        $brand = Brand::where('id', $request['id'])->first();
        $brand->status = $request['status'];
        if ($brand->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Brand Status Changed Successfully'
            ],200);
        }
    }
}
