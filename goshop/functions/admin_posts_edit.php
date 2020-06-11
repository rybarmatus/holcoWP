<?php
global $pagenow;
if($pagenow == 'edit.php'){
  
  if( !isset($_GET['post_type'])){
  
    if($goshop_config['blog']){
      require(FUNCTIONS. '/post_type_admin_columns/post.php');
    }
    
  }else {  
  
    if($_GET['post_type'] == 'banner' and $goshop_config['cpt_banners']){
      require(FUNCTIONS. '/post_type_admin_columns/banner.php');
    }else if($_GET['post_type'] == 'poradca' and $goshop_config['cpt_poradca']){
      require(FUNCTIONS. '/post_type_admin_columns/poradca.php');
    }else if($_GET['post_type'] == 'referencie' and $goshop_config['cpt_referencie']){
      require(FUNCTIONS. '/post_type_admin_columns/referencie.php');
    }else if($_GET['post_type'] == 'shop_order'){
      require(FUNCTIONS. '/post_type_admin_columns/shop_order.php');
    }  
  
  }
}
