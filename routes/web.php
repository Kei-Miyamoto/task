<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
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
Route::group(['middleware' => ['guest']], function() {
  //ログインフォーム表示
  Route::get('/', [AuthController::class, 'showLogin'])->name('showLogin');
  //ログイン処理
  Route::post('login', [AuthController::class, 'login'])->name('login');
  //新規登録フォーム表示
  Route::get('registerForm', [AuthController::class, 'showRegister'])->name('showRegister');
  //新規登録処理
  Route::post('register', [AuthController::class, 'register'])->name('register');
});


Route::group(['middleware' => ['auth']], function() {
  //ログアウト
  Route::post('logout',[AuthController::class,'logout'])->name('logout');
  //ログイン後ホーム（商品一覧検索画面）
  Route::get('/home', [HomeController::class, 'showHome'])->name('home');
  
  //検索結果表示
  Route::get('/search', [HomeController::class, 'showSearch'])->name('search');
  
  //商品登録画面
  Route::get('/product/create',[HomeController::class,'showCreate'])->name('create');
  //商品登録
  Route::post('/product/store',[HomeController::class,'exeStore'])->name('store');
  
  
  //商品詳細画面表示
  Route::get('/detail/{id}',[HomeController::class,'showDetail'])->name('detail');

  //商品編集画面表示
  Route::get('/product/edit/{id}',[HomeController::class,'showEdit'])->name('edit');
  //商品編集登録
  Route::post('/product/update',[HomeController::class,'exeUpdate'])->name('update');
  
  //商品削除
  Route::post('/product/delete/{id}',[HomeController::class,'exeDelete'])->name('delete');
});

  //Auth::routes();
