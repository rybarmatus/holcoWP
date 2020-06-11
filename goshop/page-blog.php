<?php
/**                                                                                                                                                               
Template Name: Blog template
*/
get_header();
$paged = 1;
$search = '';
if(isset($_GET['search'])){
    $search = $_GET['search'];
}
if(isset($_GET['page_num'])){
    $paged = $_GET['page_num'];
}
?>

<div class="blog_wrapper container mt-5 mb-5">
  <div class="row">
    <div class="col-md-9">
      <?php require(CONTENT.'/blog-display-mode.php'); ?>
      
      <?php if(isset($_GET['search'])){ ?>
        <h1 class="mb-1"><?= __('Hľadaný výraz pre články','goshop'); ?>: "<?= $_GET['search'] ?>"</h1>
      <?php } else { ?>
        <h1 class="mb-1"><?= get_the_title(); ?></h1>
      <?php } ?>
      <div id="blog_loop" class="blog-list row <?php if( isset($_COOKIE['blog-list-row']) and $_COOKIE['blog-list-row'] == 1){ echo 'full-row'; } ?>">
        <?php
        $blog_articles = new WP_Query([
          'post_status' => 'publish',
          'orderby' => 'post_date',
          'order' => 'DESC',
          'post_type' => 'post',
          's' => $search,
          'posts_per_page' => BLOG_POST_PER_PAGE,
          'paged' => $paged
        ]);
        if ( $blog_articles->have_posts() ) {
        
            $posts = $blog_articles->posts;
            
            foreach($posts as $post){
               getListPost($post, 'col-md-4');
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
</div>


<?php get_footer();
