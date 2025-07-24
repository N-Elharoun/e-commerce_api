<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function () {
    Route::post('/login', [api\AuthController::class, 'login']);
    Route::post('/register', [api\AuthController::class, 'register']);
    Route::post('/logout', [api\AuthController::class, 'logout']);
    Route::post('/refresh', [api\AuthController::class, 'refresh']);
    Route::get('/user_profile', [api\AuthController::class, 'userProfile']);
});
/// BRANDS CRUD
Route::get('/brands',[BrandController::class,'index']);
Route::get('/brands/{brand}',[BrandController::class,'show']);
Route::post('/brands',[BrandController::class,'store']);
Route::put('/brands/{brand}',[BrandController::class,'update']);
Route::delete('/brands/{brand}',[BrandController::class,'destroy']);

/// CATEGORIES CRUD
Route::get('/categories',[CategoryController::class,'index']);
Route::get('/categories/{category}',[CategoryController::class,'show']);
Route::post('/categories',[CategoryController::class,'store']);
Route::put('/categories/{category}',[CategoryController::class,'update']);
Route::delete('/categories/{category}',[CategoryController::class,'destroy']);

/// Locations CRUD
Route::post('/locations',[LocationController::class,'store']);
Route::put('/locations/{location}',[LocationController::class,'update']);
Route::delete('/locations/{location}',[LocationController::class,'destroy']);

/// Products CRUD
Route::get('/products',[ProductController::class,'index']);
Route::get('/products/{product}',[ProductController::class,'show']);
Route::post('/products',[ProductController::class,'store']);
Route::put('/products/{product}',[ProductController::class,'update']);
Route::delete('/products/{product}',[ProductController::class,'destroy']);

/// Orders CRUD
Route::get('/orders',[OrderController::class,'index']);
Route::get('/orders/{order}',[OrderController::class,'show']);
Route::post('/orders',[OrderController::class,'store']);
Route::put('/orders/{order}',[OrderController::class,'update']);
Route::delete('/orders/{order}',[OrderController::class,'destroy']);