<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; 
use App\Http\Controllers\Schema;
use Illuminate\Pagination\paginator;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Company;
use Log;

class OptionController extends Controller
{

  /**
   * 購入API
   */
  public function buy (Request $request) {
    \DB::beginTransaction();
    try {
      //在庫の減算
      $id = $request['id'];
      $parchase = $request['purchase'];
      $product = Product::find($id);
      $product->stock = $product->stock - $parchase;
      
      if($product->stock >= 0) {
        $product->save();
        //salesテーブル
        $sale = new Sale;
        $sale->product_id = $id;
        $sale->save();
        \DB::commit();
      } else {
        \DB::rollback();
        \Session::flash('msg_error', '在庫がありません');
      }
    } catch (\Throwable $e){
      \DB::rollback();
    }
    return response()->json(compact($product));
  }
}
