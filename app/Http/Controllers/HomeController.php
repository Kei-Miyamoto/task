<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; 
use App\Http\Controllers\Schema;
use Illuminate\Pagination\paginator;
use App\Models\Product;
use App\Models\Company;


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
    
    //セキュリティ対策
    public static function escapeLike($str) {
      return str_replace(['\\','%','_'],['\\\\','\%','\_'],$str);
    } 
    
    /**
     * 商品詳細を表示
     * @param int $id
     * @return view
     */
    public function showDetail($id) {
      $product_detail = Product::find($id);
      if(is_null($product_detail)) {
        return redirect(route('home'));
      }
      return view('detail', ['product_detail' => $product_detail]);
    }
    
    /**
     * 商品編集フォームを表示
     * @param int $id
     * @return view
     */
    public function showEdit($id) {
      $product_edit = Product::find($id);
      $company = Company::all();
      if(is_null($product_edit)) {
        \Session::flash('msg_error', 'データがありません');
        return redirect(route('home'));
      }
      return view('edit', ['product_edit' => $product_edit],['company' => $company]);
    }
    
    /**
     * 商品削除
     * @param int $id
     * @return view
     */
    public function exeDelete($id) {
      try {
        $productModel = new Product;
        $productModel->deleteProduct($id);
      } catch (\Throwable $e){
        abort(500);
      }
      exit();
    }
}