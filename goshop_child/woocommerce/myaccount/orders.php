<?php
/**
 * Orders
 * @version 3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_orders', $has_orders ); ?>

<?php if ( $has_orders ) : ?>

	<table class="w-100 my-orders-table text-center">
		<thead>
			<tr>
        <th></th>
				<?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>
					<th><?= esc_html( $column_name ); ?></th>
				<?php endforeach; ?>
			</tr>
		</thead>

		<tbody>
			<?php foreach ( $customer_orders->orders as $customer_order ) :
				$order      = wc_get_order( $customer_order );
				$item_count = $order->get_item_count();
        $status = $order->get_status();
				?>
				<tr>
                  
                  <td>
                    <!-- 
                    <?php if( $status === 'on-hold'){ ?>
                      <i class="fas fa-money-bill-wave"></i> 
                    <?php }else if($status === 'processing'){ ?> 
                      <i class="far fa-clock"></i> 
                    <?php }else if($status === 'pending'){ ?>
                      <i class="fas fa-money-bill-wave"></i> 
                    <?php }else if($status === 'completed'){ ?>
                      <i class="fas fa-check"></i>         
                    <?php }else if($status === 'cancelled'){ ?>
                      <i class="fas fa-ban"></i>
                    <?php } ?>
                    -->
                  </td>
                  
					<?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>
						<td>
							<?php if ( has_action( 'woocommerce_my_account_my_orders_column_' . $column_id ) ) : ?>
								<?php do_action( 'woocommerce_my_account_my_orders_column_' . $column_id, $order ); ?>

							<?php elseif ( 'order-number' === $column_id ) : ?>
								  <?php echo _x( '#', 'hash before order number', 'woocommerce' ) . $order->get_order_number(); ?>
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
                  
                  foreach ( $actions as $key => $action ) { ?>
										<a href="<?= esc_html($action['url']); ?>" <?php if($key == 'pay') { ?>style="float:left;" <?php } else if($key== 'cancel'){ ?> style="float:right;" <?php } ?> class="btn btn-small btn-primary"><?= esc_html( $action['name'] ); ?></a>
									<?php }
								}
								?>
							<?php endif; ?>
						</td>
					<?php endforeach; ?>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<?php do_action( 'woocommerce_before_account_orders_pagination' ); ?>

	<?php if ( 1 < $customer_orders->max_num_pages ) : ?>
		
			<?php if ( 1 !== $current_page ) : ?>
				<a class="btn btn-primary mt-1" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>"><?= _( 'Predchádzajúca strana'); ?></a>
			<?php endif; ?>

			<?php if ( intval( $customer_orders->max_num_pages ) !== $current_page ) : ?>
				<a class="btn btn-primary mt-1" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>"><?= _( 'Ďalšia strana'); ?></a>
			<?php endif; ?>
		
	<?php endif; ?>

<?php else : ?>
	<div class="alert alert-danger">
		<?php _e( 'No order has been made yet.', 'woocommerce' ); ?>
	</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>
