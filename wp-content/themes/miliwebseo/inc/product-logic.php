<?php
/**
 * Product View Counter and Custom Sorting
 */

/**
 * Track product views
 */
function miliwebseo_track_product_views() {
    if ( is_singular( 'product' ) ) {
        global $post;
        $views = get_post_meta( $post->ID, 'post_views_count', true );
        $views = ( $views == '' ) ? 0 : $views;
        $views++;
        update_post_meta( $post->ID, 'post_views_count', $views );
    }
}
add_action( 'wp_head', 'miliwebseo_track_product_views' );

/**
 * Handle custom sorting in WooCommerce
 */
function miliwebseo_custom_product_sorting( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    if ( is_post_type_archive( 'product' ) || is_tax( 'product_cat' ) || is_tax( 'brand' ) ) {
        $orderby = isset( $_GET['orderby'] ) ? sanitize_text_field( $_GET['orderby'] ) : '';

        switch ( $orderby ) {
            case 'price':
                $query->set( 'meta_key', '_price' );
                $query->set( 'orderby', 'meta_value_num' );
                $query->set( 'order', 'ASC' );
                break;
            case 'price-desc':
                $query->set( 'meta_key', '_price' );
                $query->set( 'orderby', 'meta_value_num' );
                $query->set( 'order', 'DESC' );
                break;
            case 'date':
                $query->set( 'orderby', 'date' );
                $query->set( 'order', 'DESC' );
                break;
            case 'popularity':
                $query->set( 'meta_key', 'total_sales' );
                $query->set( 'orderby', 'meta_value_num' );
                $query->set( 'order', 'DESC' );
                break;
            case 'rating':
                $query->set( 'meta_key', '_wc_average_rating' );
                $query->set( 'orderby', 'meta_value_num' );
                $query->set( 'order', 'DESC' );
                break;
            case 'views':
                $query->set( 'meta_key', 'post_views_count' );
                $query->set( 'orderby', 'meta_value_num' );
                $query->set( 'order', 'DESC' );
                break;
            case 'title':
                $query->set( 'orderby', 'title' );
                $query->set( 'order', 'ASC' );
                break;
        }
    }
}
add_action( 'pre_get_posts', 'miliwebseo_custom_product_sorting' );
