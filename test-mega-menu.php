<?php
require_once('wp-load.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "Step 1: Loading term 365\n";
$term = get_term(365, 'product_cat');
var_dump($term);
flush();

echo "Step 2: Getting term link\n";
$link = get_term_link($term);
var_dump($link);
flush();

echo "Step 3: Finding child terms\n";
$brands = get_terms([
    'taxonomy'   => 'product_cat',
    'parent'     => 365,
    'hide_empty' => false
]);
var_dump(count($brands));
flush();

echo "Done!\n";
