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

use X_UI\Core\Menu;
use X_UI\Core\ModuleLoader;

if ( ! defined( 'WPINC' ) ) {
  die; // Abort, if called directly.
}

require_once __DIR__ . '/vendor/autoload.php';
$x_ui_plugin_path = plugin_dir_path( __FILE__ );

/**
 * Current plugin version.
 */
$plugin_data = get_file_data( __FILE__, [ 'version' => 'Version' ] );
define( 'X_UI_LIBRARY_PLUGIN_VERSION', $plugin_data['version'] );

/**
 * Path constants.
 */
define( 'X_UI_LIBRARY_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'X_UI_LIBRARY_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
// Load WordPress core functions if they are not already loaded
if ( ! function_exists( 'get_plugin_data' ) ) {
  require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

/**
 * Core setup.
 */
Menu::getInstance();
$moduleLoader = new ModuleLoader();
$moduleLoader->loadModules();

