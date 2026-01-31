<script>
  // Toggle `user-is-tabbing` class to show focus styles only for keyboard users
  (function(){
    function handleFirstTab(e) {
      if (e.key === 'Tab') {
        document.documentElement.classList.add('user-is-tabbing');
        window.removeEventListener('keydown', handleFirstTab);
      }
    }
    window.addEventListener('keydown', handleFirstTab);
  })();
</script>
