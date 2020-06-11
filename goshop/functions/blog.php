<?php
add_action('wp_ajax_add_post_count', 'addPostViewCount');
add_action('wp_ajax_nopriv_add_post_count', 'addPostViewCount' );
add_action('wp_ajax_blog_page', 'blog_page_function');
add_action('wp_ajax_nopriv_blog_page', 'blog_page_function' );

function blog_page_function(){
   
   $blog_articles = new WP_Query([
      'post_type' => 'post',
      'post_status' => 'publish',
      'orderby' => 'post_date',
      'order' => 'DESC',
      'cat' => $_POST['cat'],
      's' => $_POST['search'],
      'posts_per_page' => BLOG_POST_PER_PAGE,
      'paged' => $_POST['page'],
      
    ]);
    if ( $blog_articles->have_posts() ) {
    
        $posts = $blog_articles->posts;
        foreach($posts as $post){
           getListPost($post,'col-md-4');   
        }
    }
    die();
}    

function addPostOpenCount($postID){

    $count = get_post_meta($postID, 'post_open_count', true);   
    if($count == ''){
      $count = 0;
      add_post_meta($postID, 'post_open_count', 1);
    }  
    update_post_meta($postID, 'post_open_count', ++$count);

}

function addPostViewCount() {
    $postID = $_POST['post_id'];
    
    if(!isset($_COOKIE['read_articles'])){
      $read_articles = array();
    }else{
      $cookie = str_replace("\\","",$_COOKIE['read_articles']);  
      $read_articles = json_decode($cookie, true);
    }
                     
    if(!in_array($postID, $read_articles)){
        
      array_push($read_articles, $postID);   
      setcookie('read_articles', json_encode($read_articles), time()+31556926, '/');  
    
      $count_key = 'post_views_count';
      $count = get_post_meta($postID, $count_key, true);
      if($count==''){
          $count = 0;
          delete_post_meta($postID, $count_key);
          add_post_meta($postID, $count_key, 1);
      }else{
          $count++;
          update_post_meta($postID, $count_key, $count);
      }
    
    }
    die();
}

function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count == ''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return '0';
    }
    return $count;
}


function getPostStars($postID){

  $post_rating_count_key = 'post_rating_count';  //  pocet hodnoteni
  $post_rating_score_key = 'post_rating_score';  //  priemier hodnotení
  $post_rating_count = get_post_meta($postID, $post_rating_count_key, true);
  $post_rating_score = get_post_meta($postID, $post_rating_score_key, true);

  if($post_rating_score > 0){
    
    $full_stars  = floor( $post_rating_score );
    $half_stars  = ceil( $post_rating_score - $full_stars );
    $empty_stars = 5 - $full_stars - $half_stars;
  
    if ( $post_rating_count ) {
        $format = _n( '%1$s hviezdička na základe %2$s hodnotení', '%1$s hviezdičiek na základe %2$s hodnotení', $post_rating_score );
        $title  = sprintf( $format, number_format_i18n( $post_rating_score, 1 ), number_format_i18n( $post_rating_count ) );
    }
?>
    <span class="star-rating" title="<?= $title ?>">
      <?php if($full_stars > 0){ echo str_repeat( '<svg class="full" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" viewBox="0 0 576 512"><path fill="currentColor" d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"/></svg>', $full_stars ); } ?>
      <?php if($half_stars > 0){ echo str_repeat( '<svg class="half-star" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star-half-alt" role="img" viewBox="0 0 536 512"><path fill="currentColor" d="M508.55 171.51L362.18 150.2 296.77 17.81C290.89 5.98 279.42 0 267.95 0c-11.4 0-22.79 5.9-28.69 17.81l-65.43 132.38-146.38 21.29c-26.25 3.8-36.77 36.09-17.74 54.59l105.89 103-25.06 145.48C86.98 495.33 103.57 512 122.15 512c4.93 0 10-1.17 14.87-3.75l130.95-68.68 130.94 68.7c4.86 2.55 9.92 3.71 14.83 3.71 18.6 0 35.22-16.61 31.66-37.4l-25.03-145.49 105.91-102.98c19.04-18.5 8.52-50.8-17.73-54.6zm-121.74 123.2l-18.12 17.62 4.28 24.88 19.52 113.45-102.13-53.59-22.38-11.74.03-317.19 51.03 103.29 11.18 22.63 25.01 3.64 114.23 16.63-82.65 80.38z"/></svg>', $half_stars ); } ?>
      <?php if($empty_stars > 0){ echo str_repeat( '<svg class="empty" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" viewBox="0 0 576 512"><path fill="currentColor" d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"/></svg>', $empty_stars ); } ?>
      (<span><?= $post_rating_count ?></span>)
    </span>
  <?php  
  }
}

function getSidebarPost($post){ ?>
  <div class="blog-item mb-1">
    <a title="<?= $post->post_title; ?>" href="<?= get_permalink($post->ID);?>">
      <div class="row">
        <figure class="col-3 pr-0">
          <img class="w-100 lazy" src="<?= NO_IMAGE; ?>" data-src="<?= wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' )[0]; ?>" alt="<?= $post->post_title; ?>" />
        </figure>
        <div class="col-9">
           <div class="sidebar-post-title"><?= $post->post_title; ?></div>
           <small><time datetime="<?= $post->post_date ?>"><?= date('d.m.Y', strtotime($post->post_date)); ?></time></small>
        </div>
      </div>
    </a>
   </div>
<?php }
function show_comments($postID){

    $comments = get_comments([
        'post_id' => $postID
    ]);
    
    comments_template();
      
}


/* pridá nad thumbnail text */

function custom_admin_post_thumbnail_html( $content ) {
    if($GLOBALS['post_type'] == 'post'){
      echo 'Velkost obrázku: 1903x615 px';
    }
    return $content;
}
add_filter( 'admin_post_thumbnail_html', 'custom_admin_post_thumbnail_html' );
