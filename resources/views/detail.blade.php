@extends('layouts.app')

@section('titile', '商品詳細画面')
@section('content')
<!--商品詳細-->

<link href="{{ asset('css/detail.css') }}" rel="stylesheet">
<br>
<div class="list-wrapper">
  <div class="container list-container">
    <h4 class="text-center detail-title">商品情報詳細</h4>
    <div class="table-box">
      <table class="table table-hover">
        <tbody>
          <tr class="table-heading table-active tr_row1">
            <th class="_id">ID</th>
            <th class="_name">商品名</th>
          </tr>
        
          <tr>
            <td data-label="ID" class="id">{{ $product_detail->id }}</td>
            <td data-label="商品名">{{ $product_detail->product_name }}</td>
          </tr>
        
          <tr class="table-heading table-active tr_row2">
            <th class="th_img">商品画像</th>
            <th class="th-price">価格</th>
          </tr>

          <tr>
            <td data-label="商品画像" rowspan="5"style="width:300px;height:300px;"><img src="{{ '/storage/' . $product_detail->image }}" class="product-img" /></td>
            <td data-label="価格">{{ $product_detail->price }}</td>
          </tr>
        
          <tr class="table-heading table-active tr_row3">
            <th class="th-stock">在庫数</th>
          </tr>
        
          <tr>
            <td data-label="在庫数">{{ $product_detail->stock }}</td>
          </tr>

          <tr class="table-heading table-active">
            <th class="th-maker">メーカー名</th>
          </tr>

          <tr>
            <td data-label="メーカー名">{{ $product_detail->company->company_name }}</td>
          </tr>

          <tr class="table-heading table-active">
            <th colspan="2" class="th-comment">コメント</th>  
          </tr>

          <tr>
            <td data-label="コメント" colspan="2">{!! nl2br(htmlspecialchars($product_detail->comment)) !!}</td>
          </tr>
        </tbody>
      </table>

      <div class="admin-btn btn-row">
          <a href="/home" class="btn btn-secondary btn-tb back-btn">戻る</a>
          <a href="/product/edit/{{ $product_detail->id }}" class="btn btn-info btn-tb edit-btn" style="color: white;">編集</a>
      </div>

    </div>
  </div>
</div>

@endsection
