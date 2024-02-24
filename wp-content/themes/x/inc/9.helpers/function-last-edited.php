<?php
/**
 * Cache hooks and functions
 *
 * @package axio
 */

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
function x_last_edited($asset = 'css') {

  global $x_timestamps;

  // save timestamps to cache in global variable for this request
  if (empty($x_timestamps)) {

    $filepath = get_template_directory() . '/assets/last-edited.json';

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
