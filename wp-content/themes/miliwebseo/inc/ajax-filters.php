<?php
/**
 * Ajax Product Filtering Logic
 */

add_action('wp_ajax_miliwebseo_filter_products', 'miliwebseo_filter_products');
add_action('wp_ajax_nopriv_miliwebseo_filter_products', 'miliwebseo_filter_products');

function miliwebseo_filter_products() {
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
    $brands = isset($_POST['brands']) ? $_POST['brands'] : [];
    $cpus = isset($_POST['cpus']) ? $_POST['cpus'] : [];
    $price_range = isset($_POST['price']) ? $_POST['price'] : '';

    $current_tax = isset($_POST['current_tax']) ? $_POST['current_tax'] : '';
    $current_term = isset($_POST['current_term']) ? $_POST['current_term'] : '';

    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => 12,
        'paged'          => $paged,
        'status'         => 'publish',
        'tax_query'      => array('relation' => 'AND'),
    );

    // Contextual Filter (Category/Tag/etc)
    if (!empty($current_tax) && !empty($current_term)) {
        $args['tax_query'][] = array(
            'taxonomy' => $current_tax,
            'field'    => 'slug',
            'terms'    => $current_term,
        );
    }

    if (!empty($brands)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'product_brand',
            'field'    => 'slug',
            'terms'    => $brands,
        );
    }

    if (!empty($cpus)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'cpu',
            'field'    => 'slug',
            'terms'    => $cpus,
        );
    }

    // Price Filtering Logic
    if (!empty($price_range)) {
        $meta_query = array('relation' => 'AND');
        if ($price_range === 'under-10') {
            $meta_query[] = array('key' => '_price', 'value' => 10000000, 'compare' => '<', 'type' => 'NUMERIC');
        } elseif ($price_range === '10-20') {
            $meta_query[] = array('key' => '_price', 'value' => array(10000000, 20000000), 'compare' => 'BETWEEN', 'type' => 'NUMERIC');
        } elseif ($price_range === 'over-20') {
            $meta_query[] = array('key' => '_price', 'value' => 20000000, 'compare' => '>', 'type' => 'NUMERIC');
        }
        $args['meta_query'] = $meta_query;
    }

    $query = new WP_Query($args);

    ob_start();

    if ($query->have_posts()) {
        echo '<div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">';
        while ($query->have_posts()) {
            $query->the_post();
            wc_get_template_part('content', 'product');
        }
        echo '</div>';
        
        echo '<div class="mt-12 flex justify-center">';
        echo paginate_links(array(
            'total'     => $query->max_num_pages,
            'current'   => $paged,
            'format'    => '?paged=%#%',
            'prev_text' => '‹',
            'next_text' => '›',
            'type'      => 'list',
            'class'     => 'pagination-list'
        ));
        echo '</div>';
    } else {
        echo '<div class="text-center py-20 opacity-50"><p>Không tìm thấy sản phẩm nào khớp với bộ lọc.</p></div>';
    }

    $output = ob_get_clean();
    wp_send_json_success($output);
    wp_die();
}
