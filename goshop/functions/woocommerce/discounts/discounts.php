<?php 

function register_discount_page_fields() {
  global $goshop_config;
  
  if($goshop_config['woo-gifts']){
    register_setting( 'discount-group', 'discount_gift' );
    register_setting( 'discount-group', 'discount_gift_type' );
    register_setting( 'discount-group', 'discount_gift_amount' );
    register_setting( 'discount-group', 'discount_gift_product_1' );
    register_setting( 'discount-group', 'discount_gift_product_2' );
    register_setting( 'discount-group', 'discount_gift_product_3' );
  }
  
  register_setting( 'discount-group', 'discount_whole' );
  register_setting( 'discount-group', 'discount_whole_from_1' );
  register_setting( 'discount-group', 'discount_whole_type_1' );
  register_setting( 'discount-group', 'discount_whole_amount_1' );
  
  register_setting( 'discount-group', 'discount_whole_from_2' );
  register_setting( 'discount-group', 'discount_whole_type_2' );
  register_setting( 'discount-group', 'discount_whole_amount_2' );
  
  register_setting( 'discount-group', 'discount_whole_from_3' );
  register_setting( 'discount-group', 'discount_whole_type_3' );
  register_setting( 'discount-group', 'discount_whole_amount_3' );
  
  register_setting( 'discount-group', 'discount_for_registered' );
  register_setting( 'discount-group', 'discount_for_registered_type' );
  register_setting( 'discount-group', 'discount_for_registered_amount' );
  
}

function discount_fnc(){
   require_once( __DIR__ . '/' . 'discounts_content.php');
}

add_action('admin_menu', function(){
  add_menu_page('Zlavy', 'Zlavy', 'read', 'discounts', 'discount_fnc','dashicons-universal-access-alt',34);
  add_action( 'admin_init', 'register_discount_page_fields' );
});


add_action( 'woocommerce_cart_calculate_fees', 'discount_based_on_total', 25, 1 );
  function discount_based_on_total( $cart ) {

  if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;
    
    $total = $cart->cart_contents_total;
    
    if(get_option('discount_gift')){
    
      $product_count = $cart->get_cart_contents_count();
      $type = get_option('discount_gift_type');
      $amount = get_option('discount_gift_amount');
      $gift_id = get_option('discount_gift_product_1');
      $is_in = false;
      
      if(($type == 1 && $product_count >= $amount) || ($type == 2 && $total >= $amount)){    
          
          foreach($cart->get_cart() as $key => $val ) {
              $_product = $val['data'];
       
              if($gift_id == $_product->get_id() ) {
                  $is_in = true;
              }
          }
          if(!$is_in){
            $cart->add_to_cart( $gift_id, 1 );
          }
      }else{
          $cartId = $cart->generate_cart_id( $gift_id );
          $cartItemKey = $cart->find_product_in_cart( $cartId );
          $cart->remove_cart_item( $cartItemKey );
      }
    
    }
    
    if(get_option('discount_for_registered')){
    
      if(is_user_logged_in()){
         
        $sale = $discount = false;
        $type = get_option('discount_for_registered_type');
        $amount  = get_option('discount_for_registered_amount');
        
        if($type == 1){    
          $discount = $total * ($amount/100);
          $sale = $amount.'%';
        }else{
          $discount = $amount;
          $sale = $amount.' '.get_woocommerce_currency_symbol();
        }
      
        if($discount && $sale){
          $cart->add_fee( __('Zľava pre registrovaného užívateľa').' '.$sale, -$discount );
        }
      }
    
    }
    
    
    if(get_option('discount_whole')){
    
      $sale = $discount = false;
      
      for($x=3;$x > 0;$x--){
        $discount_from = get_option('discount_whole_from_'.$x);
        $discount_type = get_option('discount_whole_type_'.$x); 
        $discount_amount  = get_option('discount_whole_amount_'.$x);
        
        if($discount_from && $total >= $discount_from){
        
          if($discount_type == 1){
            $discount = $total * ($discount_amount/100);
            $sale = $discount_amount.'%';
          }else{
            $discount = $discount_amount;
            $sale = $discount_amount.' '.get_woocommerce_currency_symbol();
          
          }
          break;
        }
      }
      
      if($discount && $sale){
        $cart->add_fee( __('Zľava na celý nákup').' '.$sale, -$discount );
      }
  
    }
  
  }

/*  
add_action( 'init', 'register_gift_product_type' );

function register_gift_product_type() {

  class WC_Product_Gift extends WC_Product {
			
    public function __construct( $product ) {
      $this->product_type = 'gift';
	  parent::__construct( $product );
    }
  }
}
*/




   