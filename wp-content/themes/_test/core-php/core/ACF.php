<?php
namespace core-php\core;
/**
 * Setup ACF (Advanced Custom Fields Pro plugin)
 *
 */
class ACF {
	private static $instance;
	public static function getInstance(): ACF {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		/**
		 * Save ACF fields as JSON at theme root /acf-json/
		 */
		add_filter('acf/settings/save_json', function() {

			return get_template_directory() . '/acf-json';

		}, 100);

		/**
		 * Load ACF fields as JSON from theme root /acf-json/
		 */
		add_filter('acf/settings/load_json', function($paths) {

			$paths[] = get_template_directory() . '/acf-json';
			return $paths;

		}, 100);

	}
}
