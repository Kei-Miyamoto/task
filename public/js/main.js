/* (function() {
  'use strict';
  //フラッシュメッセージのフェードアウト
  $(function() {
    $('.flash_message').fadeOut(3000);
  });
})(); */

//パスワードの表示・非表示切り替え

const passwordToggles = document.querySelectorAll('.js-password-toggle');

passwordToggles.forEach((el) => {
  el.addEventListener('change', function () {
    const password = el.previousElementSibling,
          passwordLabel = el.nextElementSibling;
    if (password.type === 'password') {
      password.type = 'text';
      passwordLabel.innerHTML = '<i class="fas fa-eye-slash"></i>';
    } else {
      password.type = 'password';
      passwordLabel.innerHTML = '<i class="fas fa-eye"></i>';
    }
    password.focus();
  });
});

