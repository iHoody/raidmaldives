<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package DiveRaid
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="site-header">
    <div class="site-header__wrap">
      <div class="site-branding">
        <a href="<?= esc_url(home_url('/')) ?>">
          <img src="<?= esc_attr(get_template_directory_uri() . '/dist/images/dive-raid-logo.svg') ?>" alt="<?= esc_attr(get_bloginfo('name')) ?>">
        </a>
      </div>
      <div class="site-nav">
        <div class="site-nav__burger">
          <div id="nav-icon1">
            <span></span>
            <span></span>
            <span></span>
          </div>
        </div>
        <div class="site-nav__mobile-panel">
          <div class="site-nav__sub">
            <?php
              wp_nav_menu([
                'theme_location' => 'header_social',
                'container_class' => 'site-nav__sub-container'
              ]);
            ?>
            <div class="site-nav__sub-contact">
              <ul>
                <li class="contact-link">
                  <a href="">Contact Us <i class="icon icon-contact"></i></a>
                </li>
                <li class="book-link">
                  <a href="">Book a Call <i class="icon icon-book-call"></i></a>
                </li>
              </ul>
            </div>
          </div>
          <?php
            wp_nav_menu([
              'theme_location' => 'primary',
              'menu_class' => 'site-nav__menu',
              'container_class' => 'site-nav__container'
            ]);
          ?>
        </div>
      </div>
    </div>
  <div class="site-nav__overlay"></div>
</header>
