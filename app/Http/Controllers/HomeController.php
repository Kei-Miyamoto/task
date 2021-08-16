<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
      //$quesry = Product::query();
      $query = Product::query() and Company::query();
      //フォームを機能させるために各情報を取得viewに返す
      //$company = Company::query();
      //$product = Product::query();
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
        //with('company:company_id,company_name')->get();
        ->where('company_name',$request['company_name'])
        ->get();
        
        
        //DB::table('products')->where('company_name', '=', $request['company_name'])
        //->get();
        
        $company_id = $companyId[0]->company_id;
        $product = new Product;

        $inputs = [
          $product->product_name = $request->product_name,
          $product->company_id =  $company_id,
          $product->price = $request->price,
          $product->stock = $request->stock,
          $product->comment = $request->comment
        ];
        
        $product->fill($inputs)->save();

        \DB::commit();
      } catch (\Throwable $e){
        \DB::rollback();
        abort(500);
      } 
      \Session::flash('msg_success', '商品情報を登録しました');
      return redirect(route('home'));
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
    
    /**
     * 商品削除
     * @param int $id
     * @return view
     */
    public function exeDelete($id) {
      if(empty($id)) {
        \Session::flash('msg_error', 'データがありません');
        return redirect(route('home'));
      }
      try {
        //商品を削除する
        Product::destroy($id);
      } catch (\Throwable $e){
        abort(500);
      }
      \Session::flash('msg_success', '削除しました');
      return redirect(route('home'));
    }
}