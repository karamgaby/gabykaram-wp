(function($) {
	// reduce placeholder textarea height to match tinymce settings (when using delay-setting)
	$( '.acf-editor-wrap.delay textarea' ).css( 'height', '100px' );
	// (filter called before the tinyMCE instance is created)
	acf.add_filter(
		'wysiwyg_tinymce_settings',
		function(mceInit, id, $field) {
			// enable autoresizing of the WYSIWYG editor
			mceInit.wp_autoresize_on = true;
			return mceInit;
		}
	);
	// (action called when a WYSIWYG tinymce element has been initialized)
	acf.add_action(
		'wysiwyg_tinymce_init',
		function(ed, id, mceInit, $field) {
			// reduce tinymce's min-height settings
			ed.settings.autoresize_min_height = 100;
			// reduce iframe's 'height' style to match tinymce settings
			$( '.acf-editor-wrap iframe' ).css( 'height', '100px' );
		}
	);
})( jQuery )
