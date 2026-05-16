<?php
require_once( 'wp-load.php' );

echo "--- STARTING SYSTEM RESET & RE-SEED ---\n";

global $wpdb;

// 1. TRUNCATE DATA (Cực nhanh bằng SQL)
echo "1/3 Cleanning old data...\n";
$wpdb->query("DELETE FROM {$wpdb->posts} WHERE post_type IN ('product', 'product_variation', 'attachment')");
$wpdb->query("DELETE FROM {$wpdb->postmeta} WHERE post_id NOT IN (SELECT ID FROM {$wpdb->posts})");
$wpdb->query("DELETE FROM {$wpdb->term_relationships} WHERE object_id NOT IN (SELECT ID FROM {$wpdb->posts})");

// Xóa Category cũ
$wpdb->query("DELETE FROM {$wpdb->terms} WHERE term_id IN (SELECT term_id FROM {$wpdb->term_taxonomy} WHERE taxonomy IN ('product_cat', 'product_brand', 'product_series', 'usage_needs'))");
$wpdb->query("DELETE FROM {$wpdb->term_taxonomy} WHERE taxonomy IN ('product_cat', 'product_brand', 'product_series', 'usage_needs')");
$wpdb->query("DELETE FROM {$wpdb->termmeta} WHERE term_id NOT IN (SELECT term_id FROM {$wpdb->terms})");

// Xóa Cache Mega Menu
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_miliwebseo_mega_menu_%'");
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_timeout_miliwebseo_mega_menu_%'");

echo "Done: Database Cleaned!\n";

// 2. RUN BULK SEEDER (Nạp lại danh mục & Sản phẩm)
echo "2/3 Re-seeding categories and products...\n";
require_once( 'crawler-system/bulk-seeder.php' ); 

// 3. RUN USAGE NEEDS (Phân loại nhu cầu)
echo "3/3 Mapping usage needs...\n";
require_once( 'seed-usage-needs.php' );

echo "\n--- ALL DONE: SYSTEM REFRESHED! ---\n";
