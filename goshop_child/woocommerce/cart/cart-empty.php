<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

//do_action( 'woocommerce_cart_is_empty' );

?>
<div class="container mt-2">
    <div class="mb-2 cart-empty"><strong><?= __('Váš nákupný košík je prázdny.', 'goshop'); ?></strong></div>
    <p class="return-to-shop">
        <a class="btn btn-primary btn-small" href="/">
            <?= __( 'Úvodná stránka', 'goshop' ); ?>
        </a>
    </p>
</div>