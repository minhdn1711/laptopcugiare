<?php
/**
 * Script to seed product categories
 */
define('WP_USE_THEMES', false);
require_once('wp-load.php');

if (!function_exists('wp_insert_term')) {
    echo "WP functions not loaded.";
    exit;
}

$categories = [
    'Laptop' => [
        'Laptop văn phòng', 'Laptop gaming', 'Laptop đồ họa', 'Laptop mỏng nhẹ', 'Laptop AI', 'Laptop sinh viên', 'Laptop doanh nhân'
    ],
    'Macbook' => [
        'Macbook Air', 'Macbook Pro', 'Phụ kiện Macbook'
    ],
    'PC' => [
        'PC gaming', 'PC văn phòng', 'PC đồ họa', 'PC AI', 'Build PC'
    ],
    'Linh kiện' => [
        'CPU', 'VGA', 'RAM', 'SSD', 'HDD', 'Mainboard', 'PSU', 'Case', 'Tản nhiệt', 'Card mạng/Wifi'
    ],
    'Màn hình' => [
        'Màn hình gaming', 'Màn hình văn phòng', 'Màn hình đồ họa', 'Màn hình cong', 'Màn hình 2K', 'Màn hình 4K', 'Màn hình cũ'
    ],
    'Phụ kiện' => [
        'Chuột', 'Bàn phím', 'Tai nghe', 'Webcam', 'Loa', 'Balo laptop', 'Hub chuyển đổi', 'Đế tản nhiệt', 'Ghế gaming', 'Phần mềm bản quyền'
    ],
    'Máy cũ' => [],
    'Khuyến mãi' => []
];

foreach ($categories as $parent_name => $subs) {
    $parent = wp_insert_term($parent_name, 'product_cat');
    
    if (is_wp_error($parent)) {
        if ($parent->get_error_code() === 'term_exists') {
            $parent_id = $parent->get_error_data();
            echo "Parent exists: $parent_name (ID: $parent_id)\n";
        } else {
            echo "Error creating parent $parent_name: " . $parent->get_error_message() . "\n";
            continue;
        }
    } else {
        $parent_id = $parent['term_id'];
        echo "Created parent: $parent_name (ID: $parent_id)\n";
    }

    if ($parent_id) {
        foreach ($subs as $sub_name) {
            $sub = wp_insert_term($sub_name, 'product_cat', ['parent' => $parent_id]);
            if (is_wp_error($sub)) {
                echo "  - Sub exists or error: $sub_name\n";
            } else {
                echo "  - Created sub: $sub_name\n";
            }
        }
    }
}

echo "\nSeeding completed successfully!\n";
unlink(__FILE__); // Self-delete for security
