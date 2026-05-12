<?php
/**
 * Seeder Script for Laptop Store
 * Run this via browser or WP-CLI
 */

require_once( 'wp-load.php' );

if ( ! current_user_can( 'manage_options' ) && php_sapi_name() !== 'cli' ) {
    die( 'Unauthorized' );
}

echo "Starting Seeding...\n";

// 1. Create Terms
$taxonomies_data = array(
    'brand' => array( 'Dell', 'HP', 'Apple', 'Asus', 'Acer', 'Lenovo', 'MSI' ),
    'cpu'   => array( 'Core i3', 'Core i5', 'Core i7', 'Core i9', 'Ryzen 5', 'Ryzen 7', 'Apple M1', 'Apple M2', 'Apple M3' ),
    'ram'   => array( '8GB', '16GB', '32GB', '64GB' ),
    'ssd'   => array( '256GB', '512GB', '1TB', '2TB' ),
    'vga'   => array( 'Intel Iris Xe', 'RTX 3050', 'RTX 4050', 'RTX 4060', 'RTX 4070', 'Apple GPU' ),
    'screen_size' => array( '13.3"', '14"', '15.6"', '16"' ),
    'usage_needs' => array( 'Gaming', 'Văn phòng', 'Đồ họa', 'AI', 'Sinh viên', 'Mỏng nhẹ' ),
);

foreach ( $taxonomies_data as $tax => $terms ) {
    foreach ( $terms as $term ) {
        if ( ! term_exists( $term, $tax ) ) {
            wp_insert_term( $term, $tax );
            echo "Created term: $term in $tax\n";
        }
    }
}

// 2. Create Products
$laptop_models = array(
    'Dell' => array( 'XPS 13', 'XPS 15', 'Precision 5570', 'Inspiron 16', 'G15 Gaming' ),
    'HP'   => array( 'Spectre x360', 'Envy 13', 'Pavilion 15', 'Victus 16', 'Omen 17' ),
    'Apple' => array( 'MacBook Air M1', 'MacBook Air M2', 'MacBook Pro 14', 'MacBook Pro 16' ),
    'Asus' => array( 'Zenbook 14', 'Vivobook 15', 'ROG Zephyrus G14', 'TUF Gaming F15' ),
    'Lenovo' => array( 'ThinkPad X1 Carbon', 'Yoga 7i', 'Legion 5 Pro', 'IdeaPad 3' ),
);

for ( $i = 1; $i <= 50; $i++ ) {
    $brand_names = array_keys( $laptop_models );
    $brand = $brand_names[ array_rand( $brand_names ) ];
    $model = $laptop_models[$brand][ array_rand( $laptop_models[$brand] ) ];
    
    $cpu = $taxonomies_data['cpu'][ array_rand( $taxonomies_data['cpu'] ) ];
    $ram = $taxonomies_data['ram'][ array_rand( $taxonomies_data['ram'] ) ];
    $ssd = $taxonomies_data['ssd'][ array_rand( $taxonomies_data['ssd'] ) ];
    
    $title = "Laptop $brand $model ($cpu / $ram / $ssd)";
    $price = rand( 15, 60 ) * 1000000;
    
    $product_id = wp_insert_post( array(
        'post_title'   => $title,
        'post_content' => "Cấu hình chi tiết cho $title. Đây là sản phẩm chất lượng cao từ $brand.",
        'post_status'  => 'publish',
        'post_type'    => 'product',
    ) );
    
    if ( $product_id ) {
        update_post_meta( $product_id, '_regular_price', $price );
        update_post_meta( $product_id, '_price', $price );
        update_post_meta( $product_id, '_stock_status', 'instock' );
        update_post_meta( $product_id, '_product_gifts', 'Chuột không dây + Balo laptop + Lót chuột' );
        
        // Set Taxonomies
        wp_set_object_terms( $product_id, $brand, 'brand' );
        wp_set_object_terms( $product_id, $cpu, 'cpu' );
        wp_set_object_terms( $product_id, $ram, 'ram' );
        wp_set_object_terms( $product_id, $ssd, 'ssd' );
        
        echo "Created product: $title (ID: $product_id)\n";
    }
}

echo "Seeding Completed!";
