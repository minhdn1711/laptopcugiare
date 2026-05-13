<?php
/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="cart_totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">

    <?php do_action( 'woocommerce_before_cart_totals' ); ?>

    <div class="space-y-4">
        <div class="flex justify-between items-center text-sm">
            <span class="text-gray-500 font-medium">Tạm tính:</span>
            <span class="font-bold text-secondary" data-title="Tạm tính"><?php wc_cart_totals_subtotal_html(); ?></span>
        </div>

        <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
            <div class="flex justify-between items-center text-sm text-green-600 font-medium coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                <span>Mã giảm giá: <?php wc_cart_totals_coupon_label( $coupon ); ?></span>
                <span data-title="<?php echo esc_attr( wc_cart_totals_coupon_label( $coupon, false ) ); ?>"><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
            </div>
        <?php endforeach; ?>

        <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
            <div class="border-t border-gray-50 pt-4">
                <span class="text-sm text-gray-500 font-medium block mb-2">Giao hàng:</span>
                <?php woocommerce_cart_totals_shipping_html(); ?>
            </div>
        <?php endif; ?>

        <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
            <div class="flex justify-between items-center text-sm">
                <span><?php echo esc_html( $fee->name ); ?></span>
                <span data-title="<?php echo esc_attr( $fee->name ); ?>"><?php wc_cart_totals_fee_html( $fee ); ?></span>
            </div>
        <?php endforeach; ?>

        <?php
        if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) {
            $taxable_address = WC()->customer->get_taxable_address();
            $estimated_text  = '';

            if ( WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping() ) {
                /* translators: %s location. */
                $estimated_text = sprintf( ' <small>' . esc_html__( '(estimated for %s)', 'woocommerce' ) . '</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] );
            }

            if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) {
                foreach ( WC()->cart->get_tax_totals() as $code => $tax ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
                    ?>
                    <div class="flex justify-between items-center text-sm tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                        <span><?php echo esc_html( $tax->label ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                        <span data-title="<?php echo esc_attr( $tax->label ); ?>"><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="flex justify-between items-center text-sm tax-total">
                    <span><?php echo esc_html( WC()->countries->tax_or_vat() ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                    <span data-title="<?php echo esc_attr( WC()->countries->tax_or_vat() ); ?>"><?php wc_cart_totals_taxes_total_html(); ?></span>
                </div>
                <?php
            }
        }
        ?>

        <?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

        <div class="border-t-2 border-gray-100 pt-4 flex justify-between items-center">
            <span class="text-lg font-black text-secondary">TỔNG CỘNG:</span>
            <span class="text-2xl font-black text-primary" data-title="Tổng cộng"><?php wc_cart_totals_order_total_html(); ?></span>
        </div>

        <?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>
    </div>

    <?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>
