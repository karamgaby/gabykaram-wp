<?php

namespace X_Modules\ContactSection;

use X_UI\Core\AbstractTokens;
class Tokens extends AbstractTokens {
  private static $instance = null;
  private function __construct() {
    parent::__construct([
        "bgColor" => "mate-black-800",
        "titleColor" => "yellow-gold-300",
        "textColor" => "white-white-50",
    ]);
  }

  public static function getInstance() {
    if (!self::$instance) {
      self::$instance = new Tokens();
    }
    return self::$instance;
  }
}
