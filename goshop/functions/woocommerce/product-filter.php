<?php
add_action('wp_ajax_product_filter', 'get_filtered_products');
add_action('wp_ajax_nopriv_product_filter', 'get_filtered_products' );

function get_filtered_products(){
  
  define('PRODUCT_CATEGORY', 1);

  $data = $_POST;
    
  $search = false;
  $date_query = $meta_query = $tax_query = array();
  
  if(isset($data['search'])){
    $search = $data['search'];
  }
  
  if($data['current_category_id']){
    array_push($tax_query, 
        array(
            'taxonomy' => 'product_cat',
            'field'    => 'term_id',
            'operator' => 'IN',
            'terms'    => array($data['current_category_id'])
        )
    );
  }
  if(isset($data['price_to'])){
      array_push($meta_query, 
        array(
      	    array(
      		  'key'		=> '_price',
              'type'    => 'numeric',
              'compare'	=> '<=',
              'value'	=> $data['price_to']
            )
        )
      );
  }
  
  if(isset($data['page_num'])){
    $paged = $data['page_num'];
  }else{
    $paged = 1;
  }

  if(isset($data['onsale']) && $data['onsale']){
      array_push($meta_query, 
        array(
      	    'relation' => 'OR',
            array( 
              'key'        => '_sale_price',
              'value'      => 0,
              'compare'    => '>',
              'type'       => 'numeric'
            ),
            array( // Variable products type
                'key'      => '_min_variation_sale_price',
                'value'    => 0,
                'compare'  => '>',
                'type'     => 'numeric'
            )
        )
     );
  }
  
  if(isset($data['news']) && $data['news']){
        array_push($date_query, 
            array(
                'after' => NEWS_DAYS.' days ago'
            )
        );
  }
  
  
  if(isset($data['instock']) && $data['instock']){
        array_push($meta_query, 
          array(
        	'key' 	=> '_stock_status',
            'value'	=> 'instock'
          )
        );
  }    
  
  if(isset($data['orderby'])){
    
    switch ($data['orderby']) {
      case 'price':
          $meta_key = '_price';
          $orderby = 'meta_value_num';
          $order = 'asc';      
          break;
      case 'price-desc':
          $meta_key = '_price';
          $orderby = 'meta_value_num';
          $order = 'desc';  
          break;
      case 'date':
          $meta_key = '';
          $orderby = 'date';
          $order = 'asc';
          break;
      case 'date-desc':
          $meta_key = '';
          $orderby = 'date';
          $order = 'desc';
          break;
      case 'rating':
          $meta_key = '_wc_average_rating';
          $orderby = 'meta_value_num';
          $order = 'desc';
          break;
      case 'sales':
          $meta_key = 'total_sales';
          $orderby = 'meta_value_num';
          $order = 'desc';
          break;    
      case 'name':
          $orderby = 'title';
          $meta_key = '';
          $order = 'asc';
          break;
    }
  
  }else{
    $orderby = 'name';
    $meta_key = '';
    $order = 'asc';
  }  
  if(isset($data['filter'])){
      
      foreach($data['filter'] as $key=>$filter_item){
        // $filter_item_values = array();
        
        foreach($filter_item as $filter_item_slug=>$values){
          // $filter_item_values = implode( ",", $values );
        
          if($filter_item_slug == 'manufacturer'){
            $filter_item_slug .= 's';
          }
          
          array_push($tax_query, 
            array(
          	    'taxonomy' => $filter_item_slug,
                'field'    => 'term_id',
                'operator' => 'IN',
                'terms'	   => $values
            )
          );
      
       }
    }   
        
  }  
  
  $products = new WP_Query( [
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => PRODUCTS_PER_PAGE,
    'paged' => $paged,
    's' => $search,
    'orderby'   => $orderby,
    'order' => $order,
    'date_query' => $date_query,
    'meta_key'  => $meta_key,
    'tax_query' => $tax_query,
    'meta_query' => $meta_query
  ]);
  
  define('PRODUCT_FILTER', 1);

  if ( $products->have_posts() ) :
    woocommerce_product_loop_start();
    while ( $products->have_posts() ) :
        $products->the_post(); 
        wc_get_template_part( 'content', 'product' );
    endwhile; 
    woocommerce_product_loop_end();

    echo custom_pagination($paged, $products->max_num_pages);
    
  else : 
       do_action( 'woocommerce_no_products_found' );
  endif;  

  die();
}

function get_category_filter_options($cur_cat){
  global $goshop_config;
  
  $products = wc_get_products([
    'numberposts'      => -1,
    'category'         => 0,
    'meta_key'         => '',
    'meta_value'       => '',
    'post_type'        => 'product',
    'post_status'      => 'publish',
    'suppress_filters' => true,
    'tax_query'        => array(
        array(
            'taxonomy'      => 'product_cat',
            'field'         => 'term_id',
            'terms'         =>  array($cur_cat->term_id),
            'operator'      => 'IN' 
        )
    )
  ]);
  
  $products_attributes_all = array();
  $products_attributes = array();
  $manufacturers = array();
  $price_max = 0;
  $price_min = 0;
  
  foreach($products as $product){
     
     // min a max price
     $price = $product->get_price();
     if( $price > $price_max){
          $price_max = $price;
     }
     if ($price_min == 0) {
       $price_min = $price;
     }else if($price_min > $price){
       $price_min = $price;   
     }
     
      // manufacturers
     if($goshop_config['cpt_manufacturers']){
          
          $manufacturer = get_product_brand($product->get_id());
          
          if($manufacturer){
            $manufacturer_arr =  array(
                'term_id' => $manufacturer->term_id,
                'name'    => $manufacturer->name,
                'slug'    => $manufacturer->slug
            );
          array_push($manufacturers, $manufacturer_arr);
          }
          
     }
     
     // attributes
     $attributes = $product->get_attributes();
     
     if(!empty($attributes)){
       
       foreach($attributes as $attr_slug=>$attr){
        
          $values = wc_get_product_terms( $product->get_id(), $attr_slug, array( 'fields' => 'all' ) );
          
          $attr =  array(
           // 'label'  => wc_attribute_label($attr_slug),
            'slug'   => $attr_slug,
            'value_id' => $values[0]->term_id,
            'value_name' => $values[0]->name,
            'value_slug' => $values[0]->slug
          );
          
          array_push($products_attributes_all, $attr);
       }
       
     }
  
  }
  foreach($products_attributes_all as $attr){

    $attr_slug = $attr['slug']; 
       
       if(  isset( $products_attributes[$attr_slug] )    ){
              $is_in = false;
              
              foreach(  $products_attributes[$attr_slug]['values'] as $key=> $value_array ){
                   if($key == $attr['value_slug']){
                      
                      $is_in = true;
                      $products_attributes[$attr_slug]['values'][$attr['value_slug']]['attr_count']++;
                      
                      break;
                   }else{
                   
                      
                   }
                
              }
              if(!$is_in){
                         
                    $products_attributes[$attr_slug]['values'][$attr['value_slug']] =  array(  'attr_value' =>  $attr['value_name'], 'attr_value_id' => $attr['value_id'], 'attr_count' => 1  ); 
              }
                
       }else{   
                     
           $products_attributes[$attr_slug] = array(
           
                'label' => wc_attribute_label($attr_slug),
                'values' => array(
                      
                     $attr['value_slug'] => array(
                          
                          'attr_count' => 1,
                          'attr_value_id' => $attr['value_id'],
                          'attr_value' => $attr['value_name']
                          
                     )
                    
                )
           );
        
        } 

  };
 
  
 // $products_attributes = array_map("unserialize", array_unique(array_map("serialize", $products_attributes)));
  if($goshop_config['cpt_manufacturers']){
    $manufacturers = array_map("unserialize", array_unique(array_map("serialize", $manufacturers)));
  }else{
    $manufacturers = false;
  }
  
  return array(
    'manufacturers' => $manufacturers,
    'product_attributes' => $products_attributes,
    'price_min' => $price_min,
    'price_max' => $price_max
  );

}

function get_price_filter($min, $max){

    if(isset($_GET['price_to'])){
    
        $value =  $_GET['price_to'];
        if($value > $max){
            $value = $max;
        }
        $style = 'margin-left: '.((($value/($max-$min))*100)-145).'px'; 
    }else{
        $value = $max;
        $style = 'margin-left: 96.6957px';
    }
?>
   <div class="row">
      <div class="col-3 text-right"><?= $min; ?><?= CURRENCY ?></div>
      <div class="col-6 pr-0 pl-0 relative">
        <span class="price-slider-label" style="<?= $style; ?>"><?= $value ?></span>
        <input type="range" name="<?= _('Cena do', 'goshop'); ?>" class="price-slider" term_type="_price" step="1"  min="<?= $min ?>" max="<?= $max ?>" value="<?= $value; ?>">
      </div>
      <div class="col-3 text-left"><?= $max; ?><?= CURRENCY ?></div>
   </div>

<?php
}