<?php

/*
 * Remove WP built-in Hello Dolly Plugin.
 */

function polarstork_theme_goodbye_dolly() {
	if ( file_exists( WP_PLUGIN_DIR . '/hello.php' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		delete_plugins( array( 'hello.php' ) );
	}
}
add_action( 'admin_init', 'polarstork_theme_goodbye_dolly' );
/*
 * Removes meta tag displaying WP version.
 */
remove_action( 'wp_head', 'wp_generator' );
/*
 * Removes the link to the Windows Live Writer manifest file
 */
remove_action( 'wp_head', 'wlwmanifest_link' );
/*
 * Removes the link to the Really Simple Discovery service endpoint
 */
remove_action( 'wp_head', 'rsd_link' );
/*
 * remove default emoji import
 */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
/**
 * Remove the default version number from all enqueued CSS and JS files
 *
 * @param string $src
 *
 * @return string
 */
function polarstork_theme_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}

add_filter( 'style_loader_src', 'polarstork_theme_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'polarstork_theme_remove_wp_ver_css_js', 9999 );
function remove_wp_menu_page() {
	remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', 'remove_wp_menu_page' );
/**
 * disable search feature
 */
function wpb_filter_query( $query, $error = true ) {
	if ( is_search() && ! is_admin() ) {
		$query->is_search       = false;
		$query->query_vars['s'] = false;
		$query->query['s']      = false;
		if ( $error == true ) {
			$query->is_404 = true;
		}
	}
}
add_action( 'parse_query', 'wpb_filter_query' );
add_filter(
	'get_search_form',
	function ( $a ) {
		return null;
	}
);
function remove_search_widget() {
	unregister_widget( 'WP_Widget_Search' );
}
add_action( 'widgets_init', 'remove_search_widget' );
/**
 * remove comments fucntionality.
 */
add_action(
	'admin_init',
	function () {
		// Redirect any user trying to access comments page
		global $pagenow;
		if ( $pagenow === 'edit-comments.php' ) {
			wp_redirect( admin_url() );
			exit;
		}
		// Remove comments metabox from dashboard
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
		// Disable support for comments and trackbacks in post types
		foreach ( get_post_types() as $post_type ) {
			if ( post_type_supports( $post_type, 'comments' ) ) {
				remove_post_type_support( $post_type, 'comments' );
				remove_post_type_support( $post_type, 'trackbacks' );
			}
		}
	}
);
// Close comments on the front-end
add_filter( 'comments_open', '__return_false', 20, 2 );
add_filter( 'pings_open', '__return_false', 20, 2 );
// Hide existing comments
add_filter( 'comments_array', '__return_empty_array', 10, 2 );
// Remove comments page in menu
add_action(
	'admin_menu',
	function () {
		remove_menu_page( 'edit-comments.php' );
	}
);
// Remove comments links from admin bar
add_action(
	'init',
	function () {
		if ( is_admin_bar_showing() ) {
			remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );
		}
	}
);
function my_admin_bar_render() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu( 'comments' );
}
add_action( 'wp_before_admin_bar_render', 'my_admin_bar_render' );
