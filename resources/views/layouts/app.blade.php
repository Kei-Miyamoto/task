<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
  <div class="">
   @yield('content')

   @yield('search')

<!--商品検索-->
<div class="container">
      <div class="mx-auto">
        <br>
        <h2 class="text-center">商品検索画面</h2>
        <br>
        <!--検索フォーム-->
        <div class="row">
          <div class="col-sm">
            <form method="POST" action="">
              @csrf
              {{ method_field('post') }}
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
                    @foreach($products as $product)
                      <option value="{{ $product->company_id }}">
                        {{ $product->company_id }}
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
  </div>



<!--商品一覧-->
<div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
            <th>ID</th>
            <th>商品画像</th>
            <th>商品名</th>
            <th>価格</th>
            <th>在庫数</th>
            <th>メーカー名</th>
            <th colspan="2">管理</th>
        </tr>
      </thead>
      <tbody id="tb1">
        @foreach ($products as $product)
          <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->img }}</td>
            <td>{{ $product->product_name }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->stock }}</td>
           <td>{{ $company_name ?? ''}}</td>
            <td>{!! nl2br(e(Str::limit($product->message, 100))) !!}
            <td class="text-nowrap">
                <p><a href="" class="btn btn-primary btn-sm">詳細</a></p>
                <p><a href="" class="btn btn-info btn-sm">編集</a></p>
                <p><a href="" class="btn btn-danger btn-sm">削除</a></p>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

</body>
</html>
