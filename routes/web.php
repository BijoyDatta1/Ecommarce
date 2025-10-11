<?php

use App\Http\Controllers\Authintication\AuthController;
use App\Http\Controllers\dashboard\CategoryController;
use App\Http\Controllers\dashboard\DashboardController;
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
        Route::post('/createcategory',[CategoryController::class,'create']);
    });

    Route::middleware('userRole')->group(function(){
        Route::get('/profile',[DashboardController::class,'profile']);
    });
});
