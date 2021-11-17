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
  <!-- Script -->
  
  <!-- エラ〜メッセージ -->
  <script src="{{ mix('js/crud.js') }}"></script>
  <script>
    //成功時
    @if (Session::has('msg_success'))
    $(function() {
      toastr.success('{{ session('msg_success') }}');
    });
    @endif
    //失敗時
    @if (Session::has('msg_error'))
    $(function() {
      toastr.error('{{ session('msg_error') }}');
    });
    @endif
    </script>
    
    <script>
      //window.Laravel = {!! json_encode(['data' => $data ?? null]) !!}
    </script>
  
  </body>
  </html>
