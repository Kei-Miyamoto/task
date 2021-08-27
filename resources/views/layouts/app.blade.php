<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  @include('layouts.head')
</head>
  <body>
    <div id="app">
      @include('layouts.nav')<!-- ナビゲーション -->
    </div>
    <div id="app">
    @yield('content') <!-- コンテンツ -->
    </div>    
  </body>
</html>
