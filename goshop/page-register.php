<?php
/**                                                                                                                                                               
* Template Name: Register
*/

if(is_user_logged_in()){ 
  get_header();
  ?>

  <div class="container">
    <div class="alert alert-danger"><?= sprintf(  __('Pre vytvorenie nového účtu sa musíte najprv %s odhlásiť %s'), '<a class="underline" href="'.wp_logout_url(  get_permalink()  ).'">', '</a>'); ?></div>
  </div>

<?php
}else{
 
if(isset($_POST['register-name']) && isset($_POST['register-email']) && isset($_POST['register-password'])){

  $full_name = $_POST['register-name'];
  $email = $_POST['register-email'];
  $password = $_POST['register-password'];
  $password2 = $_POST['register-password-repeat'];
  
  
  if( $full_name != '' && $email != '' && $password2 != '' && $password != '' && $password2 == $password ) {
     
      // ocekovat chyby  
     
        /* 
        fb login 
        vyplni policko vase meno
        vyplni policko email, ak email nie je policko zostane zobrazene
        ak je email tak submitne formular
        potom v dashboarde budu pripomienky: dajte si heslo, chyba vam priezvisko, 
        */
     
      $result = custom_register_new_user($full_name, $email, $password, false, 1 );
      
      if($result['result'] === true){
      
      
        // notifiácia o úspešnej registrácií
        // redirect na homepage uz prihlásený
      
        unset($_POST['register-name']);
        unset($_POST['register-email']);
        unset($_POST['register-password']);
        unset($_POST['register-password-repeat']);
      
        echo custom_login_user($email,$password);
      
      
      
      }else {
        
        $register_error = $result['error_text']; 
        
      }  
      
  }else{
  
      if($password2 != $password){
        
        $register_error = __('Heslá sa nezhodujú', 'goshop');
        unset($_POST['register-password']);
        unset($_POST['register-password-repeat']);
        
      }else{
      
        $register_error = __('Všetky polia sú povinné', 'goshop');
      
      }
  
  }
  
}

get_header();
?>

<div class="container">

<?php if(isset($register_error) && !empty($register_error)) { ?>
    <div class="alert alert-danger"><?= $register_error ?></div>
<?php } ?>

<h2><?= __('Registrácia', 'goshop'); ?></h2>

    <?php if($goshop_config['social_login']){ ?>
    <div class="text-center">
        <span title="<?= __('Facebook prihlásenie', 'goshop'); ?>" class="facebook-login pointer js-facebook-login hover-scale mb-1 mr-1 mr-mobile-0" success_text="<?= __('Úspešne si sa prihlásil', 'goshop'); ?>"><?= __('Facebook prihlásenie', 'goshop'); ?></span>
        <span title="<?= __('Google prihlásenie', 'goshop'); ?>" class="google-login pointer js-google-login hover-scale mb-1" success_text="<?= __('Úspešne si sa prihlásil', 'goshop'); ?>"><?= __('Google prihlásenie', 'goshop'); ?></span>
    </div>

    <div class="lines_through mt-2 mb-2">
        <span><?= __('alebo pokračujte pomocou', 'goshop'); ?></span>
    </div>

    <?php } ?>

  <div class="row">
    <div class="col-md-8 offset-md-2">
        <form method="post" id="register_form" action="<?php the_permalink();?>">

      	<label class="label_reg_name" for="reg_name"><?= __( 'Vaše meno', 'goshop'); ?>&nbsp;<span class="required">*</span>
            <input type="text" class="form-control" <?php if(isset($_POST['register-name'])){ echo 'value="'.$_POST['register-name'].'"';  } ?> name="register-name" id="reg_name" required />
        </label>
            
        <label class="label_reg_email" for="reg_email"><?= __('Email', 'goshop' ); ?>&nbsp;<span class="required">*</span>
            <input type="email" class="form-control" <?php if(isset($_POST['register-email'])){ echo 'value="'.$_POST['register-email'].'"';  } ?> name="register-email" fail_text="<?= __('Nepodarilo sa nám získať Vašu e-mailovú adresu, prosím doplňte ju a odošlite formulár', 'goshop'); ?>" id="reg_email" required />
        </label>
              
        <div class="row">
            <div class="col-md-6">
              <label class="label_reg_password" for="reg_password"><?= __('Heslo', 'goshop'); ?>&nbsp;<span class="required">*</span>
              	<input type="password" minlength="6" class="form-control" <?php if(isset($_POST['register-password'])){ echo 'value="'.$_POST['register-password'].'"';  } ?> name="register-password" id="reg_password" required />
              </label>
            </div>
            <div class="col-md-6">
              <label class="label_reg_password" for="reg_password_repeat"><?= __('Zopakuj heslo', 'goshop'); ?>&nbsp;<span class="required">*</span>
              	<input type="password" minlength="6" class="form-control" <?php if(isset($_POST['register-password-repeat'])){ echo 'value="'.$_POST['register-password-repeat'].'"';  } ?> name="register-password-repeat" id="reg_password_repeat" required />
              </label>
            </div>
        </div>

        <label class="d-block mt-1 mb-1" for="gdpr">
              <input type="checkbox" id="gdpr" required><?= __('Súhlasím zo spracovaním','goshop'); ?> <a class="underline" href="<?= get_permalink(3); ?>" title="<?= __('Ochrana osobných údajov', 'goshop'); ?>"><?= __('osobných údajov', 'goshop'); ?></a>            
        </label>
        <button type="submit" class="btn btn-primary" name="register" value="<?= __('Registrovať sa', 'goshop'); ?>"><?= __('Registrovať sa', 'goshop'); ?></button>
      </form>
    </div>
  </div>



</div>
<?php } /* end if logged */ ?>
<?php get_footer(); 
