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


    /**
     * 商品情報を更新する
     * @return view
     */
    public function exeUpdate(PostRequest $request) {
      \DB::beginTransaction();
      try {
        $inputs = $request->all();
        $product_edit = Product::find($inputs['id']);
        $companyId = DB::table('products')->select('company_id')->leftJoin('companies', 'products.company_id', '=', 'companies.id')
          ->where('company_name', '=', $request['company_name'])
          ->get();
        $company_id = $companyId[0]->company_id;

        $inputs = [
          $product_edit->product_name = $request->product_name,
          $product_edit->company_id =  $company_id,
          $product_edit->price = $request->price,
          $product_edit->stock = $request->stock,
          $product_edit->comment = $request->comment
        ];
        $product_edit->fill($inputs)->save();

        \DB::commit();
        \Session::flash('msg_success', '商品情報を更新しました');
      } catch (\Throwable $e){
        \DB::rollback();
        abort(500);
        \Session::flash('msg_error', '商品情報を更に失敗しました');
      } 
      return redirect(route('home'));
    }
}
