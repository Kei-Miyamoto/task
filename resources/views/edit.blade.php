@extends('layouts.app')

@section('titile', '商品情報編集')
@section('content')

<link href="{{ asset('css/form.css') }}" rel="stylesheet">

<div class="form-wrapper">
  <div class="container form-container">
    <div class="card form-card">
      <h4 class="card-header form-card-header">商品情報編集フォーム</h4>
      @if (Session::has('flash_message'))
        <p>{{ session('flash_message') }}</p>
      @endif
      <form method="POST" action="{{ route('update') }}"  class="card-body" onSubmit="return checkSubmit()" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group row col- form-row">
          <label class="col-xs-12 col-sm-4 col-md-4 col-form-label" for="product_id">商品情報ID</label>
          <input name="product_id" class="form-control col-xs-12 col-sm-7 col-md-7" type="text" value="{{ $product_edit->id }}" readonly>
        </div>
  
        <div class="form-group row col- form-row">
          <label class="col-xs-12 col-sm-4 col-md-4 col-form-label" for="product_name">商品名</label>
          <input name="product_name" class="form-control col-xs-12 col-sm-7 col-md-7" type="text" value="{{ $product_edit->product_name }}">
          @if ($errors->has('prouct_name'))
            <div class="text-danger">
              {{ $errors->first('product_name') }}
            </div>
          @endif
        </div>
  
        <div class="form-group row col- form-row">
          <label class="col-xs-12 col-sm-4 col-md-4 col-form-label" for="image">商品画像</label>
          <div class="img-box col-xs-12 col-sm-7 col-md-7">
            <input name="image" class="form-control-file" type="file" id="image" accept=".jpg,.gif,.png,image/gif,image/jpeg,image/png" value="">
          </div>
        </div>
  
        <div class="form-group row col- form-row">
          <label class="col-xs-12 col-sm-4 col-md-4 col-form-label">メーカー</label>
            <select name="company_name" class="form-control col-xs-12 col-sm-7 col-md-7" required>
              <option value="">未選択</option>
              @foreach($company as $company)
                @if($product_edit['company_id'] == $company['id'])
                  <option selected >{{ $company->company_name }}</option> 
                @else
                  <option>{{ $company->company_name }}</option>
                @endif
              @endforeach 
            </select>
            @if ($errors->has('company_name'))
              <div class="text-danger">
                {{ $errors->first('company_name') }}
              </div>
            @endif
        </div>
  
        <div class="form-group row col- form-row">
          <label class="col-xs-12 col-sm-4 col-md-4 col-form-label" for="price">価格</label> 
          <input type="text" class="form-control col-xs-12 col-sm-7 col-md-7" name="price" value="{{ $product_edit->price }}">
          @if ($errors->has('price'))
            <div class="text-danger">
              {{ $errors->first('price') }}
            </div>
          @endif
        </div>
        
        <div class="form-group row col- form-row">
          <label class="col-xs-12 col-sm-4 col-md-4 col-form-label" for="stock">在庫数</label> 
          <input type="text" class="form-control col-xs-12 col-sm-7 col-md-7" name="stock" value="{{ $product_edit->stock }}">
          @if ($errors->has('stock'))
            <div class="text-danger">
              {{ $errors->first('stock') }}
            </div>
          @endif
        </div>
        
        <div class="form-group row col- form-row">
          <label class="col-xs-12 col-sm-4 col-md-4 col-form-label" for="comment">コメント</label> 
          <textarea type="text" class="form-control col-xs-12 col-sm-7 col-md-7" name="comment" >{{ $product_edit->comment }}</textarea>
          @if ($errors->has('comment'))
            <div class="text-danger">
              {{ $errors->first('comment') }}
            </div>
          @endif
        </div>
        <div class="admin-btn">
          <button type="button" class="btn btn-secondary btn-back" onclick="location.href='{{ route('home') }}'">戻る</button>
          <button type="submit" class="btn btn-primary btn-edit">更新</button>
        </div>
      </form>
    </div>
    
  </div>
</div>
<script>
function checkSubmit(){
if(window.confirm('更新してよろしいですか？')){
    return true;
} else {
    return false;
}
}
</script>

@endsection