<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @since      1.0.0
 *
 * @package    Woccommerce_Set_Exchanged_Price_
 * @subpackage Woccommerce_Set_Exchanged_Price_/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Woccommerce_Set_Exchanged_Price_
 * @subpackage Woccommerce_Set_Exchanged_Price_/includes
 * @author     kaowebdev
 */
class Woccommerce_Set_Exchanged_Price_ {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Woccommerce_Set_Exchanged_Price__Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $woccommerce_set_exchanged_price_    The string used to uniquely identify this plugin.
	 */
	protected $woccommerce_set_exchanged_price_;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	protected $currencies;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WOCCOMMERCE_SET_EXCHANGED_PRICE__VERSION' ) ) {
			$this->version = WOCCOMMERCE_SET_EXCHANGED_PRICE__VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->woccommerce_set_exchanged_price_ = 'woccommerce-set-exchanged-price-';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Woccommerce_Set_Exchanged_Price__Loader. Orchestrates the hooks of the plugin.
	 * - Woccommerce_Set_Exchanged_Price__i18n. Defines internationalization functionality.
	 * - Woccommerce_Set_Exchanged_Price__Admin. Defines all hooks for the admin area.
	 * - Woccommerce_Set_Exchanged_Price__Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woccommerce-set-exchanged-price--loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woccommerce-set-exchanged-price--i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woccommerce-set-exchanged-price--admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-woccommerce-set-exchanged-price--public.php';

		$this->loader = new Woccommerce_Set_Exchanged_Price__Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Woccommerce_Set_Exchanged_Price__i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Woccommerce_Set_Exchanged_Price__i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Woccommerce_Set_Exchanged_Price__Admin( $this->get_woccommerce_set_exchanged_price_(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Woccommerce_Set_Exchanged_Price__Public( $this->get_woccommerce_set_exchanged_price_(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();

		$this->addCustomCurrencyField();
		$this->addPriceFilters();

		if($_SERVER['REQUEST_METHOD'] == "POST") {
			$this->postProcess($_POST);
		}
	}

	public function postProcess($post) {
		if (isset($post['usd']) && isset($post['eur'])) {
			$this->updatePrice($post['usd'], $post['eur']);
		}
	}

	public function updatePrice($usd, $eur) {
		$priceObject = new PriceUpdate($usd, $eur);
		$priceObject->updateWoccommercePrice();
	}

	public function addPriceFilters() {
		add_filter('woocommerce_product_get_price', 'updateProductPrice', 99, 2 );
		add_filter('woocommerce_product_get_regular_price', 'updateProductPrice', 99, 2 );
		add_filter( 'woocommerce_price_filter_widget_min_amount', 'updateProductPrice', 99, 2);
		add_filter( 'woocommerce_price_filter_widget_max_amount', 'updateProductPrice', 99, 2);
		// Variable
		add_filter('woocommerce_product_variation_get_regular_price', 'updateProductPrice', 99, 2 );
		add_filter('woocommerce_product_variation_get_price', 'updateProductPrice', 99, 2 );
		// Variations
		add_filter('woocommerce_variation_prices_price', 'updateProductPrice', 99, 3 );
		add_filter('woocommerce_variation_prices_regular_price', 'updateProductPrice', 99, 3 );
		add_filter( 'woocommerce_variation_prices_sale_price',    'updateProductPrice', 99, 3  );

		function updateProductPrice($price, $product) {

			$currencies = get_option('wsep_currencies');

			if (!$currencies){
				return $price;
			}
			
			if (get_post_meta ( $product->id , '_currency_type', true ) != null && get_post_meta ( $product->id , '_currency_price', true ) != null) {

				if (get_post_meta ( $product->id , '_currency_type', true ) == 'USD') {

					update_post_meta(  $product->id, '_regular_price', floatval(get_post_meta ( $product->id , '_currency_price', true )) * floatval($currencies['usd']) ); // Update regular price

					return floatval(get_post_meta ( $product->id , '_currency_price', true )) * floatval($currencies['usd']);
				} else {

					update_post_meta(  $product->id, '_regular_price', floatval(get_post_meta ( $product->id , '_currency_price', true )) * floatval($currencies['eur']) ); // Update regular price

					return floatval(get_post_meta ( $product->id , '_currency_price', true )) * floatval($currencies['eur']);
				}
				
			}
			return $price;
		}
	}

	public function addCustomCurrencyField(){
		add_action( 'woocommerce_product_options_general_product_data', 'currency_fields' );

        function currency_fields() {
			echo '<div class="options_group">';// Группировка полей 
			echo "<h2>Валютная цена:</h2>";

            woocommerce_wp_radio( array(
                'id'            => '_currency_type',
                'label'         => 'Валюта: ',
                'class'         => 'radio-field', // Произвольный класс поля
                'style'         => '', // Произвольные стили для поля
                'wrapper_class' => 'wrap-radio', // Класс обертки поля
                'desc_tip'      => 'false', // Включение подсказки
                'description'   => 'Выберите нужную валюту',// Описение поля
                'name'          => 'currency-type', // Имя поля
                'options'       => array(
                   'USD'   => 'Доллар',
                   'EUR'   => 'Евро',
                ),
            ) );

			woocommerce_wp_text_input( array(
				'id'                => '_currency_price',
				'label'             => __( 'Цена в валюте:', 'woocommerce' ),
				'placeholder'       => 'Введите цену в валюте',
				'description'       => __( 'Вводятся только числа', 'woocommerce' ),
				'type'              => 'number',
				'custom_attributes' => array(
				   'step' => 'any',
				   'min'  => '0',
				),
			 ) );
	
			echo '</div>';
        };  

		add_action( 'woocommerce_process_product_meta', 'currency_fields_save', 10 );

		function currency_fields_save($post_id) {

			$woocommerce_radio = $_POST['currency-type'];
			if ( ! empty( $woocommerce_radio ) ) {
				update_post_meta( $post_id, '_currency_type', esc_attr( $woocommerce_radio ) );
			}

			$woocommerce_number_field = $_POST['_currency_price'];
			if ( ! empty( $woocommerce_number_field ) ) {
				update_post_meta( $post_id, '_currency_price', esc_attr( $woocommerce_number_field ) );
			}
		}
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_woccommerce_set_exchanged_price_() {
		return $this->woccommerce_set_exchanged_price_;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Woccommerce_Set_Exchanged_Price__Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
