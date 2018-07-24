(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	
	$(function() {

		/**
		 * Add or remove new CORS input fields
		 *
		 * @since 1.0.0
		 */
		$(this).on('click', '#gforms-api-signer-settings a.add', function( e ) {
			e.preventDefault();
			var newInput = '<p class="input-row"><input type="url" name="gforms_api_signer_cors_url[]" value="" class="regular-text"><a href="#" class="add"><span class="dashicons dashicons-plus"></span></a><a href="#" class="remove"><span class="dashicons dashicons-minus"></span></a></p>';
			$(this).parent("p").after( newInput );
		});
		$(this).on('click', '#gforms-api-signer-settings a.remove', function( e ) {
			e.preventDefault();
			var count = $('#gforms-api-signer-settings p.input-row').length;
			if ( count > 1 ) {
				$(this).parent(".input-row").remove();
			} else {
				$(this).siblings("input").val("");
				console.log($(this));
			}
		});

		/**
		 * Show/hide CORS URLs based on restricted property
		 * @type {[type]}
		 */
		var corsRestricted = $('input[name="gforms_api_signer_cors_restrict"]');
		if( corsRestricted.is(':checked') ) {
			$(corsRestricted).closest('tr').next('tr').show();
		} else {
			$(corsRestricted).closest('tr').next('tr').hide();
		}
		corsRestricted.change( function() {
			if( this.checked ) {
				$(this).closest('tr').next('tr').show();
			} else {
				$(this).closest('tr').next('tr').hide();
			}
		});

	});

})( jQuery );
