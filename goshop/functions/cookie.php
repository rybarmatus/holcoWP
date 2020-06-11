<?php

function addValueToCookie(int $post_id, $cookie_key, $time = 15778463){ // pol roka
    
  if ( isset($_COOKIE[$cookie_key]) ){
    $items = json_decode($_COOKIE[$cookie_key], true);
  }else{  
    $items = array();
  }
  if ( in_array($post_id, $items)){
    if (($key = array_search($post_id, $items)) !== false) {
        unset($items[$key]);
    }
  }
  $items[] = $post_id;
  
  $items = array_values($items);
  
  if(!empty($items)){
    $cookie_value = json_encode($items);
  } 
  setcookie($cookie_key, $cookie_value, time()+$time, '/');
  return $cookie_value;   
}

function removeValFromCookie(int $post_id, $cookie_key, $time = 15778463){ // pol roka
  if ( isset($_COOKIE[$cookie_key]) ){
    $items = json_decode($_COOKIE[$cookie_key], true);
    
    if (($key = array_search($post_id, $items)) !== false) {
      unset($items[$key]);
      $items = array_values($items);
      if(!empty($items)){
        $cookie_value = json_encode($items);
      }
      setcookie($cookie_key, $cookie_value, time()+$time, '/');  
      return $cookie_value;
    }
  }
  return false;
}

function getCookieValue($cookie_key, $return_type = 1, $reverse = false){
    
    if ( isset($_COOKIE[$cookie_key]) ){
      $cookie_value = json_decode($_COOKIE[$cookie_key], true);
      if(!empty($cookie_value) and $reverse){
          $cookie_value = array_reverse($cookie_value, false);
      }
      if(!empty($cookie_value) and $return_type == 2){  // string with ,
          $cookie_value = implode(',', $cookie_value);
      }
      return $cookie_value;
   }else{
        return false;
   }     
}


function mergeCookieWithUserMeta($user_id){
    
    global $goshop_config;
    
    if($goshop_config['product-compare']){
        
        $user_favourite_meta = get_user_meta( $user_id, 'compare_products', true);
        $cookie_favourite = getCookieValue('compare_products');
        
        if($cookie_favourite != $user_favourite_meta){
    
          if(!empty($user_favourite_meta) and is_array($user_favourite_meta)){
            $merged_favourite = array_unique (array_merge($cookie_favourite, $user_favourite_meta));
          }else{
            $merged_favourite = $cookie_favourite;
          }
          
          $merged_favourite = array_values($merged_favourite);
          $cookie_value = json_encode($merged_favourite);
          
          update_user_meta( $user_id, 'compare_products', $cookie_value);
          setcookie('compare_products', $cookie_value, time()+15778463);
        
        }
    
    }
    
    if($goshop_config['product-favourite']){
        
        $user_favourite_meta = get_user_meta( $user_id, 'favourite_products', true);
        $cookie_favourite = getCookieValue('favourite_products');
        
        if($cookie_favourite != $user_favourite_meta){
    
          if(!empty($user_favourite_meta) and is_array($user_favourite_meta)){
            $merged_favourite = array_unique (array_merge($cookie_favourite, $user_favourite_meta));
          }else{
            $merged_favourite = $cookie_favourite;
          }
          
          $merged_favourite = array_values($merged_favourite);
          $cookie_value = json_encode($merged_favourite);
          
          update_user_meta( $user_id, 'favourite_products', $cookie_value);
          setcookie('favourite_products', $cookie_value, time()+15778463);
        
        }
    
    }

}

