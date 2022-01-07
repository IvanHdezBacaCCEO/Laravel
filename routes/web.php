<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\PostController;
use App\Http\Controllers\dashboard\UserController;
use App\Http\Controllers\dashboard\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::get('/acerca-de', function () {
//     return "Hello world";
// });

// Route::get('/test', function () {
//     return "Hello world test";
// });

// Route::get('/hola/{nombre?}', function ($nombre="Pepe") {
//     return "Hola: $nombre conocenos: <a href='".route("nosotros")."'>nosotros</a>";
// });

// Route::get('/sobre-nosotros-en-la-web', function () {
//     return "<h1>Toda la informacion sobre nosotros!</h1>";
// })->name("nosotros");

// Route::get('home/{nombre?}/{apellido?}', function ($nombre="Andres",$apellido ="Cruz") {

//     $posts = ["Post1","Post2","Post3","Post4"];
//     $posts2 = [];

//     //return view("home")->with("nombre", $nombre)->with("apellido", $apellido);
//     return view("home", ['nombre'=>'Victoria','apellido'=>'Mujica', 'posts'=>$posts, 'posts2'=>$posts2]);
// })->name("home");

//Route::get('post', [PostController::class, 'index']);
Route::resource('dashboard/post', PostController::class);
Route::post('dashboard/post/{post}/image', 'App\Http\Controllers\dashboard\PostController@image')->name('post.image');
Route::resource('dashboard/category', CategoryController::class);
Route::resource('dashboard/user', UserController::class);

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
