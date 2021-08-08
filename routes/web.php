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


Route::group(['middleware' => 'web'], function() {
  //ログイン後ホーム（商品一覧検索画面）
  Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
  
  //検索結果表示
  Route::get('/search', [App\Http\Controllers\SearchController::class, 'search'])->name('search');
  
  //商品詳細画面表示
  Route::get('/detail/{id}',[App\Http\Controllers\HomeController::class,'detail'])->name('detail');
  
  //商品編集画面表示
  Route::get('/product/edit/{id}',[App\Http\Controllers\HomeController::class,'showEdit'])->name('edit');
  //商品編集
  Route::get('/product/update',[App\Http\Controllers\HomeController::class,'exeUpdate'])->name('update');
  
  Auth::routes();
  
}); 