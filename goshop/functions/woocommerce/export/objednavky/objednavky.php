<?php

/* TODO: */

$customer_orders = get_posts( 
    array(
        'numberposts' => - 1,
        // 'meta_key'    => '_customer_user',
        // 'meta_value'  => get_current_user_id(),
        'post_type'   => array( 'shop_order' ),
        'post_status' => array( 'wc-completed' ),
        'date_query' => array(
            'after' => date('Y-m-d', strtotime('-365 days')),
            'before' => date('Y-m-d', strtotime('2019-1-1')) 
        )
    ) 
);

    foreach ( $orders as $order ) {
            print_r($order);
    
    }

function addXmlItem($xml, $post, $_product, $_variation = false){
    
    
    $shopitem = $xml->addChild('SHOPITEM');
    
    $shopitem->addChild('ITEM_ID', $item_id);
    $shopitem->addChild('PRODUCTNAME', $post->post_title);
    $shopitem->addChild('DESCRIPTION', htmlspecialchars($post->post_content));
    $shopitem->addChild('URL', get_permalink($post->ID));
        
    
    $shopitem->addChild('IMGURL', $image_url[0]);
    
    if($attachment_ids){
      foreach ( $attachment_ids as $key=>$attachment_id ) {
  		
         $shopitem->addChild('IMGURL_ALTERNATIVE', $thumbnail[0]);
      }     
    }
    
    $shopitem->addChild('PRICE_VAT', $_product->get_price());
    $shopitem->addChild('MANUFACTURER', 'Soxstar.sk');
    $shopitem->addChild('CATEGORYTEXT', 'Glami.sk | Dámske oblecenie a obuv | Dámske oblecenie | Dámska spodná bielizen | Dámske ponožky');
    $shopitem->addChild('CATEGORY_ID', 5457);
    $shopitem->addChild('EAN', $_product->get_sku());
    
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
    
}


$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');

foreach ( $orders as $order ) {
  
  addXmlItem($xml, $post, $_product);
  
}
  

header('Content-Type: application/xml');
print($xml->asXML());
