<?php
/**
 * Login Form
 
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' ); 

?>

<div class="row" id="customer_login">
  <div class="col-md-6 order-mobile-2">
      <h2><?php esc_html_e( 'Login', 'woocommerce' ); ?></h2>

	<form class="" method="post">

		<?php do_action( 'woocommerce_login_form_start' ); ?>

		<p>
			<label for="username"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
			<input type="text" class="form-control" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @ dingStandardsIgnoreLine ?>
		</p>
		<p>
			<label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
			<input class="form-control" type="password" name="password" id="password" autocomplete="current-password" />
		</p>

		<?php do_action( 'woocommerce_login_form' ); ?>

		<p>
			<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
			<button type="submit" class="btn btn-primary btn-small" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>
			<label class="">
				<input class="" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
			</label>
		</p>
        <?php
        if(isset($_POST['username'])){
        ?>
        <div class="alert alert-danger"><?= __('Zadal si zlé prihlasovacie údaje'); ?></div>
        <?php }; ?>
        
		<p class="woocommerce-LostPassword lost_password">
			<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
		</p>
        <?php do_action( 'woocommerce_login_form_end' ); ?>
    </form>
  </div>
  <div class="col-md-6 order-mobile-1 mb-2">
      <h2><?= _('Rýchle prihlásenie');?></h2>
      <?= _('Prihláste sa jednoducho a rýchlo pomocou sociálnych sietí.');?>
      
      <div class="text-center mt-3">
        <span class="facebook-login pointer js-facebook-login" success_text="<?= _('Úspešne si sa prihlásil'); ?>"><?= _('Facebook prihlásenie'); ?></span>
        &nbsp;
        <span class="google-login pointer js-google-login" success_text="<?= _('Úspešne si sa prihlásil'); ?>"><?= _('Google prihlásenie'); ?></span>
      </div>
      
  </div>
</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); 
