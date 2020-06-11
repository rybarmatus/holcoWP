<?php
function team_post_type() {
    $labels = array(
        'name'                  => __( 'Team', 'Post type general name', 'goshop_admin' ),
        'singular_name'         => __( 'Team', 'Post type singular name', 'goshop_admin' ),
        'menu_name'             => __( 'Team', 'Admin Menu text', 'goshop_admin' ),
        'name_admin_bar'        => __( 'Team', 'Add New on Toolbar', 'goshop_admin' ),
        'add_new'               => __( 'Pridat nového člena', 'goshop_admin' ),
        'add_new_item'          => __( 'Pridat nového člena', 'goshop_admin' ),
        'new_item'              => __( 'Nový člen', 'goshop_admin' ),
        'edit_item'             => __( 'Upravit člena', 'goshop_admin' ),
        'view_item'             => __( 'Zobraz člena', 'goshop_admin' ),
        'all_items'             => __( 'Všetcia členovia', 'goshop_admin' ),
        'search_items'          => __( 'Hladaj člena', 'goshop_admin' ),
        'parent_item_colon'     => __( 'Parent Books:', 'goshop_admin' ),
        'not_found'             => __( 'Žiadny člen tímu sa nenašiel.', 'goshop_admin' ),
        'not_found_in_trash'    => __( 'Žiadny člen tímu sa v koši nenašla.', 'goshop_admin' ),
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
        'supports'           => array( 'title', 'thumbnail', 'excerpt'),
    );
 
    register_post_type( 'team', $args );
}
 
add_action( 'init', 'team_post_type' );
