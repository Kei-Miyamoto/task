@extends('layouts.app')

@section('titile', '商品詳細画面')
@section('content')
<!--商品詳細-->
<br>
<div class="table-responsive">
  <h2 class="text-center">商品情報詳細</h2>
  <table class="table table-hover">
    <thead>
    <tr>
        <th>ID</th>
        <th>商品画像</th>
        <th>商品名</th>
        <th>価格</th>
        <th>在庫数</th>
        <th>メーカー名</th>
        <th>コメント</th>
        <th colspan="2">管理</th>
    </tr>
    </thead>
    <tbody id="tb1">
      <tr>
        <td>{{ $product_detail->id }}</td>
        <td>{{ $product_detail->img }}</td>
        <td>{{ $product_detail->product_name }}</td>
        <td>{{ $product_detail->price }}</td>
        <td>{{ $product_detail->stock }}</td>
        <td>{{ $product_detail->company->company_name }}</td>
        <td>{{ $product_detail->comment }}</td>
        <td>{!! nl2br(e(Str::limit($product_detail->message, 100))) !!}
        <td class="text-nowrap">
          <p><a href="/product/edit/{{ $product_detail->id }}" class="btn btn-info btn-sm">編集</a></p>
          <p><a href="/home" class="btn btn-secondary btn-sm">戻る</a></p>
        </td>
      </tr>
    </tbody>
  </table>
</div>
@endsection
