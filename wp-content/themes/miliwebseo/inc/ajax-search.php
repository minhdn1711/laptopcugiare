<?php
/**
 * Ajax Search Implementation - OPTIMIZED
 */

function miliwebseo_ajax_search() {
    $search_query = isset($_POST['query']) ? sanitize_text_field($_POST['query']) : '';
    
    // Limit search query length to prevent abuse
    if (strlen($search_query) < 2 || strlen($search_query) > 100) {
        wp_send_json_error(['message' => 'Invalid search query']);
        return;
    }

    $args = array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => 5, // Limit to 5 results
        's'              => $search_query,
        // Performance: don't load full post content
        'suppress_filters' => false,
    );

    $query = new WP_Query($args);
    $results = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            global $product;
            
            $results[] = array(
                'title' => get_the_title(),
                'url'   => get_permalink(),
                'price' => $product ? $product->get_price_html() : '',
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'),
            );
        }
    }

    wp_reset_postdata();
    wp_send_json_success($results);
    wp_die();
}

add_action('wp_ajax_nopriv_miliwebseo_search', 'miliwebseo_ajax_search');
add_action('wp_ajax_miliwebseo_search', 'miliwebseo_ajax_search');
