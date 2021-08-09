@extends('layouts.app')

@section('titile', '商品情報登録画面')
@section('content')

<div class="create-container">
  <div class="create-box">
    <h2>商品情報登録</h2>
    <form method="POST" action="{{ route('store') }}" onSubmit="return checkSubmit()">
      @csrf
      <div class="form-group row">
        <label class="col-sm-2" for="product_name">商品名</label>
        <div class="col-sm-5">
          <input name="product_name" class="form-control" type="text" placheholder="商品名を入れてください">
        </div>
       <!--  @if ($errors->has('product_name'))
          <div class="text-danger">
            {{ $errors->first('product_name') }}
          </div>
        @endif -->
      </div>
      <div class="form-group row">
        <label class="col-sm-2">メーカー</label>
        <div class="col-sm-3">
          <select name="company_name" class="form-control" >
            <option value="">未選択</option>
            @foreach($product->unique('company_id') as $product)
              <option value="{{ $product->company->company_name }}">
                {{ $product->company->company_name }}
              </option>  
            @endforeach
           <!--  @if ($errors->has('company_name'))
              <div class="text-danger">
                {{ $errors->first('company_name') }}
              </div>
            @endif -->
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="price">価格</label> 
        <div class="col-sm-5">
          <input type="text" class="form-control" name="price" placheholder="価格を入れてください">
         <!--  @if ($errors->has('price'))
            <div class="text-danger">
              {{ $errors->first('price') }}
            </div>
          @endif -->
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="stock">在庫数</label> 
        <div class="col-sm-5">
          <input type="text" class="form-control" name="stocl" placheholder="在庫数を入れてください">
         <!--  @if ($errors->has('stock'))
            <div class="text-danger">
              {{ $errors->first('stock') }}
            </div>
          @endif -->
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="comment">コメント</label> 
        <div class="col-sm-5">
          <textarea type="text" class="form-control" name="comment" placheholder="コメントを入れてください"></textarea>
      <!--     @if ($errors->has('comment'))
            <div class="text-danger">
              {{ $errors->first('comment') }}
            </div>
          @endif -->
        </div>
      </div>
    </form>
  </div>
  <div class="mt-5">
    <button type="submit" class="btn btn-secondary" onclick="location.href='{{ route('home') }}'">戻る</button>
    <button type="submit" class="btn btn-primary">登録する</button>
  </div>
</div>

@endsection