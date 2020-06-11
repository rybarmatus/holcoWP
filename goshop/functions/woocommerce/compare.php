<?php
add_action('wp_ajax_add_product_to_compare', 'add_product_to_compare_function');
add_action('wp_ajax_nopriv_add_product_to_compare', 'add_product_to_compare_function' );

add_action('wp_ajax_remove_product_from_compare', 'remove_product_from_compare_function');
add_action('wp_ajax_nopriv_remove_product_from_compare', 'remove_product_from_compare_function');


function add_product_to_compare_function(){
    
    require_once(FUNCTIONS. '/cookie.php');
    $post_id = $_POST['product_id'];
    $cookie_value = addValueToCookie($post_id, 'compare_products');
    
    if(is_user_logged_in()) {
        update_user_meta( get_current_user_id(), 'compare_products', $cookie_value);
    }
    die();
}

function remove_product_from_compare_function(){
    
    require_once(FUNCTIONS. '/cookie.php');
    $post_id = $_POST['product_id'];
    $cookie_value = removeValFromCookie($post_id, 'compare_products');
    
    if(is_user_logged_in()) {
        update_user_meta( get_current_user_id(), 'compare_products', $cookie_value);
    }
    die();
}

function countProductsInCompare(){
    
    if(is_user_logged_in()) {
       
       $compare_products = json_decode(get_user_meta( get_current_user_id(), 'compare_products', true), true);
        
    }else if(isset($_COOKIE['compare_products']) and !empty($_COOKIE['compare_products'])){
       
       $compare_products = getCookieValue('compare_products');
       
    }else{
        return false;
    }

    if(!empty($compare_products)){
        
        return count($compare_products);
        
    }else{
    
        return 0;
    }
}

function getEncodeParam($link){
    
   if(isset($_GET['cat'])){
    $cat = '&cat='.$_GET['cat'];
   }else{
    $cat = '';
   } 
    
   if(isset($_GET['compare'])){
      return $link.'?compare='.$_GET['compare'].$cat; 
   }else{
      return $link.'?compare='.base64_encode($_COOKIE['compare_products']).$cat; 
   }

}

function getProductsInCompare($return_objects = true, $add_null = true){
    
    if(isset($_GET['compare'])){
       
       $string = base64_decode($_GET['compare']);
       
       if(!$string){
          return false;
       }
       
    }else {

        if(is_user_logged_in()) {
            $compare_products = json_decode(get_user_meta( get_current_user_id(), 'compare_products', true), true);
        }else{
            $compare_products = getCookieValue('compare_products');
        }
    
    }
    
    if(empty($compare_products)) {
        return false;
    }
    
    if($add_null){
      array_unshift($compare_products, null);
    }
    
    $compare_products = array_unique($compare_products);

    if($return_objects){
        foreach($compare_products as $key=>$product_id){
            if($add_null and !$key){
                continue;
            }
        
            $product = wc_get_product( $product_id );
            if($product){
              $compare_products[$key] = $product;
            }else{
              unset($compare_products[$key]);
            }
        }
    }
    
    return $compare_products;
        
}

function checkProductCompareStatus(int $id_product){
    
    require_once(FUNCTIONS. '/cookie.php');
    if(is_user_logged_in()) {
       
       $compare_products = json_decode(get_user_meta( get_current_user_id(), 'compare_products', true), true);
       
    }else if(isset($_COOKIE['compare_products']) and !empty($_COOKIE['compare_products'])){
       
       $compare_products = getCookieValue('compare_products');
       
    }else{
        return false;
    }
    
    if($compare_products and in_array($id_product, $compare_products)){
        return true;
    }
    return false;
}
