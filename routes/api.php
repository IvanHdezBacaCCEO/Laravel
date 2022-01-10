<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\PostController;
use App\Http\Controllers\api\CategoryController;

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

Route::resource('post', PostController::class)->only(['index','show']);
Route::get('post/{category}/category', 'App\Http\Controllers\api\PostController@category');
Route::get('post/{url_clean}/url_clean', 'App\Http\Controllers\api\PostController@url_clean');
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::resource('category', CategoryController::class)->only(['index']);
Route::get('category/all', 'App\Http\Controllers\api\CategoryController@all');
