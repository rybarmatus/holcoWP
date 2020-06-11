<?php
/**
 * Product attributes
 *
 * Used by list_attributes() in the products class.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-attributes.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! $product_attributes ) {
	return;
}
?>
<table class="table-striped w-100">
	<?php foreach ( $product_attributes as $product_attribute_key => $product_attribute ) : ?>
		<tr>
			<th><?php echo wp_kses_post( $product_attribute['label'] ); ?></th>
			<td class="text-right"><?php echo wp_kses_post( $product_attribute['value'] ); ?></td>
		</tr>
	<?php endforeach; ?>
</table>


<style>
table.table-striped { border-collapse:collapse }
table.table-striped tr:nth-of-type(2n+1) td, table.table-striped tr:nth-of-type(2n+1) th {
    background: #eff5f8;
}
table.table-striped tr td, table.table-striped tr th{
    padding: 10px;
    line-height: 1.42857143;
    vertical-align: top;
}
table.table-striped td, table.table-striped th {
    border: 0;
}
table.table-striped p{
margin:0;
}

</style>