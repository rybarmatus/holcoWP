<?php
/* TREBA UPRAVIT LOOP NA PRODUKTY, ATTR VALUE A ATTRIBUTE NAME */

$attribute_name = 'pa_vykon-klimatizacie'; //slug of the attribute(taxonomy) with prefix 'pa_'
$attribute_new_value = 'green'; //slug of the attribute value (term)
$attribute_new_value = array('green', 'red'); // ak chcem pridat viac ako 1 vlastnost

/* loop na produkty */
$_pf = new WC_Product_Factory();
$args = array(
    'post_type'      => 'product',
    'posts_per_page' => -1,
    'paged' => 1,  // max 5
    'product_cat'    => 'klimatizacie'

);
$loop = new WP_Query( $args );
$products = $loop->posts;

foreach($products as $product){
    /* 
    $_product = $_pf->get_product($product->ID);
    $vykon = $_product->get_attribute( 'pa_vykon' );
    if(!$vykon){
    continue;
    }
    $vykon = str_replace(' kW','',$vykon);
    $vykon = str_replace(',','.',$vykon);
    $vykon = floatval($vykon);
    
    if($vykon == 2){
        $new_value = '2 kW'; 
    }else if($vykon < 3){
        $new_value = '2,5 kW';
    }else if($vykon < 4){
        $new_value = '3.5 kW';
    }else if($vykon < 4.6){
        $new_value = '4,2 kW';
    }else if($vykon == 5){
        $new_value = '5 kW';
    }else if($vykon < 6.5){
        $new_value = '6 kW';
    }else if($vykon < 7){
        $new_value = '7 kW';
    }
    
    $attribute_new_value = $new_value;
     */
    if($attribute_new_value) {
        
        $_product = $_pf->get_product($product->ID);
        
        $data = array(
            $attribute_name => array(
                'name' => $attribute_name,
                'value' => '',
                'is_visible' => '1',
                'is_variation' => '0',
                'is_taxonomy' => '1'
            )
        );
        
        $_product_attributes = get_post_meta($product->ID, '_product_attributes', true);
        wp_set_object_terms( $product->ID, $attribute_new_value, $attribute_name , false);
        update_post_meta($product->ID, '_product_attributes', array_merge($_product_attributes, $data));
    }
}


