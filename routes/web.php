<?php

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



//ログイン後ホーム（商品一覧検索画面）
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

//検索結果表示
Route::get('/search', [App\Http\Controllers\SearchController::class, 'search'])->name('search');

//商品詳細画面表示
Route::get('/detail/{id}',[App\Http\Controllers\HomeController::class,'detail'])->name('detail');

Auth::routes();