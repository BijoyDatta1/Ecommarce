<?php

use App\Http\Controllers\Authintication\AuthController;
use App\Http\Controllers\dashboard\BrandController;
use App\Http\Controllers\dashboard\CategoryController;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\dashboard\ProductController;
use App\Http\Controllers\dashboard\SubCategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/loginpage',[AuthController::class,'loginPage']);
Route::get('/registerPage',[AuthController::class,'registerPage']);
Route::get('/otpPage',[AuthController::class,'otpPage']);
Route::get('/recoveryPage',[AuthController::class,'recoveryPage']);

Route::post('/registation',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/sendotp',[AuthController::class,'SendOtp']);
Route::post('/verifyotp',[AuthController::class,'verifyOtp']);

Route::middleware('tokenVeryfy')->group(function(){
    Route::post('/logout',[AuthController::class,'logout']);
    Route::get('/resetPasswordPage',[AuthController::class,'resetPasswordPage']);
    Route::post('/resetpassword',[AuthController::class,'resetPassword']);

    Route::middleware('adminModaretorRole')->group(function(){
        Route::get('/dashboard',[DashboardController::class,'dashboard']);

        //category
        Route::get('/categorypage',[CategoryController::class,'CategoryPage']);
        Route::get('/createpage',[CategoryController::class,'CreatePage']);
        Route::get('/category/updatepage/{id}',[CategoryController::class,'UpdatePage']);
        Route::post('/createcategory',[CategoryController::class,'create']);
        Route::get('/getcategory',[CategoryController::class,'listCategory']);
        Route::post('/categoryitem',[CategoryController::class,'itemCategory']);
        Route::post('/updatestatus',[CategoryController::class,'updateStatus']);
        Route::post('/deletecategory',[CategoryController::class,'deleteCategory']);
        Route::post('/updatecategory',[CategoryController::class,'updateCategory']);

        //sub category
        Route::get('/sub/categorypage',[SubCategoryController::class,'subCateogoryPage']);
        Route::get('/sub/createpage',[SubCategoryController::class,'subCateogoryCreatePage']);
        Route::get('/sub/getcategory',[SubCategoryController::class,'subCateogoryGet']);
        Route::post('/sub/createcategory',[SubCategoryController::class,'subCategoryCreate']);
        Route::post('/sub/updatestatus',[SubCategoryController::class,'updateStatus']);
        Route::post('/sub/deletecategory',[SubCategoryController::class,'subCategoryDelete']);
        Route::get('/subCategory/updatepage/{id}',[SubCategoryController::class,'subCategoryUpdatePage']);
        Route::post('/sub/updatecategory',[SubCategoryController::class,'subCategoryUpdate']);

        //brand
        Route::get('/brandpage',[BrandController::class,'BrandPage']);
        Route::get('/brandcreatepage',[BrandController::class,'BrandCreatePage']);
        Route::post('/createbrand',[BrandController::class,'createBrand']);
        Route::get('/getbrand',[BrandController::class,'getAllBrand']);
        Route::post('/deletebrand',[BrandController::class,'deleteBrand']);
        Route::post('/updatebrandstatus',[BrandController::class,'updateStatus']);
        Route::get('/brand/updatepage/{id}',[BrandController::class,'brandUpdatePage']);
        Route::post('/updatebrand',[BrandController::class,'updateBrand']);

        //product
        Route::get('/product/createpage',[ProductController::class,'productCreatePage']);
        Route::get('/activecategory',[ProductController::class,'activeCategories']);
        Route::post('/getactivesubcategory',[ProductController::class,'activeSubCategories']);
        Route::get('/getactivebrand',[ProductController::class,'activeBrands']);






    });

    Route::middleware('userRole')->group(function(){
        Route::get('/profile',[DashboardController::class,'profile']);
    });
});
