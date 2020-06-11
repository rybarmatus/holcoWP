<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.2.0
 */

 /* prebehne datalayer, zasielkovna, heureka, zbozi.cz atd, spraví sa redirect */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $goshop_config;

foreach( $order->get_items( 'shipping' ) as $item_id => $shipping_item_obj ){
    $shipping_method_instance_id = $shipping_item_obj->get_instance_id(); // The instance ID
    break;
}

$goshop_config['zasielkovna_password'] = true;


if(!get_post_meta( $order->get_id(), 'success_scripts', true )){

    
    if($goshop_config['woo-bundle-products']){
        $items = $order->get_items();
        
        
        foreach ( $items as $key=>$item ) {
              $_product = $item->get_product();
              $_product = wc_get_product( $_product->get_id() );
              $bundle_items = false;
              if($_product->is_type( 'variation' ) or $_product->is_type( 'bundle' )){
                
                if ($bundle_ids_str = get_post_meta($_product->get_id(), 'bundle_ids', true)) {
                  $bundle_items = bundle_get_bundled(0, $bundle_ids_str, false);
                }
              
              }else{
                continue;
              }
              
              if($bundle_items){
                $note = __('Znížená úroveň zásob:', 'goshop_admin');
                foreach($bundle_items as $bundle_item){     
                  $_bundle_product = wc_get_product( $bundle_item['id'] );
                  if( $_bundle_product->managing_stock() ){
                    $old_quantity = $_bundle_product->get_stock_quantity(); 
                    $stock_quantity = $old_quantity - $bundle_item['qty'];               
                    wc_update_product_stock($_bundle_product, $stock_quantity );
                    
                    $note .= ' '. $_bundle_product->get_name(). ' '.$old_quantity. '→'.$stock_quantity.',';
                                        
                  }
                
                }
                $order->add_order_note( $note );
               
                
              }
          
          }
     }                                           
        
    
    
    if(get_post_meta( $order->get_id(), '_billing_heureka_overene', true )){
  
      $heureka_api_kluc = get_option('option_heureka_overene_zakaznikmi_api');
            
      if(!empty($heureka_api_kluc)){
      
        $items = $order->get_items();
        $order_items = '';
        foreach ( $items as $key=>$item ) {
            $product_id = $item->get_product_id();
            $order_items .= '&itemId[]='.$product_id;
        }
        
        $curl_url = 'https://www.heureka.sk/direct/dotaznik/objednavka.php?id='.$heureka_api_kluc.'&email='.$order->get_billing_email().$order_items.'&orderid='.$order->get_order_number();
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $curl_url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        curl_close($ch);
    }
    
  }    
  
  if($goshop_config['glami_track']) { 
    $products_names = '';
    ?>
    <script>
    glami('track', 'Purchase', {
      item_ids: [
        <?php
        $items = $order->get_items();
        $i = 0; 
        $pocet = count($items);
        foreach ($items as $item_id => $item_data) { 
           $product = $item_data->get_product();
           $products_names .= "'".$product->get_name()."'";
           $i++;
          ?>
          
          '<?= $product->get_ID() ?>'
           
          <?php if($pocet > $i){ 
              echo ',';
              $products_names .= ',';
          } ?>
          
        <?php } ?>
      
      ],
      product_names: [<?= $products_names ?>], 
      value: <?= $order->get_total(); ?>, 
      currency: '<?= CURRENCY_TEXT ?>',
      transaction_id: '<?= $order->get_id() ?>' 
    });
    </script>
  
  <?php } ?>
  
  <?php
  if($goshop_config['ZBOZI_CZ_ID_PROVOZOVNY']) { ?>
    <script>
      (function(w,d,s,u,n,k,c,t){w.ZboziConversionObject=n;w[n]=w[n]||function(){
        (w[n].q=w[n].q||[]).push(arguments)};w[n].key=k;c=d.createElement(s);
        t=d.getElementsByTagName(s)[0];c.async=1;c.src=u;t.parentNode.insertBefore(c,t)
      })(window,document,"script","https://www.zbozi.cz/conversion/js/conv-v3.js","zbozi","<?= $goshop_config['ZBOZI_CZ_ID_PROVOZOVNY'] ?>");
    
      // zapnutí testovacího režimu
      // zbozi("useSandbox");
    
      // nastavení informací o objednávce
      zbozi("setOrder",{
        "orderId": "<?= $order->get_id() ?>"
      });
    
      // odeslání
      zbozi("send");
    </script>
  <?php } ?>
  
  <script>
    if(typeof gtag != 'undefined') {
      gtag('event', 'purchase', {
        "transaction_id": <?= $order->get_id() ?>,
        "affiliation": "<?= $_SERVER['HTTP_HOST']; ?>",
        "value": '<?= $order->get_total(); ?>',
        "currency": "<?= CURRENCY_TEXT ?>",
        "tax": "0",
        "shipping": <?= $order->get_total_shipping() ?>,
        "items": [
            <?php 
            $items = $order->get_items(); $i = 0; $pocet = count($items); foreach ($items as $item_id => $item_data) { 
            $product = $item_data->get_product();
            $i++;
            ?>
            {
             'name': '<?= $product->get_name() ?>',
             'price': <?php echo number_format(round(($item_data->get_total()/$item_data->get_quantity()), 2), 2, '.', ''); ?>,
             'quantity': <?= $item_data->get_quantity() ?>
            }
            <?php if($pocet > $i){ 
                echo ',';
            } ?>
             
            <?php } ?>
        
        ]
      });
    }
    
    window.dataLayer = window.dataLayer || []
      dataLayer.push({
         'transactionId': <?= $order->get_id() ?>,
         'transactionAffiliation': '<?= $_SERVER['HTTP_HOST']; ?>',
         'transactionCurrency': '<?= CURRENCY_TEXT ?>',
         'transactionTotal': <?= $order->get_total(); ?>,
         'transactionTax': 0,
         'transactionShipping': <?= $order->get_total_shipping() ?>,
         'transactionProducts': [
         
          <?php $items = $order->get_items(); $i = 0; $pocet = count($items); foreach ($items as $item_id => $item_data) { 
           $product = $item_data->get_product();
           $i++;
          ?>
          {
           'name': '<?= $product->get_name() ?>',
           'price': <?php echo number_format(round(($item_data->get_total()/$item_data->get_quantity()), 2), 2, '.', ''); ?>,
           'quantity': <?= $item_data->get_quantity() ?>
         
          }
          <?php if($pocet > $i){ 
              echo ',';
          } ?>
           
        <?php } ?>
      
      ]
      });
  </script>
  
  
  <?php
  if($goshop_config['zasielkovna_password']){
  
    if(isset($shipping_method_instance_id)){  

      if( $shipping_method_instance_id == 4 or $shipping_method_instance_id == 6 ){

        $zasielkovna_pobocka_id = get_post_meta( $order->get_id(), '_billing_zasielkovna_branch_id', true );
        
       // $zasielkovna_pobocka_id = 149;   -- GLS
        
        $cod = 0;
        if($order->get_payment_method() == 'cod'){
          $cod = $order->get_total();
        }
        
        
        $gw = new SoapClient("http://www.zasilkovna.cz/api/soap.wsdl");
        
        try {
            $packet = $gw->createPacket($goshop_config['zasielkovna_password'], array(
                'number' => $order->get_order_number(),
                'name' => $order->get_shipping_first_name(),
                'surname' => $order->get_shipping_last_name(),
                'email' => $order->get_billing_email(),
                'phone' => $order->get_billing_phone(),
                'currency' => $order->get_currency(),
                'addressId' => $zasielkovna_pobocka_id,
                'company' => $order->get_shipping_company(),
                'cod' => $cod,
                'value' => $order->get_total(),
                'eshop' => get_site_url(),
                'street' => $order->get_shipping_address_1(),
                'houseNumber' => $order->get_shipping_address_2(), 
                'city' => $order->get_shipping_city(),       
                'zip' => $order->get_shipping_postcode() 
            ));
        }
        catch(SoapFault $e) {
           // var_dump($e->detail); // property detail contains error info
        }

      }
    }
  }
  
  add_post_meta( $order->get_id(), 'success_scripts', 1);
}
?>
<div class="thank_you_page">

	<?php if ( $order ) : ?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<p><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

			<p>
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="btn btn-primary"><?php _e( 'Pay', 'woocommerce' ) ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php _e( 'My account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>

            <div class="row thank-header-wrapper mb-4">
                <div class="col-md-12">
                    <h1 class="text-center mb-1">
                        <div class="thank-icon-wrapper text-center">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-check fa-w-16 fa-3x"><path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z" class=""></path></svg>
                        </div>
                        <?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), $order ); ?>
                    </h1>
                    <div class="order-summary-wrapp text-center">
                    <li>
    					<?= __( 'Číslo objednávky', 'goshop' ); ?>
    					<strong><?= $order->get_order_number(); ?></strong>
    				</li>
    
    				<li>
    					<?php _e( 'Date', 'woocommerce' ); ?>
    					<strong><?= wc_format_datetime( $order->get_date_created() ); ?></strong>
    				</li>
    
    				<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
    					<li>
    						<?php _e( 'Email', 'woocommerce' ); ?>
    						<strong><?= $order->get_billing_email(); ?></strong>
    					</li>
    				<?php endif; ?>
                    <?php if ( $order->get_billing_phone() ) : ?>
        			 <li>
                        Tel. kontakt
                        <strong><?= esc_html( $order->get_billing_phone() ); ?></strong>
                     </li>
        		    <?php endif; ?>
                    <li>
    					<?php _e( 'Shipping', 'woocommerce' ); ?>
    					<strong><?= $order->get_order_item_totals()['shipping']['value']; ?></strong>
    				</li>
                    <?php if ( $order->get_payment_method_title() ) : ?>
    					<li>
    						<?= __( 'Spôsob platby', 'goshop' ); ?>
    						<strong><?= wp_kses_post( $order->get_payment_method_title() ); ?></strong>
    					</li>
    				<?php endif; ?>
                    <?php
                    if( $shipping_method_instance_id == 4 or $shipping_method_instance_id == 6 ){
                        $zasielkovna_pobocka_name = get_post_meta( $order->get_id(), '_billing_zasielkovna_branch_name', true );
                        if($zasielkovna_pobocka_name){
                        ?>    
                        <li>
        					<?php _e( 'Zásielkovňa pobočka', 'goshop' ); ?>
        					<strong><?= $zasielkovna_pobocka_name; ?></strong>
        				</li>
                        <?php 
                        }
                    }     
                    ?>
                                                                   
                    <li>
    					<?php _e( 'Total', 'woocommerce' ); ?>
    					<strong><?= $order->get_formatted_order_total(); ?></strong>
    				</li>
                   
                </div>
            </div>
            </div>
            <div class="pb-2">
                <?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
                <?php do_action( 'woocommerce_thankyou', $order->get_id() ); // toto je spodny obsah ?>
            </div>
            
        <?php endif; ?>

	<?php else : ?>

		<p><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), null ); ?></p>

	<?php endif; ?>

</div>


