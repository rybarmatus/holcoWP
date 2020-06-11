<?php
/**
 * Show messages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/notices/success.php.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* only checkout */
global $post;

if ( ! $messages or $post->ID != 8 ) {
	return;
}


        
foreach ( $messages as $message ) : ?>
  <div class="notif success woocommerce-message" role="alert">
  	<?= wc_kses_notice( $message ); ?>
  </div>
<?php endforeach; 

