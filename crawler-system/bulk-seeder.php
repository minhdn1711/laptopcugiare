<?php
/**
 * Bulk Seeder v3 - Hệ thống Seeder Meta Data hoàn chỉnh
 * Hỗ trợ: Mega Menu, SEO, Root Group Logic
 */
require_once( dirname(__DIR__) . '/wp-load.php' );

if ( php_sapi_name() !== 'cli' && !current_user_can('manage_options') ) die('Unauthorized');

echo "--- STARTING ADVANCED SEEDER (3-LEVEL TREE + FULL METADATA) ---\n";

// Cấu hình Master Data cho Root Categories (Level 1)
$master_cats = [
    'Laptop' => [
        'root_group' => 'it_devices',
        'icon' => 'laptop-icon.svg',
        'menu_title' => 'Máy tính xách tay',
        'featured' => 1,
        'order_index' => 1
    ],
    'Apple' => [
        'root_group' => 'it_devices',
        'icon' => 'apple-icon.svg',
        'menu_title' => 'Sản phẩm Apple',
        'featured' => 1,
        'order_index' => 2
    ],
    'PC - Máy tính để bàn' => [
        'root_group' => 'it_devices',
        'icon' => 'pc-icon.svg',
        'menu_title' => 'Máy tính để bàn',
        'featured' => 0,
        'order_index' => 3
    ]
];

$brands = [
    'Laptop' => [
        'Asus' => ['ROG', 'TUF', 'Zenbook'],
        'Dell' => ['XPS', 'Precision', 'Latitude'],
        'HP' => ['Spectre', 'Envy', 'Victus']
    ],
    'Apple' => [
        'Macbook' => ['Macbook Air', 'Macbook Pro'],
        'iPad' => ['iPad Pro', 'iPad Air']
    ]
];

function seed_category_with_meta($name, $parent_id = 0, $level = 1, $extra_meta = []) {
    $term = get_term_by('name', $name, 'product_cat');
    $slug = sanitize_title($name);
    
    if (!$term) {
        $result = wp_insert_term($name, 'product_cat', [
            'slug' => $slug,
            'parent' => $parent_id
        ]);
        if (is_wp_error($result)) return 0;
        $term_id = $result['term_id'];
    } else {
        $term_id = $term->term_id;
    }

    // Gán FULL Metadata theo yêu cầu
    update_term_meta($term_id, 'level', $level);
    update_term_meta($term_id, 'root_group', $extra_meta['root_group'] ?? '');
    update_term_meta($term_id, 'icon', $extra_meta['icon'] ?? '');
    update_term_meta($term_id, 'thumbnail', $extra_meta['thumbnail'] ?? '');
    update_term_meta($term_id, 'order_index', $extra_meta['order_index'] ?? 0);
    update_term_meta($term_id, 'featured', $extra_meta['featured'] ?? 0);
    update_term_meta($term_id, 'show_in_mega', 1);
    update_term_meta($term_id, 'mega_column', rand(1, 4));
    update_term_meta($term_id, 'menu_title', $extra_meta['menu_title'] ?? $name);
    update_term_meta($term_id, 'seo_title', "$name Chính Hãng, Giá Rẻ Nhất - Laptop Cũ Giá Rẻ");
    update_term_meta($term_id, 'seo_description', "Mua $name uy tín, bảo hành dài hạn. Hỗ trợ trả góp 0%, giao hàng toàn quốc.");
    
    return $term_id;
}

// 1. Seed Categories first
echo "Seeding categories with metadata...\n";
$cat_map = [];
foreach ($brands as $l1_name => $l2_list) {
    $l1_meta = $master_cats[$l1_name] ?? ['root_group' => 'it_devices'];
    $l1_id = seed_category_with_meta($l1_name, 0, 1, $l1_meta);
    
    foreach ($l2_list as $l2_name => $l3_list) {
        $l2_id = seed_category_with_meta($l2_name, $l1_id, 2, ['root_group' => $l1_meta['root_group']]);
        
        foreach ($l3_list as $l3_name) {
            $l3_id = seed_category_with_meta($l3_name, $l2_id, 3, ['root_group' => $l1_meta['root_group']]);
            $cat_map[$l1_name][$l2_name][$l3_name] = [$l1_id, $l2_id, $l3_id];
        }
    }
}

// 2. Seed Products
echo "Seeding 500 products...\n";
for ($i = 0; $i < 500; $i++) {
    $l1_name = array_rand($cat_map);
    $l2_name = array_rand($cat_map[$l1_name]);
    $l3_name = array_rand($cat_map[$l1_name][$l2_name]);
    $ids = $cat_map[$l1_name][$l2_name][$l3_name];

    $title = "Laptop $l2_name $l3_name Phiên bản 2024 - " . $i;
    $post_id = wp_insert_post([
        'post_title' => $title,
        'post_type'  => 'product',
        'post_status'=> 'publish'
    ]);
    
    if ($post_id) {
        update_post_meta($post_id, '_price', rand(15, 60) * 1000000);
        wp_set_object_terms($post_id, $ids, 'product_cat');
        
        if ($i % 100 === 0) echo "Progress: $i / 500...\n";
    }
}

echo "--- COMPLETED SUCCESSFULY ---";
