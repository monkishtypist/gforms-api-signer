<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/monkishtypist/
 * @since      1.0.0
 *
 * @package    Gforms_Api_Signer
 * @subpackage Gforms_Api_Signer/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Gforms_Api_Signer
 * @subpackage Gforms_Api_Signer/admin
 * @author     Tim Spinks <tim@monkishtypist.com>
 */
class Gforms_Api_Signer_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/gforms-api-signer-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/gforms-api-signer-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * API callback function - return calculated Gravity Forms signature
	 *
	 * @since    1.0.0
	 */
	public function calculate_signature_callback( $request_data ) {

		$gf_webapi_options = get_option('gravityformsaddon_gravityformswebapi_settings');
		if( (int) $gf_webapi_options['enabled'] !== 1 )
			return array( 'error' => 'gf_web_api_not_enabled' );

		$parameters = $request_data->get_params();

		if( !isset( $parameters['public_key'] ) || empty( $parameters['public_key'] ) )
			return array( 'error' => 'no_api_public_key' );

		if( $parameters['public_key'] !== $gf_webapi_options['public_key'] )
			return array( 'error' => 'public_key_mismatch' );

		$public_key = $gf_webapi_options['public_key'];
		$private_key = $gf_webapi_options['private_key'];

		$mins = ( ( isset( $parameters['expires'] ) && (int) $parameters['expires'] >= 0 ) ? (int) $parameters['expires'] : 60 );
		$expires_string = sprintf( "+%d mins", $mins );
		$expires = strtotime( $expires_string );
		
		$method = ( isset( $parameters['method'] ) ? $parameters['method'] : "GET" );
		$route = ( isset( $parameters['route'] ) ? $parameters['route'] : "forms" );

		$string_to_sign = sprintf( "%s:%s:%s:%s", $parameters['public_key'], $method, $route, $expires );

		$signature = $this->far_calculate_signature( $string_to_sign, $private_key );

		$result = array( 'route' => $route, 'publicKey' => $public_key, 'sig' => $signature, 'expires' => $expires );
		
		return json_encode( $result );
	}

	/**
	 * Calculates Gravity Forms API signature
	 *
	 * @since    1.0.0
	 */
	public function calculate_signature( $string, $private_key ) {
		$hash = hash_hmac( "sha1", $string, $private_key, true );
		$signature = rawurlencode( base64_encode( $hash ) );

		return $signature;
	}
}
