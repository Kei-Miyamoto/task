<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  @include('layouts.head')
</head>
<body>
  

  <div id="app">
    <!-- ナビゲーション-->
    @include('layouts.nav')
    
    <!-- コンテンツ -->
    @yield('content') 
  </div>
  
</body>

</html>
  