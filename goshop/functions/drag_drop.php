<?php
global $goshop_config;

add_action( 'wp_ajax_update-custom-type-order-archive', 'saveArchiveAjaxOrder' );
  
if( isset($_GET['post_type']) and in_array($_GET['post_type'], $goshop_config['dragAndDropPosts']) ){
  
  add_action('admin_head', 'addDragAndDropFunction');
  add_action( 'pre_get_posts', function( $query ) {
      $query->set( 'orderby', 'menu_order' );
      $query->set( 'order', 'ASC' );
  });
  
}

function addDragAndDropFunction() {
  global $userdata;
  echo '
	<script type="text/javascript">
  /* <![CDATA[ */
  var CPTO = {"archive_sort_nonce":"'.wp_create_nonce('CPTO_archive_sort_nonce_' . $userdata->ID).'"};
  /* ]]> */
  </script>
  <link rel="stylesheet" href="'.get_template_directory_uri().'/library/drag-and-drop-admin-posts/drag-and-drop.css" type="text/css" media="all" />
  <script type="text/javascript" src="'.get_template_directory_uri().'/library/drag-and-drop-admin-posts/drag-and-drop.js"></script>
  ';
}

function saveArchiveAjaxOrder(){

set_time_limit(600);

global $wpdb, $userdata, $goshop_config;

$post_type  =   filter_var ( $_POST['post_type'], FILTER_SANITIZE_STRING);
$paged      =   filter_var ( $_POST['paged'], FILTER_SANITIZE_NUMBER_INT);
$nonce      =   $_POST['archive_sort_nonce'];

if($goshop_config['cpt_banners'] and $post_type == 'banner'){
  delete_transient( 'banners' );
}


//verify the nonce
if (! wp_verify_nonce( $nonce, 'CPTO_archive_sort_nonce_' . $userdata->ID ) ){
  die('die');
}

parse_str($_POST['order'], $data);

if (!is_array($data)    ||  count($data)    <   1)
  die();

//retrieve a list of all objects
$mysql_query    =   $wpdb->prepare("SELECT ID FROM ". $wpdb->posts ." 
                                      WHERE post_type = %s AND post_status IN ('publish', 'pending', 'draft', 'private', 'future')
                                      ORDER BY menu_order, post_date DESC", $post_type);
$results        =   $wpdb->get_results($mysql_query);

if (!is_array($results)    ||  count($results)    <   1)
  die();

//create the list of ID's
$objects_ids    =   array();
foreach($results    as  $result)
  {
      $objects_ids[]  =   (int)$result->ID;   
  }

global $userdata;
$objects_per_page   =   get_user_meta($userdata->ID ,'edit_' .  $post_type  .'_per_page', TRUE);
if(empty($objects_per_page))
  $objects_per_page   =   20;

$edit_start_at      =   $paged  *   $objects_per_page   -   $objects_per_page;
$index              =   0;
for($i  =   $edit_start_at; $i  <   ($edit_start_at +   $objects_per_page); $i++)
  {
      if(!isset($objects_ids[$i]))
          break;
          
      $objects_ids[$i]    =   (int)$data['post'][$index];
      $index++;
  }

//update the menu_order within database
foreach( $objects_ids as $menu_order   =>  $id ) 
  {
      $data = array(
                      'menu_order' => $menu_order
                      );
      
      //Deprecated, rely on pto/save-ajax-order
      $data = apply_filters('post-types-order_save-ajax-order', $data, $menu_order, $id);
      
      $data = apply_filters('pto/save-ajax-order', $data, $menu_order, $id);
      
      $wpdb->update( $wpdb->posts, $data, array('ID' => $id) );
  }
  
//trigger action completed
do_action('PTO/order_update_complete');

  
              
}
