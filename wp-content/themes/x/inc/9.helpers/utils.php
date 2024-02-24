<?php

/**
 * Replace the first occurrence of the <p> tag in a given content with a specified tag.
 *
 * @param string $content The content to be modified.
 * @param string $tag The tag to replace the <p> tag with. Defaults to 'h1'.
 *
 * @return string The modified content.
 */
function replace_first_p_tag( $content, $tag = 'h1' ) {
	$content = preg_replace( '/<p([^>]+)?>/', '<' . $tag . '$1>', $content, 1 );
	$content = preg_replace( '/<\/p>/', '</' . $tag . '>', $content, 1 );
	return $content;
}

/**
 * Remove the first <p> tag from the given content.
 *
 * @param string $content The content to remove the <p> tag from.
 *
 * @return string The content without the first <p> tag.
 */
function remove_first_p_tag( $content ) {
	$content = preg_replace( '/<p([^>]+)?>/', '', $content, 1 );
	$content = preg_replace( '/<\/p>/', '', $content, 1 );
	return $content;
}

/**
 * Format the title in a WYSIWYG editor content.
 * Replaces the first <p> tag with the specified HTML tag.
 *
 * @param string $content The content to format.
 * @param string $tag Optional. The HTML tag to replace the first <p> tag with. Defaults to 'h1'.
 *
 * @return string The formatted content.
 */
function format_wysiwyg_title( $content, $tag = 'h1' ): string {
	$content = replace_first_p_tag( $content, $tag );
	return $content;
}

/**
 * Format a wysiwyg order list to use alphabetical numbering instead of numerical.
 *
 * @param string $html The HTML content to format.
 *
 * @return string The formatted HTML content.
 */
function format_wysiwyg_order_list_to_alphabet( $html ): string {
	$dom = new DOMDocument();
  $temp = $html;
	// @codingStandardsIgnoreStart
	@$dom->loadHTML( $html );
	// @codingStandardsIgnoreEnd
	$x = new DOMXPath( $dom );

	foreach ( $x->query( '//ol' ) as $node ) {
		$node->setAttribute( 'type', 'A' );
	}
  $temp_html = $dom->saveHtml();

	return $temp_html ?: $html;
}

/**
 * Retrieve an array of years from the blog archives.
 *
 * The function uses the wp_get_archives() function to get the blog archives HTML content.
 * It then parses the content to extract the years and creates an array containing the year name and value.
 *
 * @return array An array of years with name and value.
 */
function x_get_year_blog_array() {
	$years      = array();
	$years_args = array(
		'type'      => 'yearly',
		'format'    => 'custom',
		'before'    => '',
		'after'     => '|',
		'echo'      => false,
		'post_type' => 'post',
		'order'     => 'DESC',
	);
	// Get Years
	$years_content = wp_get_archives( $years_args );
	if ( ! empty( $years_content ) ) {
		$years_arr = explode( '|', $years_content );
		$years_arr = array_filter(
			$years_arr,
			function ( $item ) {
				return trim( $item ) !== '';
			}
		); // Remove empty whitespace item from array
		foreach ( $years_arr as $year_item ) {
			$year_row = trim( $year_item );
			preg_match( '/href=["\']?([^"\'>]+)["\']>(.+)<\/a>/', $year_row, $year_vars );
			if ( ! empty( $year_vars ) ) {
				$years[] = array(
					'name'  => $year_vars[2],
					'value' => $year_vars[2],
				);
			}
		}
	}

	return $years;
}

/**
 * Redirects the user to a 404 page.
 *
 * This function sets the 404 status for the global $wp_query object, sets the 404 status header,
 * includes the template part for the 404 page using the "get_template_part" function,
 * and exits the script execution.
 *
 * @return void
 */
function wp_404_redirect() {
	global $wp_query;
	$wp_query->set_404();
	status_header( 404 );
	get_template_part( 404 );
	exit();
}

/**
 * Send debugging messages when WP_DEBUG is enbaled.
 *
 * @param string $msg the message for error
 * @param array  $functions the functions used
 */
function x_debug_msg( $msg, $functions ) {
	if ( WP_DEBUG === true ) {
		// init warning to get source
		$e = new Exception( $msg );
		// find file and line for problem
		$trace_line = '';
		foreach ( $e->getTrace() as $trace ) {
			if ( in_array( $trace['function'], $functions, true ) ) {
				$trace_line = ' in ' . $trace['file'] . ':' . $trace['line'];
			}
		}
		// compose error message
		$error_msg = $e->getMessage() . $trace_line;
		// trigger errors
		// @codingStandardsIgnoreStart
		trigger_error( $error_msg, E_USER_WARNING );
		error_log( $error_msg );
		// @codingStandardsIgnoreEnd
	}
}

/**
 * Returns the YouTube video ID from the given URL.
 *
 * This function uses regular expressions to extract the video ID from a YouTube URL.
 * It supports various YouTube URL formats, including the regular YouTube domain,
 * the youtu.be shortened URL, and the YouTube sharing/embedding URL.
 *
 * @param string $url The YouTube URL
 *
 * @return string|false The YouTube video ID if found, or false if not found
 */
function get_youtube_video_id_from_url( $url ) {
	preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match );
	if ( isset( $match[1] ) ) {
		return $match[1];
	}
	return false;
}

/**
 * Truncates a given text to a specified number of words.
 *
 * This function splits the text into individual words and counts them.
 * It then checks if the number of words exceeds the specified limit.
 * If it does, it removes the remaining words and appends an ellipsis.
 *
 * @param string $text The text to be truncated
 * @param int $limit The maximum number of words to keep
 * @param string $ellipsis The string to append at the end of the truncated text (default: '...')
 *
 * @keyword excerpt function
 * @return string The truncated text with an optional ellipsis
 */
function truncate_words( $text, $limit, $ellipsis = '...' ) {
	$words = preg_split( "/[\n\r\t ]+/", $text, $limit + 1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_OFFSET_CAPTURE );
	if ( count( $words ) > $limit ) {
		end( $words ); // ignore last element since it contains the rest of the string
		$last_word = prev( $words );
		$text      = substr( $text, 0, $last_word[1] + strlen( $last_word[0] ) ) . $ellipsis;
	}
	return $text;
}
