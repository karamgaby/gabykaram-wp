<?php

if ( ! function_exists( 'bridging_voice_theme_setup' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function polarstork_theme_setup() {
		 /*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 */
		load_theme_textdomain( 'polarstork_theme', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary-menu' => esc_html__( 'Primary', 'polarstork_theme' ),
				'footer-menu'  => esc_html__( 'footer Menu', 'polarstork_theme' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'gallery',
				'caption',
			)
		);
		add_theme_support( 'custom-logo' );
	}

endif;
add_action( 'after_setup_theme', 'polarstork_theme_setup' );

function storker_theme_scripts() {
	wp_enqueue_style( 'storker_theme-style', get_stylesheet_directory_uri() . '/style.css', '', STORKER_THEME_VERSION );
	wp_enqueue_style( 'storker_theme-main-styles', get_stylesheet_directory_uri() . '/build/css/main-styles.min.css', '', STORKER_THEME_VERSION );
	wp_enqueue_style( 'storker_theme-unique-styles', get_stylesheet_directory_uri() . '/build/css/' . get_page_type() . '.min.css', array( 'storker_theme-main-styles' ), STORKER_THEME_VERSION );
	wp_enqueue_script(
		'storker_theme-js',
		get_template_directory_uri() . '/build/js/scripts.min.js',
		array( 'jquery' ),
		STORKER_THEME_VERSION,
		true
	);
	wp_localize_script(
		'storker_theme-js',
		'storker_theme_script_vars',
		array(
			'ajax_url'      => admin_url( 'admin-ajax.php' ),
			'rest_url'      => get_rest_url(),
			'site_domain'   => $_SERVER['SERVER_NAME'],
			'blog_page_url' => get_post_type_archive_link( 'post' ),
		)
	);
}

function get_page_type() {
	global $wp_query;
	$page_type     = 'default';
	$page_template = get_page_template_slug();
	if ( $wp_query->is_single ) {
		$page_type = 'single-' . get_post_type();
	} elseif ( is_author() ) {
		$page_type = 'single-author';
	} elseif ( is_home() ) {
		$page_type = 'blog';
	} elseif ( $wp_query->is_404 || $wp_query->is_category || $wp_query->is_archive || $wp_query->is_tax || $wp_query->is_tag ) {
		$page_type = '404';
	} elseif ( ! empty( $page_template ) && $page_template === 'front-page.php' ) {
		$page_type = 'landing';
	} elseif ( ! empty( $page_template ) && $page_template === 'page-training.php' ) {
		$page_type = 'training';
	}
	return $page_type;
}

add_action( 'wp_enqueue_scripts', 'storker_theme_scripts' );

/**
 * add new post-thumbnails size for blazy.
 */
add_image_size( 'image-placeholder', 10, 10 );
