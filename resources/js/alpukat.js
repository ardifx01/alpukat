// Set tahun otomatis untuk copyright
(function () {
  var el = document.getElementById('displayYear');
  if (el) el.textContent = new Date().getFullYear();
})();

// Dropdown profil (tutup-buka + klik di luar menutup)
document.addEventListener('DOMContentLoaded', function() {
  const btn = document.getElementById('profileDropdownBtn');
  const menu = document.getElementById('profileDropdownMenu');

  if (btn && menu) {
    btn.addEventListener('click', function(e) {
      e.stopPropagation();
      menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
    });

    document.addEventListener('click', function() {
      menu.style.display = 'none';
    });
  }
});
