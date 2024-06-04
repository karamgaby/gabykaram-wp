<?php

namespace X_Modules\PictureCards;

use X_UI\Core\AbstractTemplateLoader;

class TemplateLoader extends AbstractTemplateLoader {

  public function __construct() {
    $is_running_inside_theme = str_contains( __FILE__, get_template_directory() );
    if ( $is_running_inside_theme ) {
      $this->theme_template_directory = "modules/" . basename( __DIR__ ) . "/templates/";
    } else {
      $this->theme_template_directory = trailingslashit( $this->theme_template_directory ) . "modules/" . basename( __DIR__ );
    }
    $this->filter_prefix = $this->filter_prefix . '_modules_' . basename( __DIR__ );
    $this->plugin_directory = trailingslashit( $this->theme_template_directory ) . "modules/" . basename( __DIR__ );
  }
}
