<?php

add_filter('woocommerce_checkout_fields', 'custom_checkout_billing_fields');
function custom_checkout_billing_fields($fields) {
    global $goshop_config;
    
    foreach($fields as $key=> $fields_group){
    
      foreach($fields_group as $lab => $group){
          $fields[$key][$lab]['input_class'] = array( 'form-control');
          $fields[$key][$lab]['class'] = array( 'col-6');
      }
    }
    
    unset($fields['billing']['billing_state']); // da preč kraje
    $fields['account']['account_username']['input_class'] = array( 'form-control');    
    $fields['account']['account_username']['class'] = array('col-md-6');
    $fields['account']['account_username']['label'] = __('Vaše meno', 'goshop');
    $fields['account']['account_password']['label'] = __('Heslo', 'goshop');
    $fields['account']['account_password']['class'] = array('col-md-6');
    $fields['account']['account_password']['input_class'] = array( 'form-control');
    $fields['account']['account_password']['placeholder'] = $fields['account']['account_username']['placeholder'] = false;
    
    $fields['order']['order_comments']['class'] = array('col-md-12');
    $fields['order']['order_comments']['label'] = false;
    
    
    
    $fields['billing']['billing_address_2']['label'] = $fields['shipping']['shipping_address_2']['label'] = __('Číslo domu', 'goshop');
    $fields['billing']['billing_email']['class'] = array('col-md-12');
    $fields['billing']['billing_company']['priority'] = 119;
    $fields['billing']['billing_company']['class'] = array('col-6 checkout-company-field');
    $fields['billing']['billing_country']['priority'] = 71;
    $fields['billing']['billing_country']['class'] = array('address-field col-6');
    
    $fields['billing']['billing_email']['priority'] = 1;
    
    $fields['billing']['billing_email']['required'] = true;
    
    if($goshop_config['checkout_company']){
     
        $fields['billing']['billing_company_checkbox'] = array(
            'label' => __('Nakupujem na firmu', 'goshop'), // Add custom field label
            'placeholder'   => '',
            'required'  => false,
            'class'     => array('col-md-12'),
            'clear'     => true,
            'priority'  => 118,
            'type'      => 'checkbox'
        );
        $fields['billing']['billing_company_ico'] = array(
            'label'        => __('IČO', 'goshop'), // Add custom field label
            'placeholder'  => '',
            'required'     => false,
            'class'        => array('col-6', 'checkout-company-field'),
            'input_class'   => array('form-control'),
            'clear'        => true,
            'priority'     => 120,
            'type'         => 'text'
        );
        $fields['billing']['billing_company_dic'] = array(
            'label' => __('DIČ', 'goshop'), // Add custom field label
            'placeholder'   => '',
            'required'      => false,
            'class'         => array('col-6', 'checkout-company-field'),
            'input_class'   => array('form-control'), 
            'clear'         => true,
            'priority'      => 120,
            'type'          => 'text'
        );
        $fields['billing']['billing_company_ic_dph'] = array(
            'label' => __('IČ DPH', 'goshop'), // Add custom field label
            'placeholder'   => '',
            'required'      => false,
            'class'         => array('col-6', 'checkout-company-field'),
            'input_class'   => array('form-control'),
            'clear'         => true,
            'priority'      => 120,
            'type'          => 'text'
            
        );
        
    }    

    if($goshop_config['cetelem']){
    
      $fields['billing']['billing_celetem_data'] = array(
          'label' => __('Cetelem data', 'goshop'), // Add custom field label
          'placeholder'   => '',
          'required'  => false,
          'class'     =>  array('d-none'),
          'clear'     => true,
          'priority'     => 130,
          'type' => 'text'
      );
    
    }
    
    
    
    if($goshop_config['zasielkovna_api']){
    
       $fields['billing']['billing_zasielkovna_branch_id'] = array(
          'label' => __('Zasielkovna pobočka id', 'goshop'), // Add custom field label
          'placeholder'   => '',
          'required'  => false,
          'class'     =>  array('d-none'),
          'input_class' => array('packeta-selector-branch-id'),
          'clear'     => true,
          'priority'     => 130,
         // 'type' => 'hidden'
      );
           
      $fields['billing']['billing_zasielkovna_branch_name'] = array(
          'label' => __('Zasielkovna pobocka name', 'goshop'), // Add custom field label
          'placeholder'   => '',
          'required'  => false,
          'class'     =>  array('d-none'),
          'input_class' => array('packeta-selector-branch-name', 'checkout-zasielkovna-name'),
          'clear'     => true,
          'priority'     => 130,
          'type' => 'text'
      );
      
    }
    
    $fields['billing']['billing_heureka_overene'] = array(
        'label' => false,
        'placeholder'   => '',
        'required'  => false,
        'class'     => array('d-none'),
        'clear'     => true,
        'priority'     => 140,
        'type' => 'select',
        'options' => array(
            '0' => '0',
            '1' => '1'
           
        )
    );
   
   $fields['city']['priority'] = 41;
   unset($fields['address_2']);
    
   return $fields;
}

/**
 * Display field value on the order edit page
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'add_fields_to_admin_post', 10, 1 );

function add_fields_to_admin_post($order){
    global $goshop_config;
  
    echo '<div style="clear:both"></div>';
                        
    $meta_values = get_post_meta( $order->get_id() );

                      
          $ico = get_post_meta( $order->get_id(), '_billing_company_ico', true ); 
          $dic = get_post_meta( $order->get_id(), '_billing_company_dic', true );
          $ic_dph = get_post_meta( $order->get_id(), '_billing_company_ic_dph', true )
          ?>
          <div class="address">
            <?php if($ico){ ?>
            <p class="form-field"><strong><?= __('IČO', 'goshop'); ?></strong><?= $ico; ?></p>
            <?php } ?>
            <?php if($dic){ ?>
            <p class="form-field"><strong><?= __('DIČ', 'goshop'); ?></strong><?= $dic; ?></p>
            <?php } ?>
            <?php if($ic_dph){ ?>
            <p class="form-field"><strong><?= __('IČ DPH', 'goshop'); ?></strong><?= $ic_dph; ?></p>
            <?php } ?>
          </div>  
          
          <div class="edit_address">
              <?php woocommerce_wp_text_input( array( 'id' => '_billing_company_ico', 'label' => __( 'IČO', 'goshop' ), 'wrapper_class' => '_billing_company_ico' ) ); ?>
              <?php woocommerce_wp_text_input( array( 'id' => '_billing_company_dic', 'label' => __( 'DIČ', 'goshop' ), 'wrapper_class' => 'billing_company_dic' ) ); ?>
              <?php woocommerce_wp_text_input( array( 'id' => '_billing_company_ic_dph', 'label' => __( 'IČ DPH', 'goshop' ), 'wrapper_class' => '_billing_company_ic_dph' ) ); ?>
          </div>
          <style>
          .billing_company_dic, .billing_zasielkovna_branch_name{
          clear:right !important;
          float:right !important;
          }
          </style>
      <?php
        echo '<div style="clear:both"></div>';    
      
      
      
      
    if($goshop_config['zasielkovna_api']){

      foreach( $order->get_items( 'shipping' ) as $item_id => $shipping_item_obj ){
         $shipping_method_instance_id = $shipping_item_obj->get_instance_id(); // The instance ID
        break;
      }
      $zasielkovna_pobocka_id = get_post_meta( $order->get_id(), '_billing_zasielkovna_branch_id', true );  
    
      if(isset($shipping_method_instance_id)){  
     
        if( $shipping_method_instance_id == 4 or $shipping_method_instance_id == 6 ){
            $zasielkovna_pobocka_name = get_post_meta( $order->get_id(), '_billing_zasielkovna_branch_name', true );
            ?>
            <div class="address">
              <p><strong><?= __('Zásilkovna pobočka id', 'goshop'); ?>:</strong> <?= $zasielkovna_pobocka_id ?></p>
              <p><strong><?= __('Zásilkovna pobočka nazov', 'goshop'); ?>:</strong> <?= $zasielkovna_pobocka_name ?></p>
            </div>
            <div class="edit_address">
                <?php woocommerce_wp_text_input( array( 'id' => '_billing_zasielkovna_branch_id', 'label' => __('Zásilkovna pobočka id', 'goshop'), 'wrapper_class' => 'billing_zasielkovna_branch_id' ) ); ?>
                <?php woocommerce_wp_text_input( array( 'id' => '_billing_zasielkovna_branch_name', 'label' => __('Zásilkovna pobočka nazov', 'goshop'), 'wrapper_class' => 'billing_zasielkovna_branch_name' ) ); ?>
            </div>
        <?php
        }
      
      }
    
    }
    
    
    $heureka_api_kluc = get_option('option_heureka_overene_zakaznikmi_api');
    
   
   if(!empty($heureka_api_kluc) and $order->get_id()){
        
        $heureka_overene =  get_post_meta( $order->get_id(), '_billing_heureka_overene', true );
      
        if(!empty($heureka_overene)){
            if($heureka_overene == 1){
                $heureka_overene = __('Áno','goshop');
            }else{
                $heureka_overene = __('Nie','goshop');
            }
            echo '<p><strong>'.__('Heureka overené zákazníkmi', 'goshop').':</strong> ' . $heureka_overene . '</p>';
        }    
   }
   
}

  function edit_new_fields( $post_id, $post ){
      global $goshop_config;
      
      update_post_meta( $post_id, '_billing_company_ico', wc_clean( $_POST[ '_billing_company_ico' ] ) );
      update_post_meta( $post_id, '_billing_company_dic', wc_clean( $_POST[ '_billing_company_dic' ] ) );
      update_post_meta( $post_id, '_billing_company_ic_dph', wc_clean( $_POST[ '_billing_company_ic_dph' ] ) );

      if($goshop_config['zasielkovna_api']){
      
        update_post_meta( $post_id, '_billing_zasielkovna_branch_id', wc_clean( $_POST[ '_billing_zasielkovna_branch_id' ] ) );
        update_post_meta( $post_id, '_billing_zasielkovna_branch_name', wc_clean( $_POST[ '_billing_zasielkovna_branch_name' ] ) );
      
      }
      
  }
  add_action( 'woocommerce_process_shop_order_meta', 'edit_new_fields', 45, 2 );
