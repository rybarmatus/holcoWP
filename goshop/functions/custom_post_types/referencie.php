<?php

function referencie_post_type() {
    $labels = array(
        'name'                  => _x( 'Referencie', 'Post type general name', 'goshop_admin' ),
        'singular_name'         => _x( 'Referencia', 'Post type singular name', 'goshop_admin' ),
        'menu_name'             => _x( 'Referencie', 'Admin Menu text', 'goshop_admin' ),
        'name_admin_bar'        => _x( 'Referencie', 'Add New on Toolbar', 'goshop_admin' ),
        'add_new'               => __( 'Pridat novú', 'goshop_admin' ),
        'add_new_item'          => __( 'Pridat novú referenciu', 'goshop_admin' ),
        'new_item'              => __( 'Nová referencia', 'goshop_admin' ),
        'edit_item'             => __( 'Upravit referenciu', 'goshop_admin' ),
        'view_item'             => __( 'Zobraz referenciu', 'goshop_admin' ),
        'all_items'             => __( 'Všetky referencie', 'goshop_admin' ),
        'search_items'          => __( 'Hladaj referenciu', 'goshop_admin' ),
        'parent_item_colon'     => __( 'Parent Books:', 'goshop_admin' ),
        'not_found'             => __( 'Žiadna referencia sa nenašla.', 'goshop_admin' ),
        'not_found_in_trash'    => __( 'Žiadna referencia sa v koši nenašla.', 'goshop_admin' ),
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
        'menu_icon'          => 'dashicons-star-empty',
        'supports'           => array( 'title', 'excerpt', 'thumbnail'),
    );
 
    register_post_type( 'referencie', $args );
}
 
add_action( 'init', 'referencie_post_type' );