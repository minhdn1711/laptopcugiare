<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 */

defined( 'ABSPATH' ) || exit;

// get_header();
?>

<div class="container mx-auto px-4">
    <!-- Breadcrumb -->
    <nav class="flex py-4 text-[10px] text-gray-500 uppercase font-bold" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2">
            <li class="inline-flex items-center">
                <a href="<?php echo home_url(); ?>" class="hover:text-primary transition-colors">Trang chủ</a>
            </li>
            <li>
                <div class="flex items-center">
                    <span class="mx-2 text-gray-300">/</span>
                    <span class="text-gray-400">Giỏ hàng</span>
                </div>
            </li>
        </ol>
    </nav>
</div>

<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-black text-secondary uppercase mb-8 italic flex items-center gap-3">
            <?php echo miliwebseo_icon('shopping-cart', 'h-8 w-8 text-primary'); ?>
            GIỎ HÀNG CỦA BẠN
        </h1>

        <?php do_action( 'woocommerce_before_cart' ); ?>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Cart Items List -->
            <div class="w-full lg:w-2/3">
                <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <table class="w-full text-left border-collapse" cellspacing="0">
                            <thead class="hidden md:table-header-group">
                                <tr class="bg-gray-50 border-b border-gray-100">
                                    <th class="px-6 py-4 text-xs font-bold uppercase text-gray-400">Sản phẩm</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase text-gray-400">Giá</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase text-gray-400">Số lượng</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase text-gray-400 text-right">Tổng</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <?php do_action( 'woocommerce_before_cart_contents' ); ?>

                                <?php
                                foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                                    $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                                    $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                                    if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                                        $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                                        ?>
                                        <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?> group">
                                            <td class="px-6 py-6 flex items-center gap-4">
                                                <!-- Remove -->
                                                <?php
                                                    echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                                        'woocommerce_cart_item_remove_link',
                                                        sprintf(
                                                            '<a href="%s" class="text-gray-300 hover:text-red-600 transition-colors" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                                                            esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                                            esc_html__( 'Remove this item', 'woocommerce' ),
                                                            esc_attr( $product_id ),
                                                            esc_attr( $_product->get_sku() )
                                                        ),
                                                        $cart_item_key
                                                    );
                                                ?>
                                                <div class="w-20 h-20 bg-gray-50 rounded-lg overflow-hidden border border-gray-100 flex-shrink-0">
                                                    <?php
                                                    $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
                                                    echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                                    ?>
                                                </div>
                                                <div class="min-w-0">
                                                    <a href="<?php echo esc_url( $product_permalink ); ?>" class="text-sm font-bold text-secondary hover:text-primary transition-colors line-clamp-2">
                                                        <?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ); ?>
                                                    </a>
                                                    <?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                                </div>
                                            </td>

                                            <td class="px-6 py-6 hidden md:table-cell">
                                                <span class="text-sm font-medium text-gray-600">
                                                    <?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); ?>
                                                </span>
                                            </td>

                                            <td class="px-6 py-6">
                                                <div class="flex items-center">
                                                    <?php
                                                    if ( $_product->is_sold_individually() ) {
                                                        $product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
                                                    } else {
                                                        $product_quantity = woocommerce_quantity_input(
                                                            array(
                                                                'input_name'   => "cart[{$cart_item_key}][qty]",
                                                                'input_value'  => $cart_item['quantity'],
                                                                'max_value'    => $_product->get_max_purchase_quantity(),
                                                                'min_value'    => '0',
                                                                'product_name' => $_product->get_name(),
                                                            ),
                                                            $_product,
                                                            false
                                                        );
                                                    }
                                                    echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                                    ?>
                                                </div>
                                            </td>

                                            <td class="px-6 py-6 text-right font-bold text-secondary">
                                                <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>

                                <?php do_action( 'woocommerce_cart_contents' ); ?>

                                <tr>
                                    <td colspan="6" class="px-6 py-6 bg-gray-50">
                                        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                                            <?php if ( wc_coupons_enabled() ) { ?>
                                                <div class="flex gap-2 w-full md:w-auto">
                                                    <input type="text" name="coupon_code" class="px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary flex-grow" id="coupon_code" value="" placeholder="Mã giảm giá" />
                                                    <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-xs font-bold uppercase hover:bg-black transition-colors" name="apply_coupon" value="Áp dụng">Áp dụng</button>
                                                </div>
                                            <?php } ?>
                                            <button type="submit" class="w-full md:w-auto border-2 border-secondary text-secondary px-6 py-2 rounded-lg text-xs font-bold uppercase hover:bg-secondary hover:text-white transition-all" name="update_cart" value="Cập nhật">Cập nhật giỏ hàng</button>
                                            <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                                        </div>
                                    </td>
                                </tr>

                                <?php do_action( 'woocommerce_after_cart_contents' ); ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>

            <!-- Cart Summary -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 sticky top-24">
                    <h2 class="text-xl font-bold mb-6 pb-4 border-b">TỔNG ĐƠN HÀNG</h2>
                    
                    <?php woocommerce_cart_totals(); ?>
                    
                    <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="block w-full bg-red-600 text-white text-center py-4 rounded-xl font-bold text-lg uppercase shadow-lg shadow-red-100 hover:bg-red-700 transition-all mt-6">
                        Tiến hành thanh toán
                    </a>
                </div>
            </div>
        </div>

        <?php do_action( 'woocommerce_after_cart' ); ?>
    </div>
</div>

<?php get_footer(); ?>
