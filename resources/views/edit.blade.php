@extends('layouts.app')

@section('titile', '商品情報編集')
@section('content')

<div class="create-container">
  <div class="create-box">
    <h2>商品情報編集フォーム</h2>
    @if (Session::has('flash_message'))
      <p>{{ session('flash_message') }}</p>
    @endif
    <form method="POST" action="{{ route('update') }}" onSubmit="return checkSubmit()" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="id" value="{{ $product_edit->id }}">
      
      <div class="form-group row">
        <label class="col-sm-2" for="product_id">商品情報ID</label>
        <div class="col-sm-5">
          <input name="product_id" class="form-control" type="text" value="{{ $product_edit->id }}" readonly>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-sm-2" for="product_name">商品名</label>
        <div class="col-sm-5">
          <input name="product_name" class="form-control" type="text" value="{{ $product_edit->product_name }}">
        </div>
        @if ($errors->has('prouct_name'))
        <div class="text-danger">
          {{ $errors->first('product_name') }}
        </div>
        @endif
      </div>

      <div class="form-group row">
        <label class="col-sm-2" for="image">商品画像</label>
        <div class="col-sm-5">
          <input name="image" class="form-control-file" type="file" id="image" value="">
        </div>
        @if ($errors->has('image'))
          <div class="text-danger">
            {{ $errors->first('image') }}
          </div>
        @endif
      </div>

      <div class="form-group row">
        <label class="col-sm-2">メーカー</label>
        <div class="col-sm-3">
          <select name="company_name" class="form-control" required>
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
      </div>

      <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="price">価格</label> 
        <div class="col-sm-5">
          <input type="text" class="form-control" name="price" value="{{ $product_edit->price }}">
        </div>
        @if ($errors->has('price'))
          <div class="text-danger">
            {{ $errors->first('price') }}
          </div>
        @endif
      </div>
      
      <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="stock">在庫数</label> 
        <div class="col-sm-5">
          <input type="text" class="form-control" name="stock" value="{{ $product_edit->stock }}">
        </div>
        @if ($errors->has('stock'))
          <div class="text-danger">
            {{ $errors->first('stock') }}
          </div>
        @endif
      </div>
      
      <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="comment">コメント</label> 
        <div class="col-sm-5">
          <textarea type="text" class="form-control" name="comment" >{{ $product_edit->comment }}</textarea>
        </div>
        @if ($errors->has('comment'))
          <div class="text-danger">
            {{ $errors->first('comment') }}
          </div>
        @endif
      </div>
      
      <div class="mt-5">
        <button type="button" class="btn btn-secondary" onclick="location.href='{{ route('home') }}'">戻る</button>
        <button type="submit" class="btn btn-primary">更新</button>
      </div>

    </form>
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