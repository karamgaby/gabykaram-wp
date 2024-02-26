<?php

namespace php;

class Reset {
	private static $instance;
	public static function getInstance(): Reset {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}
	private function __construct() {
		add_action( 'after_switch_theme', [$this, 'goodbye_dolly'] );
	}


	public function goodbye_dolly(): void {
		if ( is_admin() && file_exists( WP_PLUGIN_DIR . '/hello.php' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
			require_once ABSPATH . 'wp-admin/includes/file.php';
			delete_plugins( array( 'hello.php' ) );
		}
	}


}
