<?php
$shipping = array();

$shipping['shipping_free'] = get_option('option_shipping_free');
$shipping['cod_price'] = get_option('option_cod_fee');
$shipping['cod_fee_limit'] = get_option('option_cod_fee_limit');

if(empty($shipping['cod_price'])){
    $shipping['cod_price'] = 0;
}

$delivery_zones = WC_Shipping_Zones::get_zones();
foreach ( $delivery_zones as $key => $the_zone ) {
  
  foreach ($the_zone['shipping_methods'] as $key=>$value) {
    
    if($value->enabled == 'yes' and $value->id == 'flat_rate'){
        
        $number = floatval(str_replace(',', '.', $value->cost ));
        
        $shipping['methods'][$key]['ID'] = $value->instance_settings['heureka_delivery'];
        $shipping['methods'][$key]['price'] = $value->cost;
        $shipping['methods'][$key]['price_cod'] = $number  + $shipping['cod_price'];
        
    }
    
  }
  
  break;  
}

$products_query = new WP_Query([
 'post_type' => 'product',
 'post_status' => 'publish',
 'posts_per_page' => -1,
  'tax_query'	=> array(
	'relation' => 'OR',
      array(
	'taxonomy'  => 'product_type',
	'field'	  	=> 'slug',
	'terms' 	=> 'simple',
   ),
     array(
	'taxonomy'  => 'product_type',
	'field'	  	=> 'slug',
	'terms' 	=> 'variable',
   )
  ),
  'meta_query' => array(
     array(
       'relation' => 'OR',
       array(
        'key' => 'index',
        'value' => '1',
        'compare' => '='
       ),
        array(
          'key' => 'index',
          'compare' => 'NOT EXISTS'
        )
    )
    /* 
  'meta_query' => array(
     array(
        'relation' => 'AND',
        array(
          'key' => '_stock_status',
          'value' => 'instock',
          'compare' => '='
        )
     )  
  )
  */
  )   
]);
$products = $products_query->posts;
// $product = wc_get_product($products[0]->ID);

function addXmlItem($xml, $post, $_product, $_variation = false, $shipping){
    
    if($_variation){
        $item_id = $_variation->get_ID();
    }else{
        $item_id = $post->ID;
    }                   
    
    $image_url = wp_get_attachment_image_src( get_post_thumbnail_id($item_id), 'full' );
    $attachment_ids = $_product->get_gallery_image_ids();
    
    $shopitem = $xml->addChild('SHOPITEM');
    if($_variation){
        $shopitem->addChild('ITEMGROUP_ID', $post->ID);
    }
    $shopitem->addChild('ITEM_ID', $item_id);
    $shopitem->addChild('PRODUCTNAME', htmlspecialchars($post->post_title));
    $shopitem->addChild('DESCRIPTION', htmlspecialchars($post->post_content));
    
    if($_variation){
        $shopitem->addChild('URL', $_variation->get_permalink());                         
    }else{
        $shopitem->addChild('URL', get_permalink($post->ID));
    }
                               
    
    $shopitem->addChild('IMGURL', $image_url[0]);
    
    if($attachment_ids){
      foreach ( $attachment_ids as $key=>$attachment_id ) {
  		 $thumbnail = wp_get_attachment_image_src($attachment_id, 'full');
         $shopitem->addChild('IMGURL_ALTERNATIVE', $thumbnail[0]);
      }     
    }
    
    if($_variation){
        $shopitem->addChild( 'PRICE_VAT', $_variation->get_price() );
    }else{
        $shopitem->addChild( 'PRICE_VAT', $_product->get_price() );
    }
    
    $shopitem->addChild('MANUFACTURER', $_SERVER['SERVER_NAME']);
    
    if ( $heureka_kategoria = get_field('heureka_kategoria', $post->ID) ){
        
        /* 
        $shopitem->addChild('CATEGORY_ID', 5457);
        */
        $shopitem->addChild('CATEGORYTEXT', $heureka_kategoria);
    }else{
        $term_list = wp_get_post_terms($post->ID,'product_cat');
        $cat_term = $term_list[0];
        
        if ( $heureka_kategoria = get_field('heureka_kategoria', $cat_term) ){
            // $shopitem->addChild('CATEGORY_ID', 5457);
            $shopitem->addChild('CATEGORYTEXT', $heureka_kategoria);
        }
    }
    
    if($_variation){
        $shopitem->addChild('EAN', $_variation->get_sku());
    }else{
        $shopitem->addChild('EAN', $_product->get_sku());
    }
    
    
    /* DELIVERY */
      
    $shopitem->addChild('DELIVERY_DATE', 0);
    
    if(!empty($shipping)){
      foreach($shipping['methods'] as $method){
      
          if( isset($shipping['shipping_free']) and $_product->get_price() >= $shipping['shipping_free']){
            $method['price'] = 0;
          }
          
          if( isset($shipping['cod_fee_limit']) and $_product->get_price() >= $shipping['cod_fee_limit']){
            $method['price_cod'] = $method['price'];
          }
      
          $param = $shopitem->addChild('DELIVERY');
          $param->addChild('DELIVERY_ID', $method['ID']);
          $param->addChild('DELIVERY_PRICE', $method['price']);
          $param->addChild('DELIVERY_PRICE_COD', $method['price_cod']);    
      }
    }

    
}


$xml = new SimpleXMLElement("<?xml version=\"1.0\" encoding=\"utf-8\" ?><SHOP></SHOP>");
?>
<?php

foreach($products as $key=>$post){
  
  $_product = wc_get_product($post->ID);
  
  
  if ($_product->is_type( 'variable' )){
    $available_variations = $_product->get_available_variations();
    foreach ($available_variations as $key => $variation){
      
      $_variation = new WC_Product_Variation($variation['variation_id']); 
      addXmlItem($xml, $post, $_product, $_variation, $shipping );
    
    }   
        
    
   }else{
  
    addXmlItem($xml, $post, $_product, false, $shipping);
  
  }
  
}

header('Content-Type: application/xml');
$xml->asXml('heureka_feed.xml');
print($xml->asXML());
