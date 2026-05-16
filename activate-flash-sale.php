<?php
require 'wp-load.php';

$args = array(
    'post_type' => 'product',
    'posts_per_page' => 20,
    'orderby' => 'rand'
);

$products = get_posts($args);

echo "Bắt đầu cập nhật Flash Sale...\n";

foreach ($products as $p) {
    $product = wc_get_product($p->ID);
    $regular_price = (float)$product->get_regular_price();
    
    if ($regular_price > 0) {
        $sale_price = $regular_price * 0.85; // Giảm 15%
        
        update_post_meta($p->ID, '_sale_price', $sale_price);
        update_post_meta($p->ID, '_price', $sale_price);
        
        // Cần xóa cache để WooCommerce nhận diện Sale
        delete_transient( 'wc_products_onsale' );
        
        echo " - Đã giảm giá cho: " . $p->post_title . " (" . number_format($sale_price) . "đ)\n";
    }
}

echo "XONG! Đã có 20 sản phẩm thật trong Flash Sale.";
