<?php
global $goshop_config;

if(!$goshop_config['blog_categories']){
    header( "Location: /blog");
}

get_header();
$paged = 1;
if(isset($_GET['page_num'])){
    $paged = $_GET['page_num'];
}
$category = get_queried_object();
?>

<div class="blog_wrapper container mt-5 mb-5">
  <div class="row">
    <div class="col-md-9">
      <?php require(CONTENT.'/blog-display-mode.php'); ?>
      
      <h1><?= __('Kategória','goshop'); ?> <span class="lowercase"><?= $category->name; ?></span></h1>
      <div id="blog_loop" class="blog-list row <?php if( isset($_COOKIE['blog-list-row']) and $_COOKIE['blog-list-row'] == 1){ echo 'full-row'; } ?>">
        <?php
        $blog_articles = new WP_Query([
          'post_status' => 'publish',
          'orderby' => 'post_date',
          'order' => 'DESC',
          'post_type' => 'post',
          'posts_per_page' => BLOG_POST_PER_PAGE,
          'paged' => $paged, 
          'cat' => $category->term_id          
        ]);
        
        if ( $blog_articles->have_posts() ) {
        
            $posts = $blog_articles->posts;
            
            foreach($posts as $post){
               getListPost($post, false);
            }
            ?>
        
        <?php } else { ?>
             <div class="alert alert-danger"><?= __('Žiadny článok sa nenašiel', 'goshop'); ?></div>
        <?php }; ?>
      </div>
      <?= custom_pagination($paged, $blog_articles->max_num_pages); ?>
    </div>
    <div class="col-md-3 d-mobile-none">
      <?php require(CHILD_CONTENT. '/blog-aside.php'); ?>
    </div>
  </div>
  <input type="hidden" id="blog_cat" value="<?= $category->term_id ?>">
</div
<?php get_footer(); 
