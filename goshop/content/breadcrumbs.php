<?php
global $is_woo, $post, $goshop_config;
$bread_post = $post;
$wrap_before = '<a title="'.__('Domov','goshop').'" href="'.get_home_url().'"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="home-lg-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M570.24 215.42L323.87 13a56 56 0 0 0-71.75 0L5.76 215.42a16 16 0 0 0-2 22.54L14 250.26a16 16 0 0 0 22.53 2L64 229.71V288h-.31v208a16.13 16.13 0 0 0 16.1 16H496a16 16 0 0 0 16-16V229.71l27.5 22.59a16 16 0 0 0 22.53-2l10.26-12.3a16 16 0 0 0-2.05-22.58zM464 224h-.21v240H352V320a32 32 0 0 0-32-32h-64a32 32 0 0 0-32 32v144H111.69V194.48l.31-.25v-4L288 45.65l176 144.62z" class=""></path></svg></a> / ';
?>
<div class="breadcrumbs-wrapper">
  <div class="breadcrumbs">
      <div class="container">
      <?php
      if(isset($is_woo) and $is_woo){
        $args = array(
        'delimiter' => ' / ',
        'wrap_before' => $wrap_before,
        'home' => false
        );
        woocommerce_breadcrumb( $args ); 
      }else{
          echo $wrap_before;
          
          if (is_page()) {
              $posts_ancestors = array();
              
              while($bread_post->post_parent) {
                  $bread_post = get_post($bread_post->post_parent);
                  array_unshift($posts_ancestors, $bread_post);
                  
              }
              foreach($posts_ancestors as $item){
              ?>
                  <a href="<?= get_permalink($item->ID); ?>" title="<?= $post_title = get_the_title($item->ID); ?>"><?= $post_title ?></a>
                  /
              <?php
              }
              echo '<span class="last-item">'.$post->post_title.'</span>';
          }elseif (is_category() || is_single()) {
              if($post->post_type == 'post'){
              ?>
                <a href="<?= get_permalink($goshop_config['page_for_posts']); ?>" title="<?= $post_title = get_the_title($goshop_config['page_for_posts']); ?>"><?= $post_title ?></a> / 
                <?php
                if($goshop_config['blog_categories']){
                  echo get_the_category_list(' / ', '', $post->ID ). ' / ';
                }
              }
              if (is_single()) {
                  
                  if(!empty($bread_post->post_type) and $bread_post->post_type != 'post'){
                    $post_type = get_post_type_object($bread_post->post_type);
                    echo '<a href="/'. $post_type->rewrite['slug'] .'" title="'. $post_type->label .'">
                    <span class="post-type">'.$post_type->label.'</span>
                    </a> / ';
                  }
                  
                  echo '<span class="last-item">'.$bread_post->post_title.'</span>';
              }
              
          }elseif (is_404()){
              echo 'Error 404';
          }elseif (is_tax()){
            $tax = get_queried_object();
            print_r($tax);
            if(!empty($bread_post->post_type)){
              $post_type = get_post_type_object($bread_post->post_type);
              echo '<a href="/'. $post_type->rewrite['slug'] .'" title="'. $post_type->label .'">
              <span class="post-type">'.$post_type->label.'</span>
              </a> / ';
            }
            
            echo '<span class="last-item">'.$tax->name.'</span>';
          }
      }
      ?>
      </div>  
  </div>
</div>    