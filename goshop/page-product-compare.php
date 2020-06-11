<?php
/**                                                                                                                                                               
* Template Name: Porovnanie produktov
*/

get_header(); ?>
 
<div class="container compare_wrapper">
  <?php
  $products = getProductsInCompare();
  
  $compare_categories = array();
  
  if(isset($_GET['cat'])){
    $active_term = $_GET['cat'];
  }else{
    $active_term = false;
  }
  
  if($products){
    $products_count = count($products);
  }else{
    $products_count = 0;
  }

  if($products_count){
  
    $link = get_permalink(get_the_id());
    
    
    
    if($products_count > 2){
      
      foreach($products as $key=>$product){
          if(!$key){
              continue;
          }
          if(!isset($products[$key]->show)){
             $products[$key]->show = 0;
          }
          
          $terms = get_the_terms( $product->get_id(), 'product_cat' );
          
          foreach($terms as $term){
          
              if(get_field('cat_compare', $term)){
                  
                  if(!$active_term){
                      $active_term = $term->term_id;
                  }
                  
                  if($term->term_id == $active_term){
                      $products[$key]->show = 1;
                  }         
                  
                  array_push($compare_categories, $term);
                  
                  $termParent = get_term( $term->parent, 'product_cat' );
                  if($termParent){
                    if(get_field('cat_compare', $termParent)){
                        
                        if(!$active_term){
                            
                            $active_term = $termParent->term_id;
                        }
                        
                        if($termParent->term_id == $active_term){
                            
                            $products[$key]->show = 1;
                        }   
                            
                                 
                        array_push($compare_categories, $termParent);
                    }
                  }
               }
          };
      }
      }
    if(count($compare_categories) > 1){   
      foreach($compare_categories as $cat){
      
          if(isset($print_cats[$cat->term_id])){
          
              $print_cats[$cat->term_id]['pocet']++;    
          
          }else{      
          
            $print_cats[$cat->term_id] = array(
               'name'     => $cat->name,
               'pocet'    => 1
            );
          
          }
      
      }
      
      $help = 0;
      ?>  
      <div class="row">
        <div class="col-md-9">
            <div class="categories mb-5">
            <?php
            foreach($print_cats as $cat_id=> $print_cat){ 
               global $wp;
               ?>
            
                <a href="<?= $link; ?><?= '?cat='.$cat_id; if(isset($_GET['compare'])){echo '&compare='.$_GET['compare']; }?>" 
                  <?php if( (isset($_GET['cat']) and $_GET['cat'] == $cat_id) or !isset($_GET['cat']) and !$help) { 
                      echo 'class="active"'; 
                      $help++;
                      $active_term = $cat_id;
                  } ?> 
                  title="<?= $print_cat['name']; ?>">
                    <?= $print_cat['name']; ?> (<?= $print_cat['pocet']; ?>)
                </a>
            <?php } ?>
            </div>
        </div>
        <div class="col-3">
          <span class="js-copy pointer" data-success_text="<?= __('Link pre porovnanie produktov bol skopírovaný', 'goshop'); ?>" data-copy="<?= getEncodeParam($link) ?>">Skopíruj link porovnávača</span>
        </div>
      </div>
    <?php 
     } 
    /* https://www.hudysport.sk/porovnanie-produktov */

    foreach($products as $key=>$product){
        
        if($key and isset($product->show) and $product->show == 0){
            unset($products[$key]);
        }
        
    }    
    
    $products = array_values($products);
    if(isset($products[1])){ 
      $product = wc_get_product( $products[1] );
      $attributes = $product->get_attributes(); 
    
    ?>
    
    
    <table class="compare-table text-center">
      <tbody>
        <tr>
          <?php foreach($products as $key=>$product): ?>
            <?php
            if($key){
            ?>
              <td class="relative">
                <a href="<?= get_permalink( $product->get_id() ); ?>"><?= $product->get_name(); ?></a>
                <?php if(!isset($_GET['compare'])){ ?>
                <div class="remove-from-compape pointer js-remove_from_compare" data-product-id="<?= $product->get_id(); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times-circle" class="svg-inline--fa fa-times-circle fa-w-16" role="img" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z"/></svg>
                </div>
                <?php } ?>
              </td>  
            <?php }else { ?>
                <td></td>
            <?php } ?>
          <?php endforeach; ?>
        </tr>
        <tr>
          <?php foreach($products as $key=>$product): ?>
            <?php
            if($key){
            ?>
                <td>
                  <?= getStars($product, true); ?>
                </td>  
            <?php }else { ?>
                <td></td>
            <?php } ?>
          <?php endforeach; ?>
        </tr>
        <tr>    
        <?php foreach($products as $key=>$product): ?>
            <?php
            if($key){ 
            ?>
            <td class="image">
                <a href="<?= get_permalink( $product->get_id() ); ?>">
                  <?php 
                  $image = wp_get_attachment_image_src( $product->get_image_id(), 'product-loop' ); ?> 
                  <?php if($image){ ?> 
                    <img class="lazy" src="<?= NO_IMAGE; ?>" <?php if($image[0]){ ?> data-src="<?= $image[0] ?>" <?php } ?> alt="<?= $product->get_name() ?>">
                  <?php } else { ?>
                    <img src="<?= get_template_directory_uri(); ?>/images/no-image.png" alt="No image">
                  <?php } ?>
                  <div class="text-center mt-1">
                   <?php
                   if ( !$product->is_type( 'variable' ) ) {
                   wc_get_template( 'single-product/add-to-cart/simple-without-quantity.php' ); 
                   }
                  ?>
                  </div>
                </a>
            </td>  
            <?php }else { ?>
                <td></td>
            <?php } ?> 
          <?php endforeach; ?>
         </tr>
         <tr>
          <?php foreach($products as $key=>$product): ?>
            <?php
            if($key){
              ?>
                <td>
                  <?= wc_get_stock_html( $product ); ?>
                </td>  
            <?php }else { ?>
                <td></td>
            <?php } ?>
          <?php endforeach; ?>
        </tr>
         <?php foreach($attributes as $attr_slug=>$attr){ ?>
            <tr>
                <td><?= wc_attribute_label($attr_slug); ?></td>
                
                <?php foreach($products as $key=>$product): ?>
                
                    <?php if($key){ ?>
                    
                      <?php 
                      $attributes = $product->get_attributes();
                      
                      ?>
                      <td><?= $product->get_attribute( $attr_slug ); ?></td>
                    
                    <?php } ?>
                    
                <?php endforeach; ?>
            </tr>
        <?php } ?> 
      </tbody>    
    </table>
    <?php }else{ ?>
      <div class="alert alert-danger"><?= __('V porovnávači sa nenachádza žiadny produkt', 'goshop'); ?></div>
    <?php } ?>
  <?php }else{ ?>
  
    <div class="alert alert-danger"><?= __('V porovnávači sa nenachádza žiadny produkt', 'goshop'); ?></div>
  
  <?php } ?>
</div>    


<?php get_footer(); ?>