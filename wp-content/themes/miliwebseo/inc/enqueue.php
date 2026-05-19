<?php
/**
 * Enqueue scripts and styles - OPTIMIZED FOR PERFORMANCE
 */

// ──────────────────────────────────────────────────────────────
// 1. PRECONNECT + PRELOAD (wp_head, priority 2)
// ──────────────────────────────────────────────────────────────
add_action('wp_head', function() {
    // Preconnect to CDN domains (reduce DNS lookup latency)
    echo '<link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>' . "\n";
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
    
    // Non-blocking Google Fonts load
    echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" media="print" onload="this.media=\'all\'">' . "\n";
    echo '<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"></noscript>' . "\n";
    
    // Preload Alpine.js (critical for interactivity)
    echo '<link rel="preload" href="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js" as="script">' . "\n";
}, 2);

// ──────────────────────────────────────────────────────────────
// 2. Alpine.js: load từ CDN với defer – TRƯỚC mọi script khác
// ──────────────────────────────────────────────────────────────
add_action('wp_head', function() {
    echo '<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>' . "\n";
}, 1);

// ──────────────────────────────────────────────────────────────
// 3. MAIN THEME ASSETS (CSS + JS Module)
// ──────────────────────────────────────────────────────────────
function miliwebseo_scripts() {
    $version = MILIWEBSEO_VERSION;
    $is_dev  = defined('MILIWEBSEO_DEV') && MILIWEBSEO_DEV;

    if ($is_dev) {
        wp_enqueue_script('miliwebseo-vite', 'http://localhost:5173/@vite/client', [], null);
        wp_enqueue_script('miliwebseo-main', 'http://localhost:5173/src/main.js', [], null, true);
    } else {
        // Load production CSS with hash for cache busting
        $style_dir = MILIWEBSEO_DIR . '/dist/assets';
        if (is_dir($style_dir)) {
            $css_files = glob($style_dir . '/style-*.css');
            if (!empty($css_files)) {
                $css_file = basename($css_files[0]); // style-HASH.css
                wp_enqueue_style('miliwebseo-style', MILIWEBSEO_URI . '/dist/assets/' . $css_file, [], null);
            }
        }

        // Load production JS with hash for cache busting
        $js_files = glob($style_dir . '/main-*.js');
        if (!empty($js_files)) {
            $js_file = basename($js_files[0]); // main-HASH.js
            wp_enqueue_script('miliwebseo-main', MILIWEBSEO_URI . '/dist/assets/' . $js_file, [], null, true);
        }
    }

    // Localize AJAX variables (MUST be after enqueue)
    wp_localize_script('miliwebseo-main', 'miliwebseo_vars', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('miliwebseo_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'miliwebseo_scripts');

// ──────────────────────────────────────────────────────────────
// 8. SECURITY: Add nonce for AJAX requests (fallback)
// ──────────────────────────────────────────────────────────────
add_action('wp_footer', function() {
    echo '<script>var miliwebseo_ajax = "' . esc_js(admin_url('admin-ajax.php')) . '";</script>' . "\n";
});

// ──────────────────────────────────────────────────────────────
// 4. CONDITIONAL SPLIDE.JS (ONLY ON HOMEPAGE)
// ──────────────────────────────────────────────────────────────
function miliwebseo_splide_scripts() {
    // Only load on front page where hero slider is used
    if (!is_front_page()) {
        return;
    }

    // Lazy load Splide CSS (media="print" → async onload trick)
    wp_enqueue_style(
        'splide-css', 
        'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css', 
        [], 
        '4.1.4'
    );
    
    // Load Splide JS with defer (async would be better but needs module pattern)
    wp_enqueue_script(
        'splide-js', 
        'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js', 
        [], 
        '4.1.4', 
        true  // Footer placement for defer effect
    );
}
add_action('wp_enqueue_scripts', 'miliwebseo_splide_scripts');

// ──────────────────────────────────────────────────────────────
// 5. CONDITIONAL WOOCOMMERCE ASSETS (ONLY WHERE NEEDED)
// ──────────────────────────────────────────────────────────────
add_action('wp_enqueue_scripts', function() {
    $should_load_wc = (
        is_shop() || 
        is_product() || 
        is_product_category() || 
        is_product_tag() || 
        is_cart() || 
        is_checkout() || 
        is_account_page()
    );

    if (!$should_load_wc) {
        // Remove WooCommerce styles on non-shop pages
        wp_dequeue_style('woocommerce-general');
        wp_dequeue_style('woocommerce-layout');
        wp_dequeue_style('woocommerce-smallscreen');
        wp_dequeue_style('woocommerce-frontend-rtl');
        
        // Remove WooCommerce scripts
        wp_dequeue_script('wc-add-to-cart');
        wp_dequeue_script('wc-add-to-cart-variation');
        wp_dequeue_script('wc-single-product');
        wp_dequeue_script('woocommerce');
        wp_dequeue_script('wc-checkout');
        wp_dequeue_script('wc-cart');
    }
}, 100); // High priority to override WooCommerce's enqueue

// ──────────────────────────────────────────────────────────────
// 6. OPTIMIZE SCRIPT TAGS (add module, defer, async attributes)
// ──────────────────────────────────────────────────────────────
add_filter('script_loader_tag', function($tag, $handle) {
    // Add type="module" to Vite-built main.js
    if ($handle === 'miliwebseo-main') {
        return str_replace('<script ', '<script type="module" defer ', $tag);
    }
    
    // Async load non-critical scripts
    if (in_array($handle, ['splide-js'])) {
        // Already deferred by footer placement, mark as async if safe
        return str_replace('<script ', '<script async ', $tag);
    }
    
    return $tag;
}, 10, 2);

// ──────────────────────────────────────────────────────────────
// 7. REMOVE UNNECESSARY WORDPRESS ASSETS
// ──────────────────────────────────────────────────────────────
add_action('wp_head', function() {
    // Remove emoji scripts (not needed for laptop store)
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
}, 100);

add_action('wp_enqueue_scripts', function() {
    // Remove jQuery on non-checkout pages (checkout forms need jQuery toggle)
    if (!is_checkout() && !is_cart() && !is_admin()) {
        wp_dequeue_script('jquery');
    }
}, 100);

// Disable XML-RPC if not needed
add_filter('xmlrpc_enabled', '__return_false');
