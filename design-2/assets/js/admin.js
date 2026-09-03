/**
 * Aracım Gelsin — admin panel behaviour.
 */
(function () {
  'use strict';

  // Auto-dismiss flash messages after a few seconds.
  var flash = document.querySelector('.admin-flash');
  if (flash) {
    setTimeout(function () {
      flash.style.transition = 'opacity .3s ease';
      flash.style.opacity = '0';
      setTimeout(function () { flash.remove(); }, 300);
    }, 4500);
  }

  // Mobile sidebar toggle.
  var menuBtn = document.getElementById('adminMenuToggle');
  var navBackdrop = document.getElementById('adminNavBackdrop');
  if (menuBtn) {
    menuBtn.addEventListener('click', function () {
      document.body.classList.toggle('admin-nav-open');
    });
  }
  // Tap the dimmed backdrop to close the drawer again.
  if (navBackdrop) {
    navBackdrop.addEventListener('click', function () {
      document.body.classList.remove('admin-nav-open');
    });
  }
  // Esc closes the drawer too.
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') document.body.classList.remove('admin-nav-open');
  });

  // Preview the selected file before upload, if a preview <img> follows the input.
  document.querySelectorAll('input[type="file"]').forEach(function (input) {
    input.addEventListener('change', function () {
      if (!input.files || !input.files[0]) return;
      var preview = input.parentElement.querySelector('.admin-thumb');
      if (!preview) {
        preview = document.createElement('img');
        preview.className = 'admin-thumb';
        input.insertAdjacentElement('afterend', preview);
      }
      preview.src = URL.createObjectURL(input.files[0]);
    });
  });

  // Live SVG preview next to any icon-key <select> (data-icon-picker).
  document.querySelectorAll('[data-icon-picker]').forEach(function (select) {
    var preview = select.parentElement.querySelector('.icon-picker__preview');
    if (!preview) return;
    var icons = window.__ICONS__ || {};

    function render() {
      preview.innerHTML = icons[select.value] || icons['info'] || '';
    }
    select.addEventListener('change', render);
    render();
  });
})();
