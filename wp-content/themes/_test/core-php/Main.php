<?php
namespace -php;

use _test\coreuse;
use core\ACF;
use php\core\Yoast;

_test\coreuse _test\coreuse _test\coreuse php\core\ACF;

class Main {
	private static $instance;
	public static function getInstance(): Main {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
	    Theme::getInstance();
      Reset::getInstance();
      Security::getInstance();
      RequiredPlugins::getInstance();
      ACF::getInstance();
      Yoast::getInstance();
    }
}
