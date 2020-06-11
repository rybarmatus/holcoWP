<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;


if ( ! $product->is_purchasable() ) {
	return;
}

echo wc_get_stock_html( $product ); // WPCS: XSS ok.

if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form class="cart add_to_cart_form" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
        <?php
        if($product->get_stock_status() == 'onbackorder'){
            $max = 99;
            $max_text = __('Ľutujeme, môžete objednať iba '.$max. ' ks tohto produktu','goshop'); 
        }else{
            $max = $product->get_stock_quantity();
            $max_text = __('Ľutujeme, máme skladom iba '.$max. ' ks tohto produktu','goshop');  
        }
        ?>
		<div class="quantity quantity-buttons">
		  <label class="screen-reader-text" for="quantity_5"><?= __('Množstvo', 'goshop') ?></label>
	      <input type="number" id="quantity_<?= $product->get_id() ?>" class="" step="1" min="1" max="<?= $max ?>" name="quantity" value="1" title="<?= __('Počet', 'goshop') ?>" data-max-text="<?= $max_text; ?>">
          <a title="<?= __('Plus', 'goshop') ?>" class="quantity_plus">
            <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M368 224H224V80c0-8.84-7.16-16-16-16h-32c-8.84 0-16 7.16-16 16v144H16c-8.84 0-16 7.16-16 16v32c0 8.84 7.16 16 16 16h144v144c0 8.84 7.16 16 16 16h32c8.84 0 16-7.16 16-16V288h144c8.84 0 16-7.16 16-16v-32c0-8.84-7.16-16-16-16z" class=""></path></svg>
          </a>
          <a title="<?= __('Mínus', 'goshop') ?>" class="quantity_minus">
            <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="minus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M368 224H16c-8.84 0-16 7.16-16 16v32c0 8.84 7.16 16 16 16h352c8.84 0 16-7.16 16-16v-32c0-8.84-7.16-16-16-16z" class=""></path></svg>
          </a>       
	    </div>
        <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />
        <button type="submit" class="add_to_cart_button single_add_to_cart_button button alt"><?= esc_html( $product->single_add_to_cart_text() ); ?></button>
        

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif;
