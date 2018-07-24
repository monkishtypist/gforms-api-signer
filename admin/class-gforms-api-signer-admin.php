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

GFForms::include_addon_framework();


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
	 * The unique basename of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_base    The basename used to uniquely identify this plugin.
	 */
	protected $plugin_base;

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
	 * @param      string    $plugin_base       The basename of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $plugin_base, $version ) {

		$this->plugin_name = $plugin_name;
		$this->plugin_base = $plugin_base;
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
	 * Autoload the required libraries.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @uses GFAddOn::is_gravityforms_supported()
	 */
	public function pre_init() {
		//
	}

	/**
	 * admin_init action hook
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init() {
		$current_version = $this->version;
		$version = get_option('gform_api_signer_version');
		if ( $version != $current_version ) {
			update_option( 'gform_api_signer_version', $current_version );
			$message = __( 'plugin has been updated to version', 'gforms-api-signer' );
			$notice = sprintf( '<div class="updated notice is-dismissible"><p>%s %s <strong>%s</strong></p></div>', $this->plugin_name, $message, $current_version );
			$this->add_notice( $notice );
		}
	}

	/**
	 * Returns admin notices
	 *
	 * Notes:
	 * https://github.com/DevinVinson/WordPress-Plugin-Boilerplate/issues/331
	 * https://stackoverflow.com/questions/9807064/wordpress-how-to-display-notice-in-admin-panel-on-plugin-activation
	 *
	 * @since 1.0.0
	 */
	public function admin_notice() {
		if ( $notices = get_option( 'deferred_admin_notices' ) ) {
			foreach ( $notices as $notice ) {
				echo "

				$notice

				";
			}
			delete_option('deferred_admin_notices');
		}
	}

	/**
	 * Add admin notices
	 * 
	 * @param string $notice the admin notice (HTML) string
	 * @since 1.0.0
	 */
	public static function add_notice( $notice ) {

		$notices = get_option( 'deferred_admin_notices', array() );
		$notices[] = $notice;
		update_option( 'deferred_admin_notices', $notices );
	}

	/**
	 * Adds notice on plugin activation
	 *
	 * @since 1.0.0
	 */
	public static function add_activation_notice() {

		$notices = get_option( 'deferred_admin_notices', array() );

		$admin_url = get_admin_url();
		$gf_webapi_options = get_option('gravityformsaddon_gravityformswebapi_settings');
		
		if( (int) $gf_webapi_options['enabled'] !== 1 ) {
			$notices[] = sprintf( '<div class="updated notice is-dismissible"><p>%s. <a href="%s%s">%s</a></p></div>', __( 'The Gravity Forms Web API is currently disabled.', 'gforms-api-signer' ), $admin_url, 'admin.php?page=gf_settings&subview=gravityformswebapi', __( 'Click here to enable.', 'gforms-api-signer' ) );
		}
		update_option( 'deferred_admin_notices', $notices );
	}

	/**
	 * Add "Settings" link to plugin page
	 *
	 * @since 1.0.0
	 */
	function plugin_settings_link( $links, $file ) {
		if ( $file != $this->plugin_base ) {
			return $links;
		}

		array_unshift( $links, '<a href="' . admin_url( 'options-general.php' ) . '?page=gforms_api_signer_settings">' . esc_html__( 'Settings', 'gforms-api-signer' ) . '</a>' );

		return $links;
	}

	/**
	 * Register API endpoint(s)
	 *
	 * @since    1.0.0
	 */
	public function register_wp_api_endpoints() {
		register_rest_route( 'gfapi', '/signature', array(
			'methods' => 'GET',
			'callback' => array( $this, 'calculate_signature_callback' ),
		));
	}

	/**
	 * API callback function - return calculated Gravity Forms signature
	 *
	 * @since    1.0.0
	 */
	public function calculate_signature_callback( $request_data ) {
		// Get Gravity Forms Web API settings
		$gf_webapi_options = get_option('gravityformsaddon_gravityformswebapi_settings');
		$public_key = $gf_webapi_options['public_key'];
		$private_key = $gf_webapi_options['private_key'];
		// Require Gravity Forms API enabled
		if( (int) $gf_webapi_options['enabled'] !== 1 )
			return array( 'status' => 401, 'error' => 'gf_web_api_not_enabled', 'response' => 'Gravity Forms API not enabled' );
		// Get signature API params
		$parameters = $request_data->get_params();
		// Require public_key parameter
		if( !isset( $parameters['public_key'] ) || empty( $parameters['public_key'] ) )
			return array( 'status' => 401, 'error' => 'no_public_key', 'response' => 'Public key required' );
		// Compare public_key parameter to Gravity Forms public key
		if( $parameters['public_key'] !== $public_key )
			return array( 'status' => 401, 'error' => 'public_key_mismatch', 'response' => 'Invalid public key' );
		// Set the expiration date/time
		$expires_string = sprintf( "+%d seconds", get_option('gforms_api_signer_expires') );
		$expires = strtotime( $expires_string );
		// Get API method and validate it against array of potential methods		
		$method = ( isset( $parameters['method'] ) && in_array( strtoupper( filter_var( $parameters['method'], FILTER_SANITIZE_STRING ) ), array( "GET", "POST", "PUSH", "DELETE" ) ) ? strtoupper( filter_var( $parameters['method'], FILTER_SANITIZE_STRING ) ) : "GET" );
		// Check method availability
		$restrict_post = get_option('gforms_api_signer_restrict_post');
		if( isset( $restrict_post ) && (int) $restrict_post == 1 && $method == "POST" )
			return array( 'status' => 401, 'error' => 'method_unavailable_post', 'result' => 'Method not supported: ' . $method );
		// Get API route
		$route = ( isset( $parameters['route'] ) ? $parameters['route'] : "forms" );
		// Generate string to sign
		$string_to_sign = sprintf( "%s:%s:%s:%s", $public_key, $method, $route, $expires );
		// Calculate signature
		$signature = $this->calculate_signature( $string_to_sign, $private_key );
		// Compile result
		$result = array(
			"route" => $route,
			"publicKey" => $public_key,
			"signature" => $signature,
			"expires" => $expires,
			"method" => $method,
			"referer" => $_SERVER['HTTP_REFERER'],
			"domain" => parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST)
		);
		
		return $result;
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

	/**
	 * Adds admin option page to Gravity Forms menu
	 *
	 * @since 1.0.0
	 */
	public function admin_menu( $menus ) {
		add_options_page( 'Gravity Forms Web API Signature', 'Web API Signature', 'manage_options', 'gforms_api_signer_settings', array( $this, 'options_page' ) );
	}

	/**
	 * Defines the Options Page to be displayed in admin
	 *
	 * @since 1.0.0
	 */
	public function options_page() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/gforms-api-signer-admin-display.php';
	}

	/**
	 * Define settings, sections, and fields
	 *
	 * @since 1.0.0
	 */
	public function settings_init() {

		$option_group = 'gforms_api_signer_settings';

		// Setting: Expires
		register_setting( $option_group, 'gforms_api_signer_expires', array(
			'type' => 'integer',
			// 'sanitize_callback' => 'sanitize_text_field',
			'default' => 3600
		) );
		// Setting: Restrict POST Method
		register_setting( $option_group, 'gforms_api_signer_restrict_post', array(
			'type' => 'boolean',
			'default' => 0
		) );
		// Setting: Restrict CORS
		register_setting( $option_group, 'gforms_api_signer_cors_restrict', array(
			'type' => 'boolean',
			'default' => 0
		) );
		// Setting: CORS URLs
		register_setting( $option_group, 'gforms_api_signer_cors_url', array(
			'type' => 'string'
		) );

		// Section: All Settings
		add_settings_section(
			'gforms_api_signer_settings_section',
			__( 'API Settings', 'gforms-api-signer' ),
			array( $this, 'gforms_api_signer_settings_section_cb' ),
			$option_group
		);

		// Field: Expires
		add_settings_field(
			'gforms_api_signer_settings_field_expires',
			__( 'Expiration (in seconds)', 'gforms-api-signer' ),
			array( $this, 'gforms_api_signer_settings_field_expires_cb' ),
			$option_group,
			'gforms_api_signer_settings_section',
			array(
				'label_for' => 'gforms_api_signer_expires'
			)
		);
		// Field: Allow POST Method
		add_settings_field(
			'gforms_api_signer_settings_field_restrict_post',
			__( 'Restrict POST method', 'gforms-api-signer' ),
			array( $this, 'gforms_api_signer_settings_field_restrict_post_cb' ),
			$option_group,
			'gforms_api_signer_settings_section',
			array(
				'label_for' => 'gforms_api_signer_restrict_post'
			)
		);
		// Field: Restrict CORS
		add_settings_field(
			'gforms_api_signer_settings_field_cors_restrict',
			__( 'Restrict CORS', 'gforms-api-signer' ),
			array( $this, 'gforms_api_signer_settings_field_cors_restrict_cb' ),
			$option_group,
			'gforms_api_signer_settings_section',
			array(
				'label_for' => 'gforms_api_signer_cors_restrict'
			)
		);
		// Field: CORS URL(s)
		add_settings_field(
			'gforms_api_signer_settings_field_cors_url',
			__( '', 'gforms-api-signer' ),
			array( $this, 'gforms_api_signer_settings_field_cors_url_cb' ),
			$option_group,
			'gforms_api_signer_settings_section',
			array(
				'label_for' => 'gforms_api_signer_cors_url'
			)
		);
	}

	/**
	 * Text displayed in the admin settings
	 *
	 * @since 1.0.0
	 * @return HTML
	 */
	public function gforms_api_signer_settings_section_cb() {
		echo '<p>The following settings are used by the signature generation API.</p>';
	}

	/**
	 * Settings field: Expires
	 *
	 * @since 1.0.0
	 * @return HTML settings input field
	 */
	public function gforms_api_signer_settings_field_expires_cb() {
		$setting = get_option('gforms_api_signer_expires');
		?>
		<input type="number" name="gforms_api_signer_expires" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>" class="regular-text">
		<?php
	}

	/**
	 * Settings field: Allow POST Method
	 *
	 * @since 1.0.0
	 * @return HTML settings input field
	 */
	public function gforms_api_signer_settings_field_restrict_post_cb() {
		$setting = get_option('gforms_api_signer_restrict_post');
		?>
		<input type="checkbox" name="gforms_api_signer_restrict_post" value="1" <?php echo ( isset( $setting ) && !empty( $setting ) ) ? 'checked' : ''; ?>> <?php _e( 'By default both POST and GET methods are available. Check here to block the POST method.', 'gforms-api-signer' ); ?>
		<?php
	}

	/**
	 * Settings field: CORS
	 *
	 * @since 1.0.0
	 * @return HTML settings input field
	 */
	public function gforms_api_signer_settings_field_cors_restrict_cb() {
		$setting = get_option('gforms_api_signer_cors_restrict');
		?>
		<input type="checkbox" name="gforms_api_signer_cors_restrict" value="1" <?php echo ( isset( $setting ) && !empty( $setting ) ) ? 'checked' : ''; ?>> <?php _e( 'Restrict CORS policy to only domains you define.', 'gforms-api-signer' ); ?>
		<?php
	}

	/**
	 * Settings field: CORS URL(s)
	 *
	 * @since 1.0.0
	 * @return HTML settings input field
	 */
	public function gforms_api_signer_settings_field_cors_url_cb() {
		$setting = get_option('gforms_api_signer_cors_url');
		if( is_array( $setting ) ) {
			$setting = array_filter( $setting );
			$count = count( $setting );
			for( $i=0; $i < $count; $i++ ) {
				$value = isset( $setting[ $i ] ) ? esc_attr( $setting[ $i ] ) : '';
				?>
				<p class="input-row"><input type="url" name="gforms_api_signer_cors_url[]" value="<?php echo $value; ?>" class="regular-text"><a href="#" class="add"><span class="dashicons dashicons-plus"></span></a><a href="#" class="remove"><span class="dashicons dashicons-minus"></span></a></p>
				<?php
			}
		}
		?>
		<p class="input-row"><input type="url" name="gforms_api_signer_cors_url[]" value="" class="regular-text"><a href="#" class="add"><span class="dashicons dashicons-plus"></span></a><a href="#" class="remove"><span class="dashicons dashicons-minus"></span></a></p>
		<?php

	}

	/**
	 * .htaccess update for CORS
	 *
	 * @since 1.0.0
	 */
	public function htaccess_cors( $option_name ) {
		$restrict_cors = get_option( 'gforms_api_signer_cors_restrict' );
		if( !isset( $restrict_cors ) || empty( $restrict_cors ) ) {
			$cors = '<IfModule mod_headers.c>
	Header set Access-Control-Allow-Origin "*"
</IfModule>';
		} else {
			$cors_urls = array_filter( get_option( 'gforms_api_signer_cors_url' ) );
			$cors_str = implode("|", $cors_urls);
			$cors = '<IfModule mod_headers.c>
	SetEnvIf Origin "(' . $cors_str . ')$" AccessControlAllowOrigin=$0
	Header set Access-Control-Allow-Origin %{AccessControlAllowOrigin}e env=AccessControlAllowOrigin
</IfModule>';
		}
		if( function_exists( 'insert_with_markers' ) )
			insert_with_markers( get_home_path() . ".htaccess", "GForms API Signature", $cors );
	}

}
