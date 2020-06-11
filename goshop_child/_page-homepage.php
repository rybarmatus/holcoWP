<?php
/**                                                                                                                                                               
Template Name: Homepage template
*/

get_header(); ?>

<div class="container">
  <?php require(CONTENT. '/banner.php'); ?>
</div>

  <?php
      $referencie_articles = get_posts( [
        'orderby' => 'post_date',
        'order' => 'DESC',
        'post_type' => 'referencie',
        'numberposts' => -1,
        'post_status' => 'publish',
        'suppress_filters' => true
      ] ); 
      ?>

  <?php // echo getSlider('homepage', $referencie_articles, 3, 2, true, false, true, 'slider-referencie.php'  ); ?>

<?php get_footer(); 
