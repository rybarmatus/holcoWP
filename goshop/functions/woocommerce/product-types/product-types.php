<?php
 /*
  TODO: 
  remove virtual produt
  remove downloadable product
  remove dimensions and weight
 */
 
 
 add_filter( 'product_type_selector', 'add_product_types' );
  function add_product_types( $types ){
      global $goshop_config;
      if($goshop_config['woo-bundle-products']){
        $types[ 'bundle' ] = __( 'Balíček produktov', 'goshop_admin' );
      }
      if($goshop_config['woo-gifts']){
        $types[ 'gift' ] = __( 'Darček k objednávke', 'goshop_admin' );
      }  
      unset($types['grouped']);
      unset($types['external']);
      return $types;	
  }
 
 global $goshop_config;
 
 if($goshop_config['woo-bundle-products']){
 
    
    if(is_admin()){  /* backEnd */
    
      add_action('admin_enqueue_scripts', 'admin_enqueue_assets');
      
      function admin_enqueue_assets(){
      
          wp_enqueue_script('bundle-dragarange', get_template_directory_uri().'/functions/woocommerce/product-types/dragarange.js', array('jquery'), rand(1,999), true);
          wp_enqueue_script('bundle-backend', get_template_directory_uri().'/functions/woocommerce/product-types/backend.js', array('jquery'), rand(1,999), true);
          wp_enqueue_style('bundle-backend', get_template_directory_uri().'/functions/woocommerce/product-types/backend.css');
      }
   
   
      add_action('woocommerce_process_product_meta_bundle', 'bundle_save_option_fields');
   
   
     function bundle_save_option_fields($post_id){
        
        if (isset($_POST['bundle_ids']) && !empty($_POST['bundle_ids'])) {
            update_post_meta($post_id, 'bundle_ids', bundle_clean_ids($_POST['bundle_ids']));
        }
     }   
   
    add_action( 'woocommerce_variation_options_pricing', 'add_custom_field_to_variations', 10, 3 );
    add_action( 'woocommerce_product_data_panels', 'demo_product_tab_product_tab_content' );
     
   }
   
   add_action( 'woocommerce_save_product_variation', 'save_custom_field_variations', 10, 2 );
     
   function save_custom_field_variations( $variation_id, $i ) {
      $bundle_ids = $_POST['bundle_ids'][$i];
      if ( isset( $bundle_ids ) ) update_post_meta( $variation_id, 'bundle_ids', esc_attr( $bundle_ids ) );
   }
     
   function add_custom_field_to_variations( $loop, $variation_data, $variation ) {
                                                                   
       $post_id = $variation->ID;
       $bundle_ids_str = '';
      
       if (get_post_meta($post_id, 'bundle_ids', true)) {
          $bundle_ids_str = get_post_meta($post_id, 'bundle_ids', true);
       } elseif (isset($_GET['bundle_ids'])) {
          $bundle_ids_str = implode(',', explode('.', $_GET['bundle_ids']));
       }
       bundle_html($bundle_ids_str, $loop);
    }
    
    function demo_product_tab_product_tab_content() {
    
       global $post;
       $post_id = $post->ID;
       $bundle_ids_str = '';
      
       if (get_post_meta($post_id, 'bundle_ids', true)) {
          $bundle_ids_str = get_post_meta($post_id, 'bundle_ids', true);
       } elseif (isset($_GET['bundle_ids'])) {
          $bundle_ids_str = implode(',', explode('.', $_GET['bundle_ids']));
       }
       bundle_html($bundle_ids_str);
    
    }


    function bundle_clean_ids($ids){
      $ids = preg_replace('/[^,.\/0-9]/', '', $ids);
      return $ids;
    }
 
    function bundle_html($bundle_ids_str, $loop = false){
      $bundle_ids_str = bundle_clean_ids($bundle_ids_str);
      
    ?>

      <div id="bundle_products" class="panel woocommerce_options_panel bundle_products_panel bundle-wrapper">
        <div class="options_group">

           <p class="form-field form-row form-row-full" style="position:relative;">
      		    <label>
                  Produkty v balíčku
              </label>
              <span class="bundle_loading" style="display:none"><?php esc_html_e( 'searching...', 'goshop_admin' ); ?></span>
              <div class="search_input_wrapper" style="position: relative;">
                <input type="search" class="bundle_search" placeholder="<?php esc_html_e( 'Začni písať názov produktu..', 'goshop_admin' ); ?>" >
                <div id="bundle_results" style="display:none" class="bundle_results"></div>
              </div>
              <input type="text" class="bundle_ids" name="bundle_ids<?php if($loop !== false) echo '['.$loop.']'; ?>" value="<?php echo esc_attr($bundle_ids_str); ?>" readonly/>
           </p>
           <p>
            <span class="bundle_regular_price"></span>
           </p>

           <div class="bundle_selected">
                <ul>
                    <?php
                    if (!empty($bundle_ids_str)) {
                        $bundle_items = bundle_get_bundled(0, $bundle_ids_str, false);
                        if (is_array($bundle_items) && count($bundle_items) > 0) {
                            foreach ($bundle_items as $bundle_item) {
                                $bundle_product = wc_get_product($bundle_item['id']);
                                if (!$bundle_product || $bundle_product->is_type('bundle')) {
                                    continue;
                                }
    
                                bundle_product_data_li($bundle_product, $bundle_item['qty']);
                            }
                        }
                    }
                    ?>
                </ul>
            </div>
           
       </div>
     </div>

      <?php
      
    
    }
    
    
    add_action('wp_ajax_bundle_get_search_results', 'bundle_get_search_results');  
  
    function bundle_get_search_results(){
      $keyword = sanitize_text_field($_POST['keyword']);
      if(!empty($_POST['ids'])){
        $added_ids = explode(',', bundle_clean_ids($_POST['ids']));
      }
    
      
      
    
      if (false && is_numeric($keyword)) {
          // search by id
          $bundle_query_args = array(
              'p' => absint($keyword),
              'post_type' => 'product'
          );
      } else {
          $bundle_query_args = array(
              'post_type' => 'product',
              'post_status' => array('publish', 'private'),
              's' => $keyword,
              'posts_per_page' => 5,
              'tax_query' => array(
                  array(
                      'taxonomy' => 'product_type',
                      'field' => 'slug',
                      'terms' => array('gift', 'bundle'),
                      'operator' => 'NOT IN',
                  )
              )
          );
    
          if (true) {
          // search same
              $exclude_ids = array();
    
              if (is_array($added_ids) && count($added_ids) > 0) {
                  foreach ($added_ids as $added_id) {
                      $added_id_new = explode('/', $added_id);
                      $exclude_ids[] = absint(isset($added_id_new[0]) ? $added_id_new[0] : 0);
                  }
              }
    
              $bundle_query_args['post__not_in'] = $exclude_ids;
          }
      }
    
      $bundle_query = new WP_Query($bundle_query_args);
    
      if ($bundle_query->have_posts()) {
          echo '<ul>';
    
          while ($bundle_query->have_posts()) {
              $bundle_query->the_post();
              $bundle_product = wc_get_product(get_the_ID());
    
              if (!$bundle_product || $bundle_product->is_type('bundle')) {
                  continue;
              }
    
              bundle_product_data_li($bundle_product, 1, true);
    
              if ($bundle_product->is_type('variable')) {
                  // show all children
                  $bundle_children = $bundle_product->get_children();
    
                  if (is_array($bundle_children) && count($bundle_children) > 0) {
                      foreach ($bundle_children as $bundle_child) {
                          $bundle_product_child = wc_get_product($bundle_child);
                          bundle_product_data_li($bundle_product_child, 1, true);
                      }
                  }
              }
          }
    
          echo '</ul>';
          wp_reset_postdata();
      } else {
          echo '<ul><span>' . sprintf(esc_html__('No results found for "%s"', 'woo-product-bundle'), $keyword) . '</span></ul>';
      }
           
      die();
    }  
      
    
  function bundle_product_data_li($product, $qty = 1, $search = false){
      $product_id = $product->get_id();
  
      if ($product->is_sold_individually()) {
          $qty_input = '<input type="number" value="' . $qty . '" min="0" max="1"/>';
      } else {
          $qty_input = '<input type="number" value="' . $qty . '" min="0"/>';
      }
  
      if ($product->is_type('variable')) {
          $price = $product->get_variation_price('min');
          $price_max = $product->get_variation_price('max');
      } else {
          $price = $price_max = $product->get_price();
      }
  
      if ($search) {
          $remove_btn = '<span class="remove hint--left" aria-label="' . esc_html__('Add', 'woo-product-bundle') . '">+</span>';
      } else {
          $remove_btn = '<span class="remove hint--left" aria-label="' . esc_html__('Remove', 'woo-product-bundle') . '">×</span>';
      }
  
      $product_name = apply_filters('bundle_li_name', $product->get_name(), $product);
  
      echo '<li ' . (!$product->is_in_stock() ? 'class="out-of-stock"' : '') . ' data-id="' . $product_id . '" data-price="' . $price . '" data-price-max="' . $price_max . '"><span class="move"></span><span class="qty hint--right" aria-label="' . esc_html__('Default quantity', 'woo-product-bundle') . '">' . $qty_input . '</span> <span class="name">' . $product_name . '</span> <span class="info">' . $product->get_price_html() . '</span> ' . ($product->is_sold_individually() ? '<span class="info">sold individually</span> ' : '') . '<span class="type"><a href="' . get_edit_post_link($product_id) . '" target="_blank">' . $product->get_type() . ' #' . $product_id . '</a></span> ' . $remove_btn . '</li>';
  }  
    
  function bundle_get_bundled($product_id, $ids = null, $compact = true){
    $bundle_arr = array();
    $bundle_ids = !is_null($ids) ? $ids : get_post_meta($product_id, 'bundle_ids', true);
  
    if (!empty($bundle_ids)) {
        $bundle_items = explode(',', $bundle_ids);
  
        if (is_array($bundle_items) && count($bundle_items) > 0) {
            foreach ($bundle_items as $bundle_item) {
                $bundle_item_arr = explode('/', $bundle_item);
                $bundle_item_id = absint(isset($bundle_item_arr[0]) ? $bundle_item_arr[0] : 0);
                $bundle_item_qty = (float)(isset($bundle_item_arr[1]) ? $bundle_item_arr[1] : 1);
  
                $has_id = false;
                if ($compact && (count($bundle_arr) > 0)) {
                    foreach ($bundle_arr as $bundle_k => $bundle_it) {
                        if ($bundle_it['id'] === $bundle_item_id) {
                            $bundle_arr[$bundle_k]['qty'] += $bundle_item_qty;
                            $has_id = true;
                            break;
                        }
                    }
                }
  
                if ($has_id) {
                    continue;
                }
  
                $bundle_arr[] = array(
                    'id' => $bundle_item_id,
                    'qty' => $bundle_item_qty
                );
            }
        }
    }
  
    if (count($bundle_arr) > 0) {
        return $bundle_arr;
    }
  
    return false;
  }  
    
  

}


  
  // Other default values for 'attribute' are; general, inventory, shipping, linked_product, variations, advanced
  function product_data_tabs( $tabs) {
    
    global $goshop_config;
    
    if($goshop_config['woo-bundle-products']){	
      
      $tabs['inventory']['class'][] = 'show_if_bundle';
      $tabs['general']['class'] = array();
      $tabs['general']['class'][] = 'show_if_simple';
      $tabs['general']['class'][] = 'show_if_gift';
      $tabs['general']['class'][] = 'show_if_bundle';
      
      $tabs['products_in_bundle'] = array(
    		'label'		=> __( 'Produkty v balíčku', 'goshop_admin' ),
    		'target'	=> 'bundle_products',
    		'class'		=> array( 'show_if_bundle' ),
	    );
    }
    
    $tabs['inventory']['class'][] = 'show_if_gift';
    
    $tabs['shipping']['class'][] = 'hide_if_simple';
    $tabs['shipping']['class'][] = 'hide_if_variable';
    $tabs['shipping']['class'][] = 'hide_if_gift';
    $tabs['shipping']['class'][] = 'hide_if_bundle';
    $tabs['linked_product']['class'][] = 'hide_if_gift';
    $tabs['attribute']['class'][] = 'hide_if_gift';
    /* 
    $tabs['advanced']['class'][] = 'hide_if_simple';
    $tabs['advanced']['class'][] = 'hide_if_variable';
    $tabs['advanced']['class'][] = 'hide_if_gift';
    */
  
  	return $tabs;
  
  }
  add_filter( 'woocommerce_product_data_tabs', 'product_data_tabs' );
  

add_action( 'init', 'create_custom_product_types' );
 
function create_custom_product_types(){
    global $goshop_config;
    if($goshop_config['woo-gifts']){
      class WC_Product_Gift extends WC_Product {
        public function get_type() {
           return 'gift';
        }
      }
    }
    if($goshop_config['woo-bundle-products']){
      class WC_Product_Bundle extends WC_Product {
        public function get_type() {
           return 'bundle';
        }
      }
    }
}

/* 
add_filter( 'woocommerce_product_class', 'bbloomer_woocommerce_product_class', 10, 2 );
 
function bbloomer_woocommerce_product_class( $classname, $product_type ) {
    if ( $product_type == 'gift' ) { 
        $classname = 'WC_Product_Gift';
    }
    if ( $product_type == 'bundle' ) { 
        $classname = 'WC_Product_Bundle';
    }
    return $classname;
}
*/

  
  
  /* ---------------- KONIEC CUSTOM PRODUCT TYPES --------------- */
  
