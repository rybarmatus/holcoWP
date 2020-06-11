<?php
/**                                                                                                                                                               
* Template Name: Akciove produkty
*/

define('PRODUCT_CATEGORY', 1);
get_header(); ?>

<div class="container onsale_products">
  <?= get_sort_and_display(1); ?>
          
  <div id="products_loop">
      <?php
      if(!isset($_GET['f'])) {
        echo do_shortcode('[products on_sale="true"]');
      }
      ?>
  </div>
  <input type="hidden" id="current_category_id" value="0">
  <input type="hidden" id="instant_filter" value="1">
      
</div>

<?php get_footer(); ?>

<?php if(isset($_GET['f'])) { ?>

<script>
ajax_filter_products();
</script>    

<?php } ?>