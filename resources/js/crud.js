const { find } = require("lodash");
const { VBtnToggle } = require("vuetify/lib");

$(function () {
  
})

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
      //dataType: 'json',
      type: 'POST',
      data: {id: productID, '_method': "DELETE" }
    })

    .done(function() {
      clickEle.closest('tr').remove();
      toastr.success('削除しました');
    })
    .fail(function() {
      toastr.error('削除できませんでした');
      //alert('エラー');
    });
    }else {
      (function(e) {
        e.preventDefault()
      });
    };
  });

  //検索
  $('#search-btn').on('click', function(){
    $('#tb1').empty();//元々ある要素を空にする
    $('.search-null').remove();//検索結果が0の時のテキストを消す

    let searchWord = $('#search-name').val();//検索ワードを取得
    let companyId = $('#companyId').val();//プルダウン
    let searchMinPrice = $('#search-minPrice').val();//検索ワードを取得
    let searchMaxPrice = $('#search-maxPrice').val();//検索ワードを取得
    let searchMinStock = $('#search-minStock').val();//検索ワードを取得
    let searchMaxStock = $('#search-maxStock').val();//検索ワードを取得
    
    $.ajax({
      type: 'GET',
      url: '/ajax/search/',
      dataType: 'json',
      data: {
        product_name : searchWord,
        companyId : companyId,
        search_minPrice : searchMinPrice,
        search_maxPrice : searchMaxPrice,
        search_minStock : searchMinStock,
        search_maxStock : searchMaxStock,
      },
      cache: false,
    })
    .done(function(data) {
      let html = '';
      $.each(data.products, function (data,value) {
        html = `
        <tr id="${value.id}">
          <td class="id" data-label="ID">${value.id}</td>
          <td class="productName" data-label="商品名">${value.product_name}</td>
          <td data-label="商品画像"><img class="img-fluid product-img" src='/storage/${value.image}' class="w-50 mb-3"/></td>
          <td data-label="価格">${value.price}</td>
          <td data-label="在庫数">${value.stock}</td>
          <td data-label="メーカー名">${value.company_name}</td>
          <td class="btn-row">
            <p class="admin-btn"><a href="/detail/${value.id}" class="btn btn-primary btn-tb detail-btn">詳細</a></p>
            <p class="admin-btn"><a class="btn btn-info btn-tb buy-btn" data-id="${value.id}" data-name="${value.product_name}" style="color:white;">購入</a></p>
            <button id="delete-btn" class="btn btn-danger admin-btn delete-btn" type="button">削除</button>
          </td>
        </tr>
        `;
        $('#tb1').append(html);
      });
      if(data.products.length == 0) {
        toastr.error('該当する商品がありません');
      }
    })
    .fail(function(data, xhr, err) {
      console.log(err);
      console.log(xhr);
      console.log(data || 'null');
    });

    $(document).ajaxComplete(function(){
      //購入モーダル表示(検索後)
      $('.buy-btn').on('click', function () {
        let clickEle = $(this);
        let recipient = clickEle.data('name');
        $('#overlay, .modal-window').fadeIn();
        $('.modal-productName').append('商品名：' + recipient);
        //購入処理
        $('.js-buy').on('click', function (){
          let productID = clickEle.data('id');
          let purchase = $('#purchase').val();
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
      
      //削除機能(検索後)
      $("#delete-btn").on('click', function() {
        var deleteConfirm = confirm('削除してよろしいでしょうか？');

        if(deleteConfirm == true) {
        var clickEle = $(this);
        var productID = clickEle.parent().parent().attr('id');
        $.ajax ({
          url: '/product/delete/' + productID,
          //dataType: 'json',
          type: 'POST',
          data: {id: productID, '_method': "DELETE" }
        })
    
        .done(function() {
          clickEle.closest('tr').remove();
          toastr.success('削除しました');
        })
        .fail(function() {
          toastr.error('削除できませんでした');
          //alert('エラー');
        });
        }else {
          (function(e) {
            e.preventDefault()
          });
        };
      });

      
    });
  });
});