<?php

function poradca_post_type() {
    $labels = array(
        'name'                  => _x( 'Poradcovia', 'Post type general name', 'goshop_admin' ),
        'singular_name'         => _x( 'Poradca', 'Post type singular name', 'goshop_admin' ),
        'menu_name'             => _x( 'Poradcovia', 'Admin Menu text', 'goshop_admin' ),
        'name_admin_bar'        => _x( 'Poradcovia', 'Add New on Toolbar', 'goshop_admin' ),
        'add_new'               => __( 'Pridat nového', 'goshop_admin' ),
        'add_new_item'          => __( 'Pridat nového poradcu', 'goshop_admin' ),
        'new_item'              => __( 'Nový poradca', 'goshop_admin' ),
        'edit_item'             => __( 'Upravit poradcu', 'goshop_admin' ),
        'view_item'             => __( 'Zobraz poradcu', 'goshop_admin' ),
        'all_items'             => __( 'Všetcia poradcovia', 'goshop_admin' ),
        'search_items'          => __( 'Hladaj poradcu', 'goshop_admin' ),
        'parent_item_colon'     => __( 'Parent Books:', 'goshop_admin' ),
        'not_found'             => __( 'Žiadny poradca sa nenašiel.', 'goshop_admin' ),
        'not_found_in_trash'    => __( 'Žiadny poradca sa v koši nenašla.', 'goshop_admin' ),
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
        'menu_icon'          => 'dashicons-businessperson',
        'supports'           => array( 'title', 'thumbnail'),
    );
 
    register_post_type( 'poradca', $args );
}
 
add_action( 'init', 'poradca_post_type' );