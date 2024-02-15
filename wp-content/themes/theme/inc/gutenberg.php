<?php
/**
 * Where we manage hooks related to gutenberg
 */


/*
 * Select what blocks are available in the editor
 *
 * $block_types = WP_Block_Type_Registry::get_instance()->get_all_registered();
 * $block_types -> array of all registered blocks
 */
add_filter( 'allowed_block_types_all', 'ps_gutenberg_allowed_block_types', 10, 2 );
function ps_gutenberg_allowed_block_types( $allowed_block_types, $block_editor_context ) {
	$blocks   = array();
	$blocks[] = 'core/post-title';
	$blocks[] = 'core/paragraph';
	$blocks[] = 'core/heading';
	$blocks[] = 'core/list';
	$blocks[] = 'core/list-item';
	$blocks[] = 'core/quote';
	$blocks[] = 'core/image';
	$blocks[] = 'core/freeform';
	$blocks[] = 'core/media-text';
	$blocks[] = 'core/columns';
	$blocks[] = 'core/group';
	$blocks[] = 'core/separator';
	$blocks[] = 'core/post-date';
	$blocks[] = 'core/post-excerpt';
	$blocks[] = 'core/post-featured-image';
	$blocks[] = 'acf/youtube-video';

	// $blocks[] = 'core/block';
	return $blocks;
}

/*
 * disable Gutenberg
 */
add_filter( 'use_block_editor_for_post', 'ps_handle_disable_gutenberg', 10, 2 );
function ps_handle_disable_gutenberg( $use_block_editor, $post ) {
	if ( $post->post_type === 'post' ) {
		return true;
	}

	return false;
}

/*
 * Filter block controls per component
 *
 * */
add_filter( 'block_type_metadata', 'bv_filter_gutenberg_metadata_registration' );
function bv_filter_gutenberg_metadata_registration( $metadata ) {
	$name          = $metadata['name'];
	$disabled_html = array(
		'core/paragraph',
		'core/heading',
		'core/list',
		'core/list-item',
		'core/image',
		'core/columns',
		'core/quote',
		'core/group',
		'core/media-text',
	);
	if ( $name === 'core/image' ) {
		$metadata['usesContext'] = array();
		if ( isset( $metadata['supports']['__experimentalBorder'] ) ) {
			$metadata['supports']['__experimentalBorder']['width']  = false;
			$metadata['supports']['__experimentalBorder']['radius'] = false;
			unset( $metadata['supports']['__experimentalBorder']['__experimentalDefaultControls']['width'] );
			unset( $metadata['supports']['__experimentalBorder']['__experimentalDefaultControls']['radius'] );
		}
		unset( $metadata['styles'] );
	}
	if ( in_array( $name, $disabled_html, true ) ) {
		$metadata['supports']['html'] = false;
		if ( isset( $metadata['supports']['color'] ) ) {
			$metadata['supports']['color']['gradient'] = false;
			$metadata['supports']['color']['link']     = false;
			if ( isset( $metadata['supports']['color']['__experimentalDefaultControls'] ) ) {
				$metadata['supports']['color']['__experimentalDefaultControls']['background'] = false;
				$metadata['supports']['color']['__experimentalDefaultControls']['text']       = false;
			}
		}
		if ( isset( $metadata['supports']['typography'] ) ) {
			$metadata['supports']['typography']['fontSize']                    = false;
			$metadata['supports']['typography']['lineHeight']                  = false;
			$metadata['supports']['typography']['__experimentalFontFamily']    = false;
			$metadata['supports']['typography']['__experimentalFontStyle']     = false;
			$metadata['supports']['typography']['__experimentalLetterSpacing'] = false;
			$metadata['supports']['typography']['__experimentalFontWeight']    = false;
			if ( isset( $metadata['supports']['typography']['__experimentalDefaultControls'] ) ) {
				$metadata['supports']['typography']['__experimentalDefaultControls']['fontSize']                     = false;
				$metadata['supports']['typography']['__experimentalDefaultControls']['lineHeight']                   = false;
				$metadata['supports']['typography']['__experimentalDefaultControls']['__experimentalTextTransform']  = true;
				$metadata['supports']['typography']['__experimentalDefaultControls']['__experimentalTextDecoration'] = true;
			}
		}
	}

	return $metadata;
}

/**
 * Filter global blocks controls
 * */

function ps_filter_gutenberg_global_editor_setting( $editor_settings ) {
	$editor_settings['codeEditingEnabled']                            = false;
	$editor_settings['alignWide']                                     = false;
	$editor_settings['imageEditing']                                  = false;
	$editor_settings['enableCustomLineHeight']                        = false;
	$editor_settings['disableCustomColors']                           = true;
	$editor_settings['disableCustomFontSizes']                        = true;
	$editor_settings['disableCustomGradients']                        = true;
	$editor_settings['disableLayoutStyles']                           = true;
	$editor_settings['colors']                                        = array();
	$editor_settings['gradients']                                     = array();
	$editor_settings['fontSizes']                                     = array();
	$editor_settings['spacingSizes']                                  = array();
	$editor_settings['__experimentalFeatures']['color']['background'] = false;
	$editor_settings['__experimentalFeatures']['color']['customDuotone']        = false;
	$editor_settings['__experimentalFeatures']['color']['defaultDuotone']       = false;
	$editor_settings['__experimentalFeatures']['color']['defaultGradients']     = false;
	$editor_settings['__experimentalFeatures']['color']['defaultPalette']       = false;
	$editor_settings['__experimentalFeatures']['color']['duotone']['default']   = array();
	$editor_settings['__experimentalFeatures']['color']['gradients']['default'] = array();
	$editor_settings['titlePlaceholder']                                        = 'Bridging voice post title';
	return $editor_settings;
}

add_filter( 'block_editor_settings_all', 'ps_filter_gutenberg_global_editor_setting' );


function ps_gutenberg_disable_custom_colors() {
	add_theme_support( 'disable-custom-colors' );
	add_theme_support( 'disable-custom-gradients' );
	add_theme_support( 'custom-units', array( '%' ) );
	add_theme_support( 'editor-color-palette', array() );
	add_theme_support( 'editor-gradient-presets', array() );
}
add_action( 'after_setup_theme', 'ps_gutenberg_disable_custom_colors' );

function add_gutenberg_related_scripts( $hook ) {
	// admin.css
	wp_enqueue_style(
		'polarstork-admin-css',
		get_template_directory_uri() . '/build/css/gutenberg.min.css',
		array(),
		STORKER_THEME_VERSION
	);
	wp_enqueue_script( 'ps_gutenberg_scrips', get_template_directory_uri() . '/build/js/gutenberg.min.js', array( 'jquery-core', 'wp-hooks' ), STORKER_THEME_VERSION );
}
add_action( 'enqueue_block_editor_assets', 'add_gutenberg_related_scripts' );

add_action( 'init', 'ps_register_acf_blocks' );
function ps_register_acf_blocks() {
	// register_block_type( get_template_directory() . '/blocks/youtube-video' );
}
