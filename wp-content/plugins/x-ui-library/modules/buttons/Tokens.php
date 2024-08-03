<?php

namespace X_UI\Core\Modules\Buttons;

use X_UI\Core\AbstractTokens;
class Tokens extends AbstractTokens {
  private static $instance = null;
  private function __construct() {
    parent::__construct([
        "buttons" => [
            "primary-standard" => [
                "label" => "Primary Standard",
                "default" => [
                    "textStyle" => "button-standard",
                    "bgColor" => "medium-turquoise-500",
                    "textColor" => "mate-black-900",
                    "padding" => "0.75rem 1rem",
                    "borderRadius" => "0.75rem",
                    "outline" => null,
                ],
                "hover" => [
                    "bgColor" => "medium-turquoise-400",
                ],
                "disabled" => [
                    "bgColor" => "white-grey-300",
                    "textColor" => "mate-black-200",
                ],
            ],
            "icon-left" => [
                "label" => "Icon Left",
                "hasIcon" => "true",
                "iconPosition" => "start",
                "default" => [
                    "textStyle" => "button-standard",
                    "bgColor" => "medium-turquoise-500",
                    "textColor" => "mate-black-900",
                    "padding" => "0.75rem 1rem",
                    "borderRadius" => "0.75rem",
                    "outline" => null,
                    "iconFillColor" => "black",
                ],
                "hover" => [
                    "bgColor" => "medium-turquoise-400",
                ],
                "disabled" => [
                    "bgColor" => "white-grey-300",
                    "textColor" => "mate-black-200",
                    "iconFillColor" => "mate-black-200",
                ],
            ],
            "primary-outlined" => [
                "label" => "Primary Outlined",
                "default" => [
                    "textStyle" => "button-standard",
                    "bgColor" => "transparent",
                    "textColor" => "mate-black-900",
                    "padding" => "0.75rem 1rem",
                    "borderRadius" => "0.75rem",
                    "outline" => [
                        "style" => "solid",
                        "width" => "0.125rem",
                        "offset" => "-0.125rem",
                        "color" => "medium-turquoise-500",
                    ],
                ],
                "hover" => [
                    "bgColor" => "medium-turquoise-50",
                ],
                "disabled" => [
                    "bgColor" => "white-grey-300",
                    "textColor" => "mate-black-200",
                    "outline" => [
                        "color" => "mate-black-200",
                    ],
                ],
            ],
            "icon-left-outlined" => [
                "label" => "Icon Left Outlined",
                "hasIcon" => "true",
                "iconPosition" => "start",
                "default" => [
                    "textStyle" => "button-standard",
                    "bgColor" => "transparent",
                    "textColor" => "mate-black-900",
                    "padding" => "0.75rem 1rem",
                    "borderRadius" => "0.75rem",
                    "iconFillColor" => "black",
                    "outline" => [
                        "style" => "solid",
                        "width" => "0.125rem",
                        "offset" => "-0.125rem",
                        "color" => "medium-turquoise-500",
                    ],
                ],
                "hover" => [
                    "bgColor" => "medium-turquoise-50",
                ],
                "disabled" => [
                    "bgColor" => "white-grey-300",
                    "textColor" => "mate-black-200",
                    "iconFillColor" => "mate-black-200",
                    "outline" => [
                        "color" => "mate-black-200",
                    ],
                ],
            ],
            "icon-right" => [
                "label" => "Icon Right",
                "hasIcon" => "true",
                "iconPosition" => "end",
                "default" => [
                    "textStyle" => "button-standard",
                    "bgColor" => "medium-turquoise-500",
                    "textColor" => "mate-black-900",
                    "padding" => "0.75rem 1rem",
                    "borderRadius" => "0.75rem",
                    "outline" => null,
                    "iconFillColor" => "black",
                ],
                "hover" => [
                    "bgColor" => "medium-turquoise-400",
                ],
                "disabled" => [
                    "bgColor" => "white-grey-300",
                    "textColor" => "mate-black-200",
                    "iconFillColor" => "mate-black-200",
                ],
            ],
            "icon-right-outlined" => [
                "label" => "Icon Right Outlined",
                "hasIcon" => "true",
                "iconPosition" => "end",
                "default" => [
                    "textStyle" => "button-standard",
                    "bgColor" => "transparent",
                    "textColor" => "mate-black-900",
                    "padding" => "0.75rem 1rem",
                    "borderRadius" => "0.75rem",
                    "iconFillColor" => "black",
                    "outline" => [
                        "style" => "solid",
                        "width" => "0.125rem",
                        "offset" => "-0.125rem",
                        "color" => "medium-turquoise-500",
                    ],
                ],
                "hover" => [
                    "bgColor" => "medium-turquoise-50",
                ],
                "disabled" => [
                    "bgColor" => "white-grey-300",
                    "textColor" => "mate-black-200",
                    "iconFillColor" => "mate-black-200",
                    "outline" => [
                        "color" => "mate-black-200",
                    ],
                ],
            ],
            "light" => [
                "label" => "Light",
                "default" => [
                    "textStyle" => "button-standard",
                    "bgColor" => "white-white-50",
                    "textColor" => "mate-black-900",
                    "padding" => "0.75rem 1rem",
                    "borderRadius" => "0.75rem",
                    "outline" => null,
                ],
                "hover" => [
                    "bgColor" => "medium-turquoise-50",
                ],
                "disabled" => [
                    "bgColor" => "white-grey-300",
                    "textColor" => "mate-black-200",
                ],
            ],
            "secondary-outlined" => [
                "label" => "Secondary Outlined",
                "default" => [
                    "textStyle" => "button-standard",
                    "bgColor" => "transparent",
                    "textColor" => "mate-black-900",
                    "padding" => "0.75rem 1rem",
                    "borderRadius" => "0.75rem",
                    "outline" => [
                        "style" => "solid",
                        "width" => "0.125rem",
                        "offset" => "-0.125rem",
                        "color" => "orange-700",
                    ],
                ],
                "hover" => [
                    "bgColor" => "orange-50",
                ],
                "disabled" => [
                    "bgColor" => "white-grey-300",
                    "textColor" => "mate-black-200",
                    "outline" => [
                        "color" => "mate-black-200",
                    ],
                ],
            ],
            "icon-right-secondary" => [
                "label" => "Icon Right Secondary",
                "hasIcon" => "true",
                "iconPosition" => "end",
                "default" => [
                    "textStyle" => "button-standard",
                    "bgColor" => "transparent",
                    "textColor" => "mate-black-900",
                    "padding" => "0.75rem 1rem",
                    "borderRadius" => "0.75rem",
                    "iconFillColor" => "black",
                    "outline" => [
                        "style" => "solid",
                        "width" => "0.125rem",
                        "offset" => "-0.125rem",
                        "color" => "orange-700",
                    ],
                ],
                "hover" => [
                    "bgColor" => "orange-50",
                ],
                "disabled" => [
                    "bgColor" => "white-grey-300",
                    "textColor" => "mate-black-200",
                    "iconFillColor" => "mate-black-200",
                    "outline" => [
                        "color" => "mate-black-200",
                    ],
                ],
            ],
            "icon-left-secondary" => [
                "label" => "Icon Left Secondary",
                "hasIcon" => "true",
                "iconPosition" => "start",
                "default" => [
                    "textStyle" => "button-standard",
                    "bgColor" => "transparent",
                    "textColor" => "mate-black-900",
                    "padding" => "0.75rem 1rem",
                    "borderRadius" => "0.75rem",
                    "iconFillColor" => "black",
                    "outline" => [
                        "style" => "solid",
                        "width" => "0.125rem",
                        "offset" => "-0.125rem",
                        "color" => "orange-700",
                    ],
                ],
                "hover" => [
                    "bgColor" => "orange-50",
                ],
                "disabled" => [
                    "bgColor" => "white-grey-300",
                    "textColor" => "mate-black-200",
                    "iconFillColor" => "mate-black-200",
                    "outline" => [
                        "color" => "mate-black-200",
                    ],
                ],
            ],
            "text-only" => [
                "label" => "Text Only",
                "default" => [
                    "textStyle" => "button-standard",
                    "bgColor" => "transparent",
                    "textColor" => "mate-black-900",
                    "padding" => "0.75rem 1rem",
                    "borderRadius" => "0.75rem",
                ],
                "hover" => [
                    "textColor" => "orange-700",
                ],
                "disabled" => [
                    "textColor" => "mate-black-200",
                    "outline" => [
                        "color" => "mate-black-200",
                    ],
                ],
            ],
            "text-only-active" => [
                "label" => "Text Only Active",
                "default" => [
                    "textStyle" => "button-standard",
                    "bgColor" => "transparent",
                    "textColor" => "orange-700",
                    "padding" => "0.75rem 1rem",
                    "borderRadius" => "0.75rem",
                ],
                "hover" => [
                    "textColor" => "mate-black-900",
                ],
                "disabled" => [
                    "textColor" => "mate-black-200",
                    "outline" => [
                        "color" => "mate-black-200",
                    ],
                ],
            ],
            "icon-right-text" => [
                "label" => "Icon Right Text",
                "hasIcon" => "true",
                "iconPosition" => "end",
                "default" => [
                    "textStyle" => "button-standard",
                    "bgColor" => "transparent",
                    "textColor" => "mate-black-900",
                    "padding" => "0.75rem 1rem",
                    "iconFillColor" => "black",
                    "borderRadius" => "0.75rem",
                ],
                "hover" => [
                    "iconFillColor" => "orange-700",
                ],
                "disabled" => [
                    "textColor" => "mate-black-200",
                    "iconFillColor" => "mate-black-200",
                    "outline" => [
                        "color" => "mate-black-200",
                    ],
                ],
            ],
            "icon-left-text" => [
                "label" => "Icon Left Text",
                "hasIcon" => "true",
                "iconPosition" => "start",
                "default" => [
                    "textStyle" => "button-standard",
                    "bgColor" => "transparent",
                    "textColor" => "mate-black-900",
                    "padding" => "0.75rem 1rem",
                    "iconFillColor" => "black",
                    "borderRadius" => "0.75rem",
                ],
                "hover" => [
                    "iconFillColor" => "orange-700",
                ],
                "disabled" => [
                    "textColor" => "mate-black-200",
                    "iconFillColor" => "mate-black-200",
                    "outline" => [
                        "color" => "mate-black-200",
                    ],
                ],
            ],
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
