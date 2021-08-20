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

        $image = $request->file('image');
        $company_id = $companyId[0]->company_id;
        //画像がアップレードされていればstorageに保存
        if($request->hasFile('image')) {
          $path = \Storage::put('/public', $image);
          $path = explode('/', $path);
          
          $inputs = [
            $product_edit->id = $request->id,
            $product_edit->product_name = $request->product_name,
            $product_edit->company_id =  $company_id,
            $product_edit->image = $path[1],
            $product_edit->price = $request->price,
            $product_edit->stock = $request->stock,
            $product_edit->comment = $request->comment
          ];
          
        }else { //画像がアップロードされていない時
          $path = null;
          $inputs = [
            $product_edit->id = $request->id,
            $product_edit->product_name = $request->product_name,
            $product_edit->image = $path,
            $product_edit->company_id =  $company_id,
            $product_edit->price = $request->price,
            $product_edit->stock = $request->stock,
            $product_edit->comment = $request->comment
          ];
        }
        
        $deleteImg = Product::find($product_edit->id);
        $deleteName = $deleteImg->image;
        Storage::delete('public/'. $deleteName);
        $product_edit->fill($inputs)->save();
        //dd($inputs);
        \DB::commit();
        \Session::flash('msg_success', '商品情報を更新しました');
      } catch (\Throwable $e){
        \DB::rollback();
        //abort(500);
        \Session::flash('msg_error', '商品情報の更新に失敗しました');
      } 
      return redirect(route('home'));
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