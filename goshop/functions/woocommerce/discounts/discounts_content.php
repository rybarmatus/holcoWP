<?php 
global $goshop_config;

if($goshop_config['woo-gifts']){

  $products = get_posts( [
    'post_status' => 'publish',
    'post_type' => 'product',
    'posts_per_page'	=> -1,
    'suppress_filters' => true,
    'tax_query'	=> array(
  		array(
  		'taxonomy'  => 'product_type',
  		'field'	  	=> 'slug',
  		'terms' 	=> 'gift',
  	),
    ),
  ]);
}
?>
<div class="wrap">
  <h1><?= __('Zľavy', 'goshop_admin'); ?></h1>
  <form method="post" action="options.php">
    <?php settings_fields( 'discount-group' ); ?>
    <?php do_settings_sections( 'discount-group' ); ?>
    
    <div id="dashboard-widgets" class="metabox-holder">
       <?php if($goshop_config['woo-gifts']){ ?>
         <div id="postbox-container-1" class="postbox-container">
            <h2>Darčeky ku nákupu</h2>
            <p><label for="discount_gift"><input type="checkbox" <?= (get_option('discount_gift'))? 'checked' :  '' ?> name="discount_gift" id="discount_gift"> Aktivovať zľavu</label></p>
            
            <p><label for="discount_gift_type">Typ zľavy 
              <select name="discount_gift_type" id="discount_gift_type">
                <option value="1" <?php if(get_option('discount_gift_type') == 1) { echo 'selected'; } ?>>Od počtu produktov</option>
                <option value="2" <?php if(get_option('discount_gift_type') == 2) { echo 'selected'; } ?>>Od sumy v <?= get_woocommerce_currency_symbol() ?></option>
              </select>
            </p>  
            <p><label for="discount_gift_amount">Hodnota <input value="<?= get_option('discount_gift_amount'); ?>" type="number" min="0" step="1" name="discount_gift_amount" id="discount_gift_amount"></label></p>
            
            <?php
            for($x=1;$x<=1;$x++) {
              $gift_value = get_option('discount_gift_product_'.$x);
              
              ?>
              <p><label for="discount_gift_product_<?= $x ?>">
                Darček <?= $x ?>
                <select name="discount_gift_product_<?= $x ?>" id="discount_gift_product_<?= $x ?>">
                  <option <?php if(!$gift_value){ echo 'selected'; } ?>></option>
                  <?php foreach($products as $product) { ?>
                    <option value="<?= $product->ID ?>" <?php if($gift_value == $product->ID){ echo 'selected'; } ?> ><?= $product->post_title ?></option>  
                  <?php } ?>
                </select>
                </label>
              </p>  
            
            <?php } ?>
         <!-- Ak zadávate iba 1 darček, zadajte ho prosím do pola Darček 1     --> 
         
         </div>
       <?php } ?>  
       <div id="postbox-container-2" class="postbox-container">
          
          <h2>Zľava na celý nákup</h2>
          <p><label for="discount_whole"><input type="checkbox" <?= (get_option('discount_whole'))? 'checked' :  '' ?> name="discount_whole" id="discount_whole"> Aktivovať zľavu</label></p>
          
          <?php for($x=1;$x<=3;$x++) { ?>
            <p><label for="discount_whole_from_<?= $x ?>">Od sumy <input value="<?= get_option('discount_whole_from_'.$x); ?>" type="number" min="0" step="1" name="discount_whole_from_<?= $x ?>" id="discount_whole_from_<?= $x ?>"></label></p>
            <p><label for="discount_whole_type_<?= $x ?>">Zľava v 
              <select name="discount_whole_type_<?= $x ?>" id="discount_whole_type_<?= $x ?>">
                <option value="1" <?php if(get_option('discount_whole_type_'.$x) == 1) { echo 'selected'; } ?>>%</option>
                <option value="2" <?php if(get_option('discount_whole_type_'.$x) == 2) { echo 'selected'; } ?>><?= get_woocommerce_currency_symbol() ?></option>
              </select>
            </label></p>
            <p><label for="discount_whole_amount_<?= $x ?>">Zľava <input value="<?= get_option('discount_whole_amount_'.$x); ?>" type="number" min="0" step="1" name="discount_whole_amount_<?= $x ?>" id="discount_whole_amount_<?= $x ?>"></label></p>
            <hr>
          <?php } ?>
       
       </div>
       <div id="postbox-container-3" class="postbox-container">
          <h2>Zľava pre registrovaných</h2>
          <p><label for="discount_for_registered"><input <?= (get_option('discount_for_registered'))? 'checked' :  '' ?> type="checkbox" name="discount_for_registered" id="discount_for_registered"> Aktivovať zľavu</label></p>
          <p><label for="discount_for_registered_type">Typ zľavy 
            <select name="discount_for_registered_type" id="discount_for_registered_type">
              <option value="1" <?php if(get_option('discount_for_registered_type') == 1) { echo 'selected'; } ?>>%</option>
              <option value="2" <?php if(get_option('discount_for_registered_type') == 2) { echo 'selected'; } ?>><?= get_woocommerce_currency_symbol() ?></option>
            </select>
          </p>
          <p><label for="discount_for_registered_amount">Zľava <input value="<?= get_option('discount_for_registered_amount'); ?>" type="number" min="0" step="1" name="discount_for_registered_amount" id="discount_for_registered_amount"></label></p>
          
       
       </div>
       <div id="postbox-container-3" class="postbox-container">
          <?php
          $args = array(
              'posts_per_page'   => -1,
              'post_type'        => 'shop_coupon'
          );
              
          $coupons = get_posts( $args );
          ?>
          
          <h2>Zľavové kupóny (<?= count($coupons); ?>)</h2>
          
          <a title="Zobraziť kupóny" href="/wp-admin/edit.php?post_type=shop_coupon">Zobraziť kupóny</a>
          
        </div>
      </div>  
        <div style="clear:both;"></div>  
          
          
           
          
          
      
  
              
            
              <!-- 
              <table class="form-table">  
              <tr valign="top">
                <th scope="row">Názov firmy</th>
                <td><input type="text" name="option_company" value="<?= esc_attr( get_option('option_company') ); ?>" /></td>
              </tr>
              <tr valign="top">
                <th scope="row">Adresa</th>
                <td><input type="text" name="option_adresa" value="<?= esc_attr( get_option('option_adresa') ); ?>" /></td>
              </tr>
              <tr>
                <td colspan="2"><small>Príklad: Kominárska 3/A, 831 04 Bratislava</small></td>
              </tr>
              <tr valign="top">
                <th scope="row">Tel. kontakt</th>
                <td><input type="text" name="option_tel_kontakt" value="<?= esc_attr( get_option('option_tel_kontakt') ); ?>" /></td>
              </tr>
              <tr valign="top">
                <th scope="row">E-mail</th>
                <td><input type="email" name="option_e_mail" value="<?= esc_attr( get_option('option_e_mail') ); ?>" /></td>
              </tr>
              <tr valign="top">
                <th scope="row">E-mail pre kont. formulár</th>
                <td><input type="email" name="option_e_mail_form" value="<?= esc_attr( get_option('option_e_mail_form') ); ?>" /></td>
              </tr>
              <tr valign="top">
                <th scope="row">ICO</th>
                <td><input type="text" name="option_ico" value="<?= esc_attr( get_option('option_ico') ); ?>" /></td>
              </tr>
              
              <tr valign="top">
                <th scope="row">DIC</th>
                <td><input type="text" name="option_dic" value="<?= esc_attr( get_option('option_dic') ); ?>" /></td>
              </tr>
              
              <tr valign="top">
                <th scope="row">IC DPH</th>
                <td><input type="text" name="option_ic_dph" value="<?= esc_attr( get_option('option_ic_dph') ); ?>" /></td>
              </tr>
              
              <tr valign="top">
                <th scope="row">Bankové spojenie - IBAN</th>
                <td><input type="text" name="option_bankove_spojenie" value="<?= esc_attr( get_option('option_bankove_spojenie') ); ?>" /></td>
              </tr>
              
              
              
           </table> 
           -->
         
         
       
      
      <style>
        .form-table th{
        width:110px;
        }
        .form-table input{
        width:90%;
        }
        .mt-1{
        margin-top:1em;
        }
      </style>
      
    
      
      <?php submit_button(); ?>
    </form>
</div>
         