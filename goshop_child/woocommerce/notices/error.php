<?php
/**
 * Show error messages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/notices/error.php.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! $messages ) {
	return;
}

foreach ( $messages as $message ) : ?>
  <div class="notif danger woocommerce-message" role="alert">
  	<?= wc_kses_notice( $message ); ?>
  </div>
<?php endforeach; 
