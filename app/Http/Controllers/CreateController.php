<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; 
use App\Http\Controllers\Schema;
use Illuminate\Pagination\paginator;
use App\Models\Product;
use App\Models\Company;


class CreateController extends Controller
{

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
    \DB::beginTransaction();
    try {
      $comopany = Company::all();
      $companyId = Product::select('company_id')->leftJoin('companies', 'products.company_id', '=', 'companies.id')
      ->where('company_name',$request['company_name'])
      ->get();
      
      $image = $request->file('image');
      //画像がアップレードされていればstorageに保存
      if($request->hasFile('image')) {
        $path = \Storage::put('/public', $image);
        $path = explode('/', $path);
      }else {
        $path = null;
      }
      
      $company_id = $companyId[0]->company_id;
      $product = new Product;

      //画像を登録する場合
      if($request->hasFile('image')) {
        $inputs = [
          $product->product_name = $request->product_name,
          $product->image = $path[1],
          $product->company_id =  $company_id,
          $product->price = $request->price,
          $product->stock = $request->stock,
          $product->comment = $request->comment
        ];
      }else {   //画像を登録しない場合
        $inputs = [
          $product->product_name = $request->product_name,
          $product->company_id =  $company_id,
          $product->price = $request->price,
          $product->stock = $request->stock,
          $product->comment = $request->comment
        ];
      }
      
      //dd($inputs);
      $product->fill($inputs)->save();

      \DB::commit();
      \Session::flash('msg_success', '商品情報を登録しました');
    } catch (\Throwable $e){
      \DB::rollback();
      //abort(500);
      \Session::flash('msg_error', '商品情報を登録に失敗しました');
    } 
    return redirect(route('home'));
  }

}
