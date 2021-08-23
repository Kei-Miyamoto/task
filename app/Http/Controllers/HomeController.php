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
    public function showHome(Request $request) {
      $query = Product::query() and Company::query();
      //フォームを機能させるために各情報を取得viewに返す
      $companies = Company::orderBy('id', 'asc')->get(['company_name']);
      
      //$request->input()で検索時に入力した項目を取得
      $search_product_name = $request->input('search_product_name');
      $search_company_name = $request->input('search_company_name');
      
      //検索フォームで入力した文字列を含むカラム
      if (!empty($search_product_name)) {
        $query->from('products')->where('product_name','like','%'.self::escapeLike($search_product_name).'%')->get(); 
      }
      //プルダウンメニューで指定なし以外を選択した場合、$query->whereで選択した会社名と一致するからむ
      if($request->has('search_company_name') && $search_company_name != ('未選択')) {
        $query->from('companies')->where('company_name', $search_company_name )->get();
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
      ->orderBy('id','asc')
      ->leftJoin('companies', 'products.company_id', '=', 'companies.id')
      ->paginate(5);
        
      //dd($request);
      return view('home',[
        'products' => $products,
        'companies' => $companies,
        'search_product_name' => $search_product_name,
        'search_company_name' => $search_company_name,
      ]);
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
     * 商品削除
     * @param int $id
     * @return view
     */
    public function exeDelete($id) {
      if(is_null($id)) {
        \Session::flash('msg_error', 'データがありません');
        return redirect(route('home'));
      }
      try {
        //商品を削除する
        $deleteImg = Product::find($id);
        $deleteName = $deleteImg->image;
        Product::destroy($id);
        Storage::delete('public/'. $deleteName);
      } catch (\Throwable $e){
        abort(500);
      }
      \Session::flash('msg_success', '削除しました');
      return redirect(route('home'));
    }
}