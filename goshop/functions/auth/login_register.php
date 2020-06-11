<?php
function custom_register_new_user($full_name, $email, $password, $social_id, $type){

      /* 
      1 : normal register
      2 : fb login
      3 : google login
      */
      
      /* rozdelí full name na first and last */
      $name_array = explode(' ', $full_name, 2);
      $firstname = $name_array[0];
      if(isset($name_array[1])){
        $lastname = $name_array[1];
      }else{
        $lastname= '';
      }
      
      /* zabezpecí unique loginu */
      $login = strtolower($firstname.$lastname);
      $given_login = $login;
      
      if(username_exists($login)){
      
        for($i=1;$i<9999;$i++){
          
          if(username_exists($login)){
              $login = $given_login.$i;
          }else{
              break;
          }
        
        }
      
      }
      /* vytvorí užívatela */ 
      
      $result = wp_create_user($login, $password, $email);
      
      if (!$result || is_wp_error($result)) {
          
          $register_error = $result->get_error_message();
          return array( 'result' => false, 'error_text' => $register_error);
          
      }else{
          
          $user_id = $result;
          if($goshop_config['woocommerce'] and $goshop_config['cookies']){
            mergeCookieWithUserMeta($user_id); // cookie.php
          }
          $userinfo = array(
           'ID' => $user_id,
           'first_name' => $firstname,
           'last_name' => $lastname,
           'display_name' => $full_name
          );
          
          wp_update_user($userinfo);
      
          if($type == 2){
              update_user_meta($user_id, 'facebook_id', $social_id);
          }else if($type == 3){
              update_user_meta($user_id, 'google_id', $social_id);
          }  
          
          return array( 'result' => true, 'user_id' => $user_id);

      }
}

function log_user($user_id){
    global $goshop_config;
    wp_set_current_user($user_id);
    wp_set_auth_cookie($user_id);
    if($goshop_config['woocommerce'] and $goshop_config['cookies']){
        mergeCookieWithUserMeta($user_id); // cookie.php
    }
}

function edit_address($data,$get){
    global $current_user;
    $checkout = new WC_Checkout;
    $fields = $checkout->get_checkout_fields( $get );
    $error = false;
    unset($data['save_address']);
    
    foreach($data as $key=>$item){
        
        if(isset($fields[$key]) and $fields[$key]['required'] and empty($item)){
            $error .= 'Položka '.$fields[$key]['label']. ' je povinná! <br>';
        }
    
    }
    if($error){
        return $error;
    }else{
        foreach($data as $key=>$value){
           update_user_meta($current_user->ID, $key, $value);
        }
        return false;
    }    
}

function edit_account($data){
  global $current_user, $goshop_config;
  if(!$current_user->ID){
    echo 'return';
    return;
  }
  if(isset($data['default_password'])){
    $data['password_current'] = $goshop_config['random_password'];
    $data['change-password'] = true; 
  }
  /* 
  $data['account_first_name']
  $data['account_last_name']
  $data['account_email']
  $data['password_current']
  $data['password_1']
  $data['password_2']
  */
 // print_r($data);
  
  
  $error = false;
  if (!filter_var($data['account_email'], FILTER_VALIDATE_EMAIL)) {
    $error = __('Zadali ste emailovú adresu v zlom tvare', 'goshop');
  }
  if($user_email = email_exists( $data['account_email'] )){
    if($user_email != $current_user->ID){
      $error = __('Zadaná emailová adresa už existuje. Prosím zadajte inú.', 'goshop');
    }
  }
  
  if(isset($data['change-password'])){
    
    if($data['password_current'] == ''){
       $error = __('Nezadali ste staré heslo', 'goshop');
    }
    
    if(!wp_check_password($data['password_current'], $current_user->user_pass, $current_user->ID)){
      $error = __('Nezadali ste správne staré heslo', 'goshop');
    }
    if(strlen($data['password_1']) < MIN_PASSWORD_LENGTH ){                                                                  
      $error = __('Nové heslo je príliž krátke. Minimálny počet znakov je', 'goshop').' '.MIN_PASSWORD_LENGTH;
    }
    if($data['password_1'] != $data['password_2']){
      $error = __('Potvrdenie hesla nesúhlasí', 'goshop');
    }
  
  }
   
   if(!$error){
    $userinfo = array(
      'ID' => $current_user->ID,
      'first_name' => $data['account_first_name'],
      'last_name' => $data['account_last_name'],
      'user_email' => $data['account_email'],
      //  'display_name' => $full_name
    );
    
    if(isset($data['change-password'])){
      $userinfo['user_pass'] = $data['password_1'];
      
    }
    if(wp_update_user($userinfo)){
      global $wp;
      wp_redirect(home_url( $wp->request ).'?success=1');
    }    
    
  
  }else{
    return $error;
  }

}

 
// po uspešnej registrácií sa užívatel prihlási
function custom_login_user($email,$password){

    $creds = array(
          'user_login'    => $email,
          'user_password' => $password,
          'remember'      => true
    );
     
    $user = wp_signon( $creds, false );
    
    if ( is_wp_error( $user ) ) {
            return $user->get_error_message();
    }else{
    
        $_SESSION['notif'] = __('Úspešne si sa zaregistroval a prihlásil ako', 'goshop').' '.$email;
        header('Location: '.get_permalink( get_option('woocommerce_myaccount_page_id') ));
        
        
    }

}
