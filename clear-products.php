<?php
/**
 * Clear All Product Data Script
 */
require_once( 'wp-load.php' );

if ( php_sapi_name() !== 'cli' ) {
    // If not CLI, check for admin or a secret key for safety
    if ( ! current_user_can( 'manage_options' ) ) {
        die( 'Unauthorized' );
    }
}

echo "--- STARTING DATA CLEARING ---\n";

// 1. Delete all products
$products = get_posts([
    'post_type' => 'product',
    'numberposts' => -1,
    'post_status' => 'any',
    'fields' => 'ids'
]);

echo "Found " . count($products) . " products to delete.\n";
foreach ($products as $id) {
    wp_delete_post($id, true); // true = force delete from trash
    echo "Deleted product ID: $id\n";
}

// 2. Taxonomies to clear
$taxonomies = [
    'product_cat',
    'product_brand',
    'product_series',
    'usage_needs',
    'cpu',
    'ram',
    'ssd',
    'vga',
    'screen_size'
];

foreach ($taxonomies as $tax) {
    $terms = get_terms([
        'taxonomy' => $tax,
        'hide_empty' => false,
    ]);
    
    if (!is_wp_error($terms) && !empty($terms)) {
        echo "Clearing $tax: found " . count($terms) . " terms.\n";
        foreach ($terms as $term) {
            // Skip default category if needed, but usually we want all gone
            wp_delete_term($term->term_id, $tax);
            echo "  - Deleted term: {$term->name}\n";
        }
    }
}

echo "--- ALL PRODUCT DATA CLEARED! ---\n";
