<footer>
  <div class="container p--0">

    <div class="footer-section">
      <div class="footer-section__item">
        <h3 class="footer-header">
          Raid UK, Malta & Maldives
        </h3>
        <p>
          RAID is a fast-growing, modern, and energized diver training agency focused on bringing positive change The RAID Way™.
        </p>
        <p>
          &copy; <?= esc_attr(date('Y')) ?>. All rights reserved <?= esc_attr(get_bloginfo('name')) ?>
        </p>
      </div>
      <div class="footer-section__item">
        <h3 class="footer-header">
          What we do
        </h3>
        <?php
          wp_nav_menu([
            'theme_location' => 'footer_services',
            'container_class' => 'footer-services__wrap footer-section__nav'
          ]);
        ?>
      </div>
      <div class="footer-section__item">
        <h3 class="footer-header">
          Others
        </h3>
          <?php
              wp_nav_menu([
                  'theme_location' => 'footer_policies',
                  'container_class' => 'footer-services__wrap footer-section__nav'
              ]);
          ?>
      </div>
      <div class="footer-section__item">
        <h3 class="footer-header">
          Connect with Us
        </h3>
          <?php
              wp_nav_menu([
                  'theme_location' => 'footer_connect',
                  'container_class' => 'connect-menu__wrap footer-section__nav'
              ]);
          ?>
      </div>
    </div>

  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
