<?php
/**
 * Script to seed "Gaming" usage need and update products
 */
require_once 'wp-load.php';

if ( ! function_exists( 'wp_insert_term' ) ) {
    require_once ABSPATH . 'wp-admin/includes/taxonomy.php';
}

echo "Starting seeding for Gaming Usage Need...\n";

// 1. Create 'Gaming' term if it doesn't exist
$taxonomy = 'usage_needs';
$term_name = 'Gaming';
$term_slug = 'gaming';

$term = get_term_by('slug', $term_slug, $taxonomy);

if (!$term) {
    $inserted = wp_insert_term($term_name, $taxonomy, array('slug' => $term_slug));
    if (is_wp_error($inserted)) {
        echo "Error creating Gaming term: " . $inserted->get_error_message() . "\n";
        exit;
    }
    $term_id = $inserted['term_id'];
    echo "Created term 'Gaming' with ID: $term_id\n";
} else {
    $term_id = $term->term_id;
    echo "Term 'Gaming' already exists with ID: $term_id\n";
}

// 2. Find products that should be marked as Gaming
// We'll look for products with "Gaming" in the title or that are in the "Laptop Gaming" category
$args = array(
    'post_type'      => 'product',
    'posts_per_page' => -1,
    's'              => 'Gaming', // Search for 'Gaming' in title/content
);

$query = new WP_Query($args);
$count = 0;

if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        $product_id = get_the_ID();
        
        // Assign the usage_needs term
        wp_set_object_terms($product_id, $term_id, $taxonomy, true);
        echo "Updated product: " . get_the_title() . " (ID: $product_id)\n";
        $count++;
    }
}

// Also check products in 'Laptop Gaming' product category if exists
$cat = get_term_by('name', 'Laptop Gaming', 'product_cat');
if ($cat) {
    $args_cat = array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'tax_query'      => array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => $cat->term_id,
            ),
        ),
    );
    $query_cat = new WP_Query($args_cat);
    if ($query_cat->have_posts()) {
        while ($query_cat->have_posts()) {
            $query_cat->the_post();
            $product_id = get_the_ID();
            wp_set_object_terms($product_id, $term_id, $taxonomy, true);
            echo "Updated product from category: " . get_the_title() . " (ID: $product_id)\n";
            $count++;
        }
    }
}

wp_reset_postdata();

echo "Finished seeding. Updated $count products.\n";
