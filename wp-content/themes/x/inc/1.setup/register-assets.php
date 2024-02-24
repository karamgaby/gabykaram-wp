<?php


/**
 * Enqueue scripts and styles
 */
add_action( 'wp_enqueue_scripts', 'x_scripts' );

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
