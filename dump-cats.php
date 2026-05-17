<?php
require_once( 'wp-load.php' );
header('Content-Type: text/plain');

$categories = get_terms([
    'taxonomy' => 'product_cat',
    'hide_empty' => false,
]);

echo "Total Categories: " . count($categories) . "\n\n";

function print_tree($parent_id = 0, $level = 0) {
    $terms = get_terms([
        'taxonomy' => 'product_cat',
        'parent' => $parent_id,
        'hide_empty' => false,
    ]);
    
    foreach ($terms as $term) {
        echo str_repeat("  ", $level) . "- " . $term->name . " (ID: " . $term->term_id . ", Count: " . $term->count . ")\n";
        print_tree($term->term_id, $level + 1);
    }
}

print_tree();
