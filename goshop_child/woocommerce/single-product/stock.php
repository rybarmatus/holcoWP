<?php
/**
 * Single Product stock.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/stock.php.
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
     $quantity = $product->get_stock_quantity();
?>
<p>
    <?php if($quantity >= 5){ ?>
    
        <?= __('Skladom viac ako 5 ks', 'goshop'); ?>
    
    <?php }else{
        
        if($quantity == 0){ ?>
        
            <span class="out-of-stock"><?= __('Produkt nie je na sklade', 'goshop'); ?></span>
        
        <?php }else if($quantity == 1){ ?>
        
            <span class="last-piece-on-stock"><?= __('Posledný kus na sklade', 'goshop'); ?></span> 
        
        <?php }else{ ?>
        
            <span class="last-pieces-on-stock"><?= __('Skladom menej ako 5 ks', 'goshop'); ?></span>
        
        <?php }
    
    } ?>
</p>
