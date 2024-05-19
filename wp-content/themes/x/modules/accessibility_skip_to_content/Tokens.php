<?php

namespace X_Theme\Modules\AccessibleSkipButton;

use X_UI\Core\AbstractTokens;
class Tokens extends AbstractTokens {
  private static $instance = null;
  private function __construct() {
    parent::__construct([
        "data" => [
            "button_style" => "primary-standard",
        ],
    ]);
  }

  public static function getInstance() {
    if (!self::$instance) {
      self::$instance = new Tokens();
    }
    return self::$instance;
  }
}
