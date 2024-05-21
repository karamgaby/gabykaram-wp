<?php
namespace X_UI\Core;


class PluginSettings {
  private static ?PluginSettings $instance = null;

  public readonly string $menu_slug;
  public static function getInstance(): PluginSettings {
    if ( ! self::$instance ) {
      self::$instance = new PluginSettings();
    }

    return self::$instance;
  }
  private function __construct() {
    $this->menu_slug = 'x-ui-library-settings';
    add_action( 'acf/init', [$this, 'option_page'] );
  }

  public function option_page() {
      acf_add_options_page( array(
        'page_title' => 'X UI Library Settings',
        'menu_slug' => $this->menu_slug,
        'position' => '',
        'redirect' => false,
        'capability' => 'manage_options',
        'autoload' => true,
      ) );
  }
}
