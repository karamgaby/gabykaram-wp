<?php
namespace X_UI\Modules\MenuBar;

use X_UI\Core\AbstractTemplateLoader;

class TemplateLoader extends AbstractTemplateLoader {

  public function __construct() {
    $this->filter_prefix = $this->filter_prefix . '_modules_' .basename(__DIR__);
    $this->theme_template_directory = trailingslashit($this->theme_template_directory) . "modules/" . basename(__DIR__);
    $this->plugin_directory = trailingslashit($this->plugin_directory) . "modules/". basename(__DIR__);
  }
}
