<?php
namespace X_UI\Core;

class  RegisterAssets {
  private static ?RegisterAssets $instance = null;

  public readonly string $menu_slug;
  public static function getInstance(): RegisterAssets {
    if ( ! self::$instance ) {
      self::$instance = new RegisterAssets();
    }

    return self::$instance;
  }
  private function __construct() {

    /**
     * Enqueue scripts and styles for admin
     */
    add_action('admin_enqueue_scripts', function() {
      // admin.css
      wp_enqueue_style(
        'x-ui-library-admin-css',
        trailingslashit(X_UI_LIBRARY_PLUGIN_DIR_URL)  . 'dist/styles/admin.css',
        [],
        x_last_edited('css')
      );

    });
    /**
     * Add sizing info to image function to responsive image logic
     *
     * Module specific sizings should be registeder from the module.
     *
     * @param array $sizes
     *
     * @return array $sizes
     */
    add_filter('theme_image_sizing', function($sizes) {

      $sizes['full'] = [
        'primary'    => 'full',
        'supporting' => ['full', 'large', 'medium'],
        'sizes'      => '(min-width: 800px) 800px, 100vw'
      ];
      $sizes['large'] = [
        'primary'    => 'large',
        'supporting' => ['full', 'large', 'medium'],
        'sizes'      => '(min-width: 800px) 800px, 100vw'
      ];
      $sizes['medium'] = [
        'primary'    => 'medium',
        'supporting' => ['full', 'large', 'medium'],
        'sizes'      => '(min-width: 400px) 400px, 100vw'
      ];

      $sizes['thumbnail'] = [
        'primary'    => 'thumbnail',
        'supporting' => ['thumbnail'],
        'sizes'      => '100px'
      ];

      return $sizes;

    });
  }
}
