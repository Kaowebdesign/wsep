<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 *
 * @package    Woccommerce_Set_Exchanged_Price_
 * @subpackage Woccommerce_Set_Exchanged_Price_/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Woccommerce_Set_Exchanged_Price_
 * @subpackage Woccommerce_Set_Exchanged_Price_/includes
 * @author     kaowebdev
 */
class Woccommerce_Set_Exchanged_Price__i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'woccommerce-set-exchanged-price-',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
