<?php


/**
 * Load ACF fields
 */
add_filter( 'acf/settings/load_json', function ( $paths ) {
  $custom_acf_json_dir = dirname( __FILE__ ) . '/acf-json';
  $paths[]             = $custom_acf_json_dir;

  return $paths;
} );
