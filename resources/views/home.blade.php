@extends('layouts.app')

@section('title','商品一覧画面')

@section('content')
  @parent
<!--商品検索-->
<div class="container">
  <div class="mx-auto">
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
    <div class="row">
      <div class="col-sm card search-card">
    <br> 
    <h2 class="text-center card-header search-card-header">商品検索</h2>
    <br>
    <div class="search-form"> 
      <form method="GET" action="{{ route('home') }}">
        @csrf
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">商品名</label>
          <!--入力-->
          <div class="col-sm-5">
            <input type="search" value="{{ $search_product_name }}" class="form-control" name="search_product_name">
          </div>
        </div>
        
        <!--プルダウンカテゴリ選択-->
        <div class="form-group row">
          <label class="col-sm-2">メーカー名</label>
          <div class="col-sm-3 selectbox-box">
            <select value="search_comany_name" name="search_company_name" class="form-control" id="maker">
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
            <button type="submit" class="btn btn-primary search-btn">検索</button>
          </div>
        </div>
      </form>
    </div>
      </div>
    </div>
  </div>
</div>

<!--商品一覧-->
<div class="table-responsive">
  <div class="col-sm-auto title-btn-box">
    <h2 class="text-center product-title">商品一覧</h2>
    <p><a type="submit" class="btn btn-success btn-1" href="{{ route('create') }}">新規登録</a></p>
  </div>
  <table class="table table-hover table-fix" >
    <thead>
        <tr class="table-heading">
          <th>ID</th>
          <th style="">商品名</th>
          <th style="">商品画像</th>
          <th>価格</th>
          <th>在庫数</th>
          <th style=>メーカー名</th>
          <th colspan="">管理</th>
        </tr>

    </thead>
    <tbody id="tb1">
      @foreach ($products as $product)
        <tr>
          <td>{{ $product->id }}</td>
          <td>{{ $product->product_name }}</td>
          <td class=""><img class="img-fluid" src="{{ '/storage/' . $product->image }}" class="w-100 mb-3" /></td>
          <td>{{ $product->price }}</td>
          <td>{{ $product->stock }}</td>
          <td>{{ $product->company_name }}</td>
          <td class="text-nowrap ">
            <p class="admin-btn"><a href="/detail/{{ $product->id }}" class="btn btn-primary btn-sm">詳細</a></p>
            <form method="POST" action="{{ route('delete', $product->id) }}" onSubmit="return checkDelete()">
            @csrf
              <button href="" class="btn btn-danger btn-sm admin-btn">削除</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

{{ $products->onEachSide(5)->links('pagination::bootstrap-4') }}

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