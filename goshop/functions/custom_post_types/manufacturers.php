<?php

function product_structured_data( $markup_offer, $product ) {
	
    $markup_offer['brand'] = get_product_brand_name($product->get_id());
    $markup_offer['manufacturer'] = $markup_offer['brand'];
    return $markup_offer;
}
add_filter( 'woocommerce_structured_data_product', 'product_structured_data', 10, 2 );


function get_product_brand($product_id){
   
   $manufacturer =  get_the_terms($product_id, 'manufacturers');
   if(!empty($manufacturer)){
     return $manufacturer[0];
   }else{
     return false;
   }
    
}
function get_product_brand_name($product_id){
          
   $manufacturer =  get_the_terms($product_id, 'manufacturers');
   if(!empty($manufacturer)){
    return $manufacturer[0]->name;
   }else{
    return false;
   } 
}  

add_action( 'init', 'custom_vyrobcovia_taxonomy', 0 );
 
function custom_vyrobcovia_taxonomy() {
 
  $labels = array(
    'name' =>__(  'Výrobcovia', 'goshop_admin' ),
    'singular_name' => __( 'Výrobca', 'goshop_admin' ),
    'search_items' =>  __( 'Hladat výrobcov', 'goshop_admin' ),
    'all_items' => __( 'Všecia výrobcovia', 'goshop_admin' ),
    'edit_item' => __( 'Upravit výrobcu', 'goshop_admin' ), 
    'update_item' => __( 'Upravit výrobcu', 'goshop_admin' ),
    'add_new_item' => __( 'Pridat výrobcu', 'goshop_admin' ),
    'new_item_name' => __( 'Názov nového výrobcu', 'goshop_admin' ),
    'menu_name' => __( 'Výrobcovia', 'goshop_admin' ),
    'parent_item' => __( 'Nadradený výrobca', 'goshop_admin' )
  ); 	
 
  register_taxonomy('manufacturers',array('product'), array(
    'labels' => $labels,
    'description' => 'Výrobcovia produktov',
    'show_ui' => true,
    'has_archive' => true,
    'public' => true,  
    'show_admin_column' => true,
    'query_var' => true,
    'hierarchical' => true,
    'show_in_nav_menus' => false,
    'rewrite' => array( 'slug' => 'vyrobcovia' ),
  ));
}
   
add_action('admin_head', 'remove_parents_from_manufacturers');
function remove_parents_from_manufacturers() {
  echo '<style>body.post-type-product.taxonomy-manufacturers .form-field.term-parent-wrap{display:none;}</style>';
}
