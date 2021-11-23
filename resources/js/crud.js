const { find } = require("lodash");
const { VBtnToggle } = require("vuetify/lib");

//HOME
$(function () {
  $('#edit-btn').on('click',function () {
    if(window.confirm('更新してよろしいですか？')){
      return true;
    } else {
      return false;
    };
  })
  $('#create-btn').on('click',function () {
    if(window.confirm('作成してよろしいですか？')){
      return true;
    } else {
      return false;
    };
  })
});

$(function() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
    }
  });

  //購入モーダル表示
  $('.buy-btn').on('click', function () {
    let clickEle = $(this);
    let recipient = clickEle.data('name');
    $('#overlay, .modal-window').fadeIn();
    $('.modal-productName').append('商品名：' + recipient);
    //購入処理
    $('.js-buy').on('click', function (){
      let productID = clickEle.data('id');
      let purchase = $('#purchase').val();
      console.log(purchase)
      $.ajax({
        type: 'POST',
        url: 'api/buy/' + productID,
        dataType: 'json',
        data: {
          id : productID,
          purchase : purchase,
        },
        cache: false,
      })
      .done(function() {
        toastr.success('商品を購入しました');
      })
      .fail(function(data, xhr, err) {
        console.log(err);
        console.log(xhr);
        console.log(data || 'null');
        toastr.error('商品購入に失敗しました');
      })
      .always(function() {
        location.reload();
      });
    });
  });

  //購入モーダル非表示
  $('.js-close, #overlay, .js-buy').on('click', function () {
    $('#overlay, .modal-window').fadeOut();
    $('.modal-productName').empty();
  });

  //削除処理(初期画面)
  $(".delete-btn").on('click', function() {
    let deleteConfirm = confirm('削除してよろしいでしょうか？');

    if(deleteConfirm == true) {
    let clickEle = $(this)
    let productID = clickEle.parent().parent().attr('id');
    $.ajax ({
      url: '/product/delete/' + productID,
      type: 'POST',
      data: {id: productID, '_method': "DELETE" }
    })

    .done(function() {
      clickEle.closest('tr').remove();
      toastr.success('削除しました');
    })
    .fail(function() {
      toastr.error('削除できませんでした');
    });
    }else {
      (function(e) {
        e.preventDefault()
      });
    };
  });

  
});