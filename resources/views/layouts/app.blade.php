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
      <header-component></header-component>
      @yield('content') 
    </div>
    <!-- Script -->
    <script src="{{ mix('js/crud.js') }}"></script>
    <!-- エラ〜メッセージ -->
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
    <!-- 確認メッセージ -->
    <!-- <script>
      function checkDelete(){
        if(window.confirm('削除してよろしいですか？')){
          return true;
        } else {
          return false;
        }
      }
      </script> -->
    <script>
      window.Laravel = {!! json_encode(['data' => $data ?? null]) !!}
    </script>
    <script>
    
    </script>
  
  </body>
  </html>
