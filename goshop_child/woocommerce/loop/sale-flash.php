<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $goshop_config;
$product_id = $product->get_id();
$terms = wp_get_object_terms( $product_id,  'product_tag' );
$on_sale = $product->is_on_sale();

if($on_sale && !$product->is_type('variable')){
  $regular_price = (float) $product->get_regular_price(); // Regular price
  $sale_price = (float) $product->get_price();
  $percent =  round( 100 - ( $sale_price / $regular_price * 100 ), 0 ) . '%';
}

if($on_sale){
    echo '<span class="badge badge-danger">-'. ($goshop_config['product_list_sale_percent'] && $percent ? $percent : '').'</span>';
}

if($terms){
    foreach($terms as $term){
      echo '<span class="badge badge-success">'.__($term->name).'</span>';
      
    }
}
