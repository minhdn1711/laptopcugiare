<?php
/**
 * Miliwebseo theme functions and definitions
 *
 * @package Miliwebseo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define theme constants
define( 'MILIWEBSEO_VERSION', '1.0.0' );
define( 'MILIWEBSEO_DIR', get_template_directory() );
define( 'MILIWEBSEO_URI', get_template_directory_uri() );
define( 'MILIWEBSEO_DEV', false );

/**
 * Setup Theme
 */
function miliwebseo_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

	register_nav_menus( array(
		'primary'   => __( 'Primary Menu', 'miliwebseo' ),
		'footer'    => __( 'Footer Menu', 'miliwebseo' ),
		'mobile'    => __( 'Mobile Menu', 'miliwebseo' ),
		'mega_menu' => __( 'Mega Menu', 'miliwebseo' ),
		'vertical'  => __( 'Vertical Menu', 'miliwebseo' ),
	) );
}
add_action( 'after_setup_theme', 'miliwebseo_setup' );

/**
 * Include Core Logic
 */
require MILIWEBSEO_DIR . '/inc/taxonomies.php';
require MILIWEBSEO_DIR . '/inc/woocommerce-setup.php';
require MILIWEBSEO_DIR . '/inc/enqueue.php';
require MILIWEBSEO_DIR . '/inc/ajax-search.php';
require MILIWEBSEO_DIR . '/inc/helpers.php';
require MILIWEBSEO_DIR . '/inc/product-logic.php';
require MILIWEBSEO_DIR . '/inc/icons.php';
require MILIWEBSEO_DIR . '/inc/ajax-filters.php';
require MILIWEBSEO_DIR . '/inc/seo.php';
require MILIWEBSEO_DIR . '/inc/ajax-cart.php';
require MILIWEBSEO_DIR . '/inc/flash-sale.php';
// require MILIWEBSEO_DIR . '/inc/optimization.php';
// require MILIWEBSEO_DIR . '/inc/cache-helper.php';

/**
 * Enable Guest Checkout
 */
add_action('init', function() {
    update_option('woocommerce_enable_guest_checkout', 'yes');
    update_option('woocommerce_enable_checkout_login_reminder', 'no');
    update_option('woocommerce_require_login_to_checkout', 'no');
});

/**
 * Register Brand & Series Taxonomies
 */
add_action( 'init', function() {
    // Brand Taxonomy
    register_taxonomy( 'product_brand', 'product', array(
        'hierarchical'      => true,
        'label'             => 'Thương hiệu',
        'singular_label'    => 'Thương hiệu',
        'show_ui'           => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'brand' ),
        'show_in_rest'      => true,
    ) );

    // Series Taxonomy
    register_taxonomy( 'product_series', 'product', array(
        'hierarchical'      => true,
        'label'             => 'Dòng sản phẩm (Series)',
        'singular_label'    => 'Dòng sản phẩm',
        'show_ui'           => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'series' ),
        'show_in_rest'      => true,
    ) );
});

/**
 * Temporary Seeder for Product Categories
 */
add_action('init', function() {
    if (get_option('miliwebseo_full_seeded_v3')) return;

    $categories = [
        'Laptop' => [
            'Laptop văn phòng', 'Laptop gaming', 'Laptop đồ họa', 'Laptop mỏng nhẹ', 'Laptop AI', 'Laptop sinh viên', 'Laptop doanh nhân'
        ],
        'Macbook' => [
            'Macbook Air', 'Macbook Pro', 'Phụ kiện Macbook'
        ],
        'PC' => [
            'PC gaming', 'PC văn phòng', 'PC đồ họa', 'PC AI', 'Build PC'
        ],
        'Linh kiện' => [
            'CPU', 'VGA', 'RAM', 'SSD', 'HDD', 'Mainboard', 'PSU', 'Case', 'Tản nhiệt', 'Card mạng/Wifi'
        ],
        'Màn hình' => [
            'Màn hình gaming', 'Màn hình văn phòng', 'Màn hình đồ họa', 'Màn hình cong', 'Màn hình 2K', 'Màn hình 4K', 'Màn hình cũ'
        ],
        'Phụ kiện' => [
            'Chuột', 'Bàn phím', 'Tai nghe', 'Webcam', 'Loa', 'Balo laptop', 'Hub chuyển đổi', 'Đế tản nhiệt', 'Ghế gaming', 'Phần mềm bản quyền'
        ],
        'Máy cũ' => [],
        'Khuyến mãi' => []
    ];

    foreach ($categories as $parent_name => $subs) {
        $parent = wp_insert_term($parent_name, 'product_cat');
        $parent_id = is_wp_error($parent) ? ($parent->get_error_code() === 'term_exists' ? $parent->get_error_data() : 0) : $parent['term_id'];

        if ($parent_id) {
            foreach ($subs as $sub_name) {
                wp_insert_term($sub_name, 'product_cat', ['parent' => $parent_id]);
            }
        }
    }
    // Seed Brands & Series
    $brands_data = [
        'Asus' => ['ROG', 'TUF', 'Zenbook', 'Vivobook', 'ProArt'],
        'Dell' => ['XPS', 'Precision', 'Latitude', 'Inspiron', 'Vostro', 'Alienware'],
        'Lenovo' => ['ThinkPad', 'ThinkBook', 'Legion', 'Yoga', 'IdeaPad'],
        'HP' => ['EliteBook', 'ProBook', 'ZBook', 'Envy', 'Pavilion', 'Victus', 'Omen'],
        'Acer' => ['Predator', 'Nitro', 'Swift', 'Aspire'],
        'MSI' => ['Raider', 'Stealth', 'Katana', 'Modern', 'Prestige'],
        'Gigabyte' => ['Aorus', 'Aero'],
        'Apple' => ['Macbook Air', 'Macbook Pro', 'Macbook Neo', 'iPad', 'iPhone'],
        'Microsoft Surface' => ['Surface Pro', 'Surface Laptop', 'Surface Book'],
        'LG' => ['Gram'],
        'Samsung' => ['Galaxy Book'],
        'Huawei' => ['Matebook'],
        'Nvidia' => ['GeForce RTX', 'GeForce GTX', 'Quadro'],
        'AMD' => ['Radeon RX', 'Ryzen'],
        'ViewSonic' => [],
        'AOC' => [],
        'Xiaomi' => [],
        'Edra' => []
    ];

    foreach ($brands_data as $brand_name => $series_list) {
        // Insert Brand
        $brand = wp_insert_term($brand_name, 'product_brand');
        $brand_id = is_wp_error($brand) ? ($brand->get_error_code() === 'term_exists' ? $brand->get_error_data() : 0) : $brand['term_id'];

        if ($brand_id) {
            foreach ($series_list as $series_name) {
                // Insert Series
                $series = wp_insert_term($series_name, 'product_series');
                $series_id = is_wp_error($series) ? ($series->get_error_code() === 'term_exists' ? $series->get_error_data() : 0) : $series['term_id'];
                
                if ($series_id) {
                    // Link Series to Brand using term meta
                    update_term_meta($series_id, 'brand_id', $brand_id);
                }
            }
        }
    }

    update_option('miliwebseo_full_seeded_v3', true);
});
