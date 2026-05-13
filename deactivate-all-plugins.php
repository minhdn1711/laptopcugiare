<?php
require_once 'wp-load.php';
require_once ABSPATH . 'wp-admin/includes/plugin.php';

$all_plugins = get_plugins();
$active_plugins = get_option('active_plugins');

foreach ($active_plugins as $plugin) {
    deactivate_plugins($plugin);
    echo "Deactivated: $plugin\n";
}

// Keep WooCommerce active as it is core to the site
// activate_plugins('woocommerce/woocommerce.php');
// echo "Re-activated: WooCommerce\n";
