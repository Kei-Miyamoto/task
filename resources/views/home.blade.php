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
    <br>
    <h2 class="text-center">商品検索</h2>
    <br>
    <!--検索フォーム-->
    <div class="row">
      <div class="col-sm">
        <form method="GET" action="{{ route('home') }}">
          @csrf
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">商品名</label>
            <!--入力-->
            <div class="col-sm-5">
              <input type="search" value="{{ $search_product_name }}" class="form-control" name="search_product_name">
            </div>
            <div class="col-sm-auto">
              <button type="submit" class="btn btn-primary">検索</button>
            </div>
          </div>
      
          <!--プルダウンカテゴリ選択-->
          <div class="form-group row">
            <label class="col-sm-2">メーカー名</label>
            <div class="col-sm-3">
              <select value="search_comany_name" name="search_company_name" class="form-control" >
                <option  selected>未選択</option>
                @foreach($companies as $company)
                <option>
                  {{ $company->company_name }}
                </option>  
                @endforeach
              </select>
            </div>
          </div>
        </form>
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
  <table class="table table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>商品画像</th>
        <th>商品名</th>
        <th>価格</th>
        <th>在庫数</th>
        <th>メーカー名</th>
        <th colspan="2">管理</th>
      </tr>
    </thead>
    <tbody id="tb1">
      @foreach ($products as $product)
        <tr>
          <td>{{ $product->id }}</td>
          <td>{{ $product->img }}</td>
          <td>{{ $product->product_name }}</td>
          <td>{{ $product->price }}</td>
          <td>{{ $product->stock }}</td>
          <td>{{ $product->company_name }}</td>
          <td>{!! nl2br(e(Str::limit($product->message, 100))) !!}
          <td class="text-nowrap">
            <p><a href="/detail/{{ $product->id }}" class="btn btn-primary btn-sm">詳細</a></p>
            
            <form method="POST" action="{{ route('delete', $product->id) }}" onSubmit="return checkDelete()">
            @csrf
              <button href="" class="btn btn-danger btn-sm">削除</button>
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