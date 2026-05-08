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
 * @since             2.0.2
 * @package           Isures_Qrcode_Payment_For_Vietnam
 *
 * @wordpress-plugin
 * Plugin Name:       iSures QrCode Payment for Vietnam
 * Plugin URI:        https://plugin68.com/sanpham/isures-qrcode-payment-for-vietnam
 * Description:       Plugin supporting payment gateway integration for Vietnamese banks, featuring QR code for quick code scanning
 * Version:           2.0.2
 * Author:            Plugin68.com
 * Author URI:        https://plugin68.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       isures-qrcode-payment-for-vietnam
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
define('BACS_ID', 'vicweb_bacs');
/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'ISURES_QRCODE_PAYMENT_FOR_VIETNAM_VERSION', '2.0.2' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-isures-qrcode-payment-for-vietnam-activator.php
 */
function activate_isures_qrcode_payment_for_vietnam() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-isures-qrcode-payment-for-vietnam-activator.php';
	Isures_Qrcode_Payment_For_Vietnam_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-isures-qrcode-payment-for-vietnam-deactivator.php
 */
function deactivate_isures_qrcode_payment_for_vietnam() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-isures-qrcode-payment-for-vietnam-deactivator.php';
	Isures_Qrcode_Payment_For_Vietnam_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_isures_qrcode_payment_for_vietnam' );
register_deactivation_hook( __FILE__, 'deactivate_isures_qrcode_payment_for_vietnam' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-isures-qrcode-payment-for-vietnam.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-isures-update-en-free.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_isures_qrcode_payment_for_vietnam() {

	$plugin = new Isures_Qrcode_Payment_For_Vietnam();
	$plugin->run();

}
run_isures_qrcode_payment_for_vietnam();
