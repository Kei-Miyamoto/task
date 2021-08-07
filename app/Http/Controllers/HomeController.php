<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use App\Http\Controllers\Schema;
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
    public function index() {
      $products = Product::all();
      //dd($products);
      return view('index', ['products' => $products]);
   }

   /**
     * 商品詳細を表示
     * @param int $id
     * @return view
     */
    public function detail($id) {
      $product = Product::find($id);

      if(is_null($product)) {
        \Session::flash('err_msg', 'データがありません');
        return redirect(route('index'));
      }
      
      return view('layouts.detail', ['product' => $product]);
    }

   /* 
   public function showSearch() {
     $products = Product::all();
     return view('showSearch')->with('products', $products);
   } */

   
}