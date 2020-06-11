<?php
/**
 * Description tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $post, $goshop_config;

$heading = apply_filters( 'woocommerce_product_description_heading', __( 'Description', 'woocommerce' ) );
?>
<div class="row">
  <div class="col-md-8">
    <?php the_content(); ?>  
  </div>
  <div class="col-md-4 col-xl-4">
    <?php if($goshop_config['technicke-parametre']) { ?>
        <h2 class="h5"><?= __('Technické parametre', 'goshop'); ?></h2>
        <?php woocommerce_product_additional_information_tab(); ?>
    <?php } ?>
    <div class="need-help mt-2">
        <div class="fancyText"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="question" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M202.021 0C122.202 0 70.503 32.703 29.914 91.026c-7.363 10.58-5.093 25.086 5.178 32.874l43.138 32.709c10.373 7.865 25.132 6.026 33.253-4.148 25.049-31.381 43.63-49.449 82.757-49.449 30.764 0 68.816 19.799 68.816 49.631 0 22.552-18.617 34.134-48.993 51.164-35.423 19.86-82.299 44.576-82.299 106.405V320c0 13.255 10.745 24 24 24h72.471c13.255 0 24-10.745 24-24v-5.773c0-42.86 125.268-44.645 125.268-160.627C377.504 66.256 286.902 0 202.021 0zM192 373.459c-38.196 0-69.271 31.075-69.271 69.271 0 38.195 31.075 69.27 69.271 69.27s69.271-31.075 69.271-69.271-31.075-69.27-69.271-69.27z" class=""></path></svg></div>
        <p class="h6 bold">Potrebujete poradiť s výberom?</p>
        <svg class="kontakt-icon" aria-hidden="true" focusable="false" data-prefix="far" data-icon="phone-square-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M344.73 309l-56-24a14.46 14.46 0 0 0-4.73-1 13.61 13.61 0 0 0-9.29 4.4l-24.8 30.31a185.51 185.51 0 0 1-88.62-88.62l30.31-24.8A13.61 13.61 0 0 0 196 196a14.2 14.2 0 0 0-1-4.73l-24-56a13 13 0 0 0-11-7.27 14.51 14.51 0 0 0-2.7.31l-52 12A12.57 12.57 0 0 0 96 152c0 128.23 104 232 232 232a12.57 12.57 0 0 0 11.69-9.3l12-52a14.51 14.51 0 0 0 .31-2.7 13 13 0 0 0-7.27-11zM400 32H48A48 48 0 0 0 0 80v352a48 48 0 0 0 48 48h352a48 48 0 0 0 48-48V80a48 48 0 0 0-48-48zm0 394a6 6 0 0 1-6 6H54a6 6 0 0 1-6-6V86a6 6 0 0 1 6-6h340a6 6 0 0 1 6 6z" class=""></path></svg>
        <?= get_option('option_tel_kontakt'); ?>                   
    </div>
    
    
  </div>
  
</div>  

