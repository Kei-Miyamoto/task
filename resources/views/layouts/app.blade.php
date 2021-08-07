<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  @include('layouts.head')
</head>
  <body>
    <div id="app">
      @include('layouts.nav')
    </div>
    <div id="app">
    @yield('index') <!-- 商品検索と商品情報 -->
    </div>    
  </body>
</html>
