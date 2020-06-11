<?php

add_action('wp_ajax_facebook_login', 'facebook_login_callback');
add_action('wp_ajax_nopriv_facebook_login', 'facebook_login_callback' );

function facebook_login_callback() {
    
    $fb_id    = $_POST['fb_id'];
    $fb_name  = $_POST['fb_name'];   
    $fb_email = $_POST['fb_email'];
    $logged_user_id = $_POST['user_helper'];
    
    
    
    if ( !is_email( $fb_email ) ) {
        echo __('Neplatná e-mailová adresa', 'goshop');
        die();
    }
    
    if(is_user_logged_in() and $logged_user_id){
        $user = get_user_by('ID', $logged_user_id );
        
    }else if(!empty($fb_id)){
    
      $user = get_users(
        array(
         'meta_key' => 'facebook_id',
         'meta_value' => $fb_id,
         'number' => 1,
         'count_total' => false
        )
       );
       if($user){
        $user = $user[0];
       }
    
    }
    
    
    // skusim ziskat podla emailu, ak existuje cheknem ci ma regnutý facebook, ak nemá pripojím facebook
    
    //ceknúc ci uz je regnutý, ak áno tak lognút 
    if(!empty($user) and count($user) == 1){
    
        $user_meta = get_user_meta( $user->ID );
    
        if(!isset($user_meta['facebook_id'])){
            update_user_meta($user->ID, 'facebook_id', $fb_id);
        }
        
        if(!is_user_logged_in()){
            log_user($user->ID);
            
            $_SESSION['notif'] = __('Úspešne si sa prihlásil ako', 'goshop').' '.$fb_name;
        
        }else{
            $_SESSION['notif'] = __('Úspešne si pripojil Facebook účet','goshop');
        
        }
        die();   
    }
    
    $password = $goshop_config['random_password'];
    
    $result = custom_register_new_user($fb_name, $fb_email, $password, $fb_id, 2);
    
    if($result['result'] === true){
    
        $creds = array(
          'user_login'    => $fb_email,
          'user_password' => $password,
          'remember'      => true
        );
     
        if($user = wp_signon( $creds, false )){
            $_SESSION['notif'] = __('Ďakujeme za registráciu. Teraz si prihlásený ako', 'goshop').' '.$fb_name;
        }
     
        if ( is_wp_error( $user ) ) {
            echo $user->get_error_message();
        }
    
    }else{
    
        echo $result['error_text'];
    
    }
    
    wp_die();
}
