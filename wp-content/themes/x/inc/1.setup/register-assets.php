<?php


/**
 * Enqueue scripts and styles
 */
add_action( 'wp_enqueue_scripts', function () {
  // main css
  wp_enqueue_style(
    'x-style',
    get_template_directory_uri() . '/dist/styles/main.css',
    [],
    x_last_edited('css')
  );

  // background colors
  if (function_exists('x_enqueue_color_variables')) {
    wp_add_inline_style('x-style', x_enqueue_color_variables());
  }

  // main js
  wp_enqueue_script(
    'x-js',
    get_template_directory_uri() . '/dist/scripts/main.js',
    ['jquery'],
    x_last_edited('js'),
    true
  );
  wp_localize_script(
    'x-js',
    'x_theme_script_vars',
    array(
      'ajax_url'      => admin_url( 'admin-ajax.php' ),
      'rest_url'      => get_rest_url(),
      'site_domain'   => $_SERVER['SERVER_NAME'],
      'blog_page_url' => get_post_type_archive_link( 'post' ),
    )
  );
  // comments
  if (is_singular() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

  // wp-embed
  wp_deregister_script('wp-embed');

} );

/**
 * Enqueue styles for Gutenberg Editor
 */
add_action( 'enqueue_block_editor_assets', function () {
  // editor styles
  wp_enqueue_style(
    'x-editor-gutenberg-style',
    get_stylesheet_directory_uri() . '/dist/styles/editor-gutenberg.css',
    [],
    x_last_edited( 'css' )
  );

  // custom colors
  if ( function_exists( 'x_enqueue_color_variables' ) ) {
    wp_add_inline_style( 'x-editor-gutenberg-style', x_enqueue_color_variables() );
  }

  // editor scripts
  wp_enqueue_script(
    'x-editor-gutenberg-scripts',
    get_stylesheet_directory_uri() . '/dist/scripts/editor-gutenberg.js',
    [ 'wp-i18n', 'wp-blocks', 'wp-dom-ready' ],
    x_last_edited( 'js' ),
    true
  );
}, 10 );

/**
 * Enqueue scripts and styles for admin
 */
add_action( 'admin_enqueue_scripts', function () {
  // admin.css
  wp_enqueue_style(
    'x-admin-css',
    get_template_directory_uri() . '/dist/styles/admin.css',
    [],
    x_last_edited( 'css' )
  );
} );

/**
 * Enqueue styles for Classic Editor
 */
add_action( 'admin_init', function () {
  add_editor_style( 'dist/styles/editor-classic.css' );
} );
