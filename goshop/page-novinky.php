<?php
/**                                                                                                                                                               
* Template Name: Novinky
*/

define('PRODUCT_CATEGORY', 1);
if(!isset($_GET['f'])){
    wp_redirect( get_permalink().'?f=1' );
}
get_header(); ?>

<div class="container news_products">
  <?= get_sort_and_display(2); ?>
      
  <div id="products_loop"></div>
  
  <input type="hidden" id="current_category_id" value="0">
  <input type="hidden" id="instant_filter" value="1">
</div>

<?php get_footer(); ?>

<?php if(isset($_GET['f'])) { ?>
  <script>
  ajax_filter_products();
  </script>    
<?php }     
