<?php

if ( ! function_exists( 'bridging_voice_theme_setup' ) ) :

  /**
   * Sets up theme defaults and registers support for various WordPress features.
   *
   * Note that this function is hooked into the after_setup_theme hook, which
   * runs before the init hook. The init hook is too late for some features, such
   * as indicating support for post thumbnails.
   */
  function polarstork_theme_setup() {
    /*
    * Make theme available for translation.
    * Translations can be filed in the /languages/ directory.
    */
    load_theme_textdomain( 'polarstork_theme', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support( 'title-tag' );

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support( 'post-thumbnails' );

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus(
      array(
        'primary-menu' => esc_html__( 'Primary', 'polarstork_theme' ),
        'footer-menu'  => esc_html__( 'footer Menu', 'polarstork_theme' ),
      )
    );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support(
      'html5',
      array(
        'gallery',
        'caption',
      )
    );
    add_theme_support( 'custom-logo' );
  }

endif;
add_action( 'after_setup_theme', 'polarstork_theme_setup' );


/**
 * add new post-thumbnails size for blazy.
 */
add_image_size( 'image-placeholder', 48, 48 );

/**
 * Append to <head>
 */
add_action('wp_head', function() {
  // replace class no-js with js in html tag
  echo "<script>(function(d){d.className = d.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";

});
function x_scripts() {
  // main css
  wp_enqueue_style( 'x-style',
    get_stylesheet_directory_uri() . '/dist/styles/main.css',
    [],
    x_last_edited( 'css' )
  );
  // template specific css
  wp_enqueue_style( 'x-unique-styles', get_stylesheet_directory_uri() . '/build/css/' . get_page_type() . '.css', array( 'x-style' ), STORKER_THEME_VERSION );

  // background colors
  if ( function_exists( 'x_enqueue_color_variables' ) ) {
    wp_add_inline_style( 'x-style', x_enqueue_color_variables() );
  }

  // main js
  wp_enqueue_script(
    'x-js',
    get_template_directory_uri() . '/dist/scripts/main.js',
    array( 'jquery' ),
    x_last_edited( 'js' ),
    true
  );

  wp_localize_script(
    'storker_theme-js',
    'storker_theme_script_vars',
    array(
      'ajax_url'      => admin_url( 'admin-ajax.php' ),
      'rest_url'      => get_rest_url(),
      'site_domain'   => $_SERVER['SERVER_NAME'],
      'blog_page_url' => get_post_type_archive_link( 'post' ),
    )
  );
  // comments
  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }

  // wp-embed
  wp_deregister_script( 'wp-embed' );

}

function get_page_type() {
  global $wp_query;
  $page_type     = 'default';
  $page_template = get_page_template_slug();
  if ( $wp_query->is_single ) {
    $page_type = 'single-' . get_post_type();
  } elseif ( is_author() ) {
    $page_type = 'single-author';
  } elseif ( is_home() ) {
    $page_type = 'blog';
  } elseif ( $wp_query->is_404 || $wp_query->is_category || $wp_query->is_archive || $wp_query->is_tax || $wp_query->is_tag ) {
    $page_type = '404';
  } elseif ( ! empty( $page_template ) && $page_template === 'front-page.php' ) {
    $page_type = 'landing';
  } elseif ( ! empty( $page_template ) && $page_template === 'page-training.php' ) {
    $page_type = 'training';
  }

  return $page_type;
}
