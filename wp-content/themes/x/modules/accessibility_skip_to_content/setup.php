<?php
/**
 * Button: Data structures
 *
 * @package axio
 */

/**
 * Localization
 */
add_filter( 'axio_core_pll_register_strings', function ( $strings ) {

  return array_merge( $strings, [
    'Accessibility: Skip to content' => 'Skip to content',
  ] );

}, 10, 1 );
