<?php
/**
 * Template Name: Account Events Template
 *
 * @package DiveRaid
 */

global $allowedposttags;

// If user is not logged in, redirect to login page
if ( ! is_user_logged_in() ) {
  wp_redirect( home_url('/login') );
}

get_header();

$isAccountEventPage = is_page_template('templates/template-account-events.php');

$accountEventPage = get_pages([
    'meta_key' => '_wp_page_template',
    'meta_value' => 'templates/template-account-events.php',
]);

$accountEventURL = ! empty($accountEventPage) ? get_permalink($accountEventPage[0]->ID) : home_url('/account/events/');

$banner = get_field('banner', 'option');
$bannerBackground = $banner['background_image'] ?? get_template_directory_uri() . '/dist/images/default-banner.jpg';
?>

  <div class="post-content">

    <div class="entry-content">

      <section class="dive-event-banner site-banner" style="background-image: url(<?= esc_url($bannerBackground) ?>);">
        <div class="container site-banner__container dive-event-container">
          <div class="site-information">
            <h1 class="banner-title">Events</h1>
          </div>
        </div>
      </section>


    </div>

    <div class="woocommerce">

      <?php do_action( 'woocommerce_before_account_navigation' ); ?>
      <nav class="woocommerce-MyAccount-navigation" aria-label="<?php esc_html_e( 'Account pages', 'woocommerce' ); ?>">
        <ul>
          <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
            <?php if ($endpoint !== 'downloads'): ?>
              <?php
              // Remove the active class from dashboard if we're on the events page.
              $classes = wc_get_account_menu_item_classes( $endpoint );
              if ( $isAccountEventPage && $endpoint === 'dashboard' ) {
                $classes = str_replace( 'is-active', '', $classes );
              }
              ?>
              <li class="<?php echo esc_attr( $classes ); ?>">
                <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" <?php echo wc_is_current_account_menu_item( $endpoint ) ? 'aria-current="page"' : ''; ?>>
                  <?php echo esc_html( $label ); ?>
                </a>
              </li>

              <?php if ( $endpoint === 'dashboard' ): ?>
                <?php $accountEventClass = $isAccountEventPage ?
                    'woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--events is-active' :
                    'woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--events';  ?>
                <li class="<?php echo esc_attr( $accountEventClass ); ?>">
                  <a href="<?php echo esc_url( $accountEventURL ); ?>" <?php echo $isAccountEventPage ? 'aria-current="page"' : ''; ?>>
                    Events
                  </a>
                </li>
              <?php endif; ?>

            <?php endif; ?>
          <?php endforeach; ?>
        </ul>
      </nav>
      <?php do_action( 'woocommerce_after_account_navigation' ); ?>

      <div class="woocommerce-MyAccount-content">

        <div class="woocommerce-events-enrolled">
          <h3>Courses</h3>
        </div>

        <div class="woocommerce-events-enrolled">
          <h3>Events</h3>
          <div class="dive-events__list">
            <?php
              $current_user_id = get_current_user_id();
              $args = [
                'customer_id' => $current_user_id,
              ];
              $customer_orders = wc_get_orders( $args );
              $booking_model = new \Inc\Model\Booking();

              if ($customer_orders):
                foreach ($customer_orders as $order):
                  $order_id = $order->get_id();
                  $bookings_with_posts = $booking_model->getBookingsWithPostsByOrderId($order_id); ?>

                  <?php if (!empty($bookings_with_posts)): ?>
                    <?php foreach ($bookings_with_posts as $item): //var_dump('<pre>');var_dump($item);var_dump('</pre>'); ?>

                    <div class="dive-events__item">
                      <?php if (has_post_thumbnail($item[ 'post']->ID)) : ?>
                        <div class="dive-events__item-image">
                          <?= get_the_post_thumbnail($item['post']->ID, 'thumbnail') ?>
                        </div>
                      <?php endif; ?>
                      <div class="dive-events__item-details">
                        <?php
                          $eventDateTime = '';

                          $eventDate = get_field('event_date', $item['post']->ID);
                          $eventStartTime = get_field('event_start_time', $item['post']->ID);
                          $eventEndTime = get_field('event_end_time', $item['post']->ID);

                          if (isset($eventDate)) {
                            $eventDateTime = $eventDate;
                          }

                          if ($eventStartTime !== '') {
                            $eventDateTime = $eventDate . ' ' . $eventStartTime;
                          }

                          if ($eventStartTime !== '' && $eventEndTime !== '') {
                            $eventDateTime = $eventDate . ' ' . $eventStartTime . ' - ' . $eventEndTime;
                          }

                          $location = get_field('location', $item['post']->ID);
                        ?>
                        <?php if ($eventDateTime !== ''): ?>
                          <div class="dive-events__item-date">
                            <span><?= esc_attr($eventDateTime) ?></span>
                          </div>
                        <?php endif; ?>
                        <h3 class="dive-events__item-title"><?= esc_attr($item['post']->post_title) ?></h3>
                        <?php if ($location !== ''): ?>
                          <div class="dive-events__item-location">
                            <i class="icon icon-location"></i>
                            <?= esc_attr($location) ?>
                          </div>
                        <?php endif; ?>
                        <div class="dive-events__item-buttons">
                          <a href="<?= esc_url(get_permalink($item['post']->ID)) ?>" target="_blank" class="dive-events__item-button view-details">View Details <i class="icon icon-arrow-right-blue"></i></a>
                        </div>
                      </div>
                    </div>

                    <?php endforeach; ?>
                  <?php endif; ?>

                <?php endforeach;
                wp_reset_postdata();
              endif;
            ?>
          </div>
        </div>

      </div>

    </div>

  </div>

<?php
get_footer();
