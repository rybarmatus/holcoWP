<?php
/**                                                                                                                                                               
Template Name: Kalendár
*/
get_header();

$events = new WP_Query([
  'post_status' => 'publish',
  'orderby' => 'post_date',
  'order' => 'DESC',
  'post_type' => 'events',
  'posts_per_page' => -1,
  'paged' => $paged,
  'suppress_filters' => true
]);
if ( $events->have_posts() ) {

  $events = $events->posts;
}
?>

<div class="container">
  <h1 class="mb-2"><?= get_the_title(); ?></h1>
  <div class="row">
  <?php 
   
  $mesiace_start = 0;
  $mesiace_end = 6;
  require(CONTENT.'/calendar.php'); ?>
  
  </div>
  <?php // getCalendarSlider(12, $events, 3, true, true ); ?>
</div>

<?php
get_footer();

