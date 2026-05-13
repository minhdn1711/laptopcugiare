<?php
/**
 * Redis Object Cache Configuration Template
 * Copy this to your wp-config.php or use a plugin like 'Redis Object Cache'
 */

/*
define( 'WP_REDIS_HOST', '127.0.0.1' );
define( 'WP_REDIS_PORT', 6379 );
define( 'WP_REDIS_PASSWORD', 'your_password' );
define( 'WP_REDIS_TIMEOUT', 1 );
define( 'WP_REDIS_READ_TIMEOUT', 1 );
define( 'WP_REDIS_DATABASE', 0 );
define( 'WP_CACHE_KEY_SALT', 'laptopcugiare_' );
define( 'WP_CACHE', true );
*/

/**
 * Fragment Caching Helper
 */
function miliwebseo_get_cached_fragment($key, $callback, $expiration = HOUR_IN_SECONDS) {
    $cache_key = 'miliwebseo_fragment_' . $key;
    $fragment = wp_cache_get($cache_key);

    if (false === $fragment) {
        ob_start();
        $callback();
        $fragment = ob_get_clean();
        wp_cache_set($cache_key, $fragment, '', $expiration);
    }

    echo $fragment;
}
