<?php 
global $current_user;
$wrong_address = false;
$load_address = $_GET['address'];


if($load_address == 'billing'){
    $checkout = new WC_Checkout;
    $fields = $checkout->get_checkout_fields( $load_address );

    $firma = get_user_meta($current_user->ID, 'billing_company_checkbox' ,true);
    
    if(!$firma){
        $fields['billing_company']['class'][0] .= ' d-none';
        $fields['billing_company_ico']['class'][0] .= ' d-none';
        $fields['billing_company_dic']['class'][0] .= ' d-none';
        $fields['billing_company_ic_dph']['class'][0] .= ' d-none';
            
    } 
    $page_title = __( 'Fakturačná adresa', 'goshop' );
}elseif ($load_address == 'shipping'){
    $checkout = new WC_Checkout;
    $fields = $checkout->get_checkout_fields( $load_address );
    $page_title = __( 'Dodacia adresa', 'goshop' );
}else{
    $wrong_address = true;
}
?>


<?php // do_action( 'woocommerce_before_edit_account_address_form' ); ?>

<?php if ( ! $load_address or $wrong_address ) : ?>
	<?php require(CONTENT. '/auth/addresses.php'); ?>
<?php else : ?>

    <?php
    if(isset($edit_address_error)){
    ?>
        <div class="alert alert-danger">
            <?= $edit_address_error; ?>
        </div>
    <?php
    }
    ?>
    
	<form method="post" action="">
      <h3><?php echo apply_filters( 'woocommerce_my_account_edit_address_title', $page_title, $load_address ); ?></h3>
    
	  <?php do_action( "woocommerce_before_edit_address_form_{$load_address}" ); ?>
         
      <div class="row">
        <?php
        
        
        foreach ( $fields as $key => $field ) {
        
          /* 
          if ( isset( $field['country_field'], $fields[ $field['country_field'] ] ) ) {
              $field['country'] = $checkout->get_value( $field['country_field'] );
          }
          */
          woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
        }
        ?>
      </div>
      <button type="submit" class="btn btn-success mb-1" name="save_address" title="<?= __( 'Uložiť adresu', 'goshop' ); ?>">
        <?= __( 'Uložiť adresu', 'goshop' ); ?>
      </button>
        
        
	</form>

<?php endif; ?>

<?php do_action( 'woocommerce_after_edit_account_address_form' ); ?>