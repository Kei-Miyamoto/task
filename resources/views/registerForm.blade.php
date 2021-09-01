@extends('layouts.app')

@section('titile', 'ユーザ新規登録画面')
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
        <form class="" method="POST" action="{{ route('register') }}">
          @csrf
          <div class="form-group row">
            <label class="col-sm-12 col-md-3 col-lg-3 col-form-label text-md-center" for="">ユーザ名</label>
            <input type="user_name" class="form-control col-sm-12 col-md-8 col-lg-8" id="user_name" name="user_name" value="{{ old('user_name') }}" placeholder="" required>
          </div>
          
          
          <div class="form-group row">
            <label class="col-sm-12 col-md-3 col-lg-3 col-form-label text-md-center" for="">メールアドレス</label>
            <input type="email" class="form-control col-sm-12 col-md-8 col-lg-8" id="email" name="email" value="{{ old('email') }}" placeholder="" required>
          </div>  
          
          
          <div class="form-group row pass-box">
            <label class="col-md-3 col-form-label text-md-center" for="">パスワード</label>
            <input type="password " class="form-control js-password col-sm-12 col-md-8 col-lg-8" id="password" name="password" placeholder="" required>
            <input class="js-password-toggle button__input hidden-box" id="password--eye" type="checkbox" name="password-eye">
            <label class="js-password-label button__label" for="password--eye"><i class="fas fa-eye"></i></label>
          </div>
          
          <div class="form-group row pass-box">
            <label class="col-md-3 col-form-label text-md-center" for="">確認用パスワード</label>
            <input type="password_confirmation" class="form-control js-password col-sm-12 col-md-8 col-lg-8" id="password_confirmation" name="password_confirmation" placeholder="" required>
            <input class="js-password-toggle button__input hidden-box" id="password_confirmation--eye" type="checkbox" name="password_eye">
            <label class="js-password-label button__label" for="password_confirmation--eye"><i class="fas fa-eye"></i></label>
          </div>
          
          <div class="text-center">
            <button class="btn btn-primary btn-register" type="submit">新規登録</button>
          </div>
          <button type="button" class="btn btn-secondary btn-sm btn-back" onclick="location.href='{{ route('showLogin') }}'">戻る</button>
          
        </div>
      </form>
    </div>
  </div>
</div>
<!-- パスワード非表示/表示 -->
<script></script>
</body>

@endsection('content')