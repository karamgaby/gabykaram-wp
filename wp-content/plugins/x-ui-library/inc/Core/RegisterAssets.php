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
        $this->x_last_edited('css')
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


  /**
   * Retrieves the last edited timestamp for a given asset.
   *
   * This function retrieves the last edited timestamp for a given asset type, such
   * as CSS or JavaScript. The timestamps are cached in a global variable for the
   * current request. If there is no cached value, it attempts to load the timestamps
   * from a JSON file and save them to the global variable.
   *
   * @param string $asset The asset type (default: 'css').
   *
   * @return int The last edited timestamp for the given asset. If the asset is not found
   *             or the timestamps are not available, it returns 0.
   */
  private function x_last_edited($asset = 'css') {

    global $x_timestamps;

    // save timestamps to cache in global variable for this request
    if (empty($x_timestamps)) {

      $filepath = trailingslashit( X_UI_LIBRARY_PLUGIN_DIR_URL) . 'assets/last-edited.json';

      if (file_exists($filepath)) {
        $json = file_get_contents($filepath);
        $x_timestamps = json_decode($json, true);
      }

    }

    // use cached value from global variable
    if (isset($x_timestamps[$asset])) {
      return absint($x_timestamps[$asset]);
    }

    return 0;

  }

}
