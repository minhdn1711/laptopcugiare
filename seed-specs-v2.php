<?php
/**
 * Script to seed Brand and Screen Size for all products
 */
require_once 'wp-load.php';

if ( ! function_exists( 'wp_insert_term' ) ) {
    require_once ABSPATH . 'wp-admin/includes/taxonomy.php';
}

echo "Starting seeding for Brand and Screen Size...\n";

$products = get_posts(['post_type' => 'product', 'posts_per_page' => -1]);

foreach ($products as $product) {
    $title = $product->post_title;
    $product_id = $product->ID;
    
    echo "Processing: $title...\n";

    // 1. Detect Brand (taxonomy: 'brand')
    $brands = ['Dell', 'Asus', 'HP', 'Lenovo', 'MSI', 'Acer', 'Apple', 'Gigabyte', 'Macbook'];
    foreach ($brands as $brand) {
        if (stripos($title, $brand) !== false) {
            $brand_name = ($brand === 'Macbook' || $brand === 'Apple') ? 'Apple' : $brand;
            wp_set_object_terms($product_id, $brand_name, 'brand');
            echo " - Set Brand: $brand_name\n";
            break;
        }
    }

    // 2. Detect Screen Size (taxonomy: 'screen_size')
    $screens = [
        '13.3 inch' => ['13.3', '13 inch', 'XPS 13', 'Macbook Air'],
        '14 inch'   => ['14 inch', '14"', 'T14', 'Latitude 74', 'Elitebook 84'],
        '15.6 inch' => ['15.6', '15 inch', '15"', 'Nitro 5', 'Gaming 15', 'Vivobook 15', 'Vostro 35'],
        '16 inch'   => ['16 inch', '16"', 'Pro 16'],
        '17.3 inch' => ['17.3', '17 inch', 'Precision 17']
    ];

    $screen_found = false;
    foreach ($screens as $size => $keywords) {
        foreach ($keywords as $kw) {
            if (stripos($title, $kw) !== false) {
                wp_set_object_terms($product_id, $size, 'screen_size');
                echo " - Set Screen: $size\n";
                $screen_found = true;
                break 2;
            }
        }
    }

    // Default screen size based on type
    if (!$screen_found) {
        if (stripos($title, 'Gaming') !== false) {
            wp_set_object_terms($product_id, '15.6 inch', 'screen_size');
        } else {
            wp_set_object_terms($product_id, '14 inch', 'screen_size');
        }
    }
}

echo "Finished seeding Brand and Screen Size for " . count($products) . " products.\n";
