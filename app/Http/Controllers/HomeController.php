<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Schema;
use App\Http\Controllers\Controller,Session;
use App\Models\Product;
use App\Models\Company;
use App\Models;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 商品一覧を表示
     */
    public function showHome() {
      $products = Product::all();
      $companies = Company::all();
      //dd($products);
      return view('home', ['products' => $products], ['companies' => $companies]);
    }
    
    /**
     * 商品詳細を表示
     * @param int $id
     * @return view
     */
    public function showDetail($id) {
      $product = Product::find($id);
      
      if(is_null($product)) {
        \Session::flash('flash_message', 'データがありません');
        return redirect(route('home'));
      }
      
      return view('detail', ['product' => $product]);
    }
    
    /**
     * 商品情報登録画面を表示
     * @return view
     */
    public function showCreate() {
      $product = Product::all();
      $company = Company::all();
      return view('createForm', ['product' => $product],['company' => $company]);
    }
    
    /**
     * 商品情報を登録する
     * @return view
     */
    public function exeStore(PostRequest $request) {
      $inputs = $request->all();
      $companies = Company::all();

      \DB::beginTransaction();
      try {
        //商品情報を登録
        $product = Product::find($inputs['id']);
        $product->fill([
          'product_name' => $inputs['product_name'],
          'company_name' => $inputs['product->id'],
          'price' => $inputs['price'],
          'stock' => $inputs['stock'],
          'comment' => $inputs['comment'],
        ]);
        $product->save();
        \DB::commit();
      } catch (\Throwable $e){
        \DB::rollback();
        abort(500);
      }
      \Session::flash('flash_message', '商品情報を登録しました');
      return redirect(route('home'));
    }

    /**
     * 商品編集フォームを表示
     * @param int $id
     * @return view
     */
    public function showEdit($id) {
      $product = Product::find($id);

      if(is_null($product)) {
        \Session::flash('err_msg', 'データがありません');
        return redirect(route('home'));
      }
      
      return view('edit', ['product' => $product]);
    }
    
    /**
     * 商品情報を更新する
     * @return view
     */
    public function exeUpdate(PostRequest $request) {
      //商品情報データを受け取る
      $inputs = $request->all();
      \DB::beginTransaction();
      try {
        //商品情報を登録
        $product = Product::find($inputs['id']);
        
        $product->fill([
          'product_name' => $inputs['product_name'],
          'company_id' => $inputs['company_name'],
          'price' => $inputs['price'],
          'stock' => $inputs['stock'],
          'comment' => $inputs['comment'],
        ]);
        $product->save();
        \DB::commit();
      } catch (\Throwable $e){
        \DB::rollback();
        abort(500);
      }
      \Session::flash('flash_message', '商品情報を更新しました');
      return redirect(route('home'));
    }
    
    /**
     * 商品削除
     * @param int $id
     * @return view
     */
    public function exeDelete($id) {
      if(empty($id)) {
        \Session::flash('err_msg', 'データがありません');
        return redirect(route('home'));
      }
      try {
        //商品を削除する
        Product::destroy($id);
      } catch (\Throwable $e){
        abort(500);
      }
      \Session::flash('err_msg', '削除しました');
      return view('home');
    }
}