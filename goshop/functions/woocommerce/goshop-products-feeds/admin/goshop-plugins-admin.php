<?php


class GoShopPluginsAdmin
{
	private $launcher;
	private $licenseValidator;
	private $allPlugins;

	/**
	 * Adds menu items and page
	 * Gets options from database
	 */
	public function __construct($launcher){
        $this->launcher = $launcher;
		if (is_admin()) {
			add_action('admin_enqueue_scripts', array($this, 'loadMainAdminAssets'));
			add_action('admin_menu', array($this, 'add_plugin_page'));
		}
	}

	public function loadMainAdminAssets(){
		//wp_register_style('goshop-plugins-main-admin-css', $this->launcher->getPluginUrl() . 'assets/css/goshop-plugins-main-admin.css', array(), '1.0.0');
		wp_enqueue_style('goshop-plugins-main-admin-css');
	}
    public function add_plugin_page(){
		if (empty ($GLOBALS['admin_page_hooks']['product-feeds'])) {
			add_menu_page(
				'Product feeds',
				'Product feeds',
				'administrator',
				'product-feeds',
				array($this, 'wp_feed_manage_feed'),
				'dashicons-media-code',
				60
			);
		}
	}

	public function wp_feed_manage_feed() { 
    ?>
		<h1><?= __('List of Feeds', $this->launcher->getPluginSlug()) ?></h1>
		<div class="wrapp goshop-products-feeds-manage">

			<div class="wp-feed-box">
				<table class="wp-list-table widefat fixed">
					<thead>
					<th><?= __('File name', $this->launcher->getPluginSlug()) ?></th>
					<th><?= __('Provider', $this->launcher->getPluginSlug()) ?></th>
					<th><?= __('Description', $this->launcher->getPluginSlug()) ?></th>
					<th><?= __('Date', $this->launcher->getPluginSlug()) ?></th>
					<th><?= __('Feed URL', $this->launcher->getPluginSlug()) ?></th>
                    <th><?= __('Delete feed', $this->launcher->getPluginSlug()) ?></th>
					</thead>
					<tbody class="the-list-feed">
					<?php

					$upload_dir   = wp_upload_dir();                   
					$user_dirname = $upload_dir['basedir'];
					$feed_dir     = $user_dirname . '/product-feeds';
					$url          = $upload_dir['baseurl'] . '/product-feeds';
					$admiUrl      = admin_url( 'admin.php?page=product-feeds' );

					if ( isset( $_GET['name'] ) ) {
						$name = $_GET['name'];
						$expl = explode( '.', $name );

						global $wpdb;
						$wpdb->delete( $wpdb->options, array( 'option_name' => 'wf_config_' . $expl[0] ),
							array( '%s' ) );
						unlink( $feed_dir . '/' . $name );
						echo '<div class="updated notice">';
						echo '<h3>' . $name . ' succesfully deleted </h3>';
						echo '</div> <br><br>';
                    }

                    global $wpdb;
					$var    = "wf_config_";
					$query  = $wpdb->prepare( "SELECT * FROM $wpdb->options WHERE option_name LIKE %s;",
						$var . "%" );
					$result = $wpdb->get_results( $query, 'ARRAY_A' );
					foreach ( $result as $key => $value ) {
						$data = unserialize( $value['option_value'] );

						$provider = $data['provider'];

						if ( $provider == 'Heureka' ) {
							$filename = $data['filename'] . '.xml';
						} else {
							$filename = $data['filename'] . '.csv';
						}

						if ( file_exists( $feed_dir . '/' . $filename ) ) {

							echo '<tr><td>' . $filename . '</td>';
							echo '<td>' . $provider . '</td>';
							if ( isset( $data['feed_description'] ) ) {
								echo '<td>' . $data['feed_description'] . '</td>';
							} else {
								echo '<td></td>';
							}
							if ( isset( $data['date'] ) ) {
								echo '<td>' . $data['date'] . '</td>';
							} else {
								echo '<td></td>';
							}

							echo '<td><a target="_blank" href ="' . $url . '/' . $filename . '">' . $url . '/' . $filename . '</a><br />';
							echo '</td>';
							echo '<td><a href="' . $admiUrl . '&name=' . $filename . '" id="' . $filename . '" class="delete_feed"><span class="dashicons dashicons-trash"></span></a></td></tr>';

						} else {

							$wpdb->delete( $wpdb->options, array( 'option_name' => 'wf_config_' . $data['filename'] ),
								array( '%s' ) );
						}
					}

					?>
					</tbody>
				</table>

			</div>
		</div>
     <?php
     }
  }