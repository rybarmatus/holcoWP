<?php 
add_action( 'init', 'wc_hotovost_gateway_init', 11 );

function wc_hotovost_gateway_init() {
    
    class WC_Gateway_Hotovost extends WC_Payment_Gateway {

        function __construct() {
			$this->id                       = 'goshop_custom_payment_method_hotovost';
			$this->has_fields               = true;
			$this->method_title             = __( 'Hotovosť', 'goshop_admin' );
			$this->method_description       = __( 'Platba v hotovosti pri osobnom odbere', 'goshop_admin' );
			
			// Load the settings
			$this->init_form_fields();
			$this->init_settings();
			// Define user set variables
			$this->title                    = $this->get_option( 'title', '' );
			$this->description              = $this->get_option( 'description', __('Platba v hotovosti pri osobnom odbere', 'goshop') );
			$this->instructions             = $this->get_option( 'instructions', '' );
			$this->instructions_in_email    = $this->get_option( 'instructions_in_email', '' );
	//		$this->icon                     = $this->get_option( 'icon', '' );
	//		$this->min_amount               = $this->get_option( 'min_amount', 0 );
	//		$this->enable_for_methods       = $this->get_option( 'enable_for_methods', array() );
	//		$this->enable_for_virtual       = $this->get_option( 'enable_for_virtual', 'yes' ) === 'yes';
			$this->default_order_status     = $this->get_option( 'default_order_status', 'wc-pending' );
			$this->send_email_to_admin      = $this->get_option( 'send_email_to_admin', 'no' );
	//		$this->send_email_to_customer   = $this->get_option( 'send_email_to_customer', 'no' );
	//      $this->custom_return_url        = $this->get_option( 'custom_return_url', '' );
			
            // Actions
		//	add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
			add_action( 'woocommerce_thankyou_' . $this->id,                        array( $this, 'thankyou_page' ) );
			add_action( 'woocommerce_email_before_order_table',                     array( $this, 'email_instructions' ), 10, 3 ); // Customer Emails
		}
        
         /**
    	 * Output for the order received page.
    	 *
    	 * @version 1.0.0
    	 * @since   1.0.0
    	 */
    	function thankyou_page() {
    		if ( $this->instructions ) {
    			echo do_shortcode( wpautop( wptexturize( $this->instructions ) ) );
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
    	function email_instructions( $order, $sent_to_admin, $plain_text = false ) {
    		if ( $this->instructions_in_email && ! $sent_to_admin && $this->id === ( $this->is_wc_version_below_3 ? $order->payment_method : $order->get_payment_method() ) && $this->default_order_status === ( $this->is_wc_version_below_3 ? $order->status : $order->get_status() ) ) {
    			echo do_shortcode( wpautop( wptexturize( $this->instructions_in_email ) ) . PHP_EOL );
    		}
    	}
        
         /**
         * Process the payment and return the result.
         *
         * @param int $order_id
         * @return array
         */
        public function process_payment( $order_id ) {

            $order = wc_get_order( $order_id );

            $status = 'wc-' === substr( $this->order_status, 0, 3 ) ? substr( $this->order_status, 3 ) : $this->order_status;

            // Set order status
            $order->update_status( $status, __( 'Checkout with custom payment. ', $this->domain ) );

            // Reduce stock levels
            $order->reduce_order_stock();

            // Remove cart
            WC()->cart->empty_cart();

            // Return thankyou redirect
            return array(
                'result'    => 'success',
                'redirect'  => $this->get_return_url( $order )
            );
        }
          
        
        /**
         * Initialise Gateway Settings Form Fields.
         */
        public function init_form_fields() {

            // Prepare shipping methods
            $shipping_methods = array();
            if ( is_admin() ){
                
                $do_load_shipping_method_instances = get_option( 'alg_wc_cpg_load_shipping_method_instances', 'yes' );
				if ( 'disable' != $do_load_shipping_method_instances && is_admin() ) {
					$data_store = WC_Data_Store::load( 'shipping-zone' );
					$raw_zones  = $data_store->get_zones();
					foreach ( $raw_zones as $raw_zone ) {
						$zones[] = new WC_Shipping_Zone( $raw_zone );
					}
					$zones[] = new WC_Shipping_Zone( 0 );
					foreach ( WC()->shipping()->load_shipping_methods() as $method ) {
						$shipping_methods[ $method->get_method_title() ] = array();
						// Translators: %1$s shipping method name.
						$shipping_methods[ $method->get_method_title() ][ $method->id ] = sprintf( __( 'Any &quot;%1$s&quot; method', 'woocommerce' ),
							$method->get_method_title() );
						foreach ( $zones as $zone ) {
							$shipping_method_instances = $zone->get_shipping_methods();
							$shipping_method_instances = ( 'yes' === $do_load_shipping_method_instances ? $zone->get_shipping_methods() : array() );
							foreach ( $shipping_method_instances as $shipping_method_instance_id => $shipping_method_instance ) {
								if ( $shipping_method_instance->id !== $method->id ) {
									continue;
								}
								$option_id = $shipping_method_instance->get_rate_id();
								// Translators: %1$s shipping method title, %2$s shipping method id.
								$option_instance_title = sprintf( __( '%1$s (#%2$s)', 'woocommerce' ),
									$shipping_method_instance->get_title(), $shipping_method_instance_id );
								// Translators: %1$s zone name, %2$s shipping method instance name.
								$option_title = sprintf( __( '%1$s &ndash; %2$s', 'woocommerce' ), $zone->get_id() ? $zone->get_zone_name() :
									__( 'Other locations', 'woocommerce' ), $option_instance_title );
								$shipping_methods[ $method->get_method_title() ][ $option_id ] = $option_title;
							}
						}
					}
				}
            }
            
                
            
            $this->form_fields = array(
                'enabled' => array(
                    'title'   => __( 'Enable/Disable', 'woocommerce' ),
                    'type'    => 'checkbox',
                    'label'   => __( 'Povoliť hotovosť', 'woocommerce' ),
                    'default' => 'yes'
                ),
                'title' => array(
                    'title'       => __( 'Title', 'woocommerce' ),
                    'type'        => 'text',
                    'description' => __( 'This controls the title which the user sees during checkout.', 'woocommerce' ),
                    'default'     => __( 'Platba v hotovosti', 'goshop_admin' ),
                    'desc_tip'    => true,
                ),
                /*
                'enable_for_methods' => array(
                    'title'             => __( 'Enable for shipping methods', 'woocommerce' ),
                    'type'              => 'multiselect',
                    'class'             => 'chosen_select',
                    'css'               => 'width: 450px;',
                    'default'           => '',
                    'description'       => __( 'If gateway is only available for certain shipping methods, set it up here. Leave blank to enable for all methods.', 'woocommerce' ),
                    'options'           => $shipping_methods,
                    'desc_tip'          => true,
                    'custom_attributes' => array(
                        'data-placeholder' => __( 'Select shipping methods', 'woocommerce' )
                    )                                                
                ),
                */
                /* 
                'order_status' => array(
                    'title'       => __( 'Order Status', 'woocommerce' ),
                    'type'        => 'select',
                    'class'       => 'wc-enhanced-select',
                    'description' => __( 'Choose whether status you wish after checkout.', 'woocommerce' ),
                    'default'     => 'wc-completed',
                    'desc_tip'    => true,
                    'options'     => wc_get_order_statuses()
                ),
                */
                'description' => array(
                    'title'       => __( 'Description', 'woocommerce' ),
                    'type'        => 'textarea',
                    'description' => __( 'Payment method description that the customer will see on your checkout.', 'woocommerce' ),
                    'default'     => __('Payment Information', 'woocommerce'),
                    'desc_tip'    => true,
                ),
                'instructions' => array(
                    'title'       => __( 'Instructions', 'woocommerce' ),
                    'type'        => 'textarea',
                    'description' => __( 'Instructions that will be added to the thank you page and emails.', 'woocommerce' ),
                    'default'     => '',
                    'desc_tip'    => true,
                ),
            );
        }



    }
    
}

function add_wc_gateway_alg_custom_classes( $methods ) {
	$methods[] = new WC_Gateway_Hotovost();
	return $methods;
}
add_filter( 'woocommerce_payment_gateways', 'add_wc_gateway_alg_custom_classes' );


add_filter( 'woocommerce_available_payment_gateways', 'allow_cash_only_for_pickup' );
  
function allow_cash_only_for_pickup( $available_gateways ) {
     
   if ( ! is_admin() ) {
        
      $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
      $chosen_shipping = $chosen_methods[0];
      
      if (strpos($chosen_shipping, 'local_pickup') === false) {
        unset( $available_gateways['goshop_custom_payment_method_hotovost'] );
      }
   
   }
     
   return $available_gateways;
     
}