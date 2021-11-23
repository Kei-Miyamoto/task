<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Eloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Company;
use Kyslik\ColumnSortable\Sortable; //ソート機能

class Product extends Model
{
  use HasFactory;
  use Sortable;

  protected $table = 'products';
  protected $fillable = [
    'company_id',
    'product_name',
    'image',
    'price',
    'stock',
    'comment',
  ];
  protected $guarded = [
  ];
  public function company() {
    return $this->belongsTo('App\Models\Company');
  }
  public function sales () {
    return $this->hasMany(Sale::class);
  }
  public $sortable = ['id', 'product_name', 'price', 'stock', 'company_id', ];
  
  public function getCompany() {
    $getCompanyName = Company::pluck('company_name', 'id');
    return $getCompanyName;
  }
  //商品削除
  public function deleteProduct($id) {
    $deleteImg = Product::find($id);
    $deleteName = $deleteImg->image;
    Product::destroy($id);
    Storage::delete('public/'. $deleteName);
  }
  //表示
  public function productList(Request $request) {
    
    $query = Product::query();
    //フォームを機能させるために各情報を取得viewに返す
    $companies = self::getCompany();
    //$request->input()で検索時に入力した項目を取得
    $searchWord = $request->product_name;
    $companyId = $request->companyId;
    $search_minPrice = $request->search_minPrice;
    $search_maxPrice = $request->search_maxPrice;
    $search_minStock = $request->search_minStock;
    $search_maxStock = $request->search_maxStock;
    
    //検索フォームで入力した文字列を含むカラム
    if (!empty($searchWord)) {
      $query->from('products')->where('product_name','like','%'.self::escapeLike($searchWord).'%')->get();
      //dd($search_pName);
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
    ->leftJoin('companies', 'products.company_id', '=', 'companies.id')
    ->paginate(10);
    if(count($products) <= 0) {
      \Session::flash('msg_error', 'データがありません');
    }

    return view('async',[
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

  public function productSearch(Request $request) {
    $query = Product::query();
    //フォームを機能させるために各情報を取得viewに返す
    $companies = self::getCompany();
    //$request->input()で検索時に入力した項目を取得
    $searchWord = $request->product_name;
    $companyId = $request->companyId;
    $search_minPrice = $request->search_minPrice;
    $search_maxPrice = $request->search_maxPrice;
    $search_minStock = $request->search_minStock;
    $search_maxStock = $request->search_maxStock;
    
    //検索フォームで入力した文字列を含むカラム
    if (!empty($searchWord)) {
      $query->from('products')->where('product_name','like','%'.self::escapeLike($searchWord).'%')->get();
      //dd($search_pName);
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
    ->leftJoin('companies', 'products.company_id', '=', 'companies.id')
    ->paginate(10);
    if(count($products) <= 0) {
      \Session::flash('msg_error', 'データがありません');
    }

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

  public function create(PostRequest $request) {
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
    return $inputs;
  }
}
