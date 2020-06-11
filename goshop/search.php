<?php
get_header(); 

$search_string = $_GET['s'];

if($goshop_config['woocommerce']){
  
  $products = new WP_Query( [
    'post_type' => 'product',
    's' => $search_string,
    'post_status' => 'publish',
    'posts_per_page' => PRODUCTS_PER_PAGE,
    'tax_query'	=> array(
  	   'relation' => 'OR',
         array(
  	   'taxonomy'  => 'product_type',
  	   'field'	  	=> 'slug',
  	   'terms' 	=> 'simple',
  	   ),
         array(
  	   'taxonomy'  => 'product_type',
  	   'field'	  	=> 'slug',
  	   'terms' 	=> 'variable',
  	   )
    )
  ]);
  
  $categories = get_terms('product_cat', [
    'search' => $search_string,
    'orderby' => 'id',
    'order' => 'ASC'
  ] );         
  
  if($goshop_config['cpt_manufacturers']){
    $manufacturers = get_terms([
      'taxonomy' => 'manufacturers',
      'search' => $search_string,
      'hide_empty' => false
    ]);
  }  

}  

$posts = get_posts( [
  'post_type' => 'post',
  'post_status' => 'publish',
  's' => $search_string,
  'orderby'   => 'date',
  'posts_per_page' => 6,
  'order' => 'desc'
] );



$product_row_col = 12;
$product_col = 4;
$posts_col = 12;
if(!empty($products)) {
$posts_col = 5;
}

$result_count = '';

?>

<div class="container mt-1">
  <div class="row">
    <div class="col-md-9">
        <h1><?= __('Hľadaný výraz','goshop'); ?>: <?= $_GET['s']; ?></h1>
        
        <?php if(!empty($categories)) { ?>
          <h2 class="h5"><?= __('Nájdené kategórie','goshop'); ?>:</h2>
          <div class="child-kategorie mb-1">
            <?php getCategoryItems($categories); ?>
          </div>
          <hr>
        <?php } ?>
        
        <?php if ($products->have_posts()){ ?>
          <?= get_sort_and_display(); ?>
          <div id="products_loop">
      
          <?php if(!isset($_GET['f'])) { ?>
      
          <?php if ( woocommerce_product_loop() ) : ?>
             	<?php woocommerce_product_loop_start(); ?>
      
      			<?php if ( $products->have_posts() ) : ?>
      				<?php while ( $products->have_posts() ) : ?>
      					<?php $products->the_post(); ?>
      					<?php wc_get_template_part( 'content', 'product' ); ?>
      				<?php endwhile; ?>
      			<?php endif; ?>
            <?php woocommerce_product_loop_end(); ?>
            <?= custom_pagination(1, $products->max_num_pages); ?>
  
          <?php
              else :
                do_action( 'woocommerce_no_products_found' );
              endif;
          ?>
      
          <?php } ?> 
          </div>
          <input type="hidden" id="current_category_id" value="0">
          <input type="hidden" id="instant_filter" value="1">
          <input type="hidden" id="search_string" value="<?= $_GET['s'] ?>">
        <?php }else { 
             do_action( 'woocommerce_no_products_found' );
        } ?>
    </div>
    
    <?php if(!empty($posts) or !empty($manufacturers) ){ ?>
      <div class="col-md-3">
          <aside class="search-sidebar">
            <?php if(!empty($posts)){ ?>
              <div class="sidebar-title"><?= __('Nájdené články','goshop'); ?></div>
              <?php
              foreach($posts as $post){
                getSidebarPost($post);
              }
              ?>
            <?php } ?>
        
            
            <?php 
            if(!empty($manufacturers)) {
             getManufacturersHtml($manufacturers);
            } 
            ?>
         </aside>
      </div>
    <?php } ?>
  </div>      
</div>  


<?php get_footer(); ?>

<?php if(isset($_GET['f'])) { ?>

  <script>
  ajax_filter_products();
  </script>

<?php } ?>

<script>
  window.dataLayer = window.dataLayer || [];
  dataLayer.push({
   'event':'search',
   'pagetype':'searchPage',
   'searchString': '<?= $search_string ?>',
   'resultCount': '<?= $result_count ?>'
  });
</script>
