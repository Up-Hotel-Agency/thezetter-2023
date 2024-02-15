  <!-- browser warning -->
  <div id="check-browser-pop-up" class="check-browser-pop-up">
    <div class="check-browser-pop-up__content">
      <svg width="96" height="96" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="1.47" y="1.47" width="93.06" height="93.06" rx="6.15" fill="#fff" stroke="#000" stroke-width="2.94"/><path d="M.23 18h95.1" stroke="#000" stroke-width="2.94"/><circle cx="7.76" cy="9.04" r="1.84" fill="#000"/><circle cx="14.48" cy="9.04" r="1.84" fill="#000"/><circle cx="21.21" cy="9.04" r="1.84" fill="#000"/><path fill-rule="evenodd" clip-rule="evenodd" d="M48 40.22 31.95 69.2h32.1L48 40.21Zm.78-1.37 1.18-.65 16.81 30.37a2.24 2.24 0 0 1-1.96 3.33H31.2a2.25 2.25 0 0 1-1.96-3.33L46.04 38.2a2.24 2.24 0 0 1 3.92 0l-1.18.65Z" fill="#000"/><path fill-rule="evenodd" clip-rule="evenodd" d="M48 46.66c.74 0 1.34.6 1.34 1.34v12.96a1.34 1.34 0 0 1-2.68 0V48c0-.74.6-1.34 1.34-1.34Z" fill="#000"/><path d="M48 67.57A1.8 1.8 0 1 0 48 64a1.8 1.8 0 0 0 0 3.58Z" fill="#000"/></svg>
      <h3>This browser is no longer supported</h3>
      <p>In order to have the best experience, please update your browser. If you choose not to update, this website may not function as expected. Clicking the button below will help you to update your browser.</p>
      <a href="https://browser-update.org/update-browser.html" target="_blank" class="btn-main">Update Your Browser</a>
      <a href="#" onclick="hidePopUp()" class="btn-other">Continue Without Updating</a>
    </div>
  </div>
  <?php
    $msie = strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE') ? true : false;
    if ($msie):
      wp_enqueue_style( 'ie-gte10', get_template_directory_uri() . '/assets/css/ie-gte10.css' ); 
    endif; 
  ?>

<script type="text/javascript">
  function hidePopUp() {
   document.getElementById("check-browser-pop-up").style.display = "none";
  }
</script>