<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; 
use App\Http\Controllers\Schema;
use App\Http\Controllers\Controller,Session;
use Illuminate\Pagination\paginator;
use App\Models\Product;
use App\Models\Company;
use App\Models\User;
use App\Models\Sale;

class Detail_EditController extends Controller
{
  /**
   * 商品詳細を表示
   * @param int $id
   * @return view
   */
  public function showDetail($id) {
    $product_detail = Product::find($id);
    
    if(is_null($product_detail)) {
      \Session::flash('msg_error', 'データがありません');
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
}
