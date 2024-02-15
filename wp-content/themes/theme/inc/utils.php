<?php

function replace_first_p_tag( $content, $tag = 'h1' ) {
	$content = preg_replace( '/<p([^>]+)?>/', '<' . $tag . '$1>', $content, 1 );
	$content = preg_replace( '/<\/p>/', '</' . $tag . '>', $content, 1 );
	return $content;
}
function remove_first_p_tag( $content ) {
	$content = preg_replace( '/<p([^>]+)?>/', '', $content, 1 );
	$content = preg_replace( '/<\/p>/', '', $content, 1 );
	return $content;
}

function format_wysiwyg_title( $content, $tag = 'h1' ) {
	$content = replace_first_p_tag( $content, $tag );
	return $content;
}

function format_wysiwyg_order_list_to_alphabet( $html ) {
	$dom = new DOMDocument();
	// @codingStandardsIgnoreStart
	@$dom->loadHTML( $html );
	// @codingStandardsIgnoreEnd
	$x = new DOMXPath( $dom );

	foreach ( $x->query( '//ol' ) as $node ) {
		$node->setAttribute( 'type', 'A' );
	}

	return $dom->saveHtml();
}

function ps_theme_get_year_blog_array() {
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
function ps_debug_msg( $msg, $functions ) {
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

/* Parse the YouTube video uri/url to determine the video id */
function get_youtube_video_id_from_url( $url ) {
	preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match );
	if ( isset( $match[1] ) ) {
		return $match[1];
	}
	return false;
}

/*
 * excerpt function
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
