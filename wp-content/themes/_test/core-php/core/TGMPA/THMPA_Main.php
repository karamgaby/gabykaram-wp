<?php
namespace core\TGMPA core\TGMPA\TGM_Plugin_Activation;

-php\core\TGMPA;
/**
 * Plugin installation and activation for WordPress themes.
 *
 * Please note that this is a drop-in library for a theme or plugin.
 * The authors of this library (Thomas, Gary and Juliette) are NOT responsible
 * for the support of your plugin or theme. Please contact the plugin
 * or theme author for support.
 *
 * @package   TGM-Plugin-Activation
 * @version   2.6.1
 * @link      http://tgmpluginactivation.com/
 * @author    Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright Copyright (c) 2011, Thomas Griffin
 * @license   GPL-2.0+
 */
// phpcs:ignoreFile
/*
	Copyright 2011 Thomas Griffin (thomasgriffinmedia.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class THMPA_Main {
	private static $instance;
	public static function getInstance(): THMPA_Main {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}
	private function __construct() {
		if ( did_action( 'plugins_loaded' ) ) {
			$this->load_tgm_plugin_activation();
		} else {
			add_action( 'plugins_loaded', [$this, 'load_tgm_plugin_activation'] );
		}
	}

	public 	function load_tgm_plugin_activation() {
//		TGM_Plugin_Activation::get_instance();
		$GLOBALS['tgmpa'] = TGM_Plugin_Activation::get_instance();
	}

	/**
	 * Helper function to register a collection of required plugins.
	 *
	 * @since 2.0.0
	 * @api
	 *
	 * @param array $plugins An array of plugin arrays.
	 * @param array $config  Optional. An array of configuration values.
	 */
	public function tgmpa( $plugins, $config = array() ) {
		if(!isset( $GLOBALS['tgmpa'])) {
			return;
		}
		$instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );

		foreach ( $plugins as $plugin ) {
			$instance->register( $plugin );
		}

		if ( ! empty( $config ) && is_array( $config ) ) {
			// Send out notices for deprecated arguments passed.
			if ( isset( $config['notices'] ) ) {
				_deprecated_argument( __FUNCTION__, '2.2.0', 'The `notices` config parameter was renamed to `has_notices` in TGMPA 2.2.0. Please adjust your configuration.' );
				if ( ! isset( $config['has_notices'] ) ) {
					$config['has_notices'] = $config['notices'];
				}
			}

			if ( isset( $config['parent_menu_slug'] ) ) {
				_deprecated_argument( __FUNCTION__, '2.4.0', 'The `parent_menu_slug` config parameter was removed in TGMPA 2.4.0. In TGMPA 2.5.0 an alternative was (re-)introduced. Please adjust your configuration. For more information visit the website: https://tgmpluginactivation.com/configuration/#h-configuration-options.' );
			}
			if ( isset( $config['parent_url_slug'] ) ) {
				_deprecated_argument( __FUNCTION__, '2.4.0', 'The `parent_url_slug` config parameter was removed in TGMPA 2.4.0. In TGMPA 2.5.0 an alternative was (re-)introduced. Please adjust your configuration. For more information visit the website: https://tgmpluginactivation.com/configuration/#h-configuration-options.' );
			}

			$instance->config( $config );
		}
	}
}
