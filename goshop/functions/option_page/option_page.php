<?php 
global $goshop_config;

function register_option_page_fields() {
  global $goshop_config;
  register_setting( 'option-page-group', 'option_adresa_ulica' );
  register_setting( 'option-page-group', 'option_adresa_psc' );
  register_setting( 'option-page-group', 'option_adresa_mesto' );
  register_setting( 'option-page-group', 'option_tel_kontakt' );
  register_setting( 'option-page-group', 'option_e_mail' );
  register_setting( 'option-page-group', 'option_e_mail_form' );
  register_setting( 'option-page-group', 'option_company' );
  register_setting( 'option-page-group', 'option_ico' );
  register_setting( 'option-page-group', 'option_dic' );
  register_setting( 'option-page-group', 'option_ic_dph' );
  register_setting( 'option-page-group', 'option_bankove_spojenie' );
  register_setting( 'option-page-group', 'option_facebook' );
  register_setting( 'option-page-group', 'option_twitter' );
  register_setting( 'option-page-group', 'option_instagram' );
  register_setting( 'option-page-group', 'option_youtube' );
  register_setting( 'option-page-group', 'option_linkedln' );
  register_setting( 'option-page-group', 'option_head_end' );
  register_setting( 'option-page-group', 'option_body_start' );
  register_setting( 'option-page-group', 'option_heureka_overene_zakaznikmi_api' );
  register_setting( 'option-page-group', 'option_shipping_free' );
  register_setting( 'option-page-group', 'option_header_logo' );
  register_setting( 'option-page-group', 'option_footer_logo' );
  register_setting( 'option-page-group', 'option_google_maps' );
  register_setting( 'option-page-group', 'option_cod_fee' );
  register_setting( 'option-page-group', 'option_cod_fee_limit' );
  
  if($goshop_config['woo_export_pre_slovensku_postu']){
    register_setting( 'option-page-group', 'option_zodpovedna_osoba' );
  }
  
  
  if($goshop_config['opening_hours']){
    register_setting( 'option-page-group', 'option_opening_hours_1' );
    register_setting( 'option-page-group', 'option_opening_hours_2' );
    register_setting( 'option-page-group', 'option_opening_hours_3' );
    register_setting( 'option-page-group', 'option_opening_hours_4' );
    register_setting( 'option-page-group', 'option_opening_hours_5' );
    register_setting( 'option-page-group', 'option_opening_hours_6' );
    register_setting( 'option-page-group', 'option_opening_hours_7' );
  }
  register_setting( 'option-page-group', 'option_nazov_banky' );
  register_setting( 'option-page-group', 'option_swift' );

}

function theme_options_fnc(){
   require_once( __DIR__ . '/' . 'option_page_content.php');
}

function theme_summary_fnc(){
   require_once( __DIR__ . '/' . 'option_page_summary.php');
}
function theme_seo_summary_fnc(){
   require_once( __DIR__ . '/' . 'option_page_seo_summary.php');     
}


if(is_admin()){

  add_action('admin_menu', function(){
    add_menu_page('Nastavenie stránky', 'Theme options', 'read', 'theme-options', 'theme_options_fnc','',34);
    add_submenu_page( 'theme-options', 'Nastavenie stránky', 'Options','read', 'theme-options');
    add_submenu_page( 'theme-options', 'Theme summary', 'Summary','read', 'theme-options-summary', 'theme_summary_fnc');
    add_submenu_page( 'theme-options', 'SEO summary', 'SEO summary','read', 'theme-options-seo-summary', 'theme_seo_summary_fnc');
    
    add_action( 'admin_init', 'register_option_page_fields' );
  });
  
  add_action('admin_footer', function() { 
      
      if( isset($_GET['page']) and $_GET['page'] == 'theme-options') { 
          require_once( __DIR__ . '/' . 'option_page_images.php');
      }
  });

}
          
add_action('admin_enqueue_scripts', function(){
    wp_enqueue_media();
});




if($goshop_config['bacs_payment']){

  add_filter('woocommerce_bacs_account_fields','custom_bacs_fields');
  
  function custom_bacs_fields() {
  
    $account_fields = array(
  	'bank_name'      => array(
  		'label' => __( 'Názov banky', 'woocommerce' ),
  		'value' => get_option('option_nazov_banky')
  	),
  	/* 
    'account_name'   => array(
  		'label' => __( 'Account Name', 'woocommerce' ),
  		'value' => ''
  	),
  	'account_number' => array(
  		'label' => __( 'Account Number', 'woocommerce' ),
  		'value' => ''
  	), 
    */
  	'bic'            => array(
  		'label' => __( 'BIC', 'woocommerce' ),
  		'value' => get_option('option_swift')
  	),
  	'bic'            => array(
  		'label' => __( 'IBAN', 'woocommerce' ),
  		'value' => get_option('option_bankove_spojenie')
  	) 
    
    );
    return $account_fields;
  
  }
  
}