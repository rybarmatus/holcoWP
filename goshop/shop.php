<?php get_header(); ?>

<div class="container">
  <h1><?= __('Kategórie', 'goshop'); ?></h1>
  <?php 
  $categories = get_terms('product_cat', '' );
  if(!empty($categories)) { 
  ?>    
    <div class="child-kategorie mb-1">
      <?php getCategoryItems($categories); ?>
    </div>
  <?php
  }
  ?>
</div>
<?php get_footer();
