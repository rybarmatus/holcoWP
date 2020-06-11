<?php
add_action("wp_ajax_edit_woo_stock", "edit_woo_stock");

function edit_woo_stock(){
    $_product = wc_get_product( $_POST['product_id'] );
    
    if(isset($_POST['ean'])){
      $_product->set_sku($_POST['ean']);
    }
    if(isset($_POST['regular_price'])){
      $_product->set_regular_price($_POST['regular_price']);
    }
    if(isset($_POST['sales_price'])){  
      $_product->set_sale_price($_POST['sales_price']);
    }
    
    if(isset($_POST['manage_stock']) and $_POST['manage_stock'] == 1){
       $_product->set_manage_stock(true);
    }else{
       $_product->set_manage_stock(false);
       $_product->save();
       return true;
                                                    
    }        
    
    if(wc_update_product_stock( $_product, $_POST['quantity'])){
        return true;
    }else{
        return false;
    }
   /*
   TODO:
    
   
   */
} 

function generate_product_stock_page() {

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'product_type',
                'field' => 'slug',
                'terms' => array('gift'),
                'operator' => 'NOT IN',
            )
        )       
    );

    $loop = new WP_Query( $args );
    $products = $loop->posts;
    ?>
    
<style>
.stock_input{
width:70px;
text-align:left;
margin-right:10px;
float:left;
}
button[disabled]{
cursor:not-allowed;
opacity:0.6;
}
.stock-list-table{
margin-right: 15px;
margin-top: 15px;
width: 98%;
}
.stock-list-table tr{
background-color:white;
}
.stock-list-table tr td:nth-child(n+3){
text-align:center;
}
.stock-list-table td img{
display:block;
margin:0 auto;
}
.stock-list-table td{
padding:5px;
}
.stock-list-table th{
padding: 3px 5px;
line-height: 1.1;
font-size: 14px;
min-width: 50px;
height: 60px;
white-space: normal;
font-weight: 600;
letter-spacing: 0.3px;
}
.stock-list-table tr:nth-child(odd){
background-color:#f8f9fa;
}  
.button_td.saved:before, form.error:before{
position: absolute;
width: 100%;
z-index: 9;
height: 100%;
background-color: #23282d;
color: white;
font-size: 22px;
left: 0;
text-align: center;
line-height: 35px;
opacity: 0.9;
top: 0;
}
.button_td{
position:relative;
}
.button_td.saved:before{
content: 'Saved';
}
.button_td.error:before{
content: 'Error';
}

.hidden_input{
display:none;
}
.edit_input[type="number"]{
width:90px;
}
.data{
display:inline-block;
}
@media(min-width:768px){
  
}
</style>

<script>
jQuery(document).ready(function(){
    
    jQuery(document).on('change keyup', 'input.edit_input', function(){
      jQuery(this).addClass('edited');
      var tr = jQuery(this).closest('tr');
      jQuery('.js-save-simple', tr).attr('disabled', false);
    })
    
    jQuery('.data-wrapper').click(function(){
      var td = jQuery(this).closest('td');
      jQuery(this).fadeOut(function(){
        jQuery('.edit_input', td).fadeIn();
      })
    })
                                                   
    jQuery('input.manage_stock').change(function(){
        var tr = jQuery(this).closest('tr');
        if(jQuery(this).is(':checked') ) {
            jQuery('input.stock_input', tr).attr('readonly', false).show();
            
        }else{
            jQuery('input.stock_input', tr).attr('readonly', true);
            jQuery('input.stock_input', tr).attr('readonly', false).hide();
        }
    
    })
    
    jQuery('.js-save-simple').click(function(){                                                                                                                             
        var tr = jQuery(this).closest('tr');
        jQuery('.button_td',tr).addClass('saved');
        jQuery(this).attr('disabled', true);
        
        var quantity = jQuery('input.stock_input', tr).val();
        var product_id = jQuery(this).attr('data-product-id');
        
        
        if( jQuery('input.manage_stock', tr).is(':checked') ) {
            var manage_stock = 1;
        }
        
        var regular_price = jQuery('.regular_price.edit_input.edited', tr).val();
        var sales_price = jQuery('.sales_price.edit_input.edited', tr).val();
        var ean = jQuery('.ean.edit_input.edited', tr).val();
        
        jQuery('.change_input:visible', tr).each(function(){
          var wrapper = jQuery(this).siblings('.data-wrapper');
          var val = jQuery(this).val();
          jQuery('.data', wrapper).html(val);               
          jQuery(this).hide();
          wrapper.fadeIn();
          
                                                   
        })
        
        jQuery.ajax({
         type: "POST",
         url: '<?= admin_url( 'admin-ajax.php' ) ?>',
         data: {'action': 'edit_woo_stock',
                'product_id': product_id,
                'quantity': quantity,
                'manage_stock': manage_stock,
                'regular_price': regular_price,
                'sales_price': sales_price,
                'ean': ean
               },
         success: function(response){
          
          if(response){
                jQuery('.button_td',tr).removeClass('saved');
            }else{
                jQuery('.button_td',tr).removeClass('error');
            }  
        }
        })
        return false;
    
    })
})


</script>

   
    <div>
    <table class="stock-list-table">
      <tr>
        <th style="width:57px">
          Obr.
        </th>
        <th>
          Nazov
        </th>
        <th>
          Typ produktu
        </th>
        <th style="width:120px">
          EAN
        </th>
        <th style="width:80px">
          Cena
        </th>
        <th style="width:80px">
          Zľavová cena
        </th>
        <th style="width:70px">
          Správa skladu
        </th>
        <th style="width:80px">
          Skladom
        </th>
        <th>
        </th>
     </tr>
      
      
    <?php
    foreach($products as $key=>$item){
       $product = wc_get_product($item->ID);          
        
       get_tr_content($product);
       
       if ( $product->is_type( 'variable' ) ) {
              $available_variations = $product->get_available_variations();
              foreach ($available_variations as $variation){
                $variation_obj = new WC_Product_variation($variation['variation_id']);
                get_tr_content($variation_obj);
              }
        }
    
    }
    ?>
    </table>
    </div>
   
<?php
}
                

if ( is_admin() ) {
    add_action( 'admin_menu', 'add_products_menu_entry', 100 );
}

function add_products_menu_entry() {
    add_submenu_page(
        'edit.php?post_type=product',
        __( 'Skladové zásoby' ),
        __( 'Skladové zásoby' ),
        'administrator', // Required user capability
        'product-stock-list',
        'generate_product_stock_page'
    );
}


function get_tr_content($product){
?>
  <tr>
            <td>
              <a href="<?= get_edit_post_link($product->get_id()); ?>">
                <?php
                $thumb_id = get_post_thumbnail_id( $product->get_id()); 
                
                if(!$thumb_id){     
                    echo '<div class="cart-thumb-wrapp float-left mobile-float-none">';
                      echo '<img src="'. NO_IMAGE .'" width="30" alt="No image">';
                    echo '</div>';
                }else{
                  $image = wp_get_attachment_image_src( $thumb_id , 'thumbnail' );
                  echo '<div class="cart-thumb-wrapp float-left mobile-float-none">';
                      echo '<img src="'.$image[0].'" width="30">';
                  echo '</div>';
                }
                ?>
              </a>
            </td>
            <td>
              <a title="<?= $product->get_name(); ?>" href="<?= get_edit_post_link($product->get_id()); ?>">
                <?= $product->get_name(); ?>
              </a>
            </td>
            <td>
              <?php
              if($product->is_type( 'simple' )){
                echo '<svg style="width:15px;" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-circle fa-w-16 fa-3x"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z" class=""></path></svg>';
              }else if($product->is_type( 'variable' )){
                echo '<span class="dashicons dashicons-rest-api"></span>';
              }else if($product->is_type( 'bundle' )){
                echo '<svg style="width:20px;" aria-hidden="true" focusable="false" data-prefix="far" data-icon="box-open" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="svg-inline--fa fa-box-open fa-w-20 fa-3x"><path fill="currentColor" d="M638.3 143.8L586.8 41c-4-8-12.1-9.5-16.7-8.9L320 64 69.8 32.1c-4.6-.6-12.6.9-16.6 8.9L1.7 143.8c-4.6 9.2.3 20.2 10.1 23L64 181.7V393c0 14.7 10 27.5 24.2 31l216.2 54.1c6 1.5 17.4 3.4 31 0L551.8 424c14.2-3.6 24.2-16.4 24.2-31V181.7l52.1-14.9c9.9-2.8 14.7-13.8 10.2-23zM86 82.6l154.8 19.7-41.2 68.3-138-39.4L86 82.6zm26 112.8l97.8 27.9c8 2.3 15.2-1.8 18.5-7.3L296 103.8v322.7l-184-46V195.4zm416 185.1l-184 46V103.8l67.7 112.3c3.3 5.5 10.6 9.6 18.5 7.3l97.8-27.9v185zm-87.7-209.9l-41.2-68.3L554 82.6l24.3 48.6-138 39.4z" class=""></path></svg>';
              }else if($product->is_type( 'variation' )){
                echo 'Variation';
              }else if($product->is_type( 'gift' )){
                echo '<svg style="width:20px;" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="gift" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-gift fa-w-16 fa-3x"><path fill="currentColor" d="M464 144h-39.3c9.5-13.4 15.3-29.9 15.3-48 0-44.1-33.4-80-74.5-80-42.3 0-66.8 25.4-109.5 95.8C213.3 41.4 188.8 16 146.5 16 105.4 16 72 51.9 72 96c0 18.1 5.8 34.6 15.3 48H48c-26.5 0-48 21.5-48 48v96c0 8.8 7.2 16 16 16h16v144c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V304h16c8.8 0 16-7.2 16-16v-96c0-26.5-21.5-48-48-48zm-187.8-3.6c49.5-83.3 66-92.4 89.3-92.4 23.4 0 42.5 21.5 42.5 48s-19.1 48-42.5 48H274l2.2-3.6zM146.5 48c23.4 0 39.8 9.1 89.3 92.4l2.1 3.6h-91.5c-23.4 0-42.5-21.5-42.5-48 .1-26.5 19.2-48 42.6-48zM192 464H80c-8.8 0-16-7.2-16-16V304h128v160zm0-192H32v-80c0-8.8 7.2-16 16-16h144v96zm96 192h-64V176h64v288zm160-16c0 8.8-7.2 16-16 16H320V304h128v144zm32-176H320v-96h144c8.8 0 16 7.2 16 16v80z" class=""></path></svg>';
              }
              ?>
            </td>
            <td>
              <div class="data-wrapper">
                <div class="data">
                  <?= $product->get_sku(); ?>
                </div>  
              </div>
              <input type="text" value="<?= $product->get_sku(); ?>" class="hidden_input edit_input ean change_input">
            </td>
            <?php // if ( $product->is_type( 'simple' ) or $product->is_type( 'bundle' ) ) {  ?>
            <td>
                <?php if(!$product->is_type( 'variable' )){ ?>
                  <div class="data-wrapper">
                    <div class="data">
                      <?= $product->get_regular_price(); ?>
                    </div>  
                    <?= get_woocommerce_currency_symbol(); ?>
                  </div>
                <?php } ?>  
              </div>  
              <input type="number" step="0.01" min="0" value="<?= $product->get_regular_price(); ?>" class="regular_price hidden_input edit_input change_input">
            </td>
            <td>
              <?php if(!$product->is_type( 'variable' )){ ?>
              <?php
              if( $product->is_on_sale() ) {
                  ?>
                  <div class="data-wrapper">
                    <div class="data">
                      <?= $product->get_sale_price(); ?>
                    </div>
                    <?= get_woocommerce_currency_symbol(); ?>
                  </div>    
                  <input type="number" step="0.01" min="0" value="<?= $product->get_sale_price(); ?>" class="sales_price hidden_input edit_input change_input">
              <?php    
              }
              }
              ?>
            </td>
            <td>
              <?php if(!$product->is_type( 'variable' )){ ?>
                <input type="checkbox" class="manage_stock edit_input" value="1" name="manage_stock" <?php if($product->managing_stock()){ echo 'checked="checked"'; } ?>>
              <?php } ?>
            </td>
            <td>
              <?php if(!$product->is_type( 'variable' )){ ?>
                <div class="data-wrapper">
                  <div class="data">
                    <?= $product->get_stock_quantity(); ?> 
                  </div>
                </div>  
                <input class="stock_input hidden_input edit_input change_input" min="0" value="<?= $product->get_stock_quantity(); ?>" type="number" <?php if(!$product->managing_stock()){ echo 'readonly="readonly"'; } ?>>
              <?php } ?>
            </td>
            <td class="button_td">
              <button class="js-save-simple" data-product-id="<?= $product->get_id(); ?>" disabled>Uložiť</button>
            </td>
          <?php // } ?>
        </tr>
<?php          
}