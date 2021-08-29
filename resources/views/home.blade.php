@extends('layouts.app')

@section('title','商品一覧画面')

@section('content')
  @parent

  
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
  
<script>
//成功時
  @if (Session::has('msg_success'))
    $(function() {
      toastr.success('{{ session('msg_success') }}');
    });
  @endif
  //失敗時
  @if (Session::has('msg_error'))
    $(function() {
      toastr.error('{{ session('msg_error') }}');
    });
  @endif
</script>

<!--検索フォーム-->
<div class="search-wrapper">
  <div class="container search-container">
    <div class="card search-card">
      <h4 class="text-center card-header search-card-header">商品検索</h4>
      <div class="card-body">
        <form method="GET" class="search-form" action="{{ route('home') }}">
          @csrf
          <div class="form-group row col- search-row">
            <label class="col-xs-12 col-sm-4 col-md-4 col-form-label home-form">商品名</label>
            <!--入力-->
            <input type="search" value="{{ $search_product_name }}" class="col-xs-12 col-sm-7 col-md-7 form-control home-form" name="search_product_name">
          </div>
          
          <!--プルダウンカテゴリ選択-->
          <div class="form-group row search-row search-row-btm">
            <label class="col-xs-12 col-sm-4 col-md-4 col-form-label home-form">メーカー名</label>
              <select value="search_comany_name" name="search_company_name" class="col-xs-12 col-sm-7 col-md-7 form-control home-form" id="maker">
                <option>未選択</option>
                @foreach($companies as $company)
                <option value="{{ $company->company_name }}"
                  @if ($search_company_name == $company->company_name)
                  selected
                  @endif
                  >{{ $company->company_name }}
                </option>  
                @endforeach
              </select>
          </div>
          <div class="col-sm-auto search-btn-box">
            <button type="submit" class="btn btn-primary search-btn btn-lg">検索</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
      
<!--商品一覧-->
<div class="list-wrapper">
  <div class="container list-container">
    <h4 class="text-center product-title">商品一覧</h4>
    <p class="text-right"><a type="submit" class="btn btn-success create-btn" href="{{ route('create') }}">新規登録</a></p>
    <table class="table  table-hover" >
      <thead>
        <tr  class="table-heading table-active">
          <th class="th-id">ID</th>
          <th class="th-name">商品名</th>
          <th class="th-img">商品画像</th>
          <th class="th-price">価格</th>
          <th class="th-stock">在庫数</th>
          <th class="th-maker">メーカー名</th>
          <th class="th-admin">管理</th>
        </tr>
        
      </thead>
      <tbody id="tb1">
        @foreach ($products as $product)
        <tr>
          <td class="id" data-label="ID">{{ $product->id }}</td>
          <td  data-label="商品名">{{ $product->product_name }}</td>
          <td  data-label="商品画像"><img class="img-fluid product-img" src="{{ '/storage/' . $product->image }}" class="w-50 mb-3"/></td>
          <td  data-label="価格">{{ $product->price }}</td>
          <td  data-label="在庫数">{{ $product->stock }}</td>
          <td  data-label="メーカー名">{{ $product->company_name }}</td>
          <td class="btn-row">
            <p class="admin-btn"><a href="/detail/{{ $product->id }}" class="btn btn-primary btn-tb detail-btn">詳細</a></p>
            <form method="POST" action="{{ route('delete', $product->id) }}" onSubmit="return checkDelete()">
              @csrf
              <button href="" class="btn btn-danger  admin-btn">削除</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{ $products->onEachSide(5)->links('pagination::bootstrap-4') }}  
  </div>
</div>
      <script>
        function checkDelete(){
          if(window.confirm('削除してよろしいですか？')){
            return true;
          } else {
            return false;
          }
        }
      </script>

@endsection