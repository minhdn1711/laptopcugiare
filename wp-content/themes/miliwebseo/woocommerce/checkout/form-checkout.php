<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4 md:px-6">
        <!-- Breadcrumb -->
        <nav class="flex py-4 text-[10px] text-gray-500 uppercase font-bold mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2">
                <li class="inline-flex items-center">
                    <a href="<?php echo home_url(); ?>" class="hover:text-primary transition-colors">Trang chủ</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <span class="mx-2 text-gray-300">/</span>
                        <a href="<?php echo wc_get_cart_url(); ?>" class="hover:text-primary transition-colors">Giỏ hàng</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <span class="mx-2 text-gray-300">/</span>
                        <span class="text-gray-400">Thanh toán</span>
                    </div>
                </li>
            </ol>
        </nav>

        <h1 class="text-2xl md:text-3xl font-black text-secondary uppercase mb-6 md:mb-8 italic flex items-center gap-3">
            <?php echo miliwebseo_icon('shield', 'h-8 w-8 text-primary'); ?>
            THANH TOÁN AN TOÀN
        </h1>

        <?php
        do_action( 'woocommerce_before_checkout_form', $checkout );

        // If checkout registration is disabled and not logged in, the input field should not be displayed.
        if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
            echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
            return;
        }
        ?>

        <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
 
            <div class="flex flex-col lg:flex-row gap-8 lg:gap-12" id="customer_details">
                <!-- Left Column: Billing & Shipping -->
                <div class="w-full lg:w-3/5 space-y-8">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                        <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
                            <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
 
                            <?php do_action( 'woocommerce_checkout_billing' ); ?>
 
                            <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
                        <?php else : ?>
                            <?php do_action( 'woocommerce_checkout_billing' ); ?>
                        <?php endif; ?>
                    </div>
                </div>
 
                <!-- Right Column: Order Review -->
                <div class="w-full lg:w-2/5">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 lg:sticky lg:top-24">
                        <h3 id="order_review_heading" class="text-xl font-bold mb-6 pb-4 border-b uppercase tracking-wider">
                            Đơn hàng của bạn
                        </h3>
 
                        <?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
 
                        <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
 
                        <?php do_action( 'woocommerce_checkout_order_review' ); ?>
 
                        <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
                    </div>
                </div>
            </div>
 
        </form>

        <?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
    </div>
</div>
