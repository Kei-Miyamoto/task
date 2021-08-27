@extends('layouts.app')

@section('titile', '商品情報登録画面')
@section('content')
<link href="{{ asset('css/create.css') }}" rel="stylesheet">

<div class="create-wrapper">
  <div class="container create-container">
    <div class="card create-card">
      <h4 class="card-header create-card-header">商品情報登録フォーム</h2>
      <br>
      @if (Session::has('flash_message'))
        <p>{{ session('flash_message') }}</p>
      @endif
      <form method="POST" action="{{ route('store') }}" class="card-body" onSubmit="return checkSubmit()" enctype="multipart/form-data">
        @csrf
        <div class="form-group row col- search-row">
          <label class="col-xs-12 col-sm-4 col-md-4 col-form-label" for="product_name">商品名</label>
          <input name="product_name" class="form-control col-xs-12 col-sm-8 col-md-8" type="text" value="{{ old('product_name') }}">
          @if ($errors->has('product_name'))
            <div class="text-danger">
              {{ $errors->first('product_name') }}
            </div>
          @endif
        </div>
  
        <div class="form-group row col- search-row">
          <label class="col-xs-12 col-sm-4 col-md-4 col-form-label" for="image">商品画像</label>
          <div class="img-box col-xs-12 col-sm-8 col-md-8">
            <input  class="img-select" name="image" class="" type="file" accept=".jpg,.gif,.png,image/gif,image/jpeg,image/png" id="image" value="">
          </div>
        </div>
  
        <div class="form-group row col- search-row">
          <label class="col-xs-12 col-sm-4 col-md-4 col-form-label">メーカー</label>
            <select name="company_name" class="form-control col-xs-12 col-sm-8 col-md-8" required>
              <option value="">未選択</option>
              @foreach($company as $company)
              <option value="{{ $company->company_name }}">
                {{ $company->company_name }}
              </option>  
              @endforeach 
            </select>
            @if ($errors->has('company_name'))
              <div class="text-danger">
                {{ $errors->first('company_name') }}
              </div>
            @endif
        </div>
  
        <div class="form-group row col- search-row">
          <label class="col-xs-12 col-sm-4 col-md-4 col-form-label" for="price">価格</label> 
            <input type="text" class="form-control col-xs-12 col-sm-8 col-md-8" name="price" value="{{ old('price') }}">
          @if ($errors->has('price'))
            <div class="text-danger">
              {{ $errors->first('price') }}
            </div>
          @endif
        </div>
  
        <div class="form-group row col- search-row">
          <label class="col-xs-12 col-sm-4 col-md-4 col-form-label" for="stock">在庫数</label> 
            <input type="text" class="form-control col-xs-12 col-sm-8 col-md-8" name="stock" value="{{ old('stock') }}">
          @if ($errors->has('stock'))
            <div class="text-danger">
              {{ $errors->first('stock') }}
            </div>
          @endif
        </div>
  
        <div class="form-group row col- search-row">
          <label class="col-xs-12 col-sm-4 col-md-4 col-form-label" for="comment">コメント</label> 
            <textarea type="text" class="form-control col-xs-12 col-sm-8 col-md-8" name="comment">{{ old('comment')}}</textarea>
          @if ($errors->has('comment'))
            <div class="text-danger">
              {{ $errors->first('comment') }}
            </div>
          @endif
        </div>
  
        <div class="mt-5">
          <button type="button" class="btn btn-secondary back-btn" onclick="location.href='{{ route('home') }}'">戻る</button>
          <button type="submit" class="btn btn-primary create-btn">登録</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  function checkSubmit() {
    if(window.confirm('送信してよろしいですか？'){
      return true;
    } else {
      return false;
    }
  }
</script>

@endsection