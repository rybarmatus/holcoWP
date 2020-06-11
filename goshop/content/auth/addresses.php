<?php
$checkout = new WC_Checkout;
?>

<h1 class="h3 mb-2"><?= __('Adresy','goshop'); ?></h1>

<div class="row addresses">

  <div class="col-6 mb-mobile-1">
  	<h3 class="h5"><?= __('Fakturačná adresa', 'goshop'); ?></h3>
  	<address>
        <?php
        $fields = $checkout->get_checkout_fields( 'billing' );
          
          echo $checkout->get_value('billing_first_name'). ' ';
          echo $checkout->get_value('billing_last_name');
          echo '<br>';
          echo $checkout->get_value('billing_phone');
          echo '<br>';
          echo $checkout->get_value('billing_email');
          echo '<br>';
          echo $checkout->get_value('billing_address_1').' ';
          echo $checkout->get_value('billing_address_2');
          echo '<br>';
          echo $checkout->get_value('billing_postcode'). ' ';;
          echo $checkout->get_value('billing_city');
          echo '<br>';
          echo WC()->countries->countries[ $checkout->get_value('billing_country') ];
          
          if($checkout->get_value( 'billing_company_checkbox' ) == 1 ){
            echo '<br /><br />';
            echo $checkout->get_value('billing_company');
            echo '<br />';
            echo __('IČO', 'goshop'). ': ';
            echo $checkout->get_value('billing_company_ico');
            echo '<br>';
            $dic = $checkout->get_value('billing_company_dic');
            if(!empty($dic)){
                echo __('DIČ', 'goshop'). ': ';
                echo $dic;
                echo '<br>';
            }
            $ic_dph = $checkout->get_value('billing_company_dic');
            if(!empty($ic_dph)){
                echo __('IČ DPH', 'goshop'). ': ';
                echo $ic_dph;
                echo '<br>';
            }
            
            
            
          }
          ?>
        
    </address>
    <a href="<?= get_permalink(415); ?>?address=billing" title="<?= __('Upravit adresu', 'goshop'); ?>" class="mt-1 btn btn-small btn-primary"><?= __('Upravit adresu', 'goshop'); ?></a>    
  </div>
  <div class="col-6">
  	<h3 class="h5"><?= __('Dodacia adresa', 'goshop'); ?></h3>
  	<address>
    
    <?php
    $fields = $checkout->get_checkout_fields( 'shipping' );
    
    echo $checkout->get_value('shipping_first_name'). ' ';
    echo $checkout->get_value('shipping_last_name');
    echo '<br>';
    echo $checkout->get_value('shipping_company');
    echo '<br>';
    echo $checkout->get_value('shipping_address_1'). ' ';
    echo $checkout->get_value('shipping_address_2');
    echo '<br />';
    echo $checkout->get_value('shipping_postcode'). ' ';
    echo $checkout->get_value('shipping_city');
    echo '<br />';
    echo WC()->countries->countries[ $checkout->get_value('shipping_country') ];
    ?>
    
    </address>
    <a href="<?= get_permalink(415); ?>?address=shipping" title="<?= __('Upravit adresu', 'goshop'); ?>" class="mt-1 btn btn-small btn-primary"><?= __('Upravit adresu', 'goshop'); ?></a>    
  </div>

</div>