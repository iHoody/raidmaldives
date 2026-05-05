<?php
global $allowedposttags;
$front_page_id = get_option('page_on_front');

$faq = get_field('faq_content', $front_page_id);
$faqTitle = $faq['title'];
$faqSubTitle = $faq['sub_title'];
$faqImage = $faq['faq_image'];
$faqLists = $faq['faq'];

$reviews = get_field('client_reviews', $front_page_id);
$reviewsTitle = $reviews['title'];
$reviewsSubTitle = $reviews['sub_title'];
$reviewsBackground = $reviews['background_image'];

$hidden = '';
if (is_page('blog') || is_page('events')) {
  $hidden = 'display-none';
}
?>
<div class="site-content <?= esc_attr($hidden) ?>">
  <section class="site-faq section-content">
    <h2 class="site-faq__title section-title"><?= esc_attr($faqTitle) ?></h2>
    <h5 class="site-faq__sub-title sub-title"><?= esc_attr($faqSubTitle) ?></h5>
    <div class="container">
      <div class="site-faq__content">
        <div class="site-faq__content-image">
          <img src="<?= esc_url($faqImage) ?>" alt="faq-image">
        </div>
        <?php if ($faqLists) : ?>
          <div class="site-faq_content-wrap">
            <div class="site-faq__content-button">
              <button>Expand/Collapse All</button>
            </div>
            <div class="site-faq__content-list">
              <?php foreach ($faqLists as $faqList) : ?>
                <div class="site-faq__content-list-item">
                  <h6 class="site-faq__content-list-title"><?= esc_attr($faqList['question']) ?></h6>
                  <p class="site-faq__content-list-description"><?= esc_attr($faqList['answer']) ?></p>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

</div>

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
