@extends('layouts.app')

@section('titile', 'ログイン画面')
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
                <input type="email" class="form-control" id="" name="email" placeholder="" required>
              </div>
            </div>
            <br>

            <div class="form-group row">
              <label class="col-md-4 col-form-label text-md-right" for="">パスワード</label>
              <div class="col-md-7">
                <input type="password" class="form-control" id="" name="password" placeholder="" required>
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

</body>

@endsection('content')