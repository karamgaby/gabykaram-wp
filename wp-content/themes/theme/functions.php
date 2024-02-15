<?php

/**
 * polarstork_theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package polarstork
 */
if ( ! defined( 'STORKER_THEME_VERSION' ) ) {
	$theme         = wp_get_theme();
	$theme_version = $theme->get( 'Version' );
	define( 'STORKER_THEME_VERSION', $theme_version );
}

define( 'STORKER_DATE_FORMAT', 'd.m.Y' );

/**
 * Theme setup.
 */
require get_template_directory() . '/inc/theme-setup.php';
require get_template_directory() . '/inc/reset.php';
require get_template_directory() . '/inc/utils.php';
require get_template_directory() . '/inc/cf7.php';
require get_template_directory() . '/inc/gutenberg.php';
require get_template_directory() . '/inc/components-system.php';
require get_template_directory() . '/inc/acf-inc.php';
require get_template_directory() . '/inc/acf-hooks.php';
require get_template_directory() . '/inc/user-roles.php';

// import TGM Plugin Activation library
require_once get_template_directory() . '/inc/tgm/class-tgm-plugin-activation.php';
// import TGM Plugin Activation library setup
require_once get_template_directory() . '/inc/tgm/function-required-plugins.php';

/**
 * Load Jetpack compatibility file.
 */
// require get_template_directory() . '/inc/string-translations.php';
