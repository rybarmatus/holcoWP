<?php

class GOSHOP_FEED_ADMIN_PROCESS {
	private $launcher;
	public $data;

    public function __construct( GOSHOP_PRODUCTS_FEEDS $launcher ) {

		$this->launcher = $launcher;
		if ( is_admin() ) {

			add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
		    add_action( 'product_cat_add_form_fields', array( $this, 'custom_goshop_feed_taxonomy_add_new_meta_field' ), 10, 1 );
			add_action( 'product_cat_edit_form_fields', array( $this, 'custom_goshop_feed_taxonomy_edit_meta_field' ), 10, 1 );
            add_action( 'edited_product_cat', array( $this, 'custom_goshop_feed_save_taxonomy_custom_meta' ), 10, 1 );
			add_action( 'create_product_cat', array( $this, 'custom_goshop_feed_save_taxonomy_custom_meta' ), 10, 1 );

			if ( isset( $_GET['page'] ) ) {
				if ( $_GET['page'] == 'goshop-products-feeds' || $_GET['page'] == 'product-feeds' ) {
					add_action( 'admin_print_scripts', array( $this, 'enqueue_goshop_feeds_assets' ) );
				}
			}
		}
    }

	public function enqueue_goshop_feeds_assets() {
		wp_enqueue_style( 'bootstrapcss', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' );
		wp_enqueue_script( 'bootstrapjs', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array( 'jquery' ), '2.0', true );

		wp_enqueue_style( 'multiselectcss', '//cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css' );
		wp_enqueue_script( 'multiselect', '//cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js', array( 'jquery' ), '2.0', true );

		wp_register_style( 'jquery-ui-styles', 	'//ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css' ); 
        wp_enqueue_style( 'jquery-ui-styles' );

		wp_register_style( 'jquery-select2-styles', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css' );
		wp_enqueue_style( 'jquery-select2-styles' );

		wp_enqueue_script( 'jquery-ui-script', 'https://code.jquery.com/ui/1.12.0/jquery-ui.min.js', array( 'jquery' ), '1.12', true );
		wp_enqueue_script( 'jquery-select2-script', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js', array( 'jquery' ), '4.0.6', true );
		wp_register_script( 'my-autocomplete', $this->launcher->getPluginUrl() . 'assets/js/feed-admin.js', array( 'jquery', 'jquery-ui-autocomplete' ), '1.0', true );

		wp_localize_script( 'my-autocomplete', 'MyAutocomplete', array( 'url' => admin_url( 'admin-ajax.php' ) ) );
		wp_enqueue_script( 'my-autocomplete' );

		wp_enqueue_script( 'feeds_js', $this->launcher->getPluginUrl() . 'assets/js/feed-admin.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_style( 'feed_css',  $this->launcher->getPluginUrl() . 'assets/css/feed-admin.css' );
	}

    
	public function add_plugin_page() {
		add_submenu_page(
			'product-feeds',
			__( 'Generate Feeds', $this->launcher->getPluginSlug() ),
			__( 'Generate Feeds', $this->launcher->getPluginSlug() ),
			'manage_options',
			'goshop-products-feeds',
			array( $this, 'wp_feed_generate_feed' )
		);
    }

	// END OF SETTING IN ADMIN


	public function wp_feed_generate_feed() {

		if ( isset( $_POST['provider'] ) ) {

			$this->data        = $_POST;
			$_POST['filename'] = preg_replace( '#[^a-z0-9_]#', "", sanitize_text_field( $_POST['filename'] ) );
			$fileName          = "wf_config_" . $_POST['filename'];

			if ( ! get_option( $fileName ) ) {

				update_option( $fileName, $_POST );

				if ( $_POST['provider'] == 'Heureka' ) {
					new GOSHOP_HEUREKA_GENERATE_FEED( $this->data );
				}

				if ( $_POST['provider'] == 'Facebook' ) {
                    new GOSHOP_FACEBOOK_GENERATE_FEED( $this->data );
                }

				if ( $_POST['provider'] == 'Google Merchant Center' ) {
					new GOSHOP_GOOGLE_GENERATE_FEED( $this->data );
				}
				
                if ( $_POST['provider'] == 'Custom Feed' ) {
					new GOSHOP_CUSTOM_GENERATE_FEED( $this->data );
				}
				
                if ( $_POST['provider'] == 'Dynamic Search Ads' ) {
					new GOSHOP_DSA_GENERATE_FEED( $this->data );
				}

			} else {
				echo '<div class="notice notice-error"><p>Name of file already exists</p></div>';
				$this->create_admin_page();
			}

		} else {

			$this->create_admin_page();

		}
	}

	private function create_admin_page() { ?>
		<style>
			body {
				background: #f1f1f1;
			}
		</style>
		<div class="wrap goshop-products-feeds">
			<h1>Generate Product Feed</h1>
			<br><br>

			<form action="" id="generateFeed" class="generateFeed" method="post">
				<div>
					<table class="widefat fixed ">
						<thead class="tr-heading">
						<tr>
							<td colspan="2"><h4>Feed settings</h4></td>
						</tr>
						</thead>
						<tbody>
                        
                        <tr></tr>
                        <tr>
							<td width="30%"><b> Feed Merchant Type <span class="requiredIn">*</span></b></td>
							<td>
								<div class="selectDiv">
									<select name="provider" id="provider" data-toggle="tooltip" title="Select merchander" class="generalInput dropdown" required>
										<option></option>
										<option>Heureka</option>
										<option>Facebook</option>
										<option>Google Merchant Center</option>
										<option>Custom Feed</option>
										<option>Dynamic Search Ads</option>
									</select>
								</div>
							</td>

						</tr>
                        <tr>
							<td><b>File name<span class="requiredIn">*</span></b></td>
							<td><input name="filename" type="text" class="generalInput" required="required"
									   placeholder="Input unique name for file">
							</td>
						</tr>
						<tr>
							<td><b>Description</b></td>
							<td><textarea name="feed_description" id="feed_description"></textarea></td>
						</tr>
                        <tr class="tr-heading">
							<td colspan="2"><h4>Products settings</h4></td>

						</tr>
                        <tr>
							<td><b>Products </b></td>
							<td><select type="text" class="generalInput product_select" name="id_product[]"
										multiple="multiple" data-toggle="tooltip"
										title="If you want specific products start typing and select."
										data-placement="top"></select></td>
						</tr>

						<tr>
							<td><b>Price filter</b></td>

							<td>
								<div class="smallDiv">
									<select name="product_price_rule" wp-feed-tip="Choose comparative symbol">
										<option></option>
										<option> ></option>
										<option> =</option>
										<option> <</option>
									</select>
									<input type="text" class="generalInput" name="price_product" id="price_field"
										   placeholder="For specific price range of products" data-placement="top">
								</div>

							</td>
						</tr>

						<tr>
							<td><b>Products category filter</b></td>

							<td>
								<div class="ui-widget">
									<!--<select type="text" class="generalInput product_cat_select" name="product_cat[]"
											multiple="multiple"></select>-->
									<!--								<input id="my-search" type="search" name="product_cat" class="generalInput" autocomplete="on">-->
									<select type="text" class="generalInput product_cat_select" name="product_cat[]"
											id="multiselect_cat" multiple="multiple" data-toggle="tooltip"
											title="Choose categories" data-placement="top">
										<?php
										$args       = array( 'type' => 'product', 'taxonomy' => 'product_cat' );
										$categories = get_categories( $args );
										//$cats       = [];

										foreach ( $categories as $cat ) {
											echo '<option value="' . $cat->term_id . '">' . $cat->name . '</option>';
										}
										?>
									</select>
								</div>
							</td>

						</tr>

						<tr>
							<td><b>Exclude category</b></td>
							<td>
								<div class="ui-widget">

									<select type="text" class="generalInput product_cat_select" name="exclude_product_cat[]"
											id="multiexcerptselect_cat" multiple="multiple" data-toggle="tooltip"
											title="Choose categories" data-placement="top">
										<?php
										$args       = array( 'type' => 'product', 'taxonomy' => 'product_cat' );
										$categories = get_categories( $args );
										//$cats       = [];

										foreach ( $categories as $cat ) {
											echo '<option value="' . $cat->term_id . '">' . $cat->name . '</option>';
										}
										?>
									</select>
								</div>
							</td>

						</tr>

						<tr>
							<td><b>Check if you want generate only products in stock</b></td>
							<td><input type="checkbox" name="checkbox"></td>
						</tr>


						<tr class="heurekaCat tr-heading">
							<td colspan="2"><h4>Heureka settings</h4></td>
						</tr>


						<tr class="heurekaCat">
							<td><b> Heureka Category </b> <a target="_blank" href="https://www.heureka.sk/direct/xml-export/shops/heureka-sekce.xml"> : list here</a></td>
							<td>
								<input data-toggle="tooltip" title="Add category specific for Heureka" type="text" class="generalInput" name="heureka_cat" placeholder="" data-placement="top">
                            </td>
						</tr>

						<tr class="heurekaCat">
							<td><b>Products availability</b></td>
							<td>
								<div class="selectDiv">
									<select name="product_availability" data-toggle="tooltip" title="Add product availability if is out of stock" data-placement="top">
										<option>1-3</option>
										<option>4-7</option>
										<option>8-14</option>
										<option>15-30</option>
										<option>31 and more</option>
									</select>
								</div>
							</td>
						</tr>

						<tr class="wf_csvtxt tr-heading">
							<td colspan="2"><h4>Brand and Google Category settings</h4></td>
						</tr>


						<tr class="wf_csvtxt">
							<td><b>Google category</b><a href="http://google.com/basepages/producttype/taxonomy-with-ids.en-US.xls"> : list here</a></td>
							<td><input type="text" class="generalInput"
									   name="google_cat" data-toggle="tooltip"
									   title="Add category specific for Google." data-placement="top"></td>
						</tr>

						<tr class="wf_csvtxt">
							<td><b>Brand</b></td>
							<td><input data-toggle="tooltip" title=" Add brand of your products" type="text"
									   class="generalInput"
									   name="feed_brand" data-placement="top"></td>
						</tr>
						<tr class="wf_shipping">
							<td><b>Shipping</b></td>
							<td>
								<select name="shipping">
									<?php
									$array = WC_Shipping_Zones::get_zones();

									foreach ( $array as $ar ) {
										$shipping_array = $ar['shipping_methods'];

										$shipping_methods = array_map( create_function( '$o', 'return $o->id;' ),
											$shipping_array );
										$shipping_class   = array_map( create_function( '$o',
											'return $o->instance_settings;' ), $shipping_array );
										foreach ( $shipping_methods as $shipping_method ) {
											if ( $shipping_method == 'flat_rate' ) {

												foreach ( $shipping_class as $class ) {
													$class_shipping_price = [];
													if ( array_key_exists( 'type', $class ) ) {
														if ( ! empty( $class['cost'] ) ) {
															$class_shipping_price = $class['cost'];
															echo '<option>' . $class_shipping_price . '</option>';

														} else {
															$input   = preg_quote( 'class_cost_', '~' );
															$results = preg_grep( '~' . $input . '~',
																array_keys( $class ) );
															foreach ( $results as $result ) {
																if ( array_key_exists( $result, $class ) ) {
																	$class_shipping_price = $class[ $result ];
																	echo '<option>' . $class_shipping_price . '</option>';

																}

															}


														}
														echo '<option>0</option>';
													}
												}
											}
										}
									} ?>
								</select>
							</td>
						</tr>
						<tr class="tr-heading custom_label">
							<td colspan="2"><h4>Custom Label settings</h4></td>
						</tr>
						<tr class="custom_label">
							<td><b>Custom Label</b></td>
							<td>
								<div class="selectDiv">
									<select name="custom_label" id="custom_label" class="generalInput" data-toggle="tooltip" title=" Select what you want in custom label fields" data-placement="top">
										<option value=""></option>
										<option value="id">ID</option>
										<option value="title">Title</option>
										<option value="description">Description</option>
										<option value="image_link">Image URL</option>
										<option value="condition">Condition</option>
										<option value="type"> Product type</option>
										<option value="quantity">Quantity</option>
										<option value="sale_price">Discount price</option>
										<option value="price">Regular price</option>
										<option value="availability">Availability</option>
										<option value="cat">Category</option>
									</select>
								</div>
							</td>
						</tr>
						<input name="date" id="date" type="hidden" value="<?= date( 'd.m.Y' ); ?>">

						</tbody>
					</table>
					<br /><br />
					<button type="submit" id="wp_feed_submit" class="button button-primary button-large">
						Generate Feed
					</button>
				</div>
			</form>

		</div>


		<?php
	}

}


function goshop_ajax_products() {

	$term = $_REQUEST['q'];

	global $wpdb;
	$products = $wpdb->get_results( "SELECT * FROM  {$wpdb->prefix}posts WHERE post_title LIKE '%%$term%%' AND  post_type = 'product' " );

	$pro = [];
	foreach ( $products as $product ) {

		$pro[] = array(
			'id'   => $product->ID,
			'name' => $product->post_title
		);
	}
	$response = json_encode( $pro );
	echo $response;
	exit();

}


function goshop_ajax_categories() {

	$term = $_REQUEST['q'];


	global $wpdb;
	$categories = $wpdb->get_results( "SELECT * FROM  {$wpdb->prefix}terms WHERE name LIKE '%%$term%%' AND term_id in( SELECT term_taxonomy_id FROM  {$wpdb->prefix}term_taxonomy WHERE taxonomy= 'product_cat') " );

	$pro = [];
	foreach ( $categories as $category ) {

		$pro[] = array(
			'id'   => $category->term_id,
			'name' => $category->name
		);
	}
	$response = json_encode( $pro );
	echo $response;
	exit();

}


add_action( 'wp_ajax_my_search', 'goshop_ajax_products' );
add_action( 'wp_ajax_nopriv_my_search', 'goshop_ajax_products' );


$goshop_feed_options = get_option( 'goshop_product_feeds_setting_values' );
