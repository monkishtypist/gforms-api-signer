<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/monkishtypist/
 * @since             1.0.0
 * @package           Gforms_Api_Signer
 *
 * @wordpress-plugin
 * Plugin Name:       Gravity Forms API Signature Generator
 * Plugin URI:        https://github.com/monkishtypist/gforms-api-signer
 * Description:       Adds signature generator endpoint for Gravity Forms Web API call signatures.
 * Version:           1.0.0
 * Author:            Tim Spinks
 * Author URI:        https://github.com/monkishtypist/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       gforms-api-signer
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'GFWEBAPI_SIGNATURE_VERSION', '1.0.0' );

/**
 * Plugin basename.
 */
define( 'GFWEBAPI_SIGNATURE_BASE', plugin_basename( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-gforms-api-signer-activator.php
 */
function activate_gforms_api_signer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gforms-api-signer-activator.php';
	Gforms_Api_Signer_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-gforms-api-signer-deactivator.php
 */
function deactivate_gforms_api_signer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gforms-api-signer-deactivator.php';
	Gforms_Api_Signer_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_gforms_api_signer' );
register_deactivation_hook( __FILE__, 'deactivate_gforms_api_signer' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-gforms-api-signer.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_gforms_api_signer() {

	$plugin = new Gforms_Api_Signer();
	$plugin->run();

}
if( class_exists('GFAddOn') ) :
	run_gforms_api_signer();
endif;
