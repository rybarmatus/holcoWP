<?php
/**                                                                                                                                                               
Template Name: Favourite products
*/

get_header();
?>

<div class="container">
  <?php
  if(is_user_logged_in()) {
  ?>
  
  <div class="row">
    <nav class="myacc-nav col-md-3">
    	<?php require(CONTENT. '/auth/navigation.php'); ?>
    </nav>

    <div class="myacc-content col-md-9">
        <h1 class="h4">Obľúbené produkty</h1>
        <?php
        
        // update_user_meta( get_current_user_id(), 'favourite_products', false);
        
        $user_favourite_meta = json_decode(get_user_meta( get_current_user_id(), 'favourite_products', true), true);
        
        if(!empty($user_favourite_meta)){
            
            if(!empty($user_favourite_meta)){  // string with ,
                $user_favourite_meta = implode(',', $user_favourite_meta);
            }
        
            echo do_shortcode('[products ids="'.$user_favourite_meta.'" orderby="post__in" ]');
        }else{
        ?>
        <div class="alert alert-danger"><?= __('Nemáte obľúbené produkty', 'goshop'); ?></div>
        <?php } ?>
        
    
    </div>
  </div>

  <?php }else {
        
    if(isset($_COOKIE['favourite_products']) and !empty($_COOKIE['favourite_products'])){
        
        $product_favourite = getCookieValue('favourite_products', 2);
    
        echo do_shortcode('[products ids="'.$product_favourite.'" orderby="post__in"]');
        
    }else{ ?>
        
        <div class="alert alert-danger"><?= __('Nemáte obľúbené produkty', 'goshop'); ?></div>
        
    <?php } ?>

  <?php } ?>

</div>


<?php 
get_footer();
