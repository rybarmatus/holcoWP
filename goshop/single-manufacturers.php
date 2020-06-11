<?php get_header(); ?>

<?php   
$args = array(
  'orderby' => 'post_date',
  'post_status' => 'publish',
  'order' => 'ASC',
  'post_type' => 'product',
  'suppress_filters' => true,
  'tax_query'             => array(
        array(
            'taxonomy'      => 'manufacturers',
            'field'         => 'term_id', //This is optional, as it defaults to 'term_id'
            'terms'         => 56,
            'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
        ),
        array(
            'taxonomy'      => 'product_cat',
            'field'         => 'slug',
            'terms'         => 'batohy', // Possibly 'exclude-from-search' too
            'operator'      => 'IN'
        )
        
    )
  );
  
  $products = wp_get_recent_posts( $args, ARRAY_A );
  
  ?>
<div class="container">
    <h1 class="page-title"><?php if(isset($_GET['cat'])) { echo $_GET['cat']; } ?> <?php woocommerce_page_title(); ?></h1>

	<?php 
    if(!isset($_GET['cat'])) {
	   do_action( 'woocommerce_archive_description' ); 
    }
    ?>

    <?php 
    
    $args = array(
      'taxonomy' => 'category',
      'hide_empty' => true,
    
    );
    $categories = get_terms( 'product_cat', $args );
    
    ?>
    
    <div class="child-kategorie mb-1">
       <?php getCategoryItems($categories); ?>
    </div>
    
    <?php if ( woocommerce_product_loop() ) : ?>

		<?php do_action( 'woocommerce_before_shop_loop' ); ?>

		<?php woocommerce_product_loop_start(); ?>

		<?php if ( wc_get_loop_prop( 'total' ) ) : ?>
			<?php while ( have_posts() ) : ?>
				<?php the_post(); ?>
				<?php wc_get_template_part( 'content', 'product' ); ?>
			<?php endwhile; ?>
		<?php endif; ?>

		<?php woocommerce_product_loop_end(); ?>

		<?php do_action( 'woocommerce_after_shop_loop' ); ?>

		<?php
    else :
      do_action( 'woocommerce_no_products_found' );
    endif;
   ?>
  
</div>

<?php get_footer(); 
      