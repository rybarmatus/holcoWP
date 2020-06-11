<?php
//add Size to catalog sort
function theme_catalog_orderby( $catalog_orderby_options ) {
	
    unset($catalog_orderby_options['menu_order']);
    unset($catalog_orderby_options['popularity']);
    unset($catalog_orderby_options['rating']);
    unset($catalog_orderby_options['date']);
    
    $catalog_orderby_options['najpredavanejsie'] = __( 'Najpredávanejšie produkty', 'textdomain' );
    $catalog_orderby_options['top'] = __( 'Top produkty', 'textdomain' );
    return $catalog_orderby_options;
}

add_filter( 'woocommerce_default_catalog_orderby_options', 'theme_catalog_orderby' );
add_filter( 'woocommerce_catalog_orderby', 'theme_catalog_orderby' );

function theme_get_catalog_ordering_args( $args ) {
	$orderby_value = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
    
    if ( 'najpredavanejsie' == $orderby_value ) {
		$args['meta_key'] = 'najpredavanejsie';
		$args['orderby'] = 'meta_value_num';
		$args['order'] = 'ASC';

	}else if ( 'top' == $orderby_value ) {
		$args['meta_key'] = 'top';
		$args['orderby'] = 'meta_value_num';
		$args['order'] = 'ASC';

	}
    return $args;
}
add_filter( 'woocommerce_get_catalog_ordering_args', 'theme_get_catalog_ordering_args' );