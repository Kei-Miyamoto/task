@extends('layouts.app')

@section('search')
<main>
  <div class="container">
      <div class="mx-auto">
        <br>
        <h2 class="text-center">商品検索画面</h2>
        <br>
        <!--検索フォーム-->
        <div class="row">
          <div class="col-sm">
            <form method="POST" action="{{ url('/search') }}">
              @csrf
              {{ method_field('get') }}
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">商品名</label>
                <!--入力-->
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="searchWord" placheholder="検索したい名前を入力してください">
                </div>
                <div class="col-sm-auto">
                  <button type="submit" class="btn btn-primary ">検索</button>
                </div>
              </div>     
              <!--プルダウンカテゴリ選択-->
              <div class="form-group row">
                <label class="col-sm-2">企業名</label>
                <div class="col-sm-3">
                  <select name="company_name" class="form-control" >
                    <option value="">未選択</option>
                    @foreach($products as $companyName => $company_name)
                    <option value="{{ $companyName }}">
                      {{ $company_name }}
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
</main>
@endsection