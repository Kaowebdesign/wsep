<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Woccommerce_Set_Exchanged_Price_
 * @subpackage Woccommerce_Set_Exchanged_Price_/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Woccommerce_Set_Exchanged_Price_
 * @subpackage Woccommerce_Set_Exchanged_Price_/public
 * @author     kaowebdev
 */
class Woccommerce_Set_Exchanged_Price__Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $woccommerce_set_exchanged_price_    The ID of this plugin.
	 */
	private $woccommerce_set_exchanged_price_;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $woccommerce_set_exchanged_price_       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $woccommerce_set_exchanged_price_, $version ) {

		$this->woccommerce_set_exchanged_price_ = $woccommerce_set_exchanged_price_;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woccommerce_Set_Exchanged_Price__Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woccommerce_Set_Exchanged_Price__Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->woccommerce_set_exchanged_price_, plugin_dir_url( __FILE__ ) . 'css/woccommerce-set-exchanged-price--public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woccommerce_Set_Exchanged_Price__Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woccommerce_Set_Exchanged_Price__Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->woccommerce_set_exchanged_price_, plugin_dir_url( __FILE__ ) . 'js/woccommerce-set-exchanged-price--public.js', array( 'jquery' ), $this->version, false );

	}

}
