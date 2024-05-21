<?php
/**
 * Setup: Footer
 *
 * @package axio
 */


/**
 * Localization
 */

use X_UI\Core\PluginSettings;

/**
 * Load ACF fields
 */
//add_filter('acf/settings/load_json', function ($paths) {
//  $paths[] = dirname(__FILE__) . '/acf-json';
//  return $paths;
//
//});

add_filter( 'acf/settings/load_json', function ( $paths ) {
  $custom_acf_json_dir = dirname( __FILE__ ) . '/acf-json';
  $paths[]             = $custom_acf_json_dir;

  return $paths;
} );

add_action( 'acf/init', function () {
  $field_groups = acf_get_field_groups();
  error_log( 'Loaded ACF field groups: ' . print_r( $field_groups, true ) );
} );
add_filter( 'x_core_pll_register_strings', function ( $strings ) {
  return array_merge( $strings, [
    'Menu: Site Map'              => 'Site Map',
    'Settings: Footer Options'    => 'Footer Options',
    'Settings: Footer Menu Title' => 'Footer',
  ] );
}, 10, 1 );

/**
 * Register menu positions
 */
add_action( 'after_setup_theme', function () {
  register_nav_menus( [
    'site_map' => ask__( 'Menu: Site Map' ),
  ] );
} );

add_action( 'acf/init', function () {
  $pluginSettings   = PluginSettings::getInstance();
  $parent_menu_slug = $pluginSettings->menu_slug;
  acf_add_options_page( array(
    'page_title'  => ask__( 'Settings: Footer Options' ),
    'menu_slug'   => $parent_menu_slug . '_footer-options',
    'parent_slug' => $parent_menu_slug,
    'menu_title'  => ask__( 'Settings: Footer Menu Title' ),
    'position'    => 200,
    'redirect'    => false,
    'description' => 'Where you set the footer content and options',
  ) );
} );

/**
 * Register image sizes
 */
add_action( 'after_setup_theme', function () {

  add_image_size( 'footer_logo_l', 148, 148, false );
  add_image_size( 'footer_logo_m', 74, 74, false );

} );

/**
 * Image sizing
 */
add_filter( 'theme_image_sizing', function ( $sizes ) {

  $sizes['footer_logo'] = [
    'primary'    => 'footer_logo_m',
    'supporting' => [ 'footer_logo_l', 'footer_logo_m' ],
    'sizes'      => '(min-width: 720px) 100vw, 110vw' // compensates for horizontal-ish image
  ];

  return $sizes;

} );
