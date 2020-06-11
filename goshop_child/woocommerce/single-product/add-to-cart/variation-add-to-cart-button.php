<?php
/**
 * Single variation cart button
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;
?>
<div class="woocommerce-variation-add-to-cart variations_button">
	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	<?php
	 do_action( 'woocommerce_before_add_to_cart_quantity' );
    ?>

    <div class="quantity quantity-buttons">
	  <label class="screen-reader-text" for="quantity_5"><?= __('Množstvo', 'goshop') ?></label>
      <input type="number" id="quantity_5" class="" step="1" min="1" max="<?= $product->get_stock_quantity(); ?>" name="quantity" value="1" title="<?= __('Pocet', 'goshop') ?>" pattern="[0-9]*" inputmode="numeric" aria-labelledby="množstvo">
      <a title="<?= __('Plus','goshop') ?>" class="quantity_plus">
        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M368 224H224V80c0-8.84-7.16-16-16-16h-32c-8.84 0-16 7.16-16 16v144H16c-8.84 0-16 7.16-16 16v32c0 8.84 7.16 16 16 16h144v144c0 8.84 7.16 16 16 16h32c8.84 0 16-7.16 16-16V288h144c8.84 0 16-7.16 16-16v-32c0-8.84-7.16-16-16-16z" class=""></path></svg>
      </a>
      <a title="<?= __('Mínus','goshop') ?>" class="quantity_minus">
        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="minus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M368 224H16c-8.84 0-16 7.16-16 16v32c0 8.84 7.16 16 16 16h352c8.84 0 16-7.16 16-16v-32c0-8.84-7.16-16-16-16z" class=""></path></svg>
      </a>
	</div>

    <?php
	 do_action( 'woocommerce_after_add_to_cart_quantity' );
	?>

	<button type="submit" class="add_to_cart_button single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="variation_id" class="variation_id" value="0" />
</div>