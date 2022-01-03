<?php

use App\Http\Controllers\dashboard\PostController;
use Illuminate\Support\Facades\Route;

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
});

Route::get('/acerca-de', function () {
    return "Hello world";
});

Route::get('/test', function () {
    return "Hello world test";
});

Route::get('/hola/{nombre?}', function ($nombre="Pepe") {
    return "Hola: $nombre conocenos: <a href='".route("nosotros")."'>nosotros</a>";
});

Route::get('/sobre-nosotros-en-la-web', function () {
    return "<h1>Toda la informacion sobre nosotros!</h1>";
})->name("nosotros");

Route::get('home/{nombre?}/{apellido?}', function ($nombre="Andres",$apellido ="Cruz") {

    $posts = ["Post1","Post2","Post3","Post4"];
    $posts2 = [];

    //return view("home")->with("nombre", $nombre)->with("apellido", $apellido);
    return view("home", ['nombre'=>'Victoria','apellido'=>'Mujica', 'posts'=>$posts, 'posts2'=>$posts2]);
})->name("home");

//Route::get('post', [PostController::class, 'index']);
Route::resource('post', PostController::class);
