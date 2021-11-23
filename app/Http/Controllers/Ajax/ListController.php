<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; 
use App\Http\Controllers\Schema;
use Illuminate\Pagination\paginator;
use App\Models\Product;
use App\Models\Company;

class ListController extends Controller
{

  public function home(Request $request) {

    $product = new Product;
    return $product->productList($request);
  }

  public function getCompany() {
    $getCompanyName = Company::pluck('company_name', 'id');
    return $getCompanyName;
  }

  public function ajaxSearch(Request $request) {
  /**
   * ajaxコントローラー
   */
    $company = new Company;
    $companies = self::getCompany();
    $query = Product::query();

    $searchWord = $request->product_name;
    $companyId = $request->companyId;
    $search_minPrice = $request->search_minPrice;
    $search_maxPrice = $request->search_maxPrice;
    $search_minStock = $request->search_minStock;
    $search_maxStock = $request->search_maxStock;


    //商品名による検索(部分一致)
    if(!empty($searchWord)) {
      $query->from('products')->where('product_name','like','%'.self::escapeLike($searchWord).'%')->get();
    }

    //プルダウンメニューで指定なし以外を選択した場合、$query->whereで選択した会社名と一致するからむ
    if($request->has('companyId') && $companyId != ('未選択')) {
      $query->where('company_id', $companyId)->get();
    }

    //価格検索
    if((!empty($search_minPrice) or !empty($search_maxPrice))) {
      if(empty($search_minPrice)) {
        $search_minPrice = 0;
      }
      if(empty($search_maxPrice)) {
        $search_maxPrice = 9999999;
      }
      $query->whereBetween('price',[$search_minPrice, $search_maxPrice])->get();
    }

    //在庫数検索
    if((!empty($search_minStock) or !empty($search_maxStock))) {
      if(empty($search_minStock)) {
        $search_minStock = 0;
      }
      if(empty($search_maxStock)) {
        $search_maxStock = 9999999;
      }
      $query->whereBetween('stock',[$search_minStock, $search_maxStock])->get();
    }

    //$queryをproduct_id順に並び替えて$productsに代入
    $products = $query->from('products')->select(
      'products.id as id',
      'products.product_name as product_name',
      'products.price as price',
      'products.image as image',
      'products.stock as stock',
      'companies.company_name as company_name',
      )
      ->sortable()
      ->orderBy('id','asc')
      ->leftJoin('companies', 'products.company_id', '=', 'companies.id')->get();
      
      if(count($products) <= 0) {
        \Session::flash('msg_error', 'データがありません');
      }
      //dd($request);

      return response()->json([
        'products' => $products,
        'companies' => $companies,
        'searchWord' => $searchWord,
        'companyId' => $companyId,
        'search_minPrice' => $search_minPrice,
        'search_maxPrice' => $search_maxPrice,
        'search_minStock' => $search_minStock,
        'search_maxStock' => $search_maxStock,
      ]);

    
  }

  public static function escapeLike($str) {
    return str_replace(['\\','%','_'],['\\\\','\%','\_'],$str);
  } 

}