<?php
add_action('wp_ajax_add_product_to_favourite', 'add_product_to_favourite_function');
add_action('wp_ajax_nopriv_add_product_to_favourite', 'add_product_to_favourite_function' );

add_action('wp_ajax_remove_product_from_favourite', 'remove_product_from_favourite_function');
add_action('wp_ajax_nopriv_remove_product_from_favourite', 'remove_product_from_favourite_function');

function add_product_to_favourite_function(){
    
    require_once(FUNCTIONS. '/cookie.php');
    $post_id = $_POST['product_id'];
    $cookie_value = addValueToCookie($post_id, 'favourite_products');
    
    if(is_user_logged_in()) {
        update_user_meta( get_current_user_id(), 'favourite_products', $cookie_value);
    }
    die();
}

function remove_product_from_favourite_function(){
    
    require_once(FUNCTIONS. '/cookie.php');
    $post_id = $_POST['product_id'];
    $cookie_value = removeValFromCookie($post_id, 'favourite_products');
    
    if(is_user_logged_in()) {
        update_user_meta( get_current_user_id(), 'favourite_products', $cookie_value);
    }
    die();
}



function checkIfFavourite(int $id_product){
    
    if(is_user_logged_in()) {
       
       $favourite_products = json_decode(get_user_meta( get_current_user_id(), 'favourite_products', true), true);

    }else if(isset($_COOKIE['favourite_products']) and !empty($_COOKIE['favourite_products'])){
       require_once(FUNCTIONS. '/cookie.php');
       $favourite_products = getCookieValue('favourite_products');
       
    }else{
        return false;
    }
    
    if($favourite_products and in_array($id_product, $favourite_products)){
        return true;
    }
    return false;
}

function countProductsInFavourite(){
    
    if(is_user_logged_in()) {
       
       $favourite_products = json_decode(get_user_meta( get_current_user_id(), 'favourite_products', true), true);
        
    }else if(isset($_COOKIE['favourite_products']) and !empty($_COOKIE['favourite_products'])){
       
       $favourite_products = getCookieValue('favourite_products');
       
    }else{
        return 0;
    }
    
    if(!empty($favourite_products)){
        
        return count($favourite_products);
        
    }else{
    
        return 0;
    }
}
