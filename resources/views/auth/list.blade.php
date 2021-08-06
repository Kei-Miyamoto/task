@extends('layouts.app')
@section('list')
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
        <tr>
            <th>ID:</th>
            <th>商品画像:</th>
            <th>商品名:</th>
            <th>価格:</th>
            <th>在庫数:</th>
            <th>メーカー名:</th>
        </tr>
        </thead>
        <tbody id="tbl">
        @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <!--<td>{{ $product->img }}</td> -->
                <td>{{ $product->name }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->stock }}</td>
                <!--<td>{{ $company_name ?? ''}}</td>-->
               <!--<td>{!! nl2br(e(Str::limit($product->message, 100))) !!}-->
                <td class="text-nowrap">
                    <p><a href="" class="btn btn-primary btn-sm">詳細</a></p>
                    <p><a href="" class="btn btn-info btn-sm">編集</a></p>
                    <p><a href="" class="btn btn-danger btn-sm">削除</a></p>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
