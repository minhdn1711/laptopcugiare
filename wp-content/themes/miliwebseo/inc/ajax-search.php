<?php
/**
 * Ajax Search Implementation
 */

function miliwebseo_ajax_search() {
    $search_query = sanitize_text_field( $_POST['query'] );
    
    $args = array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => 5,
        's'              => $search_query,
    );

    $query = new WP_Query( $args );
    $results = array();

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            global $product;
            $results[] = array(
                'title' => get_the_title(),
                'url'   => get_permalink(),
                'price' => $product->get_price_html(),
                'image' => get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' ),
            );
        }
    }

    wp_send_json_success( $results );
}
add_action( 'wp_ajax_nopriv_miliwebseo_search', 'miliwebseo_ajax_search' );
add_action( 'wp_ajax_miliwebseo_search', 'miliwebseo_ajax_search' );
