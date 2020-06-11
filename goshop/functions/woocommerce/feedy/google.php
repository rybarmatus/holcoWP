<?php

Class SimpleXMLElementExtended extends SimpleXMLElement {

  /**
   * Adds a child with $value inside CDATA
   * @param unknown $name
   * @param unknown $value
   */
  public function addChildWithCDATA($name, $value = NULL) {
    $new_child = $this->addChild($name);

    if ($new_child !== NULL) {
      $node = dom_import_simplexml($new_child);
      $no   = $node->ownerDocument;
      $node->appendChild($no->createCDATASection($value));
    }

    return $new_child;
  }
}


/* TODO: 
delit kategorie na panske a damke
zobrazit iba ponozky
pridat custom fieldy pre glami parametre do goshopu - na urovni kategorie, na urovni produktu podla vlastnosti
pridat shipping a ceny nech sa generuju same
pridat field na kategorie ktore sa maju generovat
dat link na pregenerovanie vsetkych feedov - nastavit cron na tento link

spravit toto iste pre heureku

ak hodí feed error poslat mi email

'id',
'title',
'description',
'link',
'image_link',
'condition',
'availability',
'price',
'brand',
'google_product_category',
'mpn',
'identifier_exists',
'shipping',


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

$currency = get_option('woocommerce_currency');

function addXmlItem($xml, $post, $_product, $currency){
    
    
    $item_id = $post->ID;
                       
    
    $image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
    $attachment_ids = $_product->get_gallery_image_ids();
    
    $shopitem = $xml->addChild('item');
    
    $shopitem->addChild('id', $item_id, 'http://base.google.com/ns/1.0');
    $shopitem->addChildWithCDATA('title', $post->post_title);
    $shopitem->addChildWithCDATA('description', htmlspecialchars($post->post_content));
    $shopitem->addChildWithCDATA('link', get_permalink($post->ID));
    $shopitem->addChild('image_link', $image_url[0], 'http://base.google.com/ns/1.0');
    
    if($attachment_ids){
      foreach ( $attachment_ids as $key=>$attachment_id ) {
  		 $thumbnail = wp_get_attachment_image_src($attachment_id, 'full');
         $shopitem->addChild('additional_image_link', $thumbnail[0], 'http://base.google.com/ns/1.0');
      }     
    }
    
    $shopitem->addChild('condition', 'new', 'http://base.google.com/ns/1.0');
    $shopitem->addChild('availability', 'in stock', 'http://base.google.com/ns/1.0');
    
    if( $_product->is_on_sale() ) {
        $shopitem->addChild('price', $_product->get_regular_price(). " ". $currency, 'http://base.google.com/ns/1.0' );
        $shopitem->addChild('sale_price', $_product->get_sale_price(). " ". $currency, 'http://base.google.com/ns/1.0');
    }else{
        $shopitem->addChild('price', $_product->get_price(). " ". $currency, 'http://base.google.com/ns/1.0');
    }
    $shopitem->addChild('brand', 'Soxstar.sk', 'http://base.google.com/ns/1.0');
    $shopitem->addChild('google_product_category', '209', 'http://base.google.com/ns/1.0');
    //$shopitem->addChild('gtin', $_product->get_sku(), 'http://base.google.com/ns/1.0');
               
}


$xml = new SimpleXMLElementExtended('<?xml version="1.0" encoding="utf-8"?><rss xmlns:g="http://base.google.com/ns/1.0" version="2.0"></rss>');
$xml_channel = $xml->addChild('channel');
$xml_channel->addChild('title', 'Google xml feed');
$xml_channel->addChild('link', 'https://soxstar.sk/google_feed.xml');
$xml_channel->addChild('description', 'https://soxstar.sk/google_feed.xml');
         


?>
<?php
foreach($products as $key=>$post){
  
  $_product = wc_get_product($post->ID);
  addXmlItem($xml_channel, $post, $_product, $currency);
  
}

 

header('Content-Type: application/xml');
$xml->asXml('google_feed.xml');
print($xml->asXML());



