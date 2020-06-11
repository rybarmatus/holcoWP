<?php
$cur_cat = get_queried_object();
?>
<h1 class="page-title">
    <?php
    $full_name = get_field('category_full_name', $cur_cat);
    if($full_name){
        echo $full_name;
    }else{
        woocommerce_page_title();
    }
    ?>
</h1>

<?php 
if($goshop_config['product_list_cat_image']) {
    $thumb_id = get_term_meta( $cur_cat->term_id, 'thumbnail_id', true );
    $term_img = wp_get_attachment_image_src( $thumb_id , 'product-loop' );
    if(isset($term_img) && !empty($term_img)){ ?>
      <img class="category-img mb-1 d-mobile-none" src="<?= $term_img[0] ?>" alt="<?= $cur_cat->name ?>">
    <?php } 
}
?>

<?php
if($goshop_config['product_list_cat_childrens']){
    $categories = get_terms('product_cat', 
        array( 
          'parent' => $cur_cat->term_id
        )
    );
    if(!empty($categories)) { ?>
      <div class="child-kategorie mb-1">
        <?php getCategoryItems($categories); ?>
      </div>
    <?php }
} ?>
    <div class="d-mobile-none">
     <?php do_action( 'woocommerce_archive_description' ); ?>
    </div>
   
    <?= get_sort_and_display(); ?>
     
     <div id="products_loop">
    
    <?php if(!isset($_GET['f'])) { ?>

    <?php if ( woocommerce_product_loop() ) : ?>
       	<?php woocommerce_product_loop_start(); ?>

			<?php if ( wc_get_loop_prop( 'total' ) ) : ?>
				<?php while ( have_posts() ) : ?>
					<?php the_post(); ?>
					<?php wc_get_template_part( 'content', 'product' ); ?>
				<?php endwhile; ?>
			<?php endif; ?>
      <?php woocommerce_product_loop_end(); ?>
      <?= custom_pagination(1, wc_get_loop_prop('total_pages' )); ?>

    <?php
        else :
          do_action( 'woocommerce_no_products_found' );
        endif;
    ?>

    <?php } ?>   
    </div> 
    
    


<script>
  window.dataLayer = window.dataLayer || [];
  dataLayer.push({
   'event':'viewProductListingPage',
   'pagetype':'ListingPage',
   'categoryID': '<?= $cur_cat->term_id ?>',
   'categoryName': '<?= $cur_cat->name ?>'
  });
</script>
