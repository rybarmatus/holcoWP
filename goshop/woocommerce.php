<?php
global $is_woo;
$is_woo = true;
if( is_product_category() ){
    get_header();
    define('PRODUCT_CATEGORY', 1);
    $cur_cat = get_queried_object();
    ?>

    <input type="hidden" value="<?= $cur_cat->term_id ?>" id="current_category_id">
    <?php
    if($goshop_config['product_list_sidebar']){
        require(CONTENT.'/product-category-with-sidebar.php');
    }else{
    ?>
        <input type="hidden" id="instant_filter" value="1">

        <?php
        require(CONTENT.'/product-category.php');
    }  
    get_footer();
    
    
}else if(is_tax()){
    define('PRODUCT_CATEGORY', false);
    include_once('single-manufacturers.php');    
    
} else if( is_single()  ){
    define('PRODUCT_CATEGORY', false);
    global $single_product;
    $single_product = true;
    include_once('single-product.php');

} else{
    define('PRODUCT_CATEGORY', false);
    include_once('shop.php');    
}
              