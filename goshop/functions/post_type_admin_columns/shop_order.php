<?php
global $goshop;
function wc_new_order_column( $columns ) {
  
    $new_columns = array();

    foreach ( $columns as $column_name => $column_info ) {

        $new_columns[ $column_name ] = $column_info;

        if ( 'order_date' === $column_name ) {
            $new_columns['doprava'] = __('Doprava','goshop_admin');
            $new_columns['sposob_platby'] = __('Spôsob platby','goshop_admin');
        }
    }

    return $new_columns;

} 
add_filter( 'manage_edit-shop_order_columns', 'wc_new_order_column' );

function sv_wc_cogs_add_order_profit_column_content( $column ) {
  global $post, $goshop_config;

  if ( 'doprava' === $column ) {
  
      $order    = wc_get_order( $post->ID );
      
      foreach( $order->get_items( 'shipping' ) as $item_id => $shipping_item_obj ){
          $shipping_data = $shipping_item_obj->get_data();
          $shipping_data_instance_id  = $shipping_data['instance_id'];
      }
      
      echo $order->get_shipping_method();
      
      if($goshop_config['zasielkovna_api']){
        if($shipping_data_instance_id == 4 or $shipping_data_instance_id == 6){
            $zasielkovna_pobocka_id = get_post_meta( $order->get_id(), '_billing_zasielkovna_branch_id', true );  
            $zasielkovna_pobocka_name = get_post_meta( $order->get_id(), '_billing_zasielkovna_branch_name', true );
            if($zasielkovna_pobocka_id){
                echo '<div><small>'. $zasielkovna_pobocka_id. ' - '.$zasielkovna_pobocka_name .'</small></div>';
            }
        };
      }
      
  }
  if ( 'sposob_platby' === $column ) {
  
      $order    = wc_get_order( $post->ID );
      echo $order->get_payment_method_title();
      
  }
}
add_action( 'manage_shop_order_posts_custom_column', 'sv_wc_cogs_add_order_profit_column_content' ); 


if($goshop['woo_export_pre_slovensku_postu']){

  add_filter( 'bulk_actions-edit-shop_order', 'downloads_bulk_actions_edit_product', 20, 1 );
  function downloads_bulk_actions_edit_product( $actions ) {
      $actions['export_slovenska_posta'] = __( 'Export pre Slovenskú poštu', 'woocommerce' );
      return $actions;
  }
  
  add_filter( 'handle_bulk_actions-edit-shop_order', 'downloads_handle_bulk_action_edit_shop_order', 10, 3 );
  function downloads_handle_bulk_action_edit_shop_order( $redirect_to, $action, $post_ids ) {
      if ( $action !== 'export_slovenska_posta' )
          return $redirect_to; // Exit
  
      require(CONTENT_FUNCTIONS.'/export/slovenska_posta/slovenska_posta.php');
      
  }
}
