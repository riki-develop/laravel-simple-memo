<?php

use Illuminate\Support\Facades\Route;
// useを指定しておけば【Route】設定の際に、毎回パスを指定しなくて済む
use App\Http\Controllers\HomeController;

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

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// create.blade.phpのformで入力されるデータのルーティング設定
Route::post('/store', [HomeController::class, 'store'])->name('store');