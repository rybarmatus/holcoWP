<aside class="blog-sidebar d-mobile-none">
  <div class="sidebar-block">
    <form method="get" action="/blog">
      <div class="input-group">
        <input class="form-control" name="search" placeholder="<?= __('Hľadať článok', 'goshop');?>" type="text" required />
        <input type="hidden" id="blog-search-value" value="<?php if(isset($_GET['search'])) { echo $_GET['search']; } ?>">
        <button class="btn btn-primary btn-small search-button"><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="search" role="img" viewBox="0 0 512 512"><path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path></svg></button>
      </div>        
    </form>
  </div>
  <div class="sidebar-block">
    <div class="sidebar-title">Sledujte nás</div>
    <div class="socialne_siete text-center mb-1">
      <?php show_socials(); ?>
    </div>
  </div>  
  
   <div class="sidebar-block">
      <div class="sidebar-title"><?= __('Kategórie', 'goshop');?></div>
      <?php $categories = get_terms( 'category', array() ); 
      foreach($categories as $post_category){ ?>
          <div>
              <a class="hover-underline" title="<?= $post_category->name; ?>" href="<?= get_category_link($post_category->term_id); ?>">
                  <?= $post_category->name; ?> (<?= $post_category->count; ?>)
              </a>
          </div> 
      <?php } ?>
   </div>
   <div class="sidebar-block">
    
    <div class="sidebar-title"><?= __('Najčítanejšie články', 'goshop');?></div>
        <?php
        $args = array(
          'orderby' => 'post_date',
          'order' => 'DESC',
          'post_status' => 'publish',
          'numberposts' => 3,
          'meta_key' => 'post_views_count',
          'orderby' => 'meta_value_num',
          'order' => 'desc'
        );            
        $recent_posts = get_posts($args); 
            
        foreach( $recent_posts as $post ){
            getSidebarPost($post);  
        } ?>
   </div>
   <div class="sidebar-block">
        <div class="sidebar-title"><?= __('Najnovšie články', 'goshop');?></div>
        <?php
        $args = array(
        'orderby' => 'post_date',
        'order' => 'DESC',
        'post_status' => 'publish',
        'numberposts' => 3,
        'suppress_filters' => true 
        );            
        $recent_posts = get_posts($args); 
            
        foreach( $recent_posts as $post ){ 
            getSidebarPost($post);  
        } ?>
   </div>
   
    
      <?php if(is_single() and $product_id = get_field('produkt_reklama', $clanok_id)){ ?>
      <div class="blog_reklama text-center mt-2 mb-5">
        <?php $product = wc_get_product( $product_id ); ?>
        <a title="<?= $product->get_name(); ?>" href="<?= get_permalink($product_id); ?>">
          <div>
            <img class="w-100" src="<?= wp_get_attachment_url( get_post_thumbnail_id($product_id), 'medium' ); ?>" alt="<?= $product->get_name() ?>">
          </div>
          <div class="name">
            <?= $product->get_name(); ?>
          </div>
          <div class="short-desc">
            <?= $product->get_short_description(); ?>
          </div>
        </a>
        <div class="price"><?= $product->get_price_html(); ?></div>
        <a href="<?= get_permalink($product_id); ?>" class="btn btn-primary btn-small mt-1"><?= __('Detail produktu', 'goshop'); ?></a>
      </div>
      <?php } ?>
</aside>