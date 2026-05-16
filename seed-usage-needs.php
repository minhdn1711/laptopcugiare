<?php
require_once( 'wp-load.php' );

echo "--- STARTING USAGE NEEDS SEEDER ---\n";

$usage_needs = [
    'Laptop sinh viên - văn phòng' => 'office',
    'Laptop Gaming' => 'gaming',
    'Laptop đồ họa' => 'workstation',
    'Laptop mỏng nhẹ' => 'ultrabook',
    'Laptop AI' => 'ai-laptop'
];

$term_ids = [];
foreach ($usage_needs as $name => $slug) {
    $term = wp_insert_term($name, 'usage_needs', ['slug' => $slug]);
    if (is_wp_error($term)) {
        $term_ids[$slug] = $term->get_error_data();
    } else {
        $term_ids[$slug] = $term['term_id'];
    }
    echo " - Created/Found Usage Need: $name\n";
}

$products = get_posts(['post_type' => 'product', 'numberposts' => -1]);
echo "Mapping " . count($products) . " products to usage needs...\n";

foreach ($products as $p) {
    $title = strtolower($p->post_title);
    $needs_to_assign = [];

    if (strpos($title, 'gaming') !== false || strpos($title, 'rog') !== false || strpos($title, 'legion') !== false || strpos($title, 'victus') !== false) {
        $needs_to_assign[] = $term_ids['gaming'];
    }
    
    if (strpos($title, 'air') !== false || strpos($title, 'thin') !== false || strpos($title, 'slim') !== false) {
        $needs_to_assign[] = $term_ids['ultrabook'];
    }

    if (strpos($title, 'precision') !== false || strpos($title, 'proart') !== false || strpos($title, 'workstation') !== false) {
        $needs_to_assign[] = $term_ids['workstation'];
    }

    if (strpos($title, 'ai') !== false || strpos($title, 'ultra') !== false) {
        $needs_to_assign[] = $term_ids['ai-laptop'];
    }

    // Nếu không thuộc nhóm nào trên, gán vào Văn phòng
    if (empty($needs_to_assign)) {
        $needs_to_assign[] = $term_ids['office'];
    }

    wp_set_object_terms($p->ID, $needs_to_assign, 'usage_needs');
}

echo "--- COMPLETED SUCCESSFULY ---";
