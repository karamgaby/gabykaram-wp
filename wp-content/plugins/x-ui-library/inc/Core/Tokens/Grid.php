<?php

namespace X_UI\Core\Tokens;

use X_UI\Core\AbstractTokens;

class Grid extends AbstractTokens {
  private static $instance = null;

  private function __construct() {
    parent::__construct( [
      "columns"             => "24",
      "max-supported-width" => "8000px",
      "breakpoints"         => [
        "xs"  => [
          "minWidth"     => null,
          "gutter"       => "12px",
          "margin"       => "12px",
          "baseFontSize" => "16px",
        ],
        "sm"  => [
          "minWidth"     => "328px",
          "gutter"       => "16px",
          "margin"       => "16px",
          "baseFontSize" => "16px",
        ],
        "md"  => [
          "minWidth"     => "774px",
          "gutter"       => "24px",
          "margin"       => "24px",
          "baseFontSize" => "16px",
        ],
        "lg"  => [
          "minWidth"     => "1280px",
          "gutter"       => "24px",
          "margin"       => "64px",
          "baseFontSize" => "16px",
        ],
        "xl"  => [
          "minWidth"     => "1920px",
          "gutter"       => "24px",
          "margin"       => "24px",
          "baseFontSize" => "24px",
          "maxWidth"     => "1600px",
        ],
        "xxl" => [
          "minWidth"     => "3840px",
          "gutter"       => "48px",
          "margin"       => "320px",
          "baseFontSize" => "24px",
        ],
      ],
      "spacing"             => [
        "1" => "0.5rem",
        "2" => "1rem",
        "3" => "1.5rem",
        "4" => "2rem",
        "5" => "3rem",
        "6" => "4rem",
        "7" => "6rem",
        "8" => "10rem",
      ],
      "border-radius"       => [
        "1" => "0.5rem",
        "2" => "0.75rem",
        "3" => "1rem",
        "4" => "1.25rem",
        "5" => "1.5rem",
      ],
      "shadows"             => [
        "simple" => "(0px 2px 4px -2px rgba(0, 0, 0, 0.5), 0px 4px 6px -1px rgba(0, 0, 0, 0.1))",
        "medium" => "(0px 4px 6px rgba(0, 0, 0, 0.05), 0px 10px 15px -3px rgba(0, 0, 0, 0.1))",
        "big"    => "(0px 10px 10px rgba(0, 0, 0, 0.04), 0px 20px 25px -5px rgba(0, 0, 0, 0.1))",
        "max"    => "(0px 25px 50px -12px rgba(0, 0, 0, 0.25))",
        "clear"  => "(0px 2px 16px -2px rgba(0, 0, 0, 0.25))",
      ],
    ] );
  }

  public static function getInstance() {
    if ( ! self::$instance ) {
      self::$instance = new Grid();
    }

    return self::$instance;
  }
}
