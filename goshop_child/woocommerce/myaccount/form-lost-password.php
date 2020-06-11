<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.2
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_lost_password_form' );
?>
<h2><?= _('ZABUDNUTÉ HESLO'); ?></h2>

<form method="post" class="woocommerce-ResetPassword lost_reset_password">

  <p><?= _('Zadajte e-mailovú adresu, pod ktorou ste zaregistrovaný a my vám na ňu pošleme nové heslo.'); ?></p>
  <div class="row">
  	<p class="col-md-5">
  		<label for="user_login"><?= _( 'Váš e-mail'); ?></label>
  		<input class="form-control" type="text" name="user_login" id="user_login" autocomplete="username" />
  	</p>
  </div>  
  

	<?php do_action( 'woocommerce_lostpassword_form' ); ?>

	<p>
		<input type="hidden" name="wc_reset_password" value="true" />
		<button type="submit" class="btn btn-primary" value="<?php esc_attr_e( 'Reset password', 'woocommerce' ); ?>"><?php esc_html_e( 'Reset password', 'woocommerce' ); ?></button>
	</p>

	<?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>

</form>
<?php
do_action( 'woocommerce_after_lost_password_form' );
