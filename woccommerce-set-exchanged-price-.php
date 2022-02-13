<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @since             1.0.0
 * @package           Woccommerce_Set_Exchanged_Price_
 *
 * @wordpress-plugin
 * Plugin Name:       Woccommerce Set Exchanged Price 
 * Plugin URI:        https://github.com/Kaowebdesign/wsep
 * Description:       Вводи цену в USD/EUR и конвертируй в грн по текущему курсу.
 * Version:           1.0.0
 * Author:            kaowebdev
 * Author URI:        https://github.com/Kaowebdesign
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woccommerce-set-exchanged-price-
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Update it as you release new versions.
 */
define( 'WOCCOMMERCE_SET_EXCHANGED_PRICE__VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woccommerce-set-exchanged-price--activator.php
 */
function activate_woccommerce_set_exchanged_price_() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woccommerce-set-exchanged-price--activator.php';
	Woccommerce_Set_Exchanged_Price__Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woccommerce-set-exchanged-price--deactivator.php
 */
function deactivate_woccommerce_set_exchanged_price_() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woccommerce-set-exchanged-price--deactivator.php';
	Woccommerce_Set_Exchanged_Price__Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woccommerce_set_exchanged_price_' );
register_deactivation_hook( __FILE__, 'deactivate_woccommerce_set_exchanged_price_' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woccommerce-set-exchanged-price-.php';

require plugin_dir_path( __FILE__ ) . 'includes/class-currencies.php';

require plugin_dir_path( __FILE__ ) . 'includes/class-price-update.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woccommerce_set_exchanged_price_() {

	$plugin = new Woccommerce_Set_Exchanged_Price_();
	$plugin->run();

}
// run_woccommerce_set_exchanged_price_();

add_action('init', 'run_woccommerce_set_exchanged_price_');

