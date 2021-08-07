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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    /* public function index()
    {
        //home->layout.app
        return view('layouts.app');
    } */
    
    /**
     * 商品一覧を表示
     */
    public function index() {
      $products = Product::all();
      //dd($products);
      //$company_name = Models\Company::with('company_name');
      return view('layouts.app', ['products' => $products]); //('A.B')AのディレクトリーのBのブレード, ['key' => $受け取ったデータ]
   }
   /* 
   public function showSearch() {
     $products = Product::all();
     return view('showSearch')->with('products', $products);
   } */
}