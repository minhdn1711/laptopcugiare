<?php
require_once( 'wp-load.php' );
$laptop = get_term_by('name', 'Laptop', 'product_cat');
if($laptop) {
    echo "Laptop ID: " . $laptop->term_id . "\n";
    $brands = get_terms(['taxonomy' => 'product_cat', 'parent' => $laptop->term_id, 'hide_empty' => false]);
    if(empty($brands)) {
        echo "NO BRANDS FOUND UNDER LAPTOP\n";
    }
    foreach($brands as $b) {
        echo " - Brand: " . $b->name . " (ID: " . $b->term_id . ")\n";
    }
} else {
    echo "Laptop Category not found!\n";
}
