<?php
/**
 * Checkout billing form
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="woocommerce-billing-fields">

	<?php if ( WC()->cart->needs_shipping() && WC()->cart->needs_shipping_address() ) : ?>
		<h3 class="text-lg font-bold mb-6 uppercase tracking-wide">
			<?php esc_html_e( 'Billing & Shipping Details', 'woocommerce' ); ?>
		</h3>
	<?php else : ?>
		<h3 class="text-lg font-bold mb-6 uppercase tracking-wide">
			<?php esc_html_e( 'Billing Details', 'woocommerce' ); ?>
		</h3>
	<?php endif; ?>

	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

	<div class="woocommerce-billing-fields__field-wrapper">
		<?php
		$fields = $checkout->get_checkout_fields( 'billing' );

		foreach ( $fields as $key => $field ) {
			if ( isset( $field['type'] ) && 'hidden' === $field['type'] ) {
				continue;
			}
			woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
		}
		?>
	</div>

	<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>

</div>

<?php if ( WC()->cart->needs_shipping() ) : ?>
	<div class="woocommerce-shipping-fields mt-8">
		<h3 class="text-lg font-bold mb-4 uppercase tracking-wide">
			<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox flex items-center gap-3">
				<input id="ship-to-different-address" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox w-5 h-5" type="checkbox" name="ship_to_different_address" value="1" <?php checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_billing_address_only' ) ), 1 ); ?> />
				<span><?php esc_html_e( 'Ship to a different address?', 'woocommerce' ); ?></span>
			</label>
		</h3>

		<div id="shipping_address" class="shipping_address" style="display:none;">
			<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

			<div class="woocommerce-shipping-fields__field-wrapper">
				<?php
				$fields = $checkout->get_checkout_fields( 'shipping' );

				foreach ( $fields as $key => $field ) {
					if ( isset( $field['type'] ) && 'hidden' === $field['type'] ) {
						continue;
					}
					woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
				}
				?>
			</div>

			<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>
		</div>
	</div>
<?php endif; ?>

<script type="text/javascript">
(function($) {
    var $checkbox = $('#ship-to-different-address');
    var $shipping = $('#shipping_address');

    function toggleShippingAddress() {
        if ($checkbox.is(':checked')) {
            $shipping.slideDown(200);
        } else {
            $shipping.slideUp(200);
        }
    }

    $checkbox.on('change', toggleShippingAddress);

    // Set initial state correctly
    if (!$checkbox.is(':checked')) {
        $shipping.hide();
    }
})(jQuery);
</script>
