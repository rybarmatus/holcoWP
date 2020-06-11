<?php
require(FUNCTIONS_WOO. '/search.php');
require(FUNCTIONS_WOO. '/product-types/product-types.php');
require(FUNCTIONS_WOO. '/edit_checkout.php');

if($goshop_config['woo-discounts']){
    require(FUNCTIONS_WOO. '/discounts/discounts.php');
}
if($goshop_config['cpt_manufacturers']){
    require(FUNCTIONS. '/custom_post_types/manufacturers.php');
}       
if($goshop_config['cpt_poradca']){
    require(FUNCTIONS. '/custom_post_types/poradca.php');
}
if($goshop_config['product_filter']){
    require(FUNCTIONS_WOO. '/product-filter.php');
}
if($goshop_config['product-rating']){
    require(FUNCTIONS. '/rating.php');
}
if($goshop_config['product-favourite']){
    require(FUNCTIONS. '/favourite.php');  
}
if($goshop_config['product-compare']){
    require(FUNCTIONS_WOO. '/compare.php');
}
if($goshop_config['hotovost']){
    require(FUNCTIONS_WOO. '/payment_methods/hotovost.php');
}
if($goshop_config['cetelem']){
    require(FUNCTIONS_WOO. '/payment_methods/cetelem.php');
}

function goshop_woocommerce_support() {
	
  add_theme_support( 'woocommerce', array(
      'thumbnail_image_width' => 0,
      'gallery_thumbnail_image_width' => 0,
      'single_image_width' => 0,
  ));
    
}
add_action( 'after_setup_theme', 'goshop_woocommerce_support' );
                           
if(is_admin()){  /* backEnd */

  
  
/* pridanie pola pre heureku poštovné, pridanie pola pre poštovné zadarmo */

add_filter( 'woocommerce_shipping_instance_form_fields_flat_rate', 'add_extra_fields_in_flat_rate', 10, 1);
function add_extra_fields_in_flat_rate($settings){
    global $goshop_config;

    $counter = 0;
    $arr = array();
    foreach ($settings as $key => $value)
    {
        if($key == 'cost' && $counter==0)
        {
            $arr[$key] = $value; 
            $arr['doprava_zadarmo'] = array(
                'title'         => __( 'Doprava zadarmo', 'woocommerce' ), 
                'type'             => 'number',
                'description'    => 'ID dopravy zadarmo, ktorá patrí ku tejto doprave'
            ); 
            if($goshop_config['heureka_feed']){
            
              $arr['heureka_delivery'] = array(
                  'title'         => __( 'Heureka delivery', 'goshop' ), 
                  'type'             => 'select', 
                  'options'       => array(
                      'SLOVENSKA_POSTA' => 'Slovenská pošta - Balík na adresu', 
                      'SLOVENSKA_POSTA_BALIK_NA_POSTU' => 'Slovenská pošta - Balík na poštu',
                      'DPD' => 'DPD (nejedná sa o DPD Pickup)',
                      'DHL' => 'DHL',
                      'DSV' => 'DSV',
                      'EXPRES_KURIER' => 'Expres Kuriér',
                      'GEBRUDER_WEISS' => 'Gebrüder Weiss',
                      'GEIS' => 'Geis (nejedná sa o Geis Point)',
                      'GLS' => 'GLS',
                      'HDS' => 'HDS',
                      'INTIME' => 'InTime',
                      'PPL' => 'PPL',
                      'REMAX' => 'ReMax Courier Service',
                      'TNT' => 'TNT',
                      'TOPTRANS' => 'TOPTRANS',
                      'UPS' => 'UPS',
                      'FEDEX' => 'FedEX',
                      'RABEN_LOGISTICS' => 'Raben Logistics',
                      'SDS' => 'SDS',
                      'SPS' => 'SPS',
                      'ZASILKOVNA' => 'Zásielkovňa',
                      'DPD_PICKUP' => 'DPD Pickup',
                      'ULOZENKA' => 'Uloženka',
                      'VLASTNA_PREPRAVA' => 'Vlastná preprava'
                  ),
                  'description'    => 'Používa sa v heuréka feede'
              );
              
            }
            $counter++; 
        } 
        else{
            $arr[$key] = $value;
        } 
    }
    return $arr; 
} 

  // da preč virtualny produkt a na stiahnutie
  add_filter( 'product_type_options', 'add_gift_card_product_option' );   
  function add_gift_card_product_option( $product_type_options ) {
    $product_type_options = array();
   	return $product_type_options;
  }
  
  if($goshop_config['woo-stock-list']){
    require(FUNCTIONS_WOO. '/stock-list.php');
  }
  
  add_action('woocommerce_order_status_changed', 'send_cancelled_order_email_to_customer', 10, 4 );
  function send_cancelled_order_email_to_customer( $order_id, $old_status, $new_status, $order ){
    
    if ( $new_status == 'cancelled'){
        $wc_emails = WC()->mailer()->get_emails(); // Obtener todas las instancias de WC_emails
        $email_client = $order->get_billing_email(); // Email del cliente
    }
    
    if ( $new_status == 'cancelled' ) {
        // Cambiar el destinatario de la instancia
        $wc_emails['WC_Email_Cancelled_Order']->recipient .= ',' . $email_client;
        // Enviar email desde la instancia
        $wc_emails['WC_Email_Cancelled_Order']->trigger( $order_id );
    } 
    /* 
    elseif ( $new_status == 'failed' ) {
        // Cambiar el destinatario de la instancia
        $wc_emails['WC_Email_Failed_Order']->recipient .= ',' . $email_cliente;
        // Enviar email desde la instancia
        $wc_emails['WC_Email_Failed_Order']->trigger( $order_id );
    }
    */
    

  }
  
  
}else { // frontend
  
  function add_category_parent_css($css_classes, $category, $depth, $args){
    if($args['has_children']){
        $css_classes[] = 'has_children';
    }
    return $css_classes;
  }
  add_filter( 'category_css_class', 'add_category_parent_css', 10, 4);
  
  
  function getCategoryItems($categories){
    foreach($categories as $cat){
      $thumb_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
      ?>
      <a class="category_item mb-1" title="<?= $cat->name ?>" href="<?= get_term_link($cat->term_id); ?>">
        <?php
        if($thumb_id){
          $image = wp_get_attachment_image_src( $thumb_id , 'thumbnail' );
          echo '<img class="lazy" src="'.NO_IMAGE.'" data-src="'.$image[0].'" width="'.$image[1].'" height="'.$image[2].'" alt="'.$cat->name.'">';
        }
        echo $cat->name;
        ?>
      </a>
  <?php
    }
  }
  
  
function get_sort_and_display($type = false){
  /* type == 2 -> novinky | type == 1 -> akciove produkty */    
  
  global $goshop_config;
  if(!isset($_GET['orderby'])){
      $_GET['orderby'] = '';
      }
      $selected = 'selected="selected"';
      ?>
      <select name="orderby" class="orderby" aria-label="Shop order">
        <option value="name" <?= ($_GET['orderby'] == 'name') ? $selected : ''; ?>><?= __('Zoradiť podľa názvu','goshop'); ?></option>
        <option value="sales" <?= ($_GET['orderby'] == 'sales') ? $selected : ''; ?>><?= __('Zoradiť od najpredávanejších','goshop'); ?></option>
        <option value="price" <?= ($_GET['orderby'] == 'price') ? $selected : ''; ?>><?= __('Zoradiť od najlacnejších','goshop'); ?></option>
        <option value="price-desc" <?= ($_GET['orderby'] == 'price-desc') ? $selected : ''; ?>><?= __('Zoradiť od najdrahších','goshop'); ?></option>
        <option value="date" <?= ($_GET['orderby'] == 'date') ? $selected : ''; ?>><?= __('Zoradiť od najnovších','goshop'); ?></option>
        <option value="date-desc" <?= ($_GET['orderby'] == 'date-desc') ? $selected : ''; ?>><?= __('Zoradiť od najstarších','goshop'); ?></option>
        <?php if($goshop_config['product-rating']) { ?>
          <option value="rating" <?= ($_GET['orderby'] == 'rating') ? $selected : ''; ?>><?= __('Zoradiť podľa priemerného hodnotenia','goshop'); ?></option>
        <?php } ?>
      </select>
      
      <?php if($goshop_config['product_filter_stock']){ ?>
        <label for="filter_instock"><input class="filter_meta" name="<?= __('Na sklade','goshop'); ?>" id="filter_instock" type="checkbox" <?= (isset($_GET['instock']) && $_GET['instock'] ? 'checked' : '');?>><?= __('Na sklade','goshop'); ?></label>
      <?php } ?>
      
      <?php if($type == 2){ ?>
        <input class="d-none filter_meta" value="1" id="filter_news" type="checkbox" checked>
      <?php }else if($goshop_config['product_filter_news']){ ?>
        <label for="filter_news"><input class="filter_meta" name="<?= __('Novinky','goshop'); ?>" id="filter_news" type="checkbox" <?= (isset($_GET['news']) && $_GET['news'] ? 'checked' : '');?>><?= __('Novinky','goshop'); ?></label>
      <?php } ?>
      
      
      <?php if($type == 1){ ?>
        <input class="d-none filter_meta" value="1" id="filter_onsale" type="checkbox" checked>
      <?php }else if($goshop_config['product_filter_sale']){ ?>
        &nbsp;<label for="filter_onsale"><input class="filter_meta" name="<?= __('Zľava','goshop'); ?>" id="filter_onsale" type="checkbox" <?= (isset($_GET['onsale']) && $_GET['onsale'] ? 'checked' : '');?>><?= __('Zľava','goshop'); ?></label>
      <?php } ?>
       
      <div type="product" class="display-mode js-display-mode d-mobile-none float-right">
        <span type="0" class="display-grid <?php if( (isset($_COOKIE['product-list-row']) and $_COOKIE['product-list-row'] == 0) or !isset($_COOKIE['product-list-row']) ){ echo 'active'; } ?>">
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="th" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M149.333 56v80c0 13.255-10.745 24-24 24H24c-13.255 0-24-10.745-24-24V56c0-13.255 10.745-24 24-24h101.333c13.255 0 24 10.745 24 24zm181.334 240v-80c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.256 0 24.001-10.745 24.001-24zm32-240v80c0 13.255 10.745 24 24 24H488c13.255 0 24-10.745 24-24V56c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24zm-32 80V56c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.256 0 24.001-10.745 24.001-24zm-205.334 56H24c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24zM0 376v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H24c-13.255 0-24 10.745-24 24zm386.667-56H488c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24zm0 160H488c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24zM181.333 376v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24z" class=""></path></svg>
        </span>
        <span type="1" class="display-rows <?php if( isset($_COOKIE['product-list-row']) and $_COOKIE['product-list-row'] == 1 ){ echo 'active'; } ?>">
            <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="list" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M80 48H16A16 16 0 0 0 0 64v64a16 16 0 0 0 16 16h64a16 16 0 0 0 16-16V64a16 16 0 0 0-16-16zm0 160H16a16 16 0 0 0-16 16v64a16 16 0 0 0 16 16h64a16 16 0 0 0 16-16v-64a16 16 0 0 0-16-16zm0 160H16a16 16 0 0 0-16 16v64a16 16 0 0 0 16 16h64a16 16 0 0 0 16-16v-64a16 16 0 0 0-16-16zm416-136H176a16 16 0 0 0-16 16v16a16 16 0 0 0 16 16h320a16 16 0 0 0 16-16v-16a16 16 0 0 0-16-16zm0 160H176a16 16 0 0 0-16 16v16a16 16 0 0 0 16 16h320a16 16 0 0 0 16-16v-16a16 16 0 0 0-16-16zm0-320H176a16 16 0 0 0-16 16v16a16 16 0 0 0 16 16h320a16 16 0 0 0 16-16V88a16 16 0 0 0-16-16z" class=""></path></svg>                
        </span>
      </div>
      <div class="clear"></div>

      <div class="filter-bubbles mb-1 mt-1"></div>
  
<?php }
  
  
  if($goshop_config['dobierka']){
    /* dobierka poplatok */
    add_action( 'woocommerce_cart_calculate_fees', 'add_checkout_fee_for_cod' );
    function add_checkout_fee_for_cod() {
      if($cod_fee = get_option('option_cod_fee')){
        
        if(WC()->cart->cart_contents_total >= get_option('option_cod_fee_limit')){
          $cod_fee = 0;
        }
        
        $chosen_gateway = WC()->session->chosen_payment_method;
        if ( $chosen_gateway == 'cod' ) {
       
            WC()->cart->add_fee( __('Dobierka', 'goshop'), $cod_fee );
       
        }
      }
    }            
  }

  add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
  
  /* treba toto vobec ? */
  /* 
  if(IS_CHECKOUT){
   // add_action( 'wp_enqueue_scripts', 'woocommerce_script_cleaner', 99 );
  }
  
  function woocommerce_script_cleaner() {
	 
    remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );
	  wp_dequeue_script( 'selectWoo' );
    wp_dequeue_script( 'wc_price_slider' );
    wp_dequeue_script( 'wc-single-product' );
    wp_dequeue_script( 'wc-add-to-cart' );
    wp_dequeue_script( 'wc-cart-fragments' );
    wp_dequeue_script( 'wc-credit-card-form' );
    wp_dequeue_script( 'wc-lost-password' );
    wp_dequeue_script( 'wc-add-to-cart-variation' );
    wp_dequeue_script( 'wc-single-product' );
    wp_dequeue_script( 'wc-chosen' );
    wp_dequeue_script( 'prettyPhoto' );
    wp_dequeue_script( 'prettyPhoto-init' );
    wp_dequeue_script( 'jquery-blockui' );
  	wp_dequeue_script( 'jquery-placeholder' );
    wp_dequeue_script( 'jquery-payment' );
    wp_dequeue_script( 'fancybox' );
    wp_dequeue_script( 'jqueryui' );
    wp_dequeue_script( 'wc-cart' );
    wp_dequeue_script( 'woocommerce' );
    wp_dequeue_script( 'wc-add-payment-method' );
    
    wp_dequeue_script( 'select2');
    wp_deregister_script('select2');
  }   
  */
  
}  // koniec woo frontend
  
  add_filter( 'woocommerce_email_from_name', function(){ return get_bloginfo('name'); }, 10, 2 );
  
  // Change sender adress
  add_filter( 'woocommerce_email_from_address', function(){ return get_option('option_e_mail'); }, 10, 2 );
  
  /*  dovolí v email header vypísať order ID */
  add_action( 'woocommerce_email_header', 'email_header_before', 1, 2 ); 
  function email_header_before( $email_heading, $email ){
      $GLOBALS['email'] = $email;
  }
  
  

