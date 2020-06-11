<?php
/**
* Related Products
* @package 	WooCommerce/Templates
* @version     3.0.0
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $product;  

$related_products = wc_get_related_products($product->get_ID(), 4);

if ( $related_products ) : ?>

	<section class="related products">
        <div class="container">
		<h2><?= __( 'Podobné produkty', 'goshop' ); ?></h2>

		<?php woocommerce_product_loop_start(); ?>

			<?php foreach ( $related_products as $related_product ) : ?>

				<?php
				 	$post_object = get_post( $related_product );

					setup_postdata( $GLOBALS['post'] =& $post_object );

					wc_get_template_part( 'content', 'product' ); ?>

			<?php endforeach; ?>

		<?php woocommerce_product_loop_end(); ?>
        </div>
    </section>

<?php endif;

wp_reset_postdata();
