@extends('layouts.app')

@section('titile', 'ユーザ新規登録画面')
@section('content')

<body>
  <div class="row justify-content-center">
    <script>
      @if (Session::has('msg_success'))
        $(function() {
          toastr.success('{{ session('msg_success') }}');
        });
      @endif
    </script>
    <script>
      @if (Session::has('msg_error'))
        $(function() {
          toastr.error('{{ session('msg_error') }}');
        });
      @endif
    </script>

    <div class="col-md-8">
      <br>
      <div class="card">
        <form class="" method="POST" action="{{ route('register') }}">
          @csrf
          <h5 class="card-header text-center">ユーザ新規登録画面</h1>

          @if ($errors->any())
            <div class="alert alert-danger">
              <ul style="">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          
          <div class="card-body">

            <div class="form-group row">
              <label class="col-md-4 col-form-label text-md-center" for="">ユーザ名</label>
              <div class="col-md-6">
                <input type="user_name" class="form-control" id="user_name" name="user_name" value="{{ old('user_name') }}" placeholder="" required>
              </div>
            </div>
              
            
            <div class="form-group row">
              <label class="col-md-4 col-form-label text-md-center" for="">メールアドレス</label>
              <div class="col-md-6">
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="" required>
              </div>
            </div>  
                
              
            <div class="form-group row boxxx">
              <label class="col-md-4 col-form-label text-md-center" for="">パスワード</label>
              <div class="col-md-6 box-pass">
                <input type="password " class="form-control js-password eye-box" id="password" name="password" placeholder="" required>
                <input class="js-password-toggle button__input hidden-box" id="password--eye" type="checkbox" name="password-eye">
                <label class="js-password-label button__label" for="password--eye"><i class="fas fa-eye"></i></label>
              </div>
            </div>
            
            <div class="form-group row boxxx">
              <label class="col-md-4 col-form-label text-md-center" for="">確認用パスワード</label>
              <div class="col-md-6 box-pass">
                <input type="password_confirmation" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="" required>
                <input class="js-password-toggle button__input hidden-box" id="password_confirmation--eye" type="checkbox" name="password_eye">
                <label class="js-password-label button__label" for="password_confirmation--eye"><i class="fas fa-eye"></i></label>
              </div>
            </div>
            
          
              <div class="text-center">
                <button class="btn btn-primary" type="submit">新規登録</button>
              </div>
        
          </div>
        </form>
      </div>
    </div>
</div>
<!-- パスワード非表示/表示 -->
<script></script>
</body>

@endsection('content')