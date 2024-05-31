<?php

namespace X_UI\Core\Tokens;

use X_UI\Core\AbstractTokens;
class Colors extends AbstractTokens {
  private static $instance = null;
  private function __construct() {
    parent::__construct([
        "colors" => [
            "medium-turquoise-500" => "#33CCCC",
            "medium-turquoise-400" => "#66D9D9",
            "medium-turquoise-300" => "#8CE2E2",
            "medium-turquoise-100" => "#BEEFEF",
            "medium-turquoise-50" => "#CFF3F3",
            "medium-turquoise-600" => "#2CADAD",
            "medium-turquoise-700" => "#259393",
            "medium-turquoise-800" => "#207D7D",
            "yellow-gold-500" => "#F7D414",
            "yellow-gold-300" => "#FFF060",
            "yellow-gold-200" => "#FEF387",
            "yellow-gold-100" => "#FFF8B1",
            "yellow-gold-50" => "#FFFDD3",
            "yellow-gold-600" => "#FFD600",
            "yellow-gold-700" => "#FEBE00",
            "mate-black-900" => "#1F1F1F",
            "mate-black-500" => "#3C3C3B",
            "mate-black-400" => "#2D2D2C",
            "mate-black-200" => "#ACACAB",
            "mate-black-50" => "#D0D0CF",
            "orange-500" => "#EA8E12",
            "orange-400" => "#FDA625",
            "orange-300" => "#FDB64C",
            "orange-200" => "#FFCC81",
            "orange-50" => "#FEF2DF",
            "orange-700" => "#F67C01",
            "orange-900" => "#E75204",
            "white-grey-100" => "#F9F9F9",
            "white-white-50" => "#FFFFFF",
            "white-grey-200" => "#F3F3F3",
            "white-grey-300" => "#E5E5E5",
            "black" => "#000000",
            "error" => "#C6000C",
        ],
    ]);
  }

  public static function getInstance() {
    if (!self::$instance) {
      self::$instance = new Colors();
    }
    return self::$instance;
  }
}
