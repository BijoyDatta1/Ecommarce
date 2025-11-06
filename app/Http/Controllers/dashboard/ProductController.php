<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

    public function updateProductPage($id)
    {
        $product = Product::where('id', $id)->first();
        if ($product) {
            $images = Image::where('product_id', $id)->get();
            return view('dashboard.pages.product.productUpdate',compact('product','images'));
        }
    }

    public function getAllProducts(){
        $product = Product::orderBy('id', 'asc')->get();
        $images = Image::all();
        if ($product->count() > 0){
            return response()->json([
                'status' => 'success',
                'product' => $product,
                'images' => $images
            ],200);
        }else{
            return response()->json([
                'status' => 'failed',
                'message' => 'Product Not Found In Database'
            ]);
        }
    }

    public function productsListPage(){
        return view('dashboard.pages.product.productList');
    }
    public function productCreatePage(){
        return view('dashboard.pages.product.productCreate');
    }
    public function productUpdatePage(){

    }

    public function store(Request $request){
        $rules = [
            'name' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'featured' => 'required',
            'display' => 'required',
            'status' => 'required',
            'images*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        if ($request->track_qty === 'yes') {
            $rules['track_qty'] = 'required';
            $rules['qty'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()
            ]);
        }
        DB::beginTransaction();
        try {
            $product = new Product();
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->compare_price = $request->compare_price;
            $product->category_id = $request->category_id;
            $product->sub_category_id = $request->sub_category_id;
            $product->brand_id = $request->brand_id;
            $product->featured = $request->featured;
            $product->display = $request->display;
            $product->status = $request->status;
            $product->sku = $request->sku;
            $product->barcode = $request->barcode;
            $product->track_qty = $request->track_qty;
            $product->qty = $request->qty;
            $product->save();

            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach($images as $image){
                    $imageName =  $product->id.rand(1000, 9999).time().'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('/uploads/product');
                    $imageSave = $image->move($destinationPath,$imageName);
                    if($imageSave){
                        $createImage = new Image();
                        $createImage->product_id = $product->id;
                        $createImage->image_url = $imageName;
                        $createImage->save();
                    }
                }
            }
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Product added successfully'
            ],200);


        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function updateProduct(Request $request)
    {
        $product = Product::find($request->id);
        if(!$product){
            return response()->json([
                'status' => 'failed',
                'message' => 'Product not found'
            ]);
        }

        $rules = [
            'name' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'featured' => 'required',
            'display' => 'required',
            'status' => 'required',
            'images*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        if ($request->track_qty === 'yes') {
            $rules['track_qty'] = 'required';
            $rules['qty'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()
            ]);
        }
        DB::beginTransaction();
        try {
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->compare_price = $request->compare_price;
            $product->category_id = $request->category_id;
            $product->sub_category_id = $request->sub_category_id;
            $product->brand_id = $request->brand_id;
            $product->featured = $request->featured;
            $product->display = $request->display;
            $product->status = $request->status;
            $product->sku = $request->sku;
            $product->barcode = $request->barcode;
            $product->track_qty = $request->track_qty;
            $product->qty = $request->qty;
            if($product->save()){
                //remove unselected image
                $removeImages = json_decode($request->removeImages, true);
                if(!empty($removeImages)){
                    foreach($removeImages as $imageID){
                        $removeImg = Image::find($imageID);
                        if($removeImg){
                           $filePath = public_path('uploads/product/'.$removeImg->image_url);
                           if(file_exists($filePath)){
                               unlink($filePath);
                           }
                        }
                    }
                }

                //add new image
                if ($request->hasFile('images')) {
                    $images = $request->images;
                    foreach($images as $image){
                        $imageName = $product->id.rand(1000, 9999).time().'.'.$image->getClientOriginalExtension();
                        $destinationPath = public_path('/uploads/product');
                        $imageSave = $image->move($destinationPath,$imageName);
                        if($imageSave){
                            Image::create([
                                'product_id' => $product->id,
                                'image_url' => $imageName,
                            ]);
                        }
                    }
                }

                DB::commit();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Product updated successfully'
                ],200);
            }

        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ]);
        }


    }

    public function deleteProduct(Request $request){
        DB::beginTransaction();
        try {
            $product = Product::find( $request->id);
            if(!$product){
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Product not found'
                ]);
            }

            $images = Image::where('product_id', $product->id)->get();
            foreach($images as $image){
                $imagePath = public_path('/uploads/product/'.$image->image_url);
                if(file_exists($imagePath)){
                    unlink($imagePath);
                }
            }

            //now delete the image
            Image::where('product_id', $product->id)->delete();

            //now delete the product
            $product->delete();
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Product deleted successfully'
            ],200);

        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function updateStatus(Request $request){
        $product = Product::where('id', $request['id'])->first();
        $product->status = $request['status'];
        if ($product->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Category Status Changed Successfully'
            ],200);
        }
    }

}
