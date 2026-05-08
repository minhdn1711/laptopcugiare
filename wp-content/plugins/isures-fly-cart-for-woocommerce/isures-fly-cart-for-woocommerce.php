<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://plugin68.com
 * @since             3.0.2
 * @package           Isures_Fly_Cart_For_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       iSures Fly Cart For Woocommerce
 * Plugin URI:        https://plugin68.com/sanpham/isures-fly-cart-for-woocommerce/
 * Description:       Plugin helps display a mini cart and related product suggestions every time an item is added to the cart, the quantity is changed, or a product is removed directly from the mini cart... When combined with the <code><a href="https://plugin68.com/sanpham/isures-increase-average-order-value/">iSures Increase Average Order Value</a></code> plugin, it will enhance the value of your orders.
 * Version:           3.0.2
 * Author:            Plugin68.com
 * Author URI:        https://plugin68.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       isures-fly-cart-for-woocommerce
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}
if (!defined('VICWEB_FCART_URL')) {
	define('VICWEB_FCART_URL', plugin_dir_url(__FILE__));
}
if (!defined('VICWEB_FCART_PATH')) {
	define('VICWEB_FCART_PATH', plugin_dir_path(__FILE__));
}
if (!function_exists('debug')) {
	function debug($v, $die = true)
	{
		echo "<pre>";
		print_r($v);
		echo "</pre>";
		if ($die)
			die();
	}
}
/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('ISURES_FLY_CART_FOR_WOOCOMMERCE_VERSION', '3.0.2');
if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
	return;
}
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-isures-fly-cart-for-woocommerce-activator.php
 */
function activate_isures_fly_cart_for_woocommerce()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-isures-fly-cart-for-woocommerce-activator.php';
	Isures_Fly_Cart_For_Woocommerce_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-isures-fly-cart-for-woocommerce-deactivator.php
 */
function deactivate_isures_fly_cart_for_woocommerce()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-isures-fly-cart-for-woocommerce-deactivator.php';
	Isures_Fly_Cart_For_Woocommerce_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_isures_fly_cart_for_woocommerce');
register_deactivation_hook(__FILE__, 'deactivate_isures_fly_cart_for_woocommerce');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */

include_once 'classes/class-isures-autoload.php';
include_once 'classes/class-isures-include-file.php';
require plugin_dir_path(__FILE__) . 'includes/class-isures-fly-cart-for-woocommerce.php';
require plugin_dir_path(__FILE__) . 'includes/class-isures-update-en-free.php';
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_isures_fly_cart_for_woocommerce()
{

	$plugin = new Isures_Fly_Cart_For_Woocommerce();
	$plugin->run();
}
run_isures_fly_cart_for_woocommerce();

