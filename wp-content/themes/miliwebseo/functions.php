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
define( 'MILIWEBSEO_DEV', false ); // Set to false for production

/**
 * Setup Theme
 */
function miliwebseo_setup() {
	// Add support for various features
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

	// Register Menus
	register_nav_menus( array(
		'primary'   => __( 'Primary Menu', 'miliwebseo' ),
		'footer'    => __( 'Footer Menu', 'miliwebseo' ),
		'mobile'    => __( 'Mobile Menu', 'miliwebseo' ),
		'mega_menu' => __( 'Mega Menu', 'miliwebseo' ),
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
require MILIWEBSEO_DIR . '/inc/icons.php';

/**
 * Custom Quantity Buttons Script
 */
function miliwebseo_quantity_script() {
    ?>
    <script>
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('qty-btn')) {
            const btn = e.target;
            const input = btn.parentElement.querySelector('input.qty');
            const val = parseInt(input.value);
            const step = parseInt(input.getAttribute('step') || 1);
            const min = parseInt(input.getAttribute('min') || 1);
            const max = parseInt(input.getAttribute('max') || 999);

            if (btn.classList.contains('plus')) {
                if (val + step <= max) input.value = val + step;
            } else {
                if (val - step >= min) input.value = val - step;
            }
            input.dispatchEvent(new Event('change', { bubbles: true }));
        }
    });
    </script>
    <style>
        .quantity { display: flex !important; align-items: center; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; width: fit-content; }
        .quantity input.qty { border: none !important; width: 50px !important; text-align: center; font-weight: bold; padding: 8px 0 !important; -moz-appearance: textfield; }
        .quantity input.qty::-webkit-outer-spin-button, .quantity input.qty::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
        .qty-btn { background: #f8fafc; border: none; width: 35px; height: 100%; cursor: pointer; font-size: 18px; transition: background 0.2s; display: flex; align-items: center; justify-content: center; }
        .qty-btn:hover { background: #e2e8f0; }
    </style>
    <?php
}
add_action('wp_footer', 'miliwebseo_quantity_script');
