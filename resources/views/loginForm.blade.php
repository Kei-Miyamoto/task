@extends('layouts.app')

@section('titile', 'ログイン画面')
@section('content')
<link href="{{ asset('css/auth.css') }}" rel="stylesheet">

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
        <form class="" method="POST" action="{{ route('login') }}">
          @csrf
          <h5 class="card-header text-center">ログイン画面</h1>

          @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          <div class="card-body">
            <div class="form-group row">
              <label class="col-md-4 col-form-label text-md-right" for="">メールアドレス</label>
              <div class="col-md-7">
                <input type="email" class="form-control" id="email" name="email" placeholder="" required>
              </div>
            </div>
            <br>

            <div class="form-group row boxxx">
              <label class="col-md-4 col-form-label text-md-right" for="">パスワード</label>
              <div class="col-md-7 box-pass">
                <input type="password" class="form-control js-password" id="password" name="password" placeholder="" required>
                <input class="js-password-toggle button__input hidden-box" id="password--eye" type="checkbox" name="password-eye">
                <label class="js-password-label button__label" for="password--eye"><i class="fas fa-eye"></i></label>
              </div>
            </div>
            <br>
          
              <div class="text-center">
                <button class="btn btn-primary" type="submit">ログイン</button>
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