<?php
add_action('wp_ajax_search', 'search_function');
add_action('wp_ajax_nopriv_search', 'search_function' );

function search_function() {
  global $goshop_config;
  $search_string = $_POST['search_string'];
  /* darcek sa nemá zobraziť v searči */
  if($goshop_config['woocommerce']){
    $products = get_posts( [
      'post_type' => 'product',
      'post_status' => 'publish',
      's' => $search_string,
      'posts_per_page' => 6,
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
    
    $product_categories = get_terms('product_cat', [
      'search' => $search_string,
      'orderby' => 'id',
      'order' => 'ASC'
    ] );    
  }       
  
  if($goshop_config['blog']){
    $posts = get_posts( [
      'post_type' => 'post',
      'post_status' => 'publish',
      's' => $search_string,
      'orderby'   => 'date',
      'numberposts' => 6,
      'order' => 'desc'
    ] );                           
  }
                        
  if($goshop_config['cpt_manufacturers']){
    $manufacturers = get_terms([
      'taxonomy' => 'manufacturers',
      'search' => $search_string,
      'hide_empty' => false
    ]);
  }
   
  $product_row_col = 12;
  $product_col = 4;
  $posts_col = 12;
  if(!empty($products)) {
  $posts_col = 5;
  }
  ?>
  <div class="row">
    <?php
    if(!empty($posts) or !empty($product_categories)) {
    $product_row_col = 7;
    $product_col = 6;
    ?>
      <div class="col-md-<?= $posts_col ?>">
        
        <?php if(!empty($product_categories)) { ?>
          <h5><?= __('Nájdené kategórie', 'goshop'); ?></h5>
          <div class="child-kategorie mb-1">
            
            <?php foreach($product_categories as $cat){
                 $thumb_id = false;
                ?>
                <a class="category_item" title="<?= $cat->name ?>" href="<?= get_term_link($cat->term_id); ?>">
                  <?php
                  if($thumb_id){
                    $image = wp_get_attachment_image_src( $thumb_id , 'thumbnail-50' );
                    echo '<img src="'.LOADER.'" class="lazy" data-src="'.$image[0].'" width="'.$image[1].'" height="'.$image[2].'" alt="'.$cat->name.'">';
                  }
                  echo $cat->name;
                  ?>
                </a>
            <?php
              }
            ?>

          </div>

        <?php } ?>

        <?php
        if(!empty($posts)) {
        ?>
          <hr>

          <h5><?= __('Články', 'goshop'); ?></h5>
          <?php foreach($posts as $post){ ?>
            <div>
              <a class="underline mb-1" href="<?= get_permalink($post->ID); ?>" title="<?= $post->post_title; ?>"><?= $post->post_title; ?></a>
            </div>
          <?php } ?>
        <?php } ?>
        <?php 
        if(!empty($manufacturers)) {
         getManufacturersHtml($manufacturers);
        } 
        ?>
     
      </div>
    <?php } ?>

    
    <?php if(!empty($products)) { ?>
    <div class="col-md-<?= $product_row_col ?> text-center">
      <div class="row">  
        <?php foreach($products as $product){ ?>
            <div class="col-md-<?= $product_col ?> mb-1">
              <a href="<?= get_permalink($product->ID); ?>" title="<?= $product->post_title; ?>">
                <?php $_product = wc_get_product( $product->ID ); ?>
                  <div>
                    <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id($product->ID), 'product-thumbnail' ); ?>
                    <?php if($image) { ?>
                      <img class="search-image" src="<?= $image[0]; ?>" alt="<?= $product->post_title; ?>">
                    <?php } else { ?>
                      <img src="<?= NO_IMAGE; ?>" width="80" height="80" alt="<?= $product->post_title; ?>">
                    <?php } ?>
                  </div>
                  <div class="name">
                    <?= $product->post_title; ?>
                  </div>
                  <div class="price"><?= $_product->get_price_html(); ?></div>
              </a>
            </div>
        <?php } ?>
      </div>
      <?php 
      if(!empty($manufacturers) && empty($posts) ) {
       getManufacturersHtml($manufacturers);
      } 
      ?>
      
    </div>
    <?php } ?>
  </div>
  <?php if(empty($manufacturers) && empty($posts) && empty($products) && empty($product_categories)) { ?>
      <div class="alert alert-danger">Bohužiaľ sa nič nenašlo</div>
  <?php }else { ?>
      <button class="btn btn-primary btn-small float-right"><?= _('Zobraz všetky výsledky'); ?></button>
  <?php } ?>

  <?php
  // zatienit pozadie, dat pauzu pred vyhladávaním 0,5s nech nerobí 1000 requestov
  die();
}

function getManufacturersHtml($manufacturers){ ?>

    <div class="sidebar-title"><?= _('Výrobcovia') ?></div>
     <?php foreach($manufacturers as $manufacturer) { ?>
     <a href="<?= get_permalink($manufacturer->term_id); ?>" title="<?= $manufacturer->name; ?>">
        <?php $image = wp_get_attachment_image_src( get_field('image', $manufacturer), 'thumbnail-50');?>
        <img src="<?= $image[0] ?>" width="50" alt="<?= $manufacturer->name ?>">
     </a>
    <?php } ?>
<?php }
 