<?php
/**
 * Performance Optimization Hooks
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Remove wp_head bloat
 */
function miliwebseo_cleanup_head() {
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'start_post_rel_link');
    remove_action('wp_head', 'index_rel_link');
    remove_action('wp_head', 'adjacent_posts_rel_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
}
add_action('init', 'miliwebseo_cleanup_head');

/**
 * Disable Embeds
 */
function miliwebseo_disable_embeds_init() {
    global $wp;
    $wp->publicly_queryable_post_types = array_diff($wp->publicly_queryable_post_types, array('oembed_cache'));
    remove_action('rest_api_init', 'wp_oembed_register_route');
    add_filter('embed_oembed_discover', '__return_false');
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');
}
add_action('init', 'miliwebseo_disable_embeds_init', 9999);

/**
 * Limit Heartbeat API
 */
function miliwebseo_limit_heartbeat($settings) {
    $settings['interval'] = 60; // 60 seconds
    return $settings;
}
add_filter('heartbeat_settings', 'miliwebseo_limit_heartbeat');

/**
 * Disable XML-RPC
 */
add_filter('xmlrpc_enabled', '__return_false');

/**
 * Remove Version Strings from Scripts and Styles
 */
function miliwebseo_remove_wp_ver_css_js($src) {
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'miliwebseo_remove_wp_ver_css_js', 9999);
add_filter('script_loader_src', 'miliwebseo_remove_wp_ver_css_js', 9999);
