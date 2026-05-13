<?php
/**
 * Ajax Add to Cart for Single Product
 */

function miliwebseo_ajax_add_to_cart() {
    $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
    $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
    $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
    $product_status = get_post_status($product_id);

    if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity) && 'publish' === $product_status) {
        do_action('woocommerce_ajax_added_to_cart', $product_id);

        if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
            wc_add_to_cart_message(array($product_id => $quantity), true);
        }

        $data = array(
            'cart_count'  => WC()->cart->get_cart_contents_count(),
            'message'     => 'Đã thêm sản phẩm vào giỏ hàng thành công!'
        );

        wp_send_json_success($data);
    } else {
        $data = array(
            'message' => 'Có lỗi xảy ra, vui lòng thử lại.'
        );
        wp_send_json_error($data);
    }
    wp_die();
}
add_action('wp_ajax_miliwebseo_ajax_add_to_cart', 'miliwebseo_ajax_add_to_cart');
add_action('wp_ajax_nopriv_miliwebseo_ajax_add_to_cart', 'miliwebseo_ajax_add_to_cart');
