<?php
/**                                                                                                                                                               
Template Name: Zakúpené produkty
*/

get_header();
?>





  <h1 class="h3 mb-2"><?= __('Zakúpené produkty','goshop'); ?></h1>
  <?php
  
  $customer_orders = get_posts( apply_filters( 'woocommerce_my_account_my_orders_query', array(
  	'numberposts' => -1,
  	'meta_key'    => '_customer_user',
  	'meta_value'  => get_current_user_id(),
  	'post_type'   => wc_get_order_types( 'view-orders' ),
  	'post_status' => array_keys( wc_get_order_statuses() ),
  ) ) );
  
  
  if(!empty($customer_orders)){
      $buyed_products = array();
      foreach ( $customer_orders as $customer_order ) {
      
         $order  = wc_get_order( $customer_order );
         
         foreach ($order->get_items() as $item_id => $item_data) {
         
            
            $product = $item_data->get_product();
            
            if($product->is_type('gift')){
            continue;
            }
            
            $product_id = $product->get_ID();
            
            $product_quantity = $item_data->get_quantity(); // Get the item quantity
            // $product_total = $item_data->get_total(); // Get the item line total
            
            if(isset($buyed_products[$product_id])){                                           
            
              $buyed_products[$product_id]['orders'] .=  ', <a class="hover-underline" title="'. __('Zobraz objednávku č.', 'goshop') .' '.$order->get_ID(). '" href="'.get_permalink(408).'?orderID='.$order->get_ID().'">'.$order->get_id().'</a>';
              $buyed_products[$product_id]['quantity'] += $product_quantity;
              
            }else{
            
              $product_image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'thumbnail' )[0];
              if(!$product_image){
                 $product_image = IMAGES .'/no-image.png';
              }
              $product_name = $product->get_name(); // Get the product name
            
              $buyed_products[$product_id] = array(
              
                  'name'  => $product_name,
                  'image' => $product_image,
                  'orders' => '<a class="hover-underline" title="'. __('Zobraz objednávku č.', 'goshop') .' '.$order->get_ID(). '" href="'.get_permalink(408).'?orderID='.$order->get_ID().'">'.$order->get_id().'</a>',
                  'quantity' => $product_quantity
              
              );
            }
         }
                                                                   
}
      foreach($buyed_products as $key=>$item){
      ?>
      
          <div class="row mb-1 buyed_products_row">
              <div class="col-9">
                  <a  title="<?= $item['name']; ?>" href="<?= $product_link = get_permalink($key); ?>">
                      <img class="lazy float-left" src="<?= NO_IMAGE; ?>" data-src="<?= $item['image']; ?>" width="50" height="50" alt="<?= $item['name']; ?>">
                  </a>
                  <div class="float-left">
                      <a class="hover-underline" href="<?= $product_link; ?>" title="<?= $item['name']; ?>"><?= $item['name']; ?></a>
                      <div class="orders"><?= __('Objednávky','goshop');?> <?= $item['orders']; ?></div>
                  </div>
              </div>
              <div class="col-3 text-right">
                  <?= $item['quantity']; ?> <?= __('ks','goshop'); ?>
              </div>
          </div>
          
      
      <?php
      }
         

      
  }else{
  ?>
  <div class="alert alert-danger"><?= __('Zatial ste u nás nič nazakúpili.', 'goshop'); ?></div>
  <?php } ?>
  
    
    </div>
  </div>

  
</div>


<?php get_footer();
