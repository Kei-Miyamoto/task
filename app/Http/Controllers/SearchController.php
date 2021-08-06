<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models;

class SearchController extends Controller
{
    public function search(Request $request) {
      $query = Product::query();

      //$request->input()で検索時に入力した項目を取得
      $search1 = $request->input('productName');
      $search2 = $request->input('companyName');

      //プルダウンメニューで指定なし以外を選択した場合、$query->whereで選択した会社名と一致するからむ
       if ($request->has('companyName') && $search2 !=('指定なし')) {
         $query->where('companyName', $search2)->get();
       }

       //検索フォームで入力した文字列を含むカラムを取得
       if($request->has('productName') && $search1 != '') {
         $query->where('productName', 'like', '%'.$search3.'%')->get();
       }

       //商品を1ページにつき10件ずつ表示させる
       $data = $query->paginate(10);
  
       return view('/home',['data' => $data]);
    }
}
