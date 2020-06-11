<?php

/* zmení custom field na postoch */

function my_update_posts() {
    
    $args = array(
        'post_type' => 'product',
        'numberposts' => -1
    );
    $myposts = get_posts($args);
    foreach ($myposts as $mypost){
        /* tu pridat názvy fieldov */
        update_field('top', 100, $mypost->ID );
        update_field('najpredavanejsie', 100, $mypost->ID );
    }
}
add_action( 'wp_loaded', 'my_update_posts' );
