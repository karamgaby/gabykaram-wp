<?php

namespace X_Modules\MenuBar;

use X_UI\Core\AbstractTokens;
class Tokens extends AbstractTokens {
  private static $instance = null;
  private function __construct() {
    parent::__construct([
        "breakpoint" => "lg",
        "desktop" => [
            "header_bg_color" => "white-white-50",
            "shadow" => "medium",
            "maxWidth" => "64.65rem",
        ],
        "mobile" => [
            "header_bg_color" => "white-white-50",
            "shadow" => "medium",
            "maxWidth" => null,
        ],
        "drawer" => [
            "bg_color" => "white-white-50",
            "shadow" => "big",
            "maxWidth" => "23rem",
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
