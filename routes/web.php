<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;

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

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/store', [HomeController::class, 'store'])->name('store');
Route::get('/edit/{id}', [HomeController::class, 'edit'])->name('edit');
Route::post('/update', [HomeController::class, 'update'])->name('update');
Route::post('/destroy', [HomeController::class, 'destroy'])->name('destroy'); // Laravelの場合、削除Classは「delete」ではなく「destory」

// 管理者ルーティング
Route::get('/login/admin', [App\Http\Controllers\Auth\LoginController::class, 'showAdminLoginForm']);
Route::get('/register/admin', [App\Http\Controllers\Auth\RegisterController::class, 'showAdminRegisterForm']);
Route::post('/login/admin', [App\Http\Controllers\Auth\LoginController::class, 'adminLogin']);
Route::post('/register/admin', [App\Http\Controllers\Auth\RegisterController::class, 'registerAdmin'])->name('admin-register');
Route::get('/admin', [AdminController::class, 'index'])->middleware('auth:admin')->name('admin-home');
// ユーザー削除関連のルーティング
Route::delete('/admin/deleteUser/{id}', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('admin.deleteUser');
Route::get('/admin/trash', [App\Http\Controllers\AdminController::class, 'trash'])->middleware('auth:admin')->name('admin.trash');
Route::post('/admin/emptyTrash', [App\Http\Controllers\AdminController::class, 'emptyTrash'])->middleware('auth:admin')->name('admin.emptyTrash');
Route::post('/admin/restoreUser/{id}', [App\Http\Controllers\AdminController::class, 'restoreUser'])->middleware('auth:admin')->name('admin.restoreUser');

// パスワードリセットルーティング
Route::get('password/admin/reset', [App\Http\Controllers\Auth\AdminForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');
Route::post('password/admin/email', [App\Http\Controllers\Auth\AdminForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.password.email');
Route::get('password/admin/reset/{token}', [App\Http\Controllers\Auth\AdminResetPasswordController::class, 'showResetForm'])->name('admin.password.reset');
Route::post('password/admin/reset', [App\Http\Controllers\Auth\AdminResetPasswordController::class, 'reset'])->name('admin.password.update');

// メール送信のルーティング
Route::get('/contact', [ContactController::class, 'showForm'])->name('contact.form');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');