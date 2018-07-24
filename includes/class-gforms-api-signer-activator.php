<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/monkishtypist/
 * @since      1.0.0
 *
 * @package    Gforms_Api_Signer
 * @subpackage Gforms_Api_Signer/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Gforms_Api_Signer
 * @subpackage Gforms_Api_Signer/includes
 * @author     Tim Spinks <tim@monkishtypist.com>
 */
class Gforms_Api_Signer_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		// Plugin requires Gravity Forms in order to be activated
		if( !class_exists( 'GFForms' ) ) {
			deactivate_plugins( plugin_basename( __FILE__ ) );
			wp_die( __( 'Please install and activate Gravity Forms.', 'gforms-api-signer' ), 'Plugin dependency check', array( 'back_link' => true ) );
		}

		// Set CORS in .htaccess on plugin activation
		$cors = '<IfModule mod_headers.c>
	Header set Access-Control-Allow-Origin "*"
</IfModule>';
		if( function_exists( 'insert_with_markers' ) )
			insert_with_markers( get_home_path() . ".htaccess", "GForms API Signature", $cors );
	}

}

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-gforms-api-signer-admin.php';
Gforms_Api_Signer_Admin::add_activation_notice();
