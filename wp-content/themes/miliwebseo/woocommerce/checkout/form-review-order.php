<?php
/**
 * Review order table
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="order_review" class="woocommerce-checkout-review-order">
	<table class="shop_table woocommerce-checkout-review-order-table divide-y divide-gray-200">
		<thead>
			<tr>
				<th class="product-name text-left py-3"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
				<th class="product-total text-right py-3"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					?>
					<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?> py-3">
						<td class="product-name text-left">
							<?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ) . '&nbsp;'; ?>
							<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">x' . esc_html( $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</td>
						<td class="product-total text-right font-bold">
							<?php echo apply_filters( 'woocommerce_checkout_cart_item_total', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</td>
					</tr>
					<?php
				}

				do_action( 'woocommerce_checkout_table_cart_item', $cart_item, $cart_item_key );
			}
			?>
		</tbody>
		<tfoot class="space-y-2 pt-4">
			<tr class="cart-subtotal py-2">
				<th class="text-left"><?php esc_html_e( 'Subtotal:', 'woocommerce' ); ?></th>
				<td class="text-right font-semibold"><?php wc_cart_totals_subtotal_html(); ?></td>
			</tr>

			<?php foreach ( WC()->cart->get_coupons() as $coupon ) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $coupon->get_code() ) ); ?> py-2">
				<th class="text-left"><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
				<td class="text-right font-semibold"><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
			</tr>
			<?php endforeach; ?>

			<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
				<?php do_action( 'woocommerce_checkout_before_shipping' ); ?>

				<tr class="shipping py-2">
					<th class="text-left"><?php esc_html_e( 'Shipping:', 'woocommerce' ); ?></th>
					<td class="text-right font-semibold"><?php wc_cart_totals_shipping_html(); ?></td>
				</tr>

				<?php do_action( 'woocommerce_checkout_after_shipping' ); ?>
			<?php endif; ?>

			<?php do_action( 'woocommerce_checkout_before_order_total' ); ?>

			<tr class="order-total border-t-2 border-primary py-3">
				<th class="text-left font-black uppercase"><?php esc_html_e( 'Total:', 'woocommerce' ); ?></th>
				<td class="text-right">
					<strong class="text-xl font-black text-primary">
						<?php wc_cart_totals_order_total_html(); ?>
					</strong>
				</td>
			</tr>

			<?php do_action( 'woocommerce_checkout_after_order_total' ); ?>
		</tfoot>
	</table>

	<div id="payment" class="woocommerce-checkout-payment mt-8 pt-6 border-t border-gray-200">
		<?php if ( WC()->cart->get_total() > 0 ) : ?>
			<?php do_action( 'woocommerce_checkout_before_terms_and_conditions' ); ?>

			<?php do_action( 'woocommerce_checkout_terms_and_conditions' ); ?>

			<?php do_action( 'woocommerce_review_order_before_payment' ); ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_review_order_after_payment' ); ?>

		<?php do_action( 'woocommerce_checkout_after_terms_and_conditions' ); ?>
	</div>
</div>
