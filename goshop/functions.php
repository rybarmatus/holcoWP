<?php
if( !session_id() ){
session_start();
}

define('CONTENT', get_template_directory().'/content');
define('FUNCTIONS', get_template_directory().'/functions');
define('FUNCTIONS_WOO', get_template_directory().'/functions/woocommerce');
define('CHILD_DIR', get_stylesheet_directory());
define('CHILD_CONTENT', get_stylesheet_directory().'/content');
define('CURRENCY', '€');
define('CURRENCY_TEXT', 'EUR');
define('LANG', 'SK_sk');
define('HEADER_LANG', 'sk');
define('IMAGES', get_template_directory_uri().'/images' );
define('CHILD_DIR_URI', get_stylesheet_directory_uri());
define('CHILD_IMAGES', CHILD_DIR_URI .'/images' );
define('THIS_PAGE_URL', 'https://' . $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ]);
define('LOADER', IMAGES.'/loader.gif');
define('LAZY_IMG', IMAGES.'/lazy-no-image.png');
define('NO_IMAGE', IMAGES.'/no-image.png');


require(CHILD_DIR.'/configure.php');
register_nav_menus();
// add_theme_support( 'post-thumbnails' );

if(is_admin()){  /* backEnd */
    
    if($goshop_config['migrator']) {
       require(FUNCTIONS.'/migrator.php' );
    }
    
    function remove_extra_image_sizes() {
        global $goshop_config;
        if($goshop_config['woocommerce']) {
            $allowed_sizes = array( 'thumbnail', 'medium',  'product-thumbnail', 'product-loop', 'product-single', 'product-desctop-full' );
        }else{
            $allowed_sizes = array( 'thumbnail', 'medium',  'large' );
        }
        
        foreach ( get_intermediate_image_sizes() as $size ) {
        
          if ( !in_array( $size, $allowed_sizes ) ) {
              remove_image_size( $size );
          }
        }
    }
    add_action('init', 'remove_extra_image_sizes');   
    
    add_filter( 'intermediate_image_sizes', function( $sizes ){
        return array_filter( $sizes, function( $val ){
            return 'medium_large' !== $val; // Filter out 'medium_large'
        } );
    } );

    
   function remove_submenu() {
    remove_submenu_page('cfdb7-list.php','cfdb7-extensions');
   }
   add_action( 'admin_menu', 'remove_submenu', 999 );
    
    /* DISABLE BOCK EDITOR */
   add_filter('use_block_editor_for_post_type', '__return_false', 10);
   add_filter('use_block_editor_for_post', '__return_false', 10);

   require(FUNCTIONS. '/admin_posts_edit.php');
   
   
   if($goshop_config['dragAndDropOrder']){
    require(FUNCTIONS. '/drag_drop.php');
   }
   
  if($goshop_config['cpt_banners']){ 
    add_action('save_post','save_post_callback');
    function save_post_callback($post_id){
      global $post; 
      
      if ($post and $post->post_type == 'banner'){
          delete_transient( 'banners' );
      }
      
    }
  }

  require(FUNCTIONS. '/option_page/option_page.php');                                                                    
    
}else{   /* fronEnd */

 // remove_action( 'wp_head', 'noindex', 1 );

  if($goshop_config['socials']){
    require(FUNCTIONS. '/socials.php');
  }
  require(FUNCTIONS. '/seo.php');
  /* 
  if($goshop_config['sliders']){
    require(FUNCTIONS. '/slider.php');
  }
  */
  if($goshop_config['events_calendar']){
    require(FUNCTIONS. '/calendarSlider.php');
  }           
  if($goshop_config['cookies']){
    require(FUNCTIONS. '/cookie.php');
  }
  
  /* 
  add_filter( 'wp_default_scripts', 'change_default_jquery' );
  function change_default_jquery( &$scripts){
      if(!IS_CHECKOUT){
          $scripts->remove( 'jquery');
          $scripts->remove( 'wp-embed');
      }   
  } 
  */
  
  
  add_action('wp_print_styles', 'remove_all_theme_styles', 100);
  function remove_all_theme_styles() {
     global $wp_styles;
     $wp_styles->queue = array();
  }
  
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('wp_print_styles', 'print_emoji_styles');
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  add_filter('show_admin_bar', '__return_false');
  
  if($goshop_config['mailpoet']){
    function mailpoet_remove_assets() {
  	   wp_dequeue_script( 'mailpoet_vendor' );
       wp_dequeue_script( 'mailpoet_public' );
       wp_dequeue_style( 'mailpoet_public' );
    }
    add_action( 'wp_footer', 'mailpoet_remove_assets', 1 );
  }

  if($goshop_config['woocommerce']) {
    define('THIS_PAGE_ID', url_to_postid( THIS_PAGE_URL ));
    $is_cart = $is_checkout = false;
    if(THIS_PAGE_ID == 7){
      $is_cart = true;  
    }else if(THIS_PAGE_ID == 8){
      $is_checkout = true; 
    }
    define('IS_CART', $is_cart);
    define('IS_CHECKOUT', $is_checkout );
  }else{
    define('IS_CHECKOUT', false );
    define('IS_CART', false);
  }

} /* koniec frontpage */

if($goshop_config['login']){
    
  require(FUNCTIONS. '/auth/login_register.php');
  if($goshop_config['social_login']){
    require(FUNCTIONS. '/auth/facebook.php');
    require(FUNCTIONS. '/auth/google.php');
  }
}

if($goshop_config['blog'] or $goshop_config['woocommerce']){
  require(FUNCTIONS. '/pagination.php');
}

if($goshop_config['woocommerce']) {
  require(FUNCTIONS_WOO. '/woocommerce.php');
}


if($goshop_config['blog']) {
    require(FUNCTIONS. '/blog.php');
}  
if($goshop_config['cpt_banners']){
    require(FUNCTIONS. '/custom_post_types/banners.php');
}
if($goshop_config['cpt_eventy']){
    require(FUNCTIONS. '/custom_post_types/events.php');
}
if($goshop_config['cpt_referencie']){
    require(FUNCTIONS. '/custom_post_types/referencie.php');
}
if($goshop_config['cpt_team']){
    require(FUNCTIONS. '/custom_post_types/team.php');
}

/* custom functions */

if(!is_admin()){  /* backEnd */
 
  if($goshop_config['product_feeds']){
    
    add_action('wp', function() {
      global $goshop_config;
      $url_path = trim(parse_url(add_query_arg(array()), PHP_URL_PATH), '/');
      if ( $url_path === 'sitemap.xml'  ) {
         $load = locate_template('sitemap.php', true);
         if ($load) {  
            exit(); // just exit if template was found and loaded
         }
      }/*else if ( $goshop_config['glami_feed'] and $url_path === 'glami.php' ) {
         $load = include FUNCTIONS_WOO.'/feedy/glami.php';
         if ($load) {  
            exit(); // just exit if template was found and loaded
         }
      }
      /*
      else if ( $goshop_config['heureka_feed'] and $url_path === 'heureka.php' ) {
         $load = include FUNCTIONS_WOO.'/feedy/heureka.php';
         if ($load) {  
            exit(); // just exit if template was found and loaded
         }
      }
      /*
      else if ( $goshop_config['cetelem'] and $url_path === 'cetelem_redirect.php' ) {
         $load = include FUNCTIONS_WOO.'/payment_methods/cetelem_redirect.php';
         if ($load) {  
            exit(); // just exit if template was found and loaded
         }
      }
      /*
      else if ( $goshop_config['glami_feed'] and $url_path === 'glami.php' ) {
         $load = include FUNCTIONS_WOO.'/feedy/glami.php';
         if ($load) {  
            exit(); // just exit if template was found and loaded
         }
      }else if ( $goshop_config['google_feed'] and $url_path === 'google.php' ) {
         $load = include FUNCTIONS_WOO.'/feedy/google.php';
         if ($load) {  
            exit(); // just exit if template was found and loaded
         }
      }
      */
    });
  
  }
  
}
