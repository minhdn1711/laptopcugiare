<?php
/**
 * Enqueue scripts and styles
 */

// Alpine.js: load từ CDN với defer – TRƯỚC mọi script khác
add_action('wp_head', function() {
    echo '<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>' . "\n";
}, 1);

function miliwebseo_scripts() {
    $version = MILIWEBSEO_VERSION;
    $is_dev  = defined('MILIWEBSEO_DEV') && MILIWEBSEO_DEV;

    if ($is_dev) {
        wp_enqueue_script('miliwebseo-vite', 'http://localhost:5173/@vite/client', [], null);
        wp_enqueue_script('miliwebseo-main', 'http://localhost:5173/src/main.js', [], null, true);
    } else {
        // CSS
        $style_path = MILIWEBSEO_DIR . '/dist/assets/style.css';
        if (file_exists($style_path)) {
            wp_enqueue_style('miliwebseo-style', MILIWEBSEO_URI . '/dist/assets/style.css', [], $version);
        }

        // JS module (Vite build – ESM format, cần type=module)
        $script_path = MILIWEBSEO_DIR . '/dist/assets/main.js';
        if (file_exists($script_path)) {
            wp_enqueue_script('miliwebseo-main', MILIWEBSEO_URI . '/dist/assets/main.js', [], $version, true);
        }
    }

    // Splide.js
    wp_enqueue_style('splide-css', 'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css', [], '4.1.4');
    wp_enqueue_script('splide-js', 'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js', [], '4.1.4', true);

    // Truyền ajax_url ra ngoài (dùng inline script để tránh phụ thuộc vào handle)
    wp_add_inline_script('splide-js', 'var miliwebseo_ajax = "' . esc_js(admin_url('admin-ajax.php')) . '";', 'before');
}
add_action('wp_enqueue_scripts', 'miliwebseo_scripts');

// Thêm type="module" cho Vite-built main.js
add_filter('script_loader_tag', function($tag, $handle) {
    if ($handle === 'miliwebseo-main') {
        return str_replace('<script ', '<script type="module" ', $tag);
    }
    return $tag;
}, 10, 2);
