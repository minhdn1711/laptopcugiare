<?php
/**
 * Advanced Hybrid Mega Menu System for Miliwebseo
 * Handling AJAX, Caching, and Grid Rendering
 */

/**
 * 1. AJAX Endpoint for Loading Submenu
 */
add_action('wp_ajax_load_mega_menu', 'miliwebseo_ajax_load_mega_menu');
add_action('wp_ajax_nopriv_load_mega_menu', 'miliwebseo_ajax_load_mega_menu');

function miliwebseo_ajax_load_mega_menu() {
    $parent_id = isset($_POST['parent_id']) ? absint($_POST['parent_id']) : 0;
    error_log('Mega Menu AJAX called for ID: ' . $parent_id);
    
    if (!$parent_id) wp_send_json_error('Invalid Parent ID');

    $transient_key = 'miliwebseo_mega_menu_' . $parent_id;
    $html = get_transient($transient_key);

    if (false === $html) {
        error_log('Mega Menu Cache Miss for ID: ' . $parent_id);
        ob_start();
        miliwebseo_render_mega_menu_content($parent_id);
        $html = ob_get_clean();
        
        if (empty($html)) {
            error_log('Mega Menu Render EMPTY for ID: ' . $parent_id);
        }

        set_transient($transient_key, $html, 24 * HOUR_IN_SECONDS);
    } else {
        error_log('Mega Menu Cache Hit for ID: ' . $parent_id);
    }

    wp_send_json_success($html);
}

/**
 * 2. Main Rendering Logic (Grid 5 Columns)
 */
function miliwebseo_render_mega_menu_content($parent_id) {
    // Get Level 2 (Brands) - Simplified query to ensure visibility
    $brands = get_terms([
        'taxonomy'   => 'product_cat',
        'parent'     => $parent_id,
        'hide_empty' => false,
        'orderby'    => 'name',
        'order'      => 'ASC'
    ]);

    if (empty($brands)) {
        echo '<div class="p-10 text-center text-gray-400 italic">Đang cập nhật dữ liệu cho danh mục này...</div>';
        return;
    }

    echo '<div class="grid grid-cols-5 gap-8 p-8 bg-white shadow-2xl border-t border-gray-100 rounded-b-xl">';
    
    // Column 1-4: Content Area
    echo '<div class="col-span-4 grid grid-cols-4 gap-6">';
    foreach ($brands as $brand) {
        echo '<div class="space-y-4">';
        // Brand Title (Level 2)
        echo '<a href="' . get_term_link($brand) . '" class="block font-black text-secondary hover:text-primary transition-colors text-sm uppercase tracking-tight">' . $brand->name . '</a>';
        
        // Get Level 3 (Series)
        $series_list = get_terms([
            'taxonomy'   => 'product_cat',
            'parent'     => $brand->term_id,
            'hide_empty' => false,
            'orderby'    => 'name',
            'order'      => 'ASC'
        ]);

        if (!empty($series_list)) {
            echo '<ul class="space-y-2">';
            foreach ($series_list as $series) {
                echo '<li><a href="' . get_term_link($series) . '" class="text-gray-500 hover:text-secondary text-xs transition-all flex items-center gap-2 group">
                    <span class="w-1 h-1 bg-gray-300 rounded-full group-hover:bg-primary transition-colors"></span>
                    ' . $series->name . '
                </a></li>';
            }
            echo '</ul>';
        }
        echo '</div>';
    }
    echo '</div>';

    // Column 5: Featured Banner
    $banner_url = get_term_meta($parent_id, 'menu_banner_url', true);
    if (!$banner_url) {
        $banner_url = 'https://placehold.co/300x500/111827/FFFFFF?text=Laptop+Cũ+Giá+Rẻ';
    }
    
    echo '<div class="col-span-1 border-l border-gray-100 pl-8 flex flex-col justify-between">';
    echo '  <div class="relative overflow-hidden rounded-lg group">';
    echo '      <img src="' . esc_url($banner_url) . '" class="w-full h-auto object-cover transform group-hover:scale-110 transition-transform duration-700">';
    echo '      <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-4">';
    echo '          <p class="text-white font-bold text-xs">Ưu đãi giảm giá 20%</p>';
    echo '      </div>';
    echo '  </div>';
    echo '</div>';

    echo '</div>';
}

/**
 * 3. Cache Management (Clear on Update)
 */
function miliwebseo_clear_mega_menu_transients() {
    global $wpdb;
    $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_miliwebseo_mega_menu_%'");
    $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_timeout_miliwebseo_mega_menu_%'");
}
add_action('edited_product_cat', 'miliwebseo_clear_mega_menu_transients');
add_action('created_product_cat', 'miliwebseo_clear_mega_menu_transients');
add_action('delete_product_cat', 'miliwebseo_clear_mega_menu_transients');
