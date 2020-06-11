<?php 

function events_post_type() {
    $labels = array(
        'name'                  => _x( 'Events', 'Post type general name', 'goshop_admin' ),
        'singular_name'         => _x( 'Events', 'Post type singular name', 'goshop_admin' ),
        'menu_name'             => _x( 'Events', 'Admin Menu text', 'goshop_admin' ),
        'name_admin_bar'        => _x( 'Events', 'Add New on Toolbar', 'goshop_admin' ),
        'add_new'               => __( 'Pridat nový', 'goshop_admin' ),
        'add_new_item'          => __( 'Pridat nový event', 'goshop_admin' ),
        'new_item'              => __( 'Nový event', 'goshop_admin' ),
        'edit_item'             => __( 'Upravit event', 'goshop_admin' ),
        'view_item'             => __( 'Zobraz event', 'goshop_admin' ),
        'all_items'             => __( 'Všetky eventy', 'goshop_admin' ),
        'search_items'          => __( 'Hladaj event', 'goshop_admin' ),
        'parent_item_colon'     => __( 'Parent event:', 'goshop_admin' ),
        'not_found'             => __( 'Žiaden event sa nenašiel.', 'goshop_admin' ),
        'not_found_in_trash'    => __( 'Žiaden event sa v koši nenašiel.', 'goshop_admin' ),
    );
 
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-calendar-alt',
        'supports'           => array( 'editor','title', 'thumbnail'),

    );
    register_post_type( 'events', $args );
}
 
add_action( 'init', 'events_post_type' );