<?php
/**
 * Seeding script for Office Laptops
 */
require_once( 'wp-load.php' );

if ( ! function_exists( 'wp_insert_post' ) ) {
    exit;
}

function seed_office_laptops() {
    $term_name = 'Học tập - Văn phòng';
    $term_slug = 'office';
    $taxonomy = 'usage_needs';

    // 1. Ensure Term Exists
    $term = get_term_by('slug', $term_slug, $taxonomy);
    if (!$term) {
        $term = wp_insert_term($term_name, $taxonomy, ['slug' => $term_slug]);
        echo "Created taxonomy term: $term_name\n";
    } else {
        echo "Taxonomy term already exists: $term_name\n";
    }
    
    $term_id = is_array($term) ? $term['term_id'] : $term->term_id;

    $products = [
        [
            'title' => 'Laptop Dell Latitude 7420 Core i5-1135G7',
            'price' => '12500000',
            'regular_price' => '14500000',
            'image' => 'https://laptop88.vn/media/product/6420_dell_latitude_7420.jpg'
        ],
        [
            'title' => 'HP Elitebook 840 G8 Sang trọng - Bền bỉ',
            'price' => '13900000',
            'regular_price' => '15500000',
            'image' => 'https://laptop88.vn/media/product/6421_hp_elitebook_840_g8.jpg'
        ],
        [
            'title' => 'Lenovo ThinkPad T14 Gen 2 Siêu bền',
            'price' => '15800000',
            'regular_price' => '17500000',
            'image' => 'https://laptop88.vn/media/product/6422_thinkpad_t14_gen_2.jpg'
        ],
        [
            'title' => 'Asus Vivobook 15 OLED Màn cực đẹp',
            'price' => '11900000',
            'regular_price' => '13500000',
            'image' => 'https://laptop88.vn/media/product/6423_asus_vivobook_15.jpg'
        ],
        [
            'title' => 'Acer Swift 3 SF314 Mỏng nhẹ cao cấp',
            'price' => '14200000',
            'regular_price' => '16000000',
            'image' => 'https://laptop88.vn/media/product/6424_acer_swift_3.jpg'
        ]
    ];

    foreach ($products as $p) {
        // Check if product already exists
        $existing = get_page_by_title($p['title'], OBJECT, 'product');
        if ($existing) {
            echo "Skipping existing product: {$p['title']}\n";
            continue;
        }

        $post_id = wp_insert_post([
            'post_title'    => $p['title'],
            'post_content'  => 'Mô tả chi tiết sản phẩm ' . $p['title'],
            'post_status'   => 'publish',
            'post_type'     => 'product',
        ]);

        if ($post_id) {
            update_post_meta($post_id, '_price', $p['price']);
            update_post_meta($post_id, '_regular_price', $p['regular_price']);
            update_post_meta($post_id, '_sale_price', $p['price']);
            update_post_meta($post_id, '_sku', 'OFFICE-' . $post_id);
            update_post_meta($post_id, '_manage_stock', 'no');
            update_post_meta($post_id, '_stock_status', 'instock');
            update_post_meta($post_id, '_visibility', 'visible');

            // Set Taxonomy
            wp_set_object_terms($post_id, (int)$term_id, $taxonomy);
            
            echo "Successfully seeded: {$p['title']}\n";
        }
    }
}

seed_office_laptops();
