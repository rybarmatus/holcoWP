<?php
/**
 * Single product short description
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/short-description.php.
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  Automattic
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;

$short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );
if ( ! $short_description ) {
return;
}
?>
<div class="single-product-excerpt mb-2">
	<?= $short_description; ?>
    <div class="scrollTo showMore pointer" data-tab="description" data-target=".tabs-nav"><?= __('Zobrazit viac', 'goshop'); ?></div>
</div>
                  