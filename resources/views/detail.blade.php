@extends('layouts.app')

@section('titile', '商品詳細画面')
@section('content')
<!--商品詳細-->
<br>
<div class="table-responsive">
  <h2 class="text-center">商品詳細</h2>
    @if (session('err_msg'))
      <p class="text-danger">
        {{ session('err_msg') }}
      </p>
    @endif
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
        <td>{{ $product->id }}</td>
        <td>{{ $product->img }}</td>
        <td>{{ $product->product_name }}</td>
        <td>{{ $product->price }}</td>
        <td>{{ $product->stock }}</td>
        <td>{{ $product->company->company_name }}</td>
        <td>{{ $product->comment }}</td>
        <td>{!! nl2br(e(Str::limit($product->message, 100))) !!}
        <td class="text-nowrap">
            <p><a href="" class="btn btn-primary btn-sm">詳細</a></p>
            <p><a href="route('detail')" class="btn btn-info btn-sm">編集</a></p>
            <p><a href="" class="btn btn-danger btn-sm">削除</a></p>
        </td>
      </tr>
    </tbody>
  </table>
</div>
@endsection
