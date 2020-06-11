<?php
$product_id = get_the_id();

if($goshop_config['last_seen']){
  addValueToCookie($product_id, 'viewed_products');
} 

get_header(); ?>

<?php woocommerce_content(); ?>
          
<?php   
$product_categories = $product->get_category_ids();
$first_category = get_term_by( 'id', $product_categories[0], 'product_cat' );
?>

<script>
window.dataLayer = window.dataLayer || [];
dataLayer.push({
 'event':'viewProductDetail',
 'pagetype':'ProductDetail',
 'ecommerce': {
   'currencyCode':'EUR',
     'products': [{
       'id':'<?= $product_id ?>',
       'name':'<?= $product->get_name() ?>',
       'price':'<?= $product->get_price();?>',
       'category':'<?= $first_category->name ?>',
     }]
}
});
</script>




<?php get_footer(); 
