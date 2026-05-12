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
