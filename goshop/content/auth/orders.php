<h1 class="h3 mb-2"><?= __('Objednávky','goshop'); ?></h1>

<?php

$my_orders_columns = apply_filters( 'woocommerce_my_account_my_orders_columns', array(
	'order-number'  => __( 'Objednávka', 'goshop' ),
	'order-date'    => __( 'Dátum', 'goshop' ),
	'order-status'  => __( 'Stav', 'goshop' ),
	'order-total'   => __( 'Cena spolu', 'goshop' ),
	'order-actions' => '&nbsp;',
) );

$customer_orders = get_posts( apply_filters( 'woocommerce_my_account_my_orders_query', array(
	'numberposts' => 15,
	'meta_key'    => '_customer_user',
	'meta_value'  => get_current_user_id(),
	'post_type'   => wc_get_order_types( 'view-orders' ),
	'post_status' => array_keys( wc_get_order_statuses() ),
) ) );

if ( $customer_orders ) { ?>

	<table class="w-100">
        <thead>
			<tr>
				<?php foreach ( $my_orders_columns as $column_id => $column_name ) : ?>
					<th class="<?php echo esc_attr( $column_id ); ?>"><span class="nobr"><?php echo esc_html( $column_name ); ?></span></th>
				<?php endforeach; ?>
			</tr>
		</thead>

		<tbody>
			<?php foreach ( $customer_orders as $customer_order ) :
				$order      = wc_get_order( $customer_order );
				$item_count = $order->get_item_count();
				?>
				<tr class="order">
					<?php foreach ( $my_orders_columns as $column_id => $column_name ) : ?>
						<td class="<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
							<?php if ( has_action( 'woocommerce_my_account_my_orders_column_' . $column_id ) ) : ?>
								<?php do_action( 'woocommerce_my_account_my_orders_column_' . $column_id, $order ); ?>

							<?php elseif ( 'order-number' === $column_id ) : ?>
								<a href="<?= get_permalink(408).'?orderID='.$order->get_ID(); ?>" title="<?= __('Zobraz objednávku č.', 'goshop') .' '.$order->get_ID(); ?>">
									<?php echo _x( '#', 'hash before order number', 'woocommerce' ) . $order->get_order_number(); ?>
								</a>

							<?php elseif ( 'order-date' === $column_id ) : ?>
								<time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></time>

							<?php elseif ( 'order-status' === $column_id ) : ?>
								<?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>

							<?php elseif ( 'order-total' === $column_id ) : ?>
								<?php printf( _n( '%1$s za %2$s položku', '%1$s za %2$s položiek', $item_count ), $order->get_formatted_order_total(), $item_count ); ?>

							<?php elseif ( 'order-actions' === $column_id ) : ?>
								<?php
								$actions = wc_get_account_orders_actions( $order );
	               
								if ( ! empty( $actions ) ) {
									foreach ( $actions as $key => $action ) {
                                      if($key == 'view'){
                                           $action['url'] = get_permalink(408).'?orderID='.$order->get_ID();
                                      }  
										echo '<a href="' . esc_url( $action['url'] ) . '" style="margin-right:3px;" title="'. __('Zobraz objednávku č.', 'goshop') .' '.$order->get_ID(). '" class="btn btn-small btn-primary">' . esc_html( $action['name'] ) . '</a>';
									}
								}
								?>
							<?php endif; ?>
						</td> 
					<?php endforeach; ?>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php } else{ ?>

    <div class="alert alert-danger">
        <?= __('Zatiaľ u nás nemáte žiadnu objednávku','goshop'); ?>
    </div>
<?php } ?> 
