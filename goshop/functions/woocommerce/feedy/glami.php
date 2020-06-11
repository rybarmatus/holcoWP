<?php

/* TODO: 

https://soxstar.sk/glami.xml
https://www.glami.sk/info/feed/#_feed-tag-delivery
https://www.glami.sk/category-xml/

delit kategorie na panske a damke
zobrazit iba ponozky
pridat custom fieldy pre glami parametre do goshopu - na urovni kategorie, na urovni produktu podla vlastnosti
pridat shipping a ceny nech sa generuju same
pridat field na kategorie ktore sa maju generovat
dat link na pregenerovanie vsetkych feedov - nastavit cron na tento link

spravit toto iste pre heureku

ak hodí feed error poslat mi email

*/

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
  )   
]);
$products = $products_query->posts;
$product = wc_get_product($products[0]->ID);

function addXmlItem($xml, $post, $_product, $_variation = false){
    
    if($_variation){
        $item_id = $_variation->get_ID();
    }else{
        $item_id = $post->ID;
    }                   
    
    $image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
    $attachment_ids = $_product->get_gallery_image_ids();
    
    $shopitem = $xml->addChild('SHOPITEM');
    if($_variation){
        $shopitem->addChild('ITEMGROUP_ID', $post->ID);
    }
    $shopitem->addChild('ITEM_ID', $item_id);
    $shopitem->addChild('PRODUCTNAME', $post->post_title);
    $shopitem->addChild('DESCRIPTION', htmlspecialchars($post->post_content));
    $shopitem->addChild('URL', get_permalink($post->ID));
    if($_variation){
        $shopitem->addChild('URL_SIZE', $_variation->get_permalink());
    }    
    
    $shopitem->addChild('IMGURL', $image_url[0]);
    
    if($attachment_ids){
      foreach ( $attachment_ids as $key=>$attachment_id ) {
  		 $thumbnail = wp_get_attachment_image_src($attachment_id, 'full');
         $shopitem->addChild('IMGURL_ALTERNATIVE', $thumbnail[0]);
      }     
    }
    
    $shopitem->addChild('PRICE_VAT', $_product->get_price());
    $shopitem->addChild('MANUFACTURER', 'Soxstar.sk');
    $shopitem->addChild('CATEGORYTEXT', 'Glami.sk | Dámske oblecenie a obuv | Dámske oblecenie | Dámska spodná bielizen | Dámske ponožky');
    $shopitem->addChild('CATEGORY_ID', 5457);
    $shopitem->addChild('EAN', $_product->get_sku());
    
    if($_variation){
        
      $size = $_variation->get_attribute( 'pa_velkost' );
      $param = $shopitem->addChild('PARAM');
      $param->addChild('PARAM_NAME', 'velkost');
      $param->addChild('VAL', 'EU '.$size);
      
      $param = $shopitem->addChild('PARAM');
      $param->addChild('PARAM_NAME', 'size_system');
      $param->addChild('VAL', 'EU');
    
    }
      
    $param = $shopitem->addChild('PARAM');
    $param->addChild('PARAM_NAME', 'materiál');
    $param->addChild('VAL', 'Bavlna');
    $param->addChild('PERCENTAGE', '90%');
      
    $param = $shopitem->addChild('PARAM');
    $param->addChild('PARAM_NAME', 'materiál');
    $param->addChild('VAL', 'Polyamid');
    $param->addChild('PERCENTAGE', '8%');
      
    $param = $shopitem->addChild('PARAM');
    $param->addChild('PARAM_NAME', 'materiál');
    $param->addChild('VAL', 'Elastan');
    $param->addChild('PERCENTAGE', '2%');
    
    /* DELIVERY */
      
    $shopitem->addChild('DELIVERY_DATE', 0);
    
    $param = $shopitem->addChild('DELIVERY');
    $param->addChild('DELIVERY_ID', 'Zásielkovna');
    $param->addChild('DELIVERY_PRICE', '1.99');
    $param->addChild('DELIVERY_PRICE_COD', '2.99');
    
    $param = $shopitem->addChild('DELIVERY');
    $param->addChild('DELIVERY_ID', 'Slovenská pošta');
    $param->addChild('DELIVERY_PRICE', '2.5');
    $param->addChild('DELIVERY_PRICE_COD', '3.5');
    
    $param = $shopitem->addChild('DELIVERY');
    $param->addChild('DELIVERY_ID', 'Kuriér ReMax');
    $param->addChild('DELIVERY_PRICE', '3.6');
    $param->addChild('DELIVERY_PRICE_COD', '4.6');
    
}


$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');

foreach($products as $key=>$post){
  
  $_product = wc_get_product($post->ID);
  
  
  if ($_product->is_type( 'variable' )){
    $available_variations = $_product->get_available_variations();
    foreach ($available_variations as $key => $variation){
      
      $_variation = new WC_Product_Variation($variation['variation_id']); 
      
      addXmlItem($xml, $post, $_product, $_variation );
    }   
        
    
   }else{
  
    addXmlItem($xml, $post, $_product);
  
  }
  
}

header('Content-Type: application/xml');
print($xml->asXML());
