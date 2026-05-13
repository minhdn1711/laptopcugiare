<?php
/**
 * Script to seed specifications for all laptop products
 */
require_once 'wp-load.php';

if ( ! function_exists( 'wp_insert_term' ) ) {
    require_once ABSPATH . 'wp-admin/includes/taxonomy.php';
}

echo "Starting seeding for Product Specifications...\n";

$taxonomies = ['pa_brand', 'cpu', 'ram', 'ssd', 'vga'];

// 1. Ensure taxonomies are registered (just in case)
foreach ($taxonomies as $tax) {
    if (!taxonomy_exists($tax)) {
        register_taxonomy($tax, 'product');
    }
}

// 2. Define common specs for seeding
$specs_pool = [
    'cpu' => ['Core i3', 'Core i5', 'Core i7', 'Core i9', 'Ryzen 5', 'Ryzen 7', 'Apple M1', 'Apple M2'],
    'ram' => ['8GB', '16GB', '32GB', '64GB'],
    'ssd' => ['256GB', '512GB', '1TB', '2TB'],
    'vga' => ['Intel Graphics', 'RTX 3050', 'RTX 3060', 'RTX 4050', 'RTX 4060', 'GTX 1650', 'AMD Radeon'],
    'pa_brand' => ['Dell', 'HP', 'Asus', 'Lenovo', 'MSI', 'Acer', 'Apple', 'Gigabyte']
];

$products = get_posts(['post_type' => 'product', 'posts_per_page' => -1]);

foreach ($products as $product) {
    $title = $product->post_title;
    $product_id = $product->ID;
    
    echo "Processing: $title...\n";

    // Detect Brand
    foreach ($specs_pool['pa_brand'] as $brand) {
        if (stripos($title, $brand) !== false) {
            wp_set_object_terms($product_id, $brand, 'pa_brand');
            break;
        }
    }

    // Detect CPU
    $cpu_found = false;
    foreach ($specs_pool['cpu'] as $cpu) {
        if (stripos($title, $cpu) !== false) {
            wp_set_object_terms($product_id, $cpu, 'cpu');
            $cpu_found = true;
            break;
        }
    }
    if (!$cpu_found) wp_set_object_terms($product_id, 'Core i5', 'cpu'); // Default

    // Detect RAM
    $ram_found = false;
    foreach ($specs_pool['ram'] as $ram) {
        if (stripos($title, $ram) !== false) {
            wp_set_object_terms($product_id, $ram, 'ram');
            $ram_found = true;
            break;
        }
    }
    if (!$ram_found) wp_set_object_terms($product_id, '8GB', 'ram'); // Default

    // Detect SSD
    $ssd_found = false;
    foreach ($specs_pool['ssd'] as $ssd) {
        if (stripos($title, $ssd) !== false) {
            wp_set_object_terms($product_id, $ssd, 'ssd');
            $ssd_found = true;
            break;
        }
    }
    if (!$ssd_found) wp_set_object_terms($product_id, '256GB', 'ssd'); // Default

    // Detect VGA
    $vga_found = false;
    foreach ($specs_pool['vga'] as $vga) {
        if (stripos($title, $vga) !== false) {
            wp_set_object_terms($product_id, $vga, 'vga');
            $vga_found = true;
            break;
        }
    }
    if (!$vga_found) {
        if (stripos($title, 'Gaming') !== false) {
            wp_set_object_terms($product_id, 'RTX 3050', 'vga');
        } else {
            wp_set_object_terms($product_id, 'Intel Graphics', 'vga');
        }
    }
}

echo "Finished seeding specs for " . count($products) . " products.\n";
