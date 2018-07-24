<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/monkishtypist/
 * @since      1.0.0
 *
 * @package    Gforms_Api_Signer
 * @subpackage Gforms_Api_Signer/admin/partials
 */

// check user capabilities
if ( ! current_user_can( 'manage_options' ) ) {
	return;
}
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	<form action="options.php" method="post" id="gforms-api-signer-settings">
		<?php
			// output security fields for the registered setting "gforms_api_signer_options"
			settings_fields('gforms_api_signer_settings');
			// output setting sections and their fields
			// (sections are registered for "gforms_api_signer", each field is registered to a specific section)
			do_settings_sections('gforms_api_signer_settings');
			// output save settings button
			submit_button('Save Settings');
		?>
	</form>
</div>