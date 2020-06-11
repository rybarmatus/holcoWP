<?php


class GOSHOP_HEUREKA_GENERATE_FEED {

	private $xml;
	public $heureka;
	public $data;


	public function __construct( $data ) {
      
         add_filter( 'w3tc_can_print_comment', '__return_false', 10, 1 );
		$this->xml = new GOSHOP_SIMPLE_XML( "<?xml version=\"1.0\" encoding=\"utf-8\" ?><SHOP></SHOP>" );
		$this->mapProductsByRules( $data );
		$this->generateHeurekaXML( $data );
         
	}

	private function mapProductsByRules( $data ) {

        $shipping_methods_array = array();
        $shipping_zones = WC_Shipping_Zones::get_zones();
        
        if(!empty($shipping_zones)){
    		foreach ( $shipping_zones as $ar ) {
    			$shipping_array = $ar['shipping_methods'];
                
    			$shipping_methods = array_map( create_function( '$o', 'return $o->id;' ), $shipping_array );
    			$shipping_class   = array_map( create_function( '$o', 'return $o->instance_settings;' ), $shipping_array );
    			foreach ( $shipping_methods as $shipping_method ) {
                    
                    if ( $shipping_method == 'flat_rate' ) {
    
    					foreach ( $shipping_class as $class ) {
                            if( is_array($class) ){
                                array_push($shipping_methods_array,$class);
                            }
    					
    					}
    				}
    			}
  		    }
        
        }
        
        $products = new GOSHOP_PRODUCTS_GENERATE_LOOP( $data );
		if (is_array($products->productsList) || is_object($products->productsList)){
			foreach ( $products->productsList as $key ) :

				$availability = '0';
				
			
					if ( isset($data['checkbox']) and $data['checkbox'] == 'on' ) {
                    
                        if ( $key['availability'] != 'in stock' ) { 
                            continue;
                        }
                                                            
                    }
                            $shopItem = $this->xml->addChild( 'SHOPITEM' );

							$shopItem->addChild( 'ITEM_ID', $key['id'] );

                            $shopItem->addChildWithCDATA( 'PRODUCTNAME', $key['title'] );
							$shopItem->addChildWithCDATA( 'DESCRIPTION',htmlspecialchars( $key['description']) );
							$shopItem->addChild( 'URL', htmlspecialchars( $key['link'] ) );
							$shopItem->addChild( 'IMGURL', htmlspecialchars( $key['image'] ) );

							if(!empty($key['heureka_category'])){
                                $heureka_cat = sanitize_text_field($key['heureka_category']);
                                $shopItem->addChild( 'CATEGORYTEXT', $heureka_cat );
                            }

                            
							$shopItem->addChild( 'PRICE_VAT', $key['price'] );   
                            
                            if ( $key['availability'] == 'in stock' ) {
    							$availability = '0';
    						} elseif ( $data['product_availability'] == '1-3' && $key['availability'] !== 'in stock' ) {
    							$availability = '3';
    						} elseif ( $data['product_availability'] == '4-7' && $key['availability'] !== 'in stock' ) {
    							$availability = '7';
    						} elseif ( $data['product_availability'] == '8-14' && $key['availability'] !== 'in stock' ) {
    							$availability = '14';
    						} elseif ( $data['product_availability'] == '15-30' && $key['availability'] !== 'in stock' ) {
    							$availability = '30';
    						} elseif ( $data['product_availability'] == '31 and more' && $key['availability'] !== 'in stock' ) {
    							$availability = '31';
    						} else {
    							$availability = ' ';
    						}
    
                            /*  
                            foreach($shipping_methods_array as $ship){
                            
                                $delivery = $shopItem->addChild( 'SHOPITEM' );
                                $shopItem->addChild('');
                            
                            }
                            */    
                            
    
    						$shopItem->addChild( 'DELIVERY_DATE', $availability );                                                        
                             /*
						
							if ( $key['variation_type'] == 'parent' ) {
								$variable_product = new WC_Product_Variable( $key['id'] );
								$variations       = $variable_product->get_children();

								if ( $variations ) {
									foreach ( $variations as $variation ) {
										$variable_product = new WC_Product_Variation( $variation );
										$shopItem         = $this->xml->addChild( 'SHOPITEM' );

										$shopItem->addChild( 'ITEM_ID', $variation );
										$shopItem->addChild( 'ITEMGROUP_ID', $key['id'] );
										$shopItem->addChildWithCDATA( 'PRODUCTNAME', $key['title'] );
										$shopItem->addChildWithCDATA( 'DESCRIPTION', $key['description'] );
										$shopItem->addChild( 'URL', htmlspecialchars( $key['link'] ) );
										$shopItem->addChild( 'IMGURL', htmlspecialchars( $key['image'] ) );

										if(!empty($key['heureka_category'])){
                                            $heureka_cat = $key['heureka_category'];
                                        }                                        
										
                                        $shopItem->addChild( 'CATEGORYTEXT', $heureka_cat );
										$shopItem->addChild( 'PRICE_VAT', $key['price'] );

										if ( $key['availability'] == 'in stock' ) {
											$availability = '0';
										} elseif ( $data['product_availability'] == '1-3' && $key['availability'] !== 'in stock' ) {
											$availability = '3';
										} elseif ( $data['product_availability'] == '4-7' && $key['availability'] !== 'in stock' ) {
											$availability = '7';
										} elseif ( $data['product_availability'] == '8-14' && $key['availability'] !== 'in stock' ) {
											$availability = '14';
										} elseif ( $data['product_availability'] == '15-30' && $key['availability'] !== 'in stock' ) {
											$availability = '30';
										} elseif ( $data['product_availability'] == '31 and more' && $key['availability'] !== 'in stock' ) {
											$availability = '31';
										} else {
											$availability = ' ';
										}

										$shopItem->addChild( 'DELIVERY_DATE', $availability );

										$string     = wc_get_formatted_variation( $variable_product->get_attributes() );
										$string     = str_replace( '</dd><dt>', '</dd>**<dt>', $string );
										$string     = strip_tags( $string );
										$string_arr = explode( '**', $string );
										$final_arr  = [];
										if ( $string_arr ) {
											foreach ( $string_arr as $s ) {
												$params_arr = explode( ':', $s );

												$final_arr[ $params_arr[0] ] = $params_arr[1];

											}
										}
										if ( $final_arr ) {
											foreach ( $final_arr as $key1 => $val ) {
												$param = $shopItem->addChild( 'PARAM' );
												$param->addChild( 'PARAM_NAME', $key1 );
												$param->addChild( 'VAL', $val );
											}
										}
									}
								}
							}
                                 */


		endforeach;
	}else{
		$results = [
			
			'data' => $data,
			'message' =>'error',
		];
		error_log(print_r($results,true));
	}	




	}

	private function generateHeurekaXML( $data ) {

		$data['filename'] = preg_replace('#[^a-z0-9_]#',"", sanitize_text_field(  $data['filename']) );
		$fileName = $data['filename'] . '.xml';

		$asXML        = $this->xml->asXML();
		$upload_dir   = wp_upload_dir();
		$user_url     = $upload_dir['baseurl'] . '/product-feeds';
		$user_dirname = $upload_dir['basedir'];

		if ( ! file_exists( $user_dirname . '/product-feeds' ) ) {
			mkdir( $user_dirname . '/product-feeds' );
		}

		$feed_dir = $user_dirname . '/product-feeds';

		$file = $feed_dir . '/' . $fileName;

		if ( ! file_exists( $file ) ) {
			$open = fopen( $file, "w+" );
			fwrite( $open, $asXML );
			fclose( $open );
		} else {
			file_put_contents( $file, $asXML );
		}


		if ( isset( $_POST['filename'] ) && ! empty( $_POST['filename'] ) ) {
			echo '<div class="notice notice-success">';
			echo '<h5>Feed was succesfully generated here ->';
			echo '<a target="_blank" href="' . $user_url . '/' . $fileName . '"><h3>' . $user_url . '/' . $fileName . '</h3></a>';
			echo '</h5>';
			echo '</div>';
			die();
		}

	}


}


class GOSHOP_SIMPLE_XML extends SimpleXMLElement {

	public function addChildWithCDATA( $name, $value = null ) {
		$new_child = $this->addChild( $name );

		if ( $new_child !== null ) {
			$node = dom_import_simplexml( $new_child );
			$no   = $node->ownerDocument;
			$node->appendChild( $no->createCDATASection( $value ) );
		}

		return $new_child;
	}

}

