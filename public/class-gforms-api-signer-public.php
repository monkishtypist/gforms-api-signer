<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/monkishtypist/
 * @since      1.0.0
 *
 * @package    Gforms_Api_Signer
 * @subpackage Gforms_Api_Signer/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Gforms_Api_Signer
 * @subpackage Gforms_Api_Signer/public
 * @author     Tim Spinks <tim@monkishtypist.com>
 */
class Gforms_Api_Signer_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
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
		 * defined in Gforms_Api_Signer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Gforms_Api_Signer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/gforms-api-signer-public.css', array(), $this->version, 'all' );

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
		 * defined in Gforms_Api_Signer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Gforms_Api_Signer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/gforms-api-signer-public.js', array( 'jquery' ), $this->version, false );

	}


	/**
	 * Register public facing API endpoint(s)
	 *
	 * @since    1.0.0
	 */
	public function register_wp_api_endpoints() {
		register_rest_route( 'far', '/signature', array(
			'methods' => 'GET',
			'callback' => array( $this, 'far_calculate_signature_callback' ),
		));
	}

}