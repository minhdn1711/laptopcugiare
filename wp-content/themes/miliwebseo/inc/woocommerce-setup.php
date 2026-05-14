<?php
/**
 * WooCommerce Customization & Optimization
 */

// Declare WooCommerce Support
function miliwebseo_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
	
	// Enable HPOS Support
	if ( class_exists( 'Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', MILIWEBSEO_DIR . '/functions.php', true );
	}
}
add_action( 'after_setup_theme', 'miliwebseo_add_woocommerce_support' );

/**
 * Hiển thị Gift/Quà tặng
 */
function miliwebseo_display_product_gifts() {
    $gifts = get_post_meta( get_the_ID(), '_product_gifts', true );
    if ( ! empty( $gifts ) ) {
        echo '<div class="product-gifts mt-2 p-2 bg-yellow-50 border border-yellow-200 rounded text-sm flex items-center gap-2">';
        echo '<span class="font-bold text-yellow-700 flex items-center gap-1">' . miliwebseo_icon('gift', 'h-4 w-4') . ' Quà tặng:</span> ' . esc_html( $gifts );
        echo '</div>';
    }
}

/**
 * Hiển thị bảng thông số nhanh trên Product Card
 */
function miliwebseo_display_quick_specs() {
    $cpu = get_the_terms( get_the_ID(), 'cpu' );
    $ram = get_the_terms( get_the_ID(), 'ram' );
    $vga = get_the_terms( get_the_ID(), 'vga' );
    $ssd = get_the_terms( get_the_ID(), 'ssd' );

    if ( $cpu || $ram || $vga || $ssd ) {
        echo '<div class="quick-specs mt-2 text-xs text-gray-600 grid grid-cols-2 gap-2">';
        if ( $cpu ) echo '<span class="flex items-center gap-1">' . miliwebseo_icon('cpu', 'h-3 w-3') . ' ' . esc_html( $cpu[0]->name ) . '</span>';
        if ( $ram ) echo '<span class="flex items-center gap-1">' . miliwebseo_icon('brain', 'h-3 w-3') . ' ' . esc_html( $ram[0]->name ) . '</span>';
        if ( $vga ) echo '<span class="flex items-center gap-1">' . miliwebseo_icon('gamepad-2', 'h-3 w-3') . ' ' . esc_html( $vga[0]->name ) . '</span>';
        if ( $ssd ) echo '<span class="flex items-center gap-1">' . miliwebseo_icon('hard-drive', 'h-3 w-3') . ' ' . esc_html( $ssd[0]->name ) . '</span>';
        echo '</div>';
    }
}
