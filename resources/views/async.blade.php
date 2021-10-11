@extends('layouts.app')

@section('title','商品一覧画面')

@section('content')
  @parent

  
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
  

<!-- 非同期処理用画面遷移 -->
<button type="button" class="btn btn-secondary btn-back" onclick="location.href='{{ route('home') }}'">戻る</button>
<button type="button" class="btn btn-secondary btn-back" onclick="location.href='{{ route('list') }}'">非同期処理</button>

<div id="app">
  <table></table>
</div>

<script>
  new Vue ({
    el: '#app',

    mounted() {
      var url = '/ajax/product';
      axios.get(url).then(function(response){
        var products = response.data;
        console.log(products);
      })
    }
  })
</script>



@endsection