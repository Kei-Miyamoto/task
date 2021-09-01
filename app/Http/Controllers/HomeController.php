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

    /**
     * 商品一覧を表示
     */
    public function showHome(Request $request) {
      $company = new Company;
      $query = Product::query();
      //フォームを機能させるために各情報を取得viewに返す
      $companies = $company->getCompany();
      //$request->input()で検索時に入力した項目を取得
      $search_product_name = $request->input('search_product_name');
      $companyId = $request->input('companyId');
      
      //データがあるかどうかの確認
      $searchData = [];
      //検索フォームで入力した文字列を含むカラム
      if (!empty($search_product_name)) {
        $searchData = $query->from('products')->where('product_name','like','%'.self::escapeLike($search_product_name).'%')->get(); 
        if(count($searchData) <= 0) {
          \Session::flash('msg_error', 'データがありません');
        }
        //dd($search_pName);
      }
      //プルダウンメニューで指定なし以外を選択した場合、$query->whereで選択した会社名と一致するからむ
      if($request->has('companyId') && $companyId != ('未選択')) {
        $searchCompany = $query->where('company_id', $companyId)->get();
        if(count($searchCompany) <= 0 && count($searchData) <= 0) {
          \Session::flash('msg_error', 'データがありません');
        }
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
      ->paginate(10);
        
      //dd($request);
      return view('home',[
        'products' => $products,
        'companies' => $companies,
        'search_product_name' => $search_product_name,
        'companyId' => $companyId,
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