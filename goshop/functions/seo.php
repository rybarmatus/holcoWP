<?php
function get_seo_component(){
   // doriesit index a follow
   $post_id = get_the_id();
   $author = false;
   $obj = false;
   
  if(is_tax() or is_category()){
    $obj = get_queried_object();    
    $thumb_id = get_term_meta( $obj->term_id, 'thumbnail_id', true );
    if($thumb_id){
      $image = wp_get_attachment_image_src( $thumb_id, 'single-blog-size' );
      $type = get_post_mime_type($thumb_id);
      $image_alt = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
    }    
  }else if($is_author = is_author()){
    global $author;
    $post_thumbnail_id = get_field('fotka', 'user_'.$author);
    if($post_thumbnail_id){
      $image = wp_get_attachment_image_src( $post_thumbnail_id, 'single-blog-size' );
      $type = get_post_mime_type($post_thumbnail_id);
      $image_alt = get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true );
    }
  }else{
    $post_thumbnail_id = get_post_thumbnail_id($post_id);
    if($post_thumbnail_id){
      $image = wp_get_attachment_image_src( $post_thumbnail_id, 'single-blog-size' );
      $type = get_post_mime_type($post_thumbnail_id);
      $image_alt = get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true );
    }
  }
   
  $title = custom_get_title($obj, $author); 
  $description = custom_get_description($obj, $author);
  define('DESC', $description);
  $canonical = THIS_PAGE_URL; 
  $site_name = get_bloginfo();
   
   
  $index_field = get_field('index', $obj);
   
  if(!get_option('blog_public') or (!$index_field and isset($index_field))){   
    $index = false;
  }else{
    $index = true;
  } 
?>
<meta name='robots' content='<?= (!$index)? 'no' : ''; ?>index,follow' />
<title><?= $title ?></title>
<meta name="description" content="<?= $description ?>"/>
<meta name="keywords" content="<?= get_the_tags($post_id) ?>">
<link rel="canonical" href="<?= $canonical ?>" />
<meta property="og:locale" content="<?= LANG ?>" />
<!-- <meta property="og:locale:alternate" content="<?= LANG ?>" /> -->
<meta property="og:type" content="website" />
<meta property="og:title" content="<?= $title ?>" />
<?php if($video = get_field('video', $post_id)) { ?>
<meta property="og:video" content="<?= $video ?>" />
<?php } ?>
<?php if(isset($image)) { ?>
<meta property="og:image" content="<?= $image[0] ?>" />
<meta property="og:image:secure_url" content="<?= $image[0] ?>" />
<meta property="og:image:type" content="<?= $type ?>" />
<meta property="og:image:width" content="<?= $image[1] ?>" />
<meta property="og:image:height" content="<?= $image[2] ?>" />
<?php if($image_alt) { ?>
<meta property="og:image:alt" content="<?= $image_alt ?>" />
<?php } ?>
<?php } ?>
<meta property="og:description" content="<?= $description ?>" />
<meta property="og:url" content="<?= $canonical ?>" />
<meta property="og:site_name" content="<?= $site_name ?>" />
<meta property="fb:app_id" content="<?= FB_APP ?>" /> 
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:description" content="<?= $description ?>" />
<meta name="twitter:title" content="<?= $title ?>" />
<?php if(isset($image)) { ?>
<meta property="og:image" content="<?= $image[0] ?>" />
<meta property="og:image:secure_url" content="<?= $image[0] ?>" />
<meta property="og:image:type" content="<?= $type ?>" />
<meta property="og:image:width" content="<?= $image[1] ?>" />
<meta property="og:image:height" content="<?= $image[2] ?>" />
<?php if($image_alt) { ?>
<meta property="og:image:alt" content="<?= $image_alt ?>" />
<?php } ?>
<?php } ?>
<meta name="twitter:site" content="@<?= $site_name ?>" />
<meta name="twitter:creator" content="@<?= $site_name ?>" />
<?php if(isset($image)) { ?>
<meta name="twitter:image" content="<?= $image[0] ?>">
<?php } ?>
<?php
}
function custom_get_title($obj, $author){
    if($obj){
        $field = get_field('meta_tag_title',$obj);
        if($field){
            $title = $field;
        }else if( $obj->taxonomy == 'product_cat' and $full_name = get_field('category_full_name', $obj) ){
            $title = $full_name;
        }else{
            $title = $obj->name;
        }
    }else if($author){
        $title = get_field('meta_tag_title', 'user_'.$author); 
    }else if($field = get_field('meta_tag_title')){
        $title = $field;
    }else if(is_category()){
        $category = get_queried_object();
        $title = __('Kategória článkov', 'goshop').': '.$category->name;    
    }else if(is_404()){
        $title = '404';    
    }else if(is_search()){
        $title = __('Hľadaný výraz', 'goshop').': '.$_GET['s'];
    }else{
        $title = get_the_title();    
    }   
    return $title. ' | '. $_SERVER['HTTP_HOST']; 
}

function custom_get_description($obj, $author){
  if($obj){
      $field = get_field('meta_tag_description',$obj);
      if($field){            
         return $field;
      }else{
        return $obj->description;
      }
  }else if($author){
    return get_field('meta_tag_description', 'user_'.$author);
  }else if ($field = get_field('meta_tag_description')){    
      return $field;
  }else if($author){
    return get_field('meta_tag_description', 'user_'.$author);
  }else if( has_excerpt() ){
      return get_the_excerpt();
  } else if(IS_CART){
    return __('Nákupný proces - košík', 'goshop');
  } else if(IS_CHECKOUT){
    return __('Nákupný proces - pokladňa', 'goshop');
  }else {    
      $this_post = get_post(get_the_id());
      if($this_post and !empty($this_post->post_content)){
        $content = apply_filters('the_content', $this_post->post_content);
        return wp_trim_words($content, 26);
      }
      return ''; 	
  }
}
