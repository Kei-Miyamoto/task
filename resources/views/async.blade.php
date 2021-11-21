@extends('layouts.app')

@section('title','商品一覧画面')

@section('content')
  @parent

  
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">


<!-- 非同期処理用画面遷移 -->
<!-- 購入モーダルウィンドウ  -->
  <!-- オーバーレイ -->
  <div id="overlay" class="overlay"></div>
  <!-- モーダルウィンドウ -->
  <div class="modal-window" id="modaldiv">
    <div class="container modal-container">
      <div class="title modal-title">
        <h5 class="text-center">購入数を入力して下さい</h3>
      </div>
      <div class="buy-data form-group">
        <p class="modal-productName text-center"></p>
        <input id="purchase" class="form-control" type="number" min="1">
        <label class="right" for="">個</label>
      </div>
    </div>
    <!-- 閉じるボタン -->
    <button class="js-close btn btn-danger btn-tb">戻る</button>
    <button class="js-buy btn btn-success btn-tb" type="button" >購入</button>
  </div>


<div class="search-wrapper">
  <div class="container search-container">
    <div class="card search-card">
      <h4 class="text-center card-header search-card-header">商品検索</h4>
      <div class="card-body">
        <div class="search-form">
          <div class="form-group row col- search-row">
            <label class="col-xs-12 col-sm-4 col-md-4 col-form-label home-form">商品名</label>
            <!--入力-->
            <input id="search-name" type="text" class="col-xs-12 col-sm-7 col-md-7 form-control home-form" name="searchName">
          </div>
          
          <!-- プルダウンカテゴリ選択 -->
          <div class="form-group row search-row">
            <label class="col-xs-12 col-sm-4 col-md-4 col-form-label home-form">メーカー名</label>
            <select value="companyId" name="companyId" class="col-xs-12 col-sm-7 col-md-7 form-control home-form" id="companyId">
              <option>未選択</option>
              @foreach($companies as $id => $company_name)
              <option value="{{ $id }}"
              @if ($companyId === $id)
              selected
              @endif
              >{{ $company_name }}
              </option>  
              @endforeach
            </select>
          </div>
        
          <div class="form-group row search-row">
            <label class="col-xs-2 col-sm-4 col-md-4 col-form-label home-form">価格</label>
            <input id="search-minPrice" type="text" class="col-xs-2 col-sm-3 col-md-3 form-control home-form number-box" name="search-minPrice" placeholder="下限">
            <label class="col-form-label home-form col-xs-2" for="">　〜　</label>
            <input id="search-maxPrice" type="text" class="col-xs-2 col-sm-3 col-md-3 form-control home-form number-box" name="search-maxPrice" placeholder="上限">
            <label class="col-form-label home-form">　円</label>
          </div>
        
          <div class="form-group row search-row">
            <label class="col-xs-12 col-sm-4 col-md-4 col-form-label home-form">在庫数</label>
            <input id="search-minStock" type="text" class="form-control home-form number-box col-xs-4 col-sm-3 col-md-3" name="search-minStock" placeholder="下限">
            <label class="col-form-label home-form col-xs-4" for="">　〜　</label>
            <input id="search-maxStock" type="text" class="col-xs-4 col-sm-3 col-md-3 form-control home-form number-box" name="search-maxStock" placeholder="上限">
            <label class="col-form-label home-form">　個</label>
          </div>
        
          <div class="col-sm-auto search-btn-box">
            <button  id="search-btn" type="button" class="btn btn-primary search-btn btn-lg">検索</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="list-wrapper">
  <div class="container list-container">
    <h4 class="text-center product-title">商品一覧</h4>
    <p class="text-right"><a type="submit" class="btn btn-success create-btn" href="{{ route('create') }}">新規登録</a></p>
    
    <table id="table" class="table table-hover dataTable">
      <div class="dropDown">
        <ul class="dropDown-menu">
          <li class="dropDown-list"><a href="javascript:void(0)" onClick="hogeFunction();return false;" class="sort">並び替え</a>
          <ul class="items">
              <li class="item item_1">@sortablelink('id', 'ID')</li>
              <li class="item">@sortablelink('product_name','商品名')</li>
              <li class="item">@sortablelink('price', '価格')</li>
              <li class="item">@sortablelink('stock','在庫数')</li>
            </ul>
          </li>
        </ul>
      </div>
      
      <thead>
        <tr  class="table-heading table-active">
          <th class="th-id">@sortablelink('id', 'ID')</th>
          <th class="th-name">@sortablelink('product_name','商品名')</th>
          <th class="th-img">商品画像</th>
          <th class="th-price">@sortablelink('price', '価格')</th>
          <th class="th-stock">@sortablelink('stock','在庫数')</th>
          <th class="th-maker">メーカー名</th>
          <th class="th-admin">管理</th>
        </tr>
      </thead>
      <tbody id="tb1">
        @foreach ($products as $product)
          <tr id="{{ $product->id }}">
            <td id="sortId" class="id" data-label="ID">{{ $product->id }}</td>
            <td class="productName" data-label="商品名">{{ $product->product_name }}</td>
            <td data-label="商品画像"><img class="img-fluid product-img" src="{{ '/storage/' . $product->image }}" class="w-50 mb-3"/></td>
            <td data-label="価格">{{ $product->price }}</td>
            <div id="stock">
              <td data-label="在庫数">{{ $product->stock }}</td>
            </div>
            <td data-label="メーカー名">{{ $product->company_name }}</td>
            <td class="btn-row">
              <p class="admin-btn"><a href="/detail/{{ $product->id }}" class="btn btn-primary btn-tb detail-btn">詳細</a></p>
              <p class="admin-btn">
                <button class="btn btn-info btn-tb buy-btn" data-id="{{ $product->id }}" data-name="{{ $product->product_name }}" style="color:white;">購入</button>
              </p>
              <button id="delete-btn" class="btn btn-danger admin-btn delete-btn" type="button">削除</button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    {{ $products->appends(request()->query())->onEachSide(5)->links('pagination::bootstrap-4') }}  
  </div>
</div>



@endsection