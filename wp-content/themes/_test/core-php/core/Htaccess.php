<?php
namespace core;

use WP_Error;

class Htaccess {

	public static function update( $key, $htaccess_path, $content ): true|WP_Error {
		if ( ! file_exists( $htaccess_path ) ) {
			$result = file_put_contents( $htaccess_path, '' );
			if ( $result === false ) {
				return new WP_Error( 'permission_create', 'Failed to create the htaccess file' );
			}
		}

		$htaccess_contents = file_get_contents( $htaccess_path );
		// Check if the key already exists in the htaccess file
		$key_pattern = "/^\s*# BEGIN $key\s*\n(.*?)^\s*# END $key\s*\n/sm";
		if ( preg_match( $key_pattern, $htaccess_contents, $matches ) && ! empty( $matches[1] ) ) {
			$htaccess_contents = str_replace( $matches[1], $content . "\n", $htaccess_contents );
		} elseif ( ! empty( $matches[0] && empty( $matches[1] ) ) ) {
			$new_htaccess     = str_replace( $matches[0], '', $htaccess_contents );
			$content           = "\n# BEGIN $key\n$content\n# END $key\n" . $new_htaccess;
			$htaccess_contents = str_replace( $matches[0], $content . "\n", $htaccess_contents );
		} else {
			$htaccess_contents = "\n# BEGIN $key\n$content\n# END $key\n" . $htaccess_contents;
		}

		$result = file_put_contents( $htaccess_path, $htaccess_contents );
		if ( $result === false ) {
			return new WP_Error( 'permission_update', 'Failed to write to the htaccess file' );
		}

		flush_rewrite_rules();

		return  true;
	}

}
