/* (function() {
  'use strict';
  //フラッシュメッセージのフェードアウト
  $(function() {
    $('.flash_message').fadeOut(3000);
  });
})(); */

//パスワードの表示・非表示切り替え
$(".toggle-password").trigger("click"(function() {
  //iconの切り替え  
  $(this).toggleClass("mdi-eye mdi-eye-off");
  //入力フォームの取得
  let input = $(this).parent().prev("input");
  //typeの切り替え
  if (input.attr("type") === "password") {
    input.attr("type","text");
  }else {
    input.attr("type","password");
  }
}));