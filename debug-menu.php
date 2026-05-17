<?php
require_once('wp-load.php');

function dump_categories($parent = 0, $level = 0) {
    $terms = get_terms([
        'taxonomy' => 'product_cat',
        'parent' => $parent,
        'hide_empty' => false
    ]);

    foreach ($terms as $term) {
        echo str_repeat('--', $level) . ' ' . $term->name . ' (ID: ' . $term->term_id . ')' . PHP_EOL;
        dump_categories($term->term_id, $level + 1);
    }
}

header('Content-Type: text/plain; charset=utf-8');
dump_categories();
