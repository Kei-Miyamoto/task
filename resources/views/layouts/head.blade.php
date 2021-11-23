
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title')</title>

<!-- Scripts -->
    
<script src="{{ asset('js/pass.js') }}" defer></script>
<script src="{{ asset('js/app.js') }}" ></script>
<script src="{{ asset('js/crud.js') }}" ></script>
<script src="{{ asset('js/search.js') }}" ></script>

<!--Sessionメッセージ Script-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

<!-- datatable -->
<link rel="stylesheet" type="text/css" href="/js/datatables/datatables.min.css"/>
<script type="text/javascript" src="/js/datatables/datatables.min.js"></script>

<!-- Styles -->
<link href="{{ asset('css/default.css') }}" rel="stylesheet">

<!-- Session logo -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
<!-- eye -->
<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">

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
