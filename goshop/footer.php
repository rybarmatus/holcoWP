<?php global $goshop_config, $product; ?>
</main>
<div class="clear"></div>

<?php require_once( CHILD_CONTENT. '/footer.php'); ?>

<?php 
if($goshop_config['copyright']){
  if($goshop_config['copyright'] == 1){
      require_once( CONTENT . '/footer_copyright/goup.php');
  }else{
      require_once( CONTENT . '/footer_copyright/pixelweb.php');
  }
} ?>

<?php require_once( CONTENT . '/cookie_bar.php'); ?>

<script src="<?= CHILD_DIR_URI ?>/js/script.js?ver=<?= rand(1,99999); ?>"></script>

<?php wp_footer(); ?>

<script>
  window.dataLayer = window.dataLayer || [];
  document.addEventListener( 'wpcf7mailsent', function( event ) {
      alert('funguje');
      if ( '5' == event.detail.contactFormId ) {
          ga( 'send', 'event', 'form_contact', 'submit' );
          dataLayer.push({'event': 'formular'});
      }
      if ( '180' == event.detail.contactFormId ) {
          ga( 'send', 'event', 'recommend_product', 'submit' );
          dataLayer.push({'event': 'recommend_product'});
      }
  }, false );
  var child_dir = "<?= CHILD_DIR_URI; ?>";
</script>

<script type='text/javascript'>
/* <![CDATA[ */
var wpcf7 = {"apiSettings":{"root":"https:\/\/<?= $_SERVER[ 'HTTP_HOST' ]; ?>\/wp-json\/contact-form-7\/v1","namespace":"contact-form-7\/v1"}};
/* ]]> */
</script>
<script type='text/javascript' src='<?= 'https://' . $_SERVER[ 'HTTP_HOST' ]; ?>/wp-content/plugins/contact-form-7/includes/js/scripts.js?ver=5.1.7'></script>



<?php
if($goshop_config['cpt_poradca']){
  global $single_product;
  if($single_product){
?>

    <script>
    jQuery(document).ready(function(){
        jQuery('#product-advisor-name').val('<?= $product->get_title(); ?>');
        jQuery('#product-advisor-url').val('<?= THIS_PAGE_URL; ?>');
        jQuery('#product-advisor-text').val('<?= __('Dobry deň, mal by som otázku', 'goshop');?>:');
        jQuery('#recommend-text').val('Ahoj, na webe <?= $_SERVER['SERVER_NAME'] ?> som našiel tento produkt: <?= THIS_PAGE_URL ?>');
          
        <?php if(is_user_logged_in()){ 
            $user = wp_get_current_user();
        ?> 
            jQuery('.product-your-name').val('<?= $user->display_name; ?>');
            jQuery('.product-your-email').val('<?= $user->user_email; ?>');        
        
        <?php } ?>
    }) 
    </script>
  
  <?php } ?>
<?php } ?>
  
  
  <div class="overlay"></div>
  <div class="scrollTo toTop" data-target="html">
      <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="arrow-alt-circle-up" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M8 256C8 119 119 8 256 8s248 111 248 248-111 248-248 248S8 393 8 256zm292 116V256h70.9c10.7 0 16.1-13 8.5-20.5L264.5 121.2c-4.7-4.7-12.2-4.7-16.9 0l-115 114.3c-7.6 7.6-2.2 20.5 8.5 20.5H212v116c0 6.6 5.4 12 12 12h64c6.6 0 12-5.4 12-12z"></path></svg>
  </div>
  
<?php if($goshop_config['woocommerce']){ ?>
  

<?php if(isset($_GET['f']) and is_product_category()) { ?>

<script>
ajax_filter_products();
</script>

<?php } ?>

<?php if( is_singular('product') and $product->is_type( 'variable' )  ){ ?>
  <script>
  var wc_add_to_cart_variation_params = {"wc_ajax_url":"<?= 'https://' . $_SERVER[ 'HTTP_HOST' ]; ?>/?wc-ajax=%%endpoint%%","i18n_no_matching_variations_text":"Sorry, no products matched your selection. Please choose a different combination.","i18n_make_a_selection_text":"Please select some product options before adding this product to your cart.","i18n_unavailable_text":"Sorry, this product is unavailable. Please choose a different combination."};
  </script>
  
  <script type="text/template" id="tmpl-variation-template">
  	<div class="woocommerce-variation-description">
  		{{{ data.variation.variation_description }}}
  	</div>
  
  	<div class="woocommerce-variation-price">
  		{{{ data.variation.price_html }}}
  	</div>
  
  	<div class="woocommerce-variation-availability">
  		{{{ data.variation.availability_html }}}
  	</div>
  </script>
  <script src="<?= CHILD_DIR_URI ?>/js/product-variation.js"></script>

<?php } ?>




<input type="hidden" id="item_added_to_cart_text" value="<?= __('Tovar bol pridaný do košíka', 'goshop'); ?>">
<input type="hidden" id="product_remove_text" value="<?= __('Tovar bol odstránený z košíka', 'goshop'); ?>">
<input type="hidden" id="compare-remove-text" value="<?= __('Produkt sa odstránil z porovnávača', 'goshop'); ?>">
<input type="hidden" id="compare-add-text" value="<?php printf(__( 'Produkt bol pridaný do %sporovnávača%s', 'goshop' ), "<a href='".get_permalink(168)."'>", "</a>" ); ?>">
<input type="hidden" id="add-to-favourite-text" value="<?= __( 'Produkt bol pridaný do obľúbených', 'goshop' ); ?>">
<input type="hidden" id="favourite-remove-text" value="<?= __('Produkt sa odstránil z obľúbených.', 'goshop'); ?>">

<?php if( IS_CHECKOUT ){ ?>

  <script>
    $(document).ready(function(){
        if($("billing_company_checkbox").checked) {
            $(".checkout-company-field").show();
        }
    })
    jQuery(function($){
      $( document.body ).trigger( 'update_checkout' );  
      $(document).on('change', 'input[name="payment_method"]', function() {
        $( document.body ).trigger( 'update_checkout' );
      });
      $('#billing_heureka_overene').val(0);
      $('#billing_celetem_data').val('');
    })

  </script>
  
<?php if($goshop_config['cetelem']){ ?>
  <script src="<?= CHILD_DIR_URI ?>/js/cetelem.js"></script>
  <input type="hidden" id="cetelem-pozicia-nastavena" value="<?= __('Cetelem pôžička bola nastavená.', 'goshop'); ?>">
  <input type="hidden" id="cetelem-upravit-parametre" value="<?= __('Upraviť parametre splátok.', 'goshop'); ?>">
<?php } ?>

<?php } // koniec checkout ?>

<?php if($goshop_config['add_to_cart_modal']){ ?>
  
  <?php require(CONTENT. '/add-to-cart-modal.php'); ?>
  <input type="hidden" id="add-to-cart-modal" value="1">
  
<?php } ?>


<?php if($goshop_config['glami_feed'] and isset($product)) { ?>
<script>
function onAddToCart(){
  glami('track', 'AddToCart', {
    item_ids: ['<?= $product->get_ID() ?>'], 
    product_names: ['<?= $product->get_name() ?>'], 
    value: <?= $product->get_price() ?>,
    currency: '<?= CURRENCY_TEXT ?>'
  });
}
</script>
<?php } ?>


<?php } // koniec woo ?>

<?php if($goshop_config['mailpoet']){ ?>
<input type="hidden" id="mailpoet_wrong_email" value="<?= __('Zadali ste zlú emailovú adresu', 'goshop'); ?>">
<input type="hidden" id="mailpoet_empty_email" value="<?= __('Nezadali ste emailovú adresu', 'goshop'); ?>">
<input type="hidden" id="mailpoet_empty_gdpr" value="<?= __('Pre prihlásenie do newslettra musíte súhlasiť so spracovaním osobných údajov', 'goshop'); ?>">
<input type="hidden" id="mailpoet_loading" value="<?= __('Loading', 'goshop'); ?>">  
<?php } ?>

<?php
if( $goshop_config['login'] and !is_user_logged_in()){   
  require(CONTENT. '/login-modal.php'); 
}
?>

<?php if(isset($_SESSION['notif']) and $_SESSION['notif']){ ?>
<script>
$(document).ready(function(){
    notif('success', '<?= $_SESSION['notif']; ?>');
});    
</script>
<?php
$_SESSION['notif'] = false;
unset($_SESSION['notif']);
?>

<?php } ?>

<div id="notif_wrapper"></div>

<?php if( $goshop_config['tooltip']){ ?>
<div class="goshop-tooltip">
    <div class="tooltip-inner"></div>
    <!-- 
    <div class="tooltip-arrow"></div>
    -->
</div>
<?php } ?>

<?php
if( current_user_can( 'administrator' ) ){
?>
  <a href="<?= get_edit_post_link(); ?>" target="_blank" class="admnin_page_edit d-mobile-none" title="<?= __('Upraviť stránku', 'goshop'); ?>">
      <svg style="width:20px;vertical-align:text-top;" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="wrench" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M507.73 109.1c-2.24-9.03-13.54-12.09-20.12-5.51l-74.36 74.36-67.88-11.31-11.31-67.88 74.36-74.36c6.62-6.62 3.43-17.9-5.66-20.16-47.38-11.74-99.55.91-136.58 37.93-39.64 39.64-50.55 97.1-34.05 147.2L18.74 402.76c-24.99 24.99-24.99 65.51 0 90.5 24.99 24.99 65.51 24.99 90.5 0l213.21-213.21c50.12 16.71 107.47 5.68 147.37-34.22 37.07-37.07 49.7-89.32 37.91-136.73zM64 472c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24z" class=""></path></svg>
  </a>
  <style>
  .admnin_page_edit{
  position: fixed;
  top: 20%;
  cursor: pointer;
  right: 0;
  background-color: #1f3851;
  color: white;
  z-index: 99999;
  padding: 5px 10px;
  }    
  </style>
<?php } ?>

</body>
</html>