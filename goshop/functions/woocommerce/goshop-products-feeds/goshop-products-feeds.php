<?php
/*
Plugin Name: GoShop product feed
Plugin URI: https://goup.sk
Description: Plugin GoShop Products Feeds is designed for Wordpress (WooCommerce) online stores and generates xml or csv files used for google/facebook or heureka feed.
Author: GoShop
Author URI: https://goup.sk
Version: 1.2.3
*/

require_once __DIR__ . '/goshop-products-feeds-dependencies.php';

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class GOSHOP_PRODUCTS_FEEDS {

    public function __construct() {

		$this->settings['plugin-slug'] = 'products-feeds';
		$this->settings['plugin-path'] = plugin_dir_path( __FILE__ );
		$this->settings['plugin-url']  = get_template_directory_uri().'/content/functions/goshop-products-feeds/';
		$this->settings['plugin-name'] = 'Products Feeds';
		$this->initialize();
    }

	private function initialize() {
		new GoShopPluginsAdmin( $this );
		new GOSHOP_FEED_ADMIN_PROCESS($this);
    }

	public function getPluginSlug() {
		return $this->settings['plugin-slug'];
	}

	public function getPluginPath() {
		return $this->settings['plugin-path'];
	}

	public function getPluginUrl() {
		return $this->settings['plugin-url'];
	}

	public function getPluginName() {
		return $this->settings['plugin-name'];
	}

	public function getPluginLicenseVersion() {
		return $this->settings['plugin-license-version'];
	}
}
    new GOSHOP_PRODUCTS_FEEDS();



$plugin = plugin_basename( __FILE__ );

function plugin_add_settings_link( $links ) {

	$links = array_merge( array(
		'<a href="' . esc_url( admin_url( '/options-reading.php' ) ) . '">' . __( 'Settings', 'goshop_admin' ) . '</a>'
	), $links );
	return $links;
}
add_action( "plugin_action_links_$plugin", 'plugin_add_settings_link');


function clear_description($description){
	$descriptionText = trim(preg_replace('/\t+/', '', strip_tags($description)));
	$descriptionText = str_replace( "&nbsp;", " ", $descriptionText );
	$descriptionText = str_replace( "\t", " ", $descriptionText );
	$descriptionText = str_replace( "\r\n", " ", $descriptionText );
	$descriptionText = str_replace( "\r", " ", $descriptionText );
	$descriptionText = str_replace( "\n", " ", $descriptionText );
	return $descriptionText;
}


register_activation_hook( __FILE__, 'goshop_product_feed_activate' );


function goshop_product_feed_activate() {
	if ( ! wp_next_scheduled( 'goshop_product_feed_update' ) ) {
		wp_schedule_event( time(), 'daily', 'goshop_product_feed_update' );
	}
}

add_action( 'goshop_product_feed_update', 'goshop_product_feed_do_cron' );

function goshop_product_feed_do_cron() {

	$MSG = '----------------------------------------------------------------WF-CRON----------------------------------------------------------------------';

	if ( WP_DEBUG_LOG === true ) {
		if ( is_array( $MSG ) || is_object( $MSG ) ) {
			error_log( print_r( $MSG, true ) );
		} else {
			error_log( $MSG );
		}
	}

	global $wpdb;
	$var    = "wf_config_";
	$query  = $wpdb->prepare( "SELECT * FROM $wpdb->options WHERE option_name LIKE %s;", $var . "%" );
	$result = $wpdb->get_results( $query, 'ARRAY_A' );
	foreach ( $result as $key => $value ) {

		$data = unserialize( $value['option_value'] );

		if ( $data['provider'] == 'heureka' || $data['provider'] == 'Heureka' ) {
			new GOSHOP_HEUREKA_GENERATE_FEED( $data );
			
        }
		if ( $data['provider'] == 'facebook' || $data['provider'] == 'Facebook' ) {
			new GOSHOP_FACEBOOK_GENERATE_FEED( $data );
		
		}
		if ( $data['provider'] == 'google merchant center' || $data['provider'] == 'Google Merchant Center' ) {
			new GOSHOP_GOOGLE_GENERATE_FEED( $data );
		
		}
		if ( $data['provider'] == 'custom feed' || $data['provider'] == 'Custom Feed' ) {
			new GOSHOP_CUSTOM_GENERATE_FEED( $data );
			
		}
		if ( $data['provider'] == 'dynamic search feed' || $data['provider'] == 'Dynamic Search Ads' ) {
			new GOSHOP_DSA_GENERATE_FEED( $data );
			
		}

	}

}

register_deactivation_hook( __FILE__, 'goshop_product_feed_cron_deactivation' );

function goshop_product_feed_cron_deactivation() {
	wp_clear_scheduled_hook( 'goshop_product_feed_update' );
}
