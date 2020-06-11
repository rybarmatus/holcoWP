<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} 
global $goshop_config;

$user_meta = get_user_meta( $current_user->ID );

if(isset($_POST['delete_social_login'])){

  if ( delete_user_meta($current_user->ID, $_POST['type']) ) {
       $_SESSION['notif'] = __('Úspešne si odpojil externé pripojenie', 'goshop');
  }
  header("Location: ".get_permalink());
}

if(isset($user_meta['first_name'][0])){
  ?>
  <p><?= __( 'Dobrý deň', 'goshop').' '.$user_meta['first_name'][0]; ?></p>
  <?php
} 
 
 
 if($goshop_config['woocommerce']){
 
   $num_orders = wc_get_customer_order_count( $current_user->ID );  
   if($num_orders > 0){
    
     $customer_orders = get_posts( apply_filters( 'woocommerce_my_account_my_orders_query', array(
          'numberposts' => -1,
          'meta_key'    => '_customer_user',
          'meta_value'  => $current_user->ID,
          'post_type'   => wc_get_order_types( 'view-orders' ),
          'post_status' => array_keys( wc_get_order_statuses() )
      ) ) );
      
      if($customer_orders){
        $total = 0;
        foreach($customer_orders as $order){
                               
          $order = wc_get_order( $order->ID );
          
          $total += $order->get_total();
        
        };
      }
      ?>
      <?= __('Spravili ste u nás celkovo','goshop'); ?> <span class="bold"><?= $num_orders ?></span> <?= __('objednávok v celkovej hodnote', 'goshop'); ?> <span class="bold"><?= $total ?> <?= $order->get_currency() ?></span> 
    <?php
    }
  } 
?>

<?php
if($result = wp_check_password($goshop_config['random_password'], $current_user->user_pass, $current_user->ID)){ ?>

    <div class="mt-2 alert alert-danger">
        <?= __('Vaše prihlasovacie heslo bolo vygenerované automaticky, prosím upravte si ho v sekcií', 'goshop'); ?> <a class="underline" href="/moj-ucet/upravit-ucet/"><?= __('upraviť účet', 'goshop'); ?></a>
    </div>

<?php } ?>

    <?php if($goshop_config['social_login']){ ?>
    <h5 class="mt-3"><?= __('Prihlásenie cez externé úcty', 'goshop'); ?></h5>
    <div class="row text-center">
        <div class="col-md-4 mb-2">
           <div class="dash-social-log">
             <div class="top">
               <img alt="Facebook login" src="<?= IMAGES ?>/dash-facebook.png">
             </div>
             <?php if(isset($user_meta['facebook_id'][0])){ ?>
                <span><?= $user_meta['facebook_id'][0]; ?></span>
                <div class="check">
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" class="svg-inline--fa fa-check fa-w-16" role="img" viewBox="0 0 512 512"><path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"/></svg>
                </div>
                <form method="post" action="">
                    <input type="hidden" value="1" name="delete_social_login" />
                    <input type="hidden" value="facebook_id" name="type" />
                    <button type="submit" class="remove pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times" class="svg-inline--fa fa-times fa-w-11" role="img" viewBox="0 0 352 512"><path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"/></svg>
                    </button>
                </form>
             <?php }else{ ?>
                <button class="btn btn-small btn-primary w-100 js-facebook-login"><?= __('Prepojiť', 'goshop'); ?></button>
             <?php } ?>
           </div>
        </div>
        <div class="col-md-4">
           <div class="dash-social-log">
             <div class="top">
                <img alt="Google login" src="<?= IMAGES ?>/dash-google.png">
             </div>
             <?php if(isset($user_meta['google_id'][0])){ ?>
                <span><?= $user_meta['google_id'][0]; ?></span>
                <div class="check">
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" class="svg-inline--fa fa-check fa-w-16" role="img" viewBox="0 0 512 512"><path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"/></svg>
                </div>
                <form method="post" action="">
                    <input type="hidden" value="1" name="delete_social_login" />
                    <input type="hidden" value="google_id" name="type" />
                    <button type="submit" class="remove pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times" class="svg-inline--fa fa-times fa-w-11" role="img" viewBox="0 0 352 512"><path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"/></svg>    
                    </button>
                </form>
             <?php }else{ ?>
                <button class="btn btn-small btn-primary w-100 js-google-login"><?= _('Prepojit'); ?></button>
             <?php } ?>
           </div>
        </div>
   </div>     
   <input type="hidden" id="user_helper" value="<?= $current_user->ID ?>">
   <?php } ?> 

<?php
 /* TOTO NEVIEM CO ROBI */

	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	 /*
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
