<?php

namespace X_UI\Core\Modules\MenuBar;

use X_UI\Core\AbstractTokens;
class Tokens extends AbstractTokens {
  private static $instance = null;
  private function __construct() {
    parent::__construct([
        "breakpoint" => "lg",
        "desktop" => [
            "button_style" => "text-only",
            "active_button_style" => "text-only-active",
            "header_bg_color" => "white-white-50",
            "shadow" => "medium",
            "maxWidth" => "64.65rem",
        ],
        "mobile" => [
            "button_style" => "text-only",
            "active_button_style" => "text-only-active",
            "header_bg_color" => "white-white-50",
            "shadow" => "medium",
            "maxWidth" => null,
        ],
        "drawer" => [
            "bg_color" => "white-white-50",
            "button_style" => "text-only",
            "active_button_style" => "text-only-active",
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
