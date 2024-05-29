<?php
/**
 * MenuBar: Data structures
 *
 * @package axio
 */


/**
 * Localization
 */
add_filter('axio_core_pll_register_strings', function($strings) {

  return array_merge($strings, [
    'Button: Type Solid'              => 'Solid',
    'Button: Type Outline'            => 'Outline',
  ]);

}, 10, 1);
