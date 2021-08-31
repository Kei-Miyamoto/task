@extends('layouts.app')

@section('titile', 'ログイン画面')
@section('content')
<link href="{{ asset('css/auth.css') }}" rel="stylesheet">

<body>
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

  <div class="auth-wrapper">
    <div class="container auth-container">
      <div class="card">
        <h5 class="card-header text-center">ログイン画面</h5>
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
          <form class="" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group row">
              <label class="col-sm-12 col-md-3 col-lg-3 col-form-label text-md-center" for="">メールアドレス</label>
              <input type="email" class="form-control col-sm-12 col-md-8 col-lg-8" id="email" name="email" placeholder="" required>
            </div>
  
            <div class="form-group row pass-box">
              <label class="col-md-3 col-form-label text-md-center" for="">パスワード</label>
              <input type="password" class="form-control js-password col-sm-12 col-md-8 col-lg-8" id="password" name="password" placeholder="" required>
              <input class="js-password-toggle button__input hidden-box " id="password--eye" type="checkbox" name="password-eye">
              <label class="js-password-label button__label" for="password--eye"><i class="fas fa-eye"></i></label>
            </div>
          
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