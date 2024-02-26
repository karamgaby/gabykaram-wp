<?php

namespace core;

class Yoast {
	private static $instance;
	public static function getInstance(): Yoast {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		add_filter( 'wpseo_metabox_prio', [$this, 'lowpriority_yoastseo'] );
	}

	/**
	 *  Set Yoast SEO plugin metabox priority to low.
	 */
	public function lowpriority_yoastseo() {
		return 'low';
	}
}
