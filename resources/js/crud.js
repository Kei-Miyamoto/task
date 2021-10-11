
$(function() {
  //商品名検索機能
  $("#search-name").on('input', searchName);
  function searchName() {
    var results = [];
    var inputProductName = $(this).val();
    
  }


  //検索ボタン押したら
  $("#search-btn").on('click', function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
      }
    });
    var productName = $('#search-name').val();
    if(!productName) {
      return false;
    }
    $.ajax({
      url:'/home',
      type: 'GET',
      data: {
        'search-name' : searchName,
      },
      dataType:'json',
      beforeSend: function() {
        $('.loading').removeClass('display-none');
      }
      .done(function(data) {
        $('.loading').addClass('dispay-none');
        var html = '';
        $.each(data, function(index, value) {
          var id = value.id;
          var name = value.name;
          html = `
          <tr>
            <td class="id" data-label="ID">${id}</td>
            <td class="productName" data-label="商品名">${name}</td>
            <td data-label="商品画像"><img class="img-fluid product-img" src="{{ '/storage/' . ${image} }}" class="w-50 mb-3"/></td>
            <td data-label="価格">${pric}</td>
            <td data-label="在庫数">${stock}</td>
            <td data-label="メーカー名">${company_name}</td>
            <td class="btn-row">
              <p class="admin-btn"><a href="/detail/${id}" class="btn btn-primary btn-tb detail-btn">詳細</a></p>
              <button class="btn btn-danger admin-btn delete-btn" type="button">削除</button>
            </td>
          </tr>
          `
        })
        $('tbody').append(html);
        if(data.length === 0) {
          $('tr').remove();
          toastr.error('該当する商品がありません');
        }
      })
      .fail(function() {
        toastr.error('エラー');
      })
    });
  });


  //削除機能
  $(".delete-btn").on('click', function() {
    var deleteConfirm = confirm('削除してよろしいでしょうか？');
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
      }
    });
    
    if(deleteConfirm == true) {
      var clickEle = $(this)
      var productID = clickEle.parent().parent().attr('id');
      $.ajax ({
        url: '/product/delete/' + productID,
        //dataType: 'json',
        type: 'POST',
        data: {'id': productID, '_method': "DELETE" }
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
