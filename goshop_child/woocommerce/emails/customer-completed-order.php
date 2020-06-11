<?php
/**
 * Customer completed order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-completed-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<div style="margin-bottom:30px;">
  
  <p><?= __('Dobrý deň','goshop');?> <strong style="text-transform:capitalize"><?= esc_html( $order->get_billing_first_name() ); ?></strong></p>
  
  <?php
  foreach( $order->get_items( 'shipping' ) as $item_id => $shipping_item_obj ){
    $shipping_method_id = $shipping_item_obj->get_method_id();
  }
  ?>
  
  <?php if($shipping_method_id == 'local_pickup'){ ?>
  
    <p><?= __('Vašu objednávku sme práve dokončili a je pripravená na odber na našom odbernom mieste.','goshop'); ?></p>
  
  <?php } else if( $order->get_payment_method() == 'cod' ) { ?>
    
    <p><?= __('Vašu objednávku sme práve spracovali a odovzdali na odoslanie Vami vybranému prepravcovi. Objednávku zaplatíte pri prevzatí tovaru.','goshop'); ?></p>
    
  <?php }else { ?>
  
    <p><?= __('Prijali sme od Vás platbu za objednávku a tovar sme odovzdali na odoslanie Vami vybranému prepravcovi.','goshop'); ?></p>
  
  <?php } ?>
  
  
  
  

  <?php
  if ( $additional_content ) {
  	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
  }
  ?>

</div>


<?php

/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );



/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
