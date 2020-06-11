<?php 

add_filter('acf/update_value/type=date-picker', 'my_update_value_date_time_picker', 10, 3);

function my_update_value_date_time_picker( $value, $post_id, $field ) {
	
	return strtotime($value);
	
}

function banner_post_type() {
    $labels = array(
        'name'                  => _x( 'Bannery', 'Post type general name', 'goshop_admin' ),
        'singular_name'         => _x( 'Banner', 'Post type singular name', 'goshop_admin' ),
        'menu_name'             => _x( 'Bannery', 'Admin Menu text', 'goshop_admin' ),
        'name_admin_bar'        => _x( 'Bannery', 'Add New on Toolbar', 'goshop_admin' ),
        'add_new'               => __( 'Pridat nový', 'goshop_admin' ),
        'add_new_item'          => __( 'Pridat nový banner', 'goshop_admin' ),
        'new_item'              => __( 'Nový banner', 'goshop_admin' ),
        'edit_item'             => __( 'Upravit banner', 'goshop_admin' ),
        'view_item'             => __( 'Zobraz banner', 'goshop_admin' ),
        'all_items'             => __( 'Všetky bannery', 'goshop_admin' ),
        'search_items'          => __( 'Hladaj banner', 'goshop_admin' ),
        'parent_item_colon'     => __( 'Parent Books:', 'goshop_admin' ),
        'not_found'             => __( 'Žiaden banner sa nenašiel.', 'goshop_admin' ),
        'not_found_in_trash'    => __( 'Žiaden banner sa v koši nenašiel.', 'goshop_admin' ),
    );
 
    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-slides',
        'supports'           => array( 'title', 'thumbnail'),

    );
    register_post_type( 'banner', $args );
}
 
add_action( 'init', 'banner_post_type' );
