<?php
/**
 * Enqueue scripts and styles
 */
function miliwebseo_scripts() {
    $version = MILIWEBSEO_VERSION;
    $is_dev = defined( 'MILIWEBSEO_DEV' ) && MILIWEBSEO_DEV;

    if ( $is_dev ) {
        // Vite Dev Server
        wp_enqueue_script( 'miliwebseo-vite', 'http://localhost:5173/@vite/client', array(), null );
        wp_enqueue_script( 'miliwebseo-main', 'http://localhost:5173/src/main.js', array(), null, true );
    } else {
        // Production Assets
        $style_path = MILIWEBSEO_DIR . '/dist/assets/style.css';
        $script_path = MILIWEBSEO_DIR . '/dist/assets/main.js';

        if ( file_exists( $style_path ) ) {
            wp_enqueue_style( 'miliwebseo-main', MILIWEBSEO_URI . '/dist/assets/style.css', array(), $version );
        }
        if ( file_exists( $script_path ) ) {
            wp_enqueue_script( 'miliwebseo-main', MILIWEBSEO_URI . '/dist/assets/main.js', array(), $version, true );
        }
    }

    // Splide.js
    wp_enqueue_style( 'splide-css', 'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css', array(), '4.1.4' );
    wp_enqueue_script( 'splide-js', 'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js', array(), '4.1.4', true );

    // Alpine.js
    wp_enqueue_script( 'alpine-js', 'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js', array(), '3.x.x', true );

    // Localize for Ajax
    wp_localize_script( 'miliwebseo-main', 'miliwebseo_data', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'miliwebseo_scripts' );
