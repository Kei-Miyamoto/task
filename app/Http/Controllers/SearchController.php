<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models;

class SearchController extends Controller
{
    public function search(Request $request) {
      $query = Product::query();
      $company = Company::query();

      //$request->input()で検索時に入力した項目を取得
      $search_product = $request->input('product_name');
      $search_company = $request->input('company_name');

       //検索フォームで入力した文字列を含むカラムを取得
      if (!empty($search_product)) {
        $query->where('product_name','like','%'.$search_product.'%')->get();
      }
      //プルダウンメニューで指定なし以外を選択した場合、$query->whereで選択した会社名と一致するからむ
      if($request->has('company_name') && $search_company != '未選択') {
        $query->where('company_name', $search)->get();
      }

  
      return view('/home',['data' => $data]->with(['product_name','$search_product'],['company_name','$search_company']));
    }
}
