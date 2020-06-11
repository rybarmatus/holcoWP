<?php
defined( 'ABSPATH' ) || exit;

global $goshop_config,$current_user; 

$default_password = false;

if($result = wp_check_password($goshop_config['random_password'], $current_user->user_pass, $current_user->ID)){ 
    $default_password = true;
}
?>
<h1 class="h3 mb-2"><?= __('Upraviť účet','goshop'); ?></h1>

<?php
if($default_password){ ?>

    <div class="alert alert-danger"><?= __('Prosím zadajte si nové heslo.', 'goshop'); ?></div>

<?php } ?>

<?php if(isset($_GET['success'])){ ?>

  <div class="alert alert-success"><?= __('Váš účet bol upravený','goshop'); ?></div>

<?php }else if(isset($edit_uset_error)){ ?>

  <div class="alert alert-danger"><?= $edit_uset_error; ?></div>

<?php } ?>

<form class="edit-account-form" action="" method="post">

	<?php // do_action( 'woocommerce_edit_account_form_start' ); ?>

	<div class="row">
      <div class="col-md-6 mb-1">
  		 <label for="account_first_name"><?= __( 'Krstné meno', 'goshop' ); ?>&nbsp;<span class="required">*</span></label>
  		 <input type="text" class="form-control" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?= esc_attr( $current_user->first_name ); ?>" required />
      </div>
      <div class="col-md-6 mb-1">
         <label for="account_last_name"><?= __( 'Priezvisko', 'goshop' ); ?>&nbsp;<span class="required">*</span></label>
    	 <input type="text" class="form-control" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?= esc_attr( $current_user->last_name ); ?>" required />
      </div>
    </div>
	<!-- 
  <p>
		<label for="account_display_name"><?= __( 'Display name', 'goshop' ); ?>&nbsp;<span class="required">*</span></label>
		<input type="text" class="form-control" name="account_display_name" id="account_display_name" value="<?= esc_attr( $current_user->display_name ); ?>" required />
  </p>
  -->
	<p>
		<label for="account_email"><?= __( 'Emailová adresa', 'goshop' ); ?>&nbsp;<span class="required">*</span></label>
		<input type="email" class="form-control" name="account_email" id="account_email" autocomplete="email" value="<?= esc_attr( $current_user->user_email ); ?>" required />
	</p>


  <?php if(!$default_password){ ?>
  <p>
    <label for="change_password">
      <input name="change-password" type="checkbox" id="change_password">
      <?= __('Zmeniť heslo', 'goshop'); ?>
    </label>
  </p>
  <?php }else { ?>
  <input type="hidden" value="1" class="form-control" name="default_password" id="default_password" autocomplete="off" />
  <?php } ?>
  
  <div class="password_change_wrapper d-none" <?php if($default_password){ echo 'style="display:block"'; } ?>>
  <?php if(!$default_password){ ?>
    <p>
  	 <label for="password_current"><?= __( 'Súčasné heslo (ak ho nechcete zmeniť, nechajte prázdne)', 'goshop' ); ?></label>
  	 <input type="password" class="form-control" name="password_current" id="password_current" autocomplete="off" />
  	</p>
  <?php } ?>

	<p>
		<label for="password_1"><?php if($default_password) { echo __('Nové heslo', 'goshop').'&nbsp;<span class="required">*</span>'; } else { echo __( 'Nové heslo (ak ho nechcete zmeniť, nechajte prázdne)', 'goshop' );  }?></label>
		<input type="password" class="form-control" name="password_1" id="password_1" autocomplete="off" <?php if($default_password) { echo 'required'; } ?> />
	</p>
	<p>
		<label for="password_2"><?= __( 'Potvrďte nové heslo', 'goshop' ); ?><?php if($default_password) { echo '&nbsp;<span class="required">*</span>'; } ?></label>
		<input type="password" class="form-control" name="password_2" id="password_2" autocomplete="off" />
	</p>
    <?php if(!$default_password) { ?>
    </div>
    <?php } ?>
	

	<?php // do_action( 'woocommerce_edit_account_form' ); ?>

	<p>
		<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
		<button type="submit" class="btn btn-success mt-1" name="save_account_details" value="<?= __( 'Uložiť zmeny', 'goshop' ); ?>"><?= __( 'Uložiť zmeny', 'goshop' ); ?></button>
		<input type="hidden" name="action" value="save_account_details" />
	</p>

	<?php // do_action( 'woocommerce_edit_account_form_end' ); ?>
</form>

<?php // do_action( 'woocommerce_after_edit_account_form' ); ?>
