<?php 
add_action( 'init', 'wc_cetelem_gateway_init', 11 );

function wc_cetelem_gateway_init() {
    
    class WC_Gateway_Cetelem extends WC_Payment_Gateway {

        function __construct() {
    			
          $this->id                       = 'goshop_custom_payment_method_cetelem';
    	  $this->has_fields               = true;
    	  $this->method_title             = __( 'Cetelem - nákup na splatky', 'goshop_admin' );
          $this->method_description       = __( 'Cetelem - minimálna suma pôžičky je 100 eur.', 'goshop_admin' );
    	  $this->cetelem_request_url      = 'https://online.cetelem.sk/eshop/ziadost.php';
          $this->cetelem_request_form     = 'cetelem_redirect.php';
          $this->title                    = $this->get_option( 'title', '' );
    	  $this->description              = $this->get_option( 'description', '' );
          $this->kod_predajcu             = $this->get_option( 'kod_predajcu', '' );      
          $this->default_order_status     = 'wc-processing';      
          $this->cetelem_back_url      = 'cetelem_redirect.php';
                
          /* https://online.cetelem.sk:8654/eshop/xmlcalc-demo.htm */
          /* https://online.cetelem.sk/eshop/ziadost.php */                                                 
          
          	
    			// Load the settings
    			$this->init_form_fields();
    			$this->init_settings();
    			// Define user set variables
    			
                
                
    	//		$this->instructions             = $this->get_option( 'instructions', '' );
    	//		$this->instructions_in_email    = $this->get_option( 'instructions_in_email', '' );
    	//		$this->icon                     = $this->get_option( 'icon', '' );
    	//		$this->min_amount               = $this->get_option( 'min_amount', 0 );
    	//		$this->enable_for_methods       = $this->get_option( 'enable_for_methods', array() );
    	//		$this->enable_for_virtual       = $this->get_option( 'enable_for_virtual', 'yes' ) === 'yes';
    			
    	//	    $this->send_email_to_admin      = $this->get_option( 'send_email_to_admin', 'yes' );
    	//	    $this->send_email_to_customer   = $this->get_option( 'send_email_to_customer', 'yes' );
    	//      $this->custom_return_url        = $this->get_option( 'custom_return_url', '' );
    			
          // Actions
    			add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
    		  //	add_action( 'woocommerce_thankyou_' . $this->id, array( $this, 'thankyou_page' ) );
    	    //  add_action( 'woocommerce_email_before_order_table', array( $this, 'email_instructions' ), 10, 3 ); // Customer Emails
                
      
            
            
		}
    
   
        
         /**
    	 * Output for the order received page.
    	 *
    	 * @version 1.0.0
    	 * @since   1.0.0
    	 */
        /* 
          public function thankyou_page() {
              if ( $this->instructions ) {
                  echo wpautop( wptexturize( $this->instructions ) );
              }
          }
          
    
    	/**
    	 * Add content to the WC emails.
    	 *
    	 * @version 1.1.0
    	 * @since   1.0.0
    	 * @access  public
    	 * @param   WC_Order $order
    	 * @param   bool $sent_to_admin
    	 * @param   bool $plain_text
    	 */
         /* 
    	function email_instructions( $order, $sent_to_admin, $plain_text = false ) {
    		if ( $this->instructions && ! $sent_to_admin && 'offline' === $order->payment_method && $order->has_status( 'on-hold' ) ) {
                echo wpautop( wptexturize( $this->instructions ) ) . PHP_EOL;
            }
    	}
        */
        
        
         
         
        public function process_payment( $order_id ) {

           
            $order = wc_get_order( $order_id );
            
            if( empty( $_POST[ 'billing_celetem_data' ]) ) {
            		wc_add_notice(  'Musíte nastaviť parametre splátok!', 'goshop' );
            		return false;
            }
            
            
            $order->add_order_note( __( 'Klient bol presmerovaný na Cetelem. ', 'goshop_admin' ) );
            
            // $order->update_status( 'wc-processing', __( 'Klient bol presmerovaný na Cetelem. ', 'goshop_admin' ) );
    
            
           // $order->reduce_order_stock();
    
            // WC()->cart->empty_cart();
    
            // Return thankyou redirect
            /* 
            return array(
                'result'    => 'success',
                'redirect'  => $this->get_return_url( $order )
            );
            */
            
            
            $ozn_tovaru = '';
            foreach ($order->get_items() as $item_id => $item_data) {
          
               $product = $item_data->get_product();
               $ozn_tovaru .= $product->get_name().','; 
              
            }
            $ozn_tovaru = substr( substr($ozn_tovaru, 0, -2),0,30); /* odstranenie poslednej ciarky a max 30 znakov */
            
            $cetelem_data_from_calc = get_post_meta( $order->get_id(), '_billing_celetem_data', true );
            $cetelem_data_from_calc = json_decode($cetelem_data_from_calc);
            
            $cetelem_data = array(
              'kodPredajcu' => $this->kod_predajcu,
              'kodBaremu' => $cetelem_data_from_calc->kodBaremu,
              'kodPoistenia' => $cetelem_data_from_calc->kodPoistenia,
              'kodMaterialu' => $cetelem_data_from_calc->kodMaterialu,
              'cenaTovaru' => $cetelem_data_from_calc->cenaTovaru,
              'priamaPlatba' => $cetelem_data_from_calc->priamaPlatba,
              'vyskaUveru' => $cetelem_data_from_calc->vyskaUveru,
              'pocetSplatok' => $cetelem_data_from_calc->pocetSplatok,
              'odklad' => $cetelem_data_from_calc->odklad,
              'zdarma' => $cetelem_data_from_calc->zdarma,
              'vyskaSplatky' => $cetelem_data_from_calc->vyskaSplatky,
              'cenaUveru' => $cetelem_data_from_calc->cenaUveru,
              'ursadz' => $cetelem_data_from_calc->ursadz,
              'RPMN' => $cetelem_data_from_calc->RPMN,     
              'numklient' => $order_id,
              'obj' => $order_id,
              'oznTovaru' => $ozn_tovaru,
              'url_back_ok' => get_site_url().'/'.$this->cetelem_back_url,
              'url_back_ko' => get_site_url().'/'.$this->cetelem_back_url,
              'redirect_to_cetelem' => true                  
           );
              
           
           $cetelem_data_get_query = http_build_query($cetelem_data) . "\n";
        
        
                      
           return array(
               'result'    => 'success',
               'redirect'  => get_site_url().'/'.$this->cetelem_request_form.'?'.$cetelem_data_get_query
           );
            
            /* 
            $response = wp_remote_post( $this->cetelem_request_url, array(
                'method'      => 'POST',
                'timeout'     => 60,
                'redirection' => 5,
                'httpversion' => '1.0',
                'blocking'    => true,
                'headers'     => array(),
                'body'        => array(
                    'kodPredajcu' => $this->kod_predajcu,
                    'kodBaremu' => $cetelem_data_from_calc->kodBaremu,
                    'kodPoistenia' => $cetelem_data_from_calc->kodPoistenia,
                    'kodMaterialu' => $cetelem_data_from_calc->kodMaterialu,
                    'cenaTovaru' => $cetelem_data_from_calc->cenaTovaru,
                    'priamaPlatba' => $cetelem_data_from_calc->priamaPlatba,
                    'vyskaUveru' => $cetelem_data_from_calc->vyskaUveru,
                    'pocetSplatok' => $cetelem_data_from_calc->pocetSplatok,
                    'odklad' => $cetelem_data_from_calc->odklad,
                    'zdarma' => $cetelem_data_from_calc->zdarma,
                    'vyskaSplatky' => $cetelem_data_from_calc->vyskaSplatky,
                    'cenaUveru' => $cetelem_data_from_calc->cenaUveru,
                    'ursadz' => $cetelem_data_from_calc->ursadz,
                    'RPMN' => $cetelem_data_from_calc->RPMN,     
                    'numklient' => $order_id,
                    'obj' => $order_id,
                    'oznTovaru' => $ozn_tovaru            
                )
              //  'cookies'     => array()
                )
            );
            
            print_r($response);
            print_r($response->get_error_message());
            */
       
            
        }
          
        
        /**
         * Initialise Gateway Settings Form Fields.
         */
        public function init_form_fields() {

           $this->form_fields = array(
                'enabled' => array(
                    'title'   => __( 'Enable/Disable', 'woocommerce' ),
                    'type'    => 'checkbox',
                    'label'   => __( 'Povoliť Cetelem', 'woocommerce' ),
                    'default' => 'no'
                ),
                'title' => array(
                    'title'       => __( 'Title', 'woocommerce' ),
                    'type'        => 'text',
                    'description' => __( 'This controls the title which the user sees during checkout.', 'woocommerce' ),
                    'default'     => __( 'Cetelem - nákup na splatky', 'woocommerce' ),
                    'desc_tip'    => true,
                ),
                'kod_predajcu' => array(
              			'title'       => __( 'Cetelem kód predajcu', 'goshop_admin' ),
              			'type'        => 'text',
                    'description' => __( 'Tento kod obdržíte v partnerskom rozhraní Cetelemu. Bez zadania kódu je Cetelem nefunkčný.', 'goshop_admin' ),
                    'desc_tip'    => false,
                    'required'    => true
          		),
                'description' => array(
                    'title'       => __( 'Description', 'woocommerce' ),
                    'type'        => 'textarea',
                    'description' => __( 'Payment method description that the customer will see on your checkout.', 'woocommerce' ),
                    'default'     => '',
                    'desc_tip'    => true,
                )
            );
        }



    }  /* end celetem class */
}


add_filter( 'woocommerce_payment_gateways', 'add_wc_cetelem_gateway' );
function add_wc_cetelem_gateway( $methods ) {
	$cetelem_class = new WC_Gateway_Cetelem();
	
  $methods[] = $cetelem_class; 
  return $methods;
}



  
add_filter( 'woocommerce_available_payment_gateways', 'disable_cetelem' );
  
function disable_cetelem( $available_gateways ) {
     
   if ( ! is_admin() ) {
        
      /* 
      $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
      $chosen_shipping = $chosen_methods[0];
      
      if (strpos($chosen_shipping, 'local_pickup') === false and $chosen_shipping != 'free_shipping:3') {
        unset( $available_gateways['goshop_custom_payment_method_cetelem'] );
      }
      */
      
      $cetelem_class = new WC_Gateway_Cetelem();
      $kod_predajcu = $cetelem_class->kod_predajcu;      
      
      if(WC()->cart->total < 100 or !$kod_predajcu){
        unset( $available_gateways['goshop_custom_payment_method_cetelem'] );
      }
      
   
   }
     
   return $available_gateways;
     
}


