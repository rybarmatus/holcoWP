<?php
add_action('wp_ajax_google_login', 'google_login_callback');
add_action('wp_ajax_nopriv_google_login', 'google_login_callback' );

function google_login_callback() {
    session_start();
    global $goshop_config;
    
    $google_id = $_POST['google_id'];
    $google_name = $_POST['google_name'];
    $google_email = $_POST['google_email'];
    $logged_user_id = $_POST['user_helper'];
    
    if ( !is_email( $google_email ) ) {
        echo _('Neplatná e-mailová adresa');
        die();
    }
    
    if(is_user_logged_in() and $logged_user_id){
        $user = get_user_by('ID', $logged_user_id );
        
    }else if(!empty($google_id)){
    
      $user = get_users(
        array(
         'meta_key' => 'google_id',
         'meta_value' => $google_id,
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
    
        if(!isset($user_meta['google_id'])){
            update_user_meta($user->ID, 'google_id', $google_id);

        }
        if(!is_user_logged_in()){ 
          log_user($user->ID);
          $_SESSION['notif'] = __('Úspešne si sa prihlásil ako', 'goshop').' '.$google_name;
        }else{
            $_SESSION['notif'] = __('Úspešne si pripojil Google účet', 'goshop');
        
        }        
        die();   

    }
    
    $password = $goshop_config['random_password'];
    
    $result = custom_register_new_user($google_name, $google_email, $password, $google_id, 3);
    
    if($result['result'] === true){
    
        $creds = array(
          'user_login'    => $google_email,
          'user_password' => $password,
          'remember'      => true
        );
     
        if($user = wp_signon( $creds, false )){
            $_SESSION['notif'] = __('Ďakujeme za registráciu. Teraz si prihlásený ako', 'goshop').' '.$google_name;
        }
     
        if ( is_wp_error( $user ) ) {
            echo $user->get_error_message();
        }
    
    }else{
        echo $result['error_text'];
    
    }
    
    die();
}
