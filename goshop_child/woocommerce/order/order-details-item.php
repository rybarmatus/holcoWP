<?php
/**
 * Order Item Details
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
	return;
}
?>
<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'woocommerce-table__line-item order_item', $item, $order ) ); ?>">
  <td>
	  <?php
    $thumb_id = get_post_thumbnail_id( $product->get_id());
    
    if ( $product->is_type( 'variation' ) and !$thumb_id ) {
      $parent_id = $product->get_parent_id();
      $thumb_id = get_post_thumbnail_id( $parent_id);                  
    } 
     
    if(!$thumb_id){                     
        echo '<img width="50" src="'. NO_IMAGE .'" alt="No image">';
    }else{
        $image = wp_get_attachment_image_src( $thumb_id , 'thumbnail' );
        echo '<img src="'.$image[0].'" width="'.$image[1].'" height="'.$image[2].'" alt="'. $product->get_name() . '">';
    }
    
    $is_visible = $product && $product->is_visible();
		$product_permalink = apply_filters( 'woocommerce_order_item_permalink', $is_visible ? $product->get_permalink( $item ) : '', $item, $order );

		echo apply_filters( 'woocommerce_order_item_name', $product_permalink ? sprintf( '<a href="%s">%s</a>', $product_permalink, $item->get_name() ) : $item->get_name(), $item, $is_visible );
		echo apply_filters( 'woocommerce_order_item_quantity_html', ' <strong class="product-quantity">' . sprintf( '&times; %s', $item->get_quantity() ) . '</strong>', $item );

		do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, false );

		wc_display_item_meta( $item );

		do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order, false );
	  ?>
	</td>
  <td>
		<?php echo $order->get_formatted_line_subtotal( $item ); ?>
	</td>

</tr>

<?php if ( $show_purchase_note && $purchase_note ) : ?>

<tr>
  <td colspan="2"><?php echo wpautop( do_shortcode( wp_kses_post( $purchase_note ) ) ); ?></td>
</tr>

<?php endif; ?>
