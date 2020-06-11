<?php
// https://www.sitemaps.org/protocol.html
$manufacturers = $product_cats = $products = array();
global $goshop_config;

$posts_query = new WP_Query([
  'post_type' => 'post',
  'post_status' => 'publish',
  'posts_per_page' => -1,
  'meta_query' => array(
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
]);

$posts_array = $posts_query->posts;

$post_cats = get_categories([
    'post_status' => 'publish',
    'numberposts' => -1,
    'orderby' => 'date',
    'order' => 'DESC',
    'post_type' => 'post',
    'suppress_filters' => true
]);

$pages_query = new WP_Query([
  'post_type' => 'page',
  'post_status' => 'publish',
  'numberposts' => -1,
  'meta_query' => array(
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
]);
$pages = $pages_query->posts;

if($goshop_config['woocommerce']){

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
  
  $product_cats = get_categories([
      'post_status' => 'publish',
      'numberposts' => -1,
      'taxonomy' => 'product_cat',
      'orderby' => 'date',
      'order' => 'DESC',
      'post_type' => 'product',
      'suppress_filters' => true
  ]);
  
  $manufacturers = get_categories([
      'post_status' => 'publish',
      'numberposts' => -1,
      'taxonomy' => 'manufacturers',
      'orderby' => 'date',
      'order' => 'DESC',
      'post_type' => 'product',
      'suppress_filters' => true
  ]);

}            

$xml_posts =  array_merge($products, $pages, $posts_array);
$xml_cats =  array_merge($product_cats, $post_cats, $manufacturers);

$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');

  foreach($xml_posts as $post){
    $postdate = explode(" ", $post->post_modified);  
    $url = $xml->addChild('url');
    $url->addChild('loc', get_permalink($post->ID));
    $url->addChild('lastmod', $postdate[0]);
    $url->addChild('changefreq', 'weekly');
  
  }
  
  foreach($xml_cats as $term){
    $url = $xml->addChild('url');
    $url->addChild('loc', get_term_link($term->term_id));
    $url->addChild('changefreq', 'weekly');
  }
header('Content-Type: application/xml');
print($xml->asXML());
