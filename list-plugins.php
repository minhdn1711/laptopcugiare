<?php
require_once('wp-load.php');
$active_plugins = get_option('active_plugins');
foreach ($active_plugins as $plugin) {
    echo $plugin . PHP_EOL;
}
