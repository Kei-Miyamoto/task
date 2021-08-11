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
  Route::get('/home', [App\Http\Controllers\HomeController::class, 'showHome'])->name('home');
  
  //検索結果表示
  Route::get('/search', [App\Http\Controllers\HomeController::class, 'showSearch'])->name('search');
  
  //商品登録画面
  Route::get('/product/create',[App\Http\Controllers\HomeController::class,'showCreate'])->name('create');
  //商品登録
  Route::post('/product/store',[App\Http\Controllers\HomeController::class,'exeStore'])->name('store');
  
  
  //商品詳細画面表示
  Route::get('/detail/{id}',[App\Http\Controllers\HomeController::class,'showDetail'])->name('detail');

  //商品編集画面表示
  Route::get('/product/edit/{id}',[App\Http\Controllers\HomeController::class,'showEdit'])->name('edit');
  //商品編集登録
  Route::post('/product/update',[App\Http\Controllers\HomeController::class,'exeUpdate'])->name('update');
  
  //商品削除
  Route::post('/product/delete/{id}',[App\Http\Controllers\HomeController::class,'exeDelete'])->name('delete');

  Auth::routes();
