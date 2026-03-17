<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );

$isAccountEventPage = is_page_template('templates/template-account-events.php');

$accountEventPage = get_pages([
    'meta_key' => '_wp_page_template',
    'meta_value' => 'templates/template-account-events.php',
]);

$accountEventURL = ! empty($accountEventPage) ? get_permalink($accountEventPage[0]->ID) : home_url('/account/events/');
?>

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
        <li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
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
