<?php

namespace php;

class Theme {
	private static $instance;
	public static function getInstance(): Theme {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		add_action( 'after_setup_theme', [ $this, 'setup' ] );
		load_theme_textdomain( 'block-theme', get_template_directory() . '/languages' );
		add_action( 'wp_enqueue_scripts', [$this, 'theme_scripts'] );

	}

	public function setup(): void {
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

		/**
		 * add new post-thumbnails size for blazy.
		 */
		add_image_size( 'image-placeholder', 10, 10 );

		// gutenberg related stuff
		add_theme_support( 'appearance-tools' );
		add_theme_support( 'disable-custom-colors' );
		add_theme_support( 'editor-color-palette', array(
			array(
				'name' => __( 'Strong magenta', 'themeLangDomain' ),
				'slug' => 'strong-magenta',
				'color' => '#a156b4',
			),
			array(
				'name' => __( 'Light grayish magenta', 'themeLangDomain' ),
				'slug' => 'light-grayish-magenta',
				'color' => '#d0a5db',
			),
		) );


		add_theme_support( 'disable-custom-font-sizes' );
		add_theme_support( 'editor-font-sizes', array(
			array(
				'name' => __( 'Small', 'themeLangDomain' ),
				'size' => 12,
				'slug' => 'small'
			),
			array(
				'name' => __( 'Regular', 'themeLangDomain' ),
				'size' => 16,
				'slug' => 'regular'
			)
		));

		// Define a custom palette.
		add_theme_support(
			'__experimental-editor-gradient-presets',
			array(
				array(
					'name'     => __( 'Vivid cyan blue to vivid purple', 'themeLangDomain' ),
					'gradient' => 'linear-gradient(135deg,rgba(6,147,227,1) 0%,rgb(155,81,224) 100%)',
					'slug'     => 'vivid-cyan-blue-to-vivid-purple'
				),
				array(
					'name'     => __( 'Vivid green cyan to vivid cyan blue', 'themeLangDomain' ),
					'gradient' => 'linear-gradient(135deg,rgba(0,208,132,1) 0%,rgba(6,147,227,1) 100%)',
					'slug'     =>  'vivid-green-cyan-to-vivid-cyan-blue',
				),
			)
		);

		// Disable custom gradients.
		add_theme_support( '__experimental-disable-custom-gradients' );
	}

	public function theme_scripts(): void {
		wp_enqueue_style( 'block-theme', get_stylesheet_directory_uri() . '/style.css', '', STAGE_ZERO_VERSION );
		wp_localize_script(
			'block-theme',
			'BLOCK_THEME',
			array(
				'ajax_url'      => admin_url( 'admin-ajax.php' ),
				'rest_url'      => get_rest_url(),
				'site_domain'   => $_SERVER['SERVER_NAME'],
				'blog_page_url' => get_post_type_archive_link( 'post' ),
			)
		);

	}
}
