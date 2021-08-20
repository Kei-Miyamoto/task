@extends('layouts.app')

@section('titile', 'ログイン画面')
@section('content')

<body>
  <div class="row justify-content-center">
    <div class="col-md-8">
      <br>
      <div class="card">
        <form>
          @csrf
          <h1 class="h4 mb-3 fw-normal card-header">ログイン画面</h1>
          <div class="card-body">

            <div class="form-group row">
              <label class="col-md-4 col-form-label text-md-right" for="">メールアドレス</label>
              <div class="col-md-8">
                <input type="email" class="form-control" id="" placeholder="">
              </div>
            </div>
            <br>

            <div class="form-group row">
              <label class="col-md-4 col-form-label text-md-right" for="">パスワード</label>
              <div class="col-md-8">
                <input type="password" class="form-control" id="" placeholder="">
              </div>
            </div>
            <br>
          
              <div class="col-md-8 offset-md-4">
                <button class="btn btn-primary" type="submit">ログイン</button>
              </div>
        
          </div>
        </form>
      </div>
    </div>
</div>

</body>

@endsection('content')