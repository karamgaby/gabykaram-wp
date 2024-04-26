<?php
/**
 * Plugin Name:       X UI Library
 * Description:       Core component system library
 * Version:           0.0.1
 * Requires at least: 5.7
 * Requires PHP:      8.0
 * Author:            Gaby Karam
 * Author URI:        https://gabykaram.com
 * License:           GPL v3 or later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       safe-svg
 *
 * @package x-ui-library
 */
if ( ! defined( 'ABSPATH' ) ) {
  exit();
}

require_once __DIR__ . '/vendor/autoload.php';
global $x_ui_plugin_path;
$x_ui_plugin_path = plugin_dir_path( __FILE__ );

// Load WordPress core functions if they are not already loaded
if ( ! function_exists( 'get_plugin_data' ) ) {
  require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

/**
 * polarstork_theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package polarstork
 */
$plugin_data = get_plugin_data( __FILE__ );
$plugin_version = $plugin_data['Version'];

define( 'X_UI_PLUGIN_VERSION', $plugin_version );

/**
 * Core setup.
 */

$media_breakpoints = X_UI\Core\Config::get_grid_breakpoints_keys(  );
