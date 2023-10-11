<div id="main-drawer" class="cmk-drawer">
  <div class="backdrop"></div>
  <div class="paper">
    <?php
    wp_nav_menu(array(
      'theme_location'  => 'menu-1',
      'menu_id'         => 'primary-menu',
      'link_before'     => '<i class="fas fa-chevron-right"></i>&nbsp;',
    ));
    ?>
  </div>
</div>
<script>
(() => {
  const button = document.querySelector("#nav-menu-button");
  const drawer = document.getElementById('main-drawer');
  const backdrop = drawer.querySelector('.backdrop');
  const paper = drawer.querySelector('.paper');
  
  button.addEventListener('click', () => {
    drawer.style.display = 'block';
    paper.classList.remove("leave");
  });

  backdrop.addEventListener('click', () => {
    paper.classList.add("leave");
  });
  
  paper.addEventListener('animationend', () => {
    if (paper.classList.contains("leave")) {
      drawer.style.display = 'none';
      paper.classList.remove("leave");
    }
  });
})();
(() => {
  const sb = new SearchBox("#search-box", () => sb.close());
  const button = document.querySelector("#nav-search-button");
  button?.addEventListener('click', () => sb.open());
})();
</script>