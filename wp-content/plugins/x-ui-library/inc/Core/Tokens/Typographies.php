<?php

namespace X_UI\Core\Tokens;

use X_UI\Core\AbstractTokens;

class Typographies extends AbstractTokens {
  private static $instance = null;

  private function __construct() {
    parent::__construct( [
      "typographies" => [
        "h1"              => [
          "fontFamily"     => "Outfit",
          "fontSize"       => "4rem",
          "fontWeight"     => "700",
          "letterSpacing"  => "0.5px",
          "lineHeight"     => "120%",
          "textTransform"  => "none",
          "textDecoration" => "none",
        ],
        "h2"              => [
          "fontFamily"     => "Outfit",
          "fontSize"       => "4rem",
          "fontWeight"     => "600",
          "letterSpacing"  => "0.5px",
          "lineHeight"     => "120%",
          "textTransform"  => "none",
          "textDecoration" => "none",
        ],
        "h3"              => [
          "fontFamily"     => "Outfit",
          "fontSize"       => "3rem",
          "fontWeight"     => "600",
          "letterSpacing"  => "0.5px",
          "lineHeight"     => "100%",
          "textTransform"  => "none",
          "textDecoration" => "none",
        ],
        "h4"              => [
          "fontFamily"     => "Outfit",
          "fontSize"       => "2.25rem",
          "fontWeight"     => "700",
          "letterSpacing"  => "0.5px",
          "lineHeight"     => "100%",
          "textTransform"  => "none",
          "textDecoration" => "none",
        ],
        "h5"              => [
          "fontFamily"     => "Outfit",
          "fontSize"       => "1.5rem",
          "fontWeight"     => "700",
          "letterSpacing"  => "0.5px",
          "lineHeight"     => "100%",
          "textTransform"  => "none",
          "textDecoration" => "none",
        ],
        "subtitle-1"      => [
          "fontFamily"     => "Outfit",
          "fontSize"       => "1.5rem",
          "fontWeight"     => "400",
          "letterSpacing"  => "0.5px",
          "lineHeight"     => "150%",
          "textTransform"  => "none",
          "textDecoration" => "none",
        ],
        "subtitle-2"      => [
          "fontFamily"     => "Outfit",
          "fontSize"       => "1.125rem",
          "fontWeight"     => "600",
          "letterSpacing"  => "0.5px",
          "lineHeight"     => "100%",
          "textTransform"  => "none",
          "textDecoration" => "none",
        ],
        "body-1"          => [
          "fontFamily"     => "Outfit",
          "fontSize"       => "1rem",
          "fontWeight"     => "400",
          "letterSpacing"  => "0.5px",
          "lineHeight"     => "130%",
          "textTransform"  => "none",
          "textDecoration" => "none",
        ],
        "body-2"          => [
          "fontFamily"     => "Outfit",
          "fontSize"       => "0.875rem",
          "fontWeight"     => "400",
          "letterSpacing"  => "0.5px",
          "lineHeight"     => "120%",
          "textTransform"  => "none",
          "textDecoration" => "none",
        ],
        "body-3"          => [
          "fontFamily"     => "Outfit",
          "fontSize"       => "0.875rem",
          "fontWeight"     => "600",
          "letterSpacing"  => "0.5px",
          "lineHeight"     => "120%",
          "textTransform"  => "none",
          "textDecoration" => "none",
        ],
        "paragraph"       => [
          "fontFamily"     => "Outfit",
          "fontSize"       => "1rem",
          "fontWeight"     => "400",
          "letterSpacing"  => "0.5px",
          "lineHeight"     => "100%",
          "textTransform"  => "none",
          "textDecoration" => "none",
        ],
        "button-standard" => [
          "fontFamily"     => "Outfit",
          "fontSize"       => "1rem",
          "fontWeight"     => "600",
          "letterSpacing"  => "0.5px",
          "lineHeight"     => "100%",
          "textTransform"  => "none",
          "textDecoration" => "none",
        ],
        "button-medium"   => [
          "fontFamily"     => "Outfit",
          "fontSize"       => "0.875rem",
          "fontWeight"     => "500",
          "letterSpacing"  => "0.5px",
          "lineHeight"     => "100%",
          "textTransform"  => "none",
          "textDecoration" => "none",
        ],
        "link"            => [
          "fontFamily"     => "Outfit",
          "fontSize"       => "1rem",
          "fontWeight"     => "500",
          "letterSpacing"  => "0.5px",
          "lineHeight"     => "100%",
          "textTransform"  => "none",
          "textDecoration" => "underline",
        ],
        "input-text"      => [
          "fontFamily"     => "Outfit",
          "fontSize"       => "0.875rem",
          "fontWeight"     => "400",
          "letterSpacing"  => "0.5px",
          "lineHeight"     => "100%",
          "textTransform"  => "none",
          "textDecoration" => "none",
        ],
        "input-label"     => [
          "fontFamily"     => "Outfit",
          "fontSize"       => "0.75rem",
          "fontWeight"     => "300",
          "letterSpacing"  => "0.5px",
          "lineHeight"     => "100%",
          "textTransform"  => "none",
          "textDecoration" => "none",
        ],
        "badge"           => [
          "fontFamily"     => "Outfit",
          "fontSize"       => "0.75rem",
          "fontWeight"     => "500",
          "letterSpacing"  => "0.5px",
          "lineHeight"     => "100%",
          "textTransform"  => "none",
          "textDecoration" => "none",
        ],
      ],
    ] );
  }

  public static function getInstance() {
    if ( ! self::$instance ) {
      self::$instance = new Typographies();
    }

    return self::$instance;
  }
}