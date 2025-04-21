<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Subcategory;
use App\Models\ChildCategory;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('/subcategories/{category_id}', function ($category_id) {
    return Subcategory::where('category_id', $category_id)->get();
});

Route::get('/childcategories/{subcategory_id}', function ($subcategory_id) {
    return ChildCategory::where('subcategory_id', $subcategory_id)->get();
});

