<?php
/*
Plugin Name: Lighthouse
Plugin URI: https://getbutterfly.com/wordpress-plugins/lighthouse/
Description: Lighthouse is a performance tuning plugin, removing lots of default WordPress behaviour, such as filters, actions, injected code, native code and third-party actions.
Version: 4.2.0
Author: Ciprian Popescu
Author URI: https://getbutterfly.com/

Lighthouse
Copyright (C) 2014-2024 Ciprian Popescu (getbutterfly@gmail.com)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

define( 'LIGHTHOUSE_VERSION', '4.2.0' );
define( 'LIGHTHOUSE_PLUGIN_URL', WP_PLUGIN_URL . '/' . dirname( plugin_basename( __FILE__ ) ) );
define( 'LIGHTHOUSE_PLUGIN_PATH', WP_PLUGIN_DIR . '/' . dirname( plugin_basename( __FILE__ ) ) );
define( 'LIGHTHOUSE_PLUGIN_FILE_PATH', WP_PLUGIN_DIR . '/' . plugin_basename( __FILE__ ) );

define( 'LIGHTHOUSE_CHECK_PHP_MIN_VERSION', '8.0' );
define( 'LIGHTHOUSE_CHECK_PHP_REC_VERSION', '8.3' );
define( 'LIGHTHOUSE_CHECK_WP_MIN_VERSION', '6.5' );
define( 'LIGHTHOUSE_CHECK_WP_REC_VERSION', '6.5.5' );

define( 'LIGHTHOUSE_CHECK_CP_REC_VERSION', '2.1.1' );

define( 'CORE_UPGRADE_SKIP_NEW_BUNDLED', true );

if ( ! defined( 'CURL_HTTP_VERSION_2_0' ) ) {
    define( 'CURL_HTTP_VERSION_2_0', 3 );
}

include LIGHTHOUSE_PLUGIN_PATH . '/includes/updater.php';

if ( (int) get_option( 'lighthouse_brute_force' ) === 1 ) {
    include 'includes/lh-security.php';
}

include 'firewall.php';

include_once LIGHTHOUSE_PLUGIN_PATH . '/includes/functions.php';
include_once LIGHTHOUSE_PLUGIN_PATH . '/includes/functions-queries.php';
include_once LIGHTHOUSE_PLUGIN_PATH . '/includes/registration.php';

if ( is_admin() ) {
    include_once LIGHTHOUSE_PLUGIN_PATH . '/includes/settings.php';
}

include_once LIGHTHOUSE_PLUGIN_PATH . '/includes/metrics.php';

// SpeedFactor
include_once LIGHTHOUSE_PLUGIN_PATH . '/speedfactor/get-score-curl.php';
include_once LIGHTHOUSE_PLUGIN_PATH . '/speedfactor/get-score-curl-beacon.php';
include_once LIGHTHOUSE_PLUGIN_PATH . '/speedfactor/get-site-assets.php';

// CAPTCHA
if ( (int) get_option( 'lighthouse_captcha_enable' ) === 1 ) {
    include_once LIGHTHOUSE_PLUGIN_PATH . '/includes/captcha.php';
}



register_activation_hook( __FILE__, 'lighthouse_install' );



/**
 * Hook into wp_enqueue_scripts and enqueue/dequeue or register/deregister as required
 *
 * @return void
 */
function lighthouse_enqueue_scripts() {
    // Lighthouse Instant Loading
    if ( (int) get_option( 'lighthouse_prefetch' ) === 1 ) {
        wp_enqueue_script( 'lhf-prefetch', plugins_url( '/assets/prerender.min.js', __FILE__ ), [], LIGHTHOUSE_VERSION, true );
    } elseif ( (int) get_option( 'lighthouse_prefetch' ) === 2 ) {
        wp_enqueue_script( 'lhf-prefetch', plugins_url( '/assets/prefetch.min.js', __FILE__ ), [], LIGHTHOUSE_VERSION, true );
    }

    if ( (int) get_option( 'lighthouse_prefetch' ) > 0 ) {
        wp_localize_script(
            'lhf-prefetch',
            'lhf_ajax_var',
            [
                'prefetch_throttle' => (int) get_option( 'lighthouse_prefetch_throttle' ),
            ]
        );
    }

    // Dequeue mediaelement.js script
    if ( (int) get_option( 'lighthouse_mediaelement' ) === 1 ) {
        lighthouse_disable_wp_media_elements_js();
    }

    // Dequeue comment-reply.js script
    if ( (int) get_option( 'lighthouse_comment_reply' ) === 1 ) {
        wp_dequeue_script( 'comment-reply' );
    }
}

add_action( 'wp_enqueue_scripts', 'lighthouse_enqueue_scripts', PHP_INT_MAX );



// Dequeue jetpack.css stylesheet
if ( (int) get_option( 'lighthouse_no_jetpack_css' ) === 1 ) {
    add_filter( 'jetpack_sharing_counts', '__return_false', 99 );
    add_filter( 'jetpack_implode_frontend_css', '__return_false', 99 );
}

// Dequeue classic-themes.min.css style
if ( (int) get_option( 'lighthouse_no_classic_css' ) === 1 ) {
    add_action(
        'wp_enqueue_scripts',
        function() {
            wp_dequeue_style( 'classic-theme-styles' );
        },
        20
    );
}



/**
 * Hook into plugins_loaded and filter as required
 *
 * @return void
 */
function lighthouse_plugins_loaded() {
    // Plugin initialization and textdomain setup
    load_plugin_textdomain( 'lighthouse', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action( 'plugins_loaded', 'lighthouse_plugins_loaded' );



function lighthouse_on_init() {
    lhf_declutter_head();
    lhf_disable_emojis();
    lhf_disable_embeds_init();
}

add_action( 'init', 'lighthouse_on_init', 3 );



add_action( 'admin_menu', 'lighthouse_add_option_page' );
add_action( 'admin_enqueue_scripts', 'lhf_load_admin_style' );
add_action( 'after_setup_theme', 'lighthouse_setup' );
add_action( 'pre_ping', 'lhf_no_self_ping' );

if ( (int) get_option( 'lhfm_responsive' ) === 1 ) {
    add_filter( 'the_content', 'wp_make_content_images_responsive' );

    // Re-enable responsive images or srcset if the theme disabled it
    add_action( 'after_setup_theme', 'lighhouse_reenable_srcset', 11 );

} elseif ( (int) get_option( 'lhfm_responsive' ) === 2 ) {
    add_filter( 'wp_calculate_image_srcset', 'lighthouse_disable_srcset' );
    add_filter( 'max_srcset_image_width', 'lighthouse_remove_max_srcset_image_width' );
}

if ( (int) get_option( 'lighthouse_jquery_migrate' ) === 1 ) {
    add_filter( 'wp_default_scripts', 'lhf_remove_jquery_migrate' );
}

function lighhouse_reenable_srcset() {
    remove_filter( 'wp_calculate_image_srcset', '__return_false' );
}
function lighthouse_disable_srcset( $sources ) {
    return false;
}
function lighthouse_remove_max_srcset_image_width( $max_width ) {
    return false;
}


if ( (int) get_option( 'lighthouse_zen' ) === 1 ) {
    add_action( 'wp_before_admin_bar_render', 'lhf_admin_bar' );
    add_action( 'wp_dashboard_setup', 'lhf_dashboard_widgets' );

    lhf_capital_p_bangit();
    lhf_taxonomies();
}

if ( (int) get_option( 'lighthouse_no_lazy_loading' ) === 1 ) {
    add_filter( 'wp_lazy_loading_enabled', '__return_false' );
}

function lighthouse_add_option_page() {
    add_menu_page( 'Lighthouse', 'Lighthouse', 'manage_options', 'lighthouse', 'lighthouse_options_page', 'dashicons-shield-alt' );

    add_submenu_page( 'lighthouse', 'Lighthouse', 'Lighthouse', 'manage_options', 'lighthouse', 'lighthouse_options_page', 0 );

    if ( (int) get_option( 'lighthouse_firewall' ) === 1 ) {
        add_submenu_page( 'lighthouse', 'Firewall', 'Firewall', 'manage_options', 'lighthouse-firewall', 'lighthouse_fw_dashboard', 1 );
    }

    if ( (int) get_option( 'lighthouse_remove_custom_fields_metabox' ) === 1 ) {
        /**
         * Remove Custom Fields metabox from post editor because it uses a very slow meta_key sort query.
         * On sites with large wp_postmeta tables, it is very slow.
         */
        foreach ( get_post_types( '', 'names' ) as $post_type ) {
            remove_meta_box( 'postcustom', $post_type, 'normal' );
        }
    }
}

function lhf_load_admin_style() {
    wp_register_style( 'lighthouse-inter', 'https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap', false, LIGHTHOUSE_VERSION );

    wp_enqueue_style( 'lighthouse', LIGHTHOUSE_PLUGIN_URL . '/assets/lighthouse.css', false, LIGHTHOUSE_VERSION );

    // SpeedFactor
    wp_enqueue_script( 'sparkline', plugins_url( '/assets/js/sparkline.min.js', __FILE__ ), [], '1.0.0', true );

    wp_register_script( 'lhf-chartjs', plugins_url( '/assets/js/chart.umd.min.js', __FILE__ ), [], '4.3.2', true );

    wp_register_script( 'sf-charts', plugins_url( '/assets/js/charts.js', __FILE__ ), [ 'lhf-chartjs', 'sparkline' ], LIGHTHOUSE_VERSION, true );

    // Synchro
    wp_register_style( 'lhf-segment', plugins_url( '/assets/js/segment/segment.css', __FILE__ ), [], '1.0.0' );
    wp_register_script( 'lhf-segment', plugins_url( '/assets/js/segment/segment.js', __FILE__ ), [], '1.0.0', true );
    //

    wp_enqueue_script( 'sf-init', plugins_url( '/assets/js/init.js', __FILE__ ), [], LIGHTHOUSE_VERSION, true );

    wp_localize_script(
        'sf-init',
        'sfAjaxVar',
        [
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
        ]
    );
}

function lighthouse_setup() {
    if ( (int) get_option( 'lighthouse_version_parameter' ) === 1 ) {
        add_filter( 'script_loader_src', 'lhf_remove_script_version', 15, 1 );
        add_filter( 'style_loader_src', 'lhf_remove_script_version', 15, 1 );
    }

    if ( (int) get_option( 'lighthouse_head_cleanup' ) === 1 ) {
        remove_action( 'wp_head', 'rsd_link' );
        remove_action( 'wp_head', 'wlwmanifest_link' );
        remove_action( 'wp_head', 'wp_generator' );
        remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
        remove_action( 'template_redirect', 'wp_shortlink_header', 11, 0 );
    }

    if ( (int) get_option( 'lighthouse_rss_links' ) === 1 ) {
        remove_action( 'wp_head', 'feed_links_extra', 3 );
        remove_action( 'wp_head', 'feed_links', 2 );
    }

    if ( (int) get_option( 'lighthouse_author_archive' ) === 1 ) {
        add_action( 'template_redirect', 'lhf_disable_author_archive' );
    }
    if ( (int) get_option( 'lighthouse_canonical' ) === 1 ) {
        remove_filter( 'template_redirect', 'redirect_canonical' );
    }

    if ( (int) get_option( 'lighthouse_comment_html' ) === 1 ) {
        add_filter( 'pre_comment_content', 'esc_html' );
    }

    //
    if ( (int) get_option( 'lighthouse_theme_support_formats' ) === 1 ) {
        remove_theme_support( 'post-formats' );
    }
    if ( (int) get_option( 'lighthouse_theme_support_block_widgets' ) === 1 ) {
        remove_theme_support( 'widgets-block-editor' );
    }
    if ( (int) get_option( 'lighthouse_theme_support_responsive_embeds' ) === 1 ) {
        remove_theme_support( 'responsive-embeds' );
    }
    if ( (int) get_option( 'lighthouse_theme_support_editor_styles' ) === 1 ) {
        remove_theme_support( 'editor-styles' );
    }
    if ( (int) get_option( 'lighthouse_theme_support_block_styles' ) === 1 ) {
        remove_theme_support( 'wp-block-styles' );
    }
    if ( (int) get_option( 'lighthouse_theme_support_block_templates' ) === 1 ) {
        remove_theme_support( 'block-templates' );
    }
    if ( (int) get_option( 'lighthouse_theme_support_core_block_patterns' ) === 1 ) {
        remove_theme_support( 'core-block-patterns' );
    }
    if ( (int) get_option( 'lighthouse_theme_support_woocommerce' ) === 1 ) {
        remove_theme_support( 'woocommerce' );
    }
}

function lhf_declutter_head() {
    if ( (int) get_option( 'lighthouse_comment_cookies' ) === 1 ) {
        remove_action( 'set_comment_cookies', 'wp_set_comment_cookies' );
    }

    if ( (int) get_option( 'lighthouse_prepend_attachment' ) === 1 ) {
        remove_filter( 'the_content', 'prepend_attachment' );
    }
}

if ( (int) get_option( 'lighthouse_xmlrpc' ) === 1 ) {
    add_filter( 'xmlrpc_methods', 'lhf_remove_xmlrpc_methods' );
    add_filter( 'xmlrpc_enabled', '__return_false' );
    add_filter( 'pre_option_default_pingback_flag', '__return_zero' );

    if ( isset( $_GET['doing_wp_cron'] ) ) {
        remove_action( 'do_pings', 'do_all_pings' );
        wp_clear_scheduled_hook( 'do_pings' );
    }

    // Force removal of physical pingback tag
    add_filter( 'bloginfo_url', 'lhf_remove_pingback_url', 10, 2 );

    // Hide xmlrpc.php in HTTP response headers // default is on
    add_filter( 'wp_headers', 'lhf_remove_x_pingback' );
}

if ( (int) get_option( 'lighthouse_normalize_scheme' ) === 1 ) {
    add_filter( 'script_loader_src', 'lhf_src_scheme' );
    add_filter( 'style_loader_src', 'lhf_src_scheme' );
}



// SpeedFactor
function lhf_db_install() {
    global $wpdb;

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    $table_name = $wpdb->prefix . 'lhf_sf_curl';

    $sql = "CREATE TABLE $table_name (
        audit_id int(11) NOT NULL AUTO_INCREMENT,
        audit_total_time float NOT NULL,
        audit_namelookup_time float NOT NULL,
        audit_connect_time float NOT NULL,
        audit_pretransfer_time float NOT NULL,
        audit_redirect_time float NOT NULL,
        audit_starttransfer_time float NOT NULL,
        audit_timestamp timestamp NOT NULL,
        PRIMARY KEY (audit_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

    dbDelta( $sql );
    maybe_convert_table_to_utf8mb4( $table_name );

    //
    $table_name = $wpdb->prefix . 'lhf_sf_curl_beacon';

    $sql = "CREATE TABLE $table_name (
        audit_id int(11) NOT NULL AUTO_INCREMENT,
        audit_total_time float NOT NULL,
        audit_namelookup_time float NOT NULL,
        audit_connect_time float NOT NULL,
        audit_pretransfer_time float NOT NULL,
        audit_redirect_time float NOT NULL,
        audit_starttransfer_time float NOT NULL,
        audit_timestamp timestamp NOT NULL,
        PRIMARY KEY (audit_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

    dbDelta( $sql );
    maybe_convert_table_to_utf8mb4( $table_name );

    //
    $table_name = $wpdb->prefix . 'lhf_sf_curl_payload';

    $sql = "CREATE TABLE $table_name (
        audit_id int(11) NOT NULL AUTO_INCREMENT,
        audit_site_assets_img int(11) NOT NULL,
        audit_site_assets_css int(11) NOT NULL,
        audit_site_assets_js int(11) NOT NULL,
        audit_site_requests int(11) NOT NULL,
        audit_timestamp timestamp NOT NULL,
        PRIMARY KEY (audit_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

    dbDelta( $sql );
    maybe_convert_table_to_utf8mb4( $table_name );

    //
    $table_name = $wpdb->prefix . 'lhf_sf_cwv';

    // Drop the CWV table from the database
    $wpdb->query( "DROP TABLE IF EXISTS $table_name" );

    // Query tracker
    $table_name = $wpdb->prefix . 'lhf_query_tracker';

    if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) !== $table_name ) {
        $sql = "CREATE TABLE $table_name (
    		id mediumint(16) NOT NULL AUTO_INCREMENT,
    		longdatetime datetime NOT NULL,
    		qcount mediumint(16) NOT NULL,
    		qmemory float NOT NULL,
    		qtime float NOT NULL,
    		qpage varchar(255) NOT NULL,
    		useragent varchar(255) NOT NULL,
    		UNIQUE KEY id (id)
		) ENGINE=InnoDB;";

        dbDelta( $sql );
        maybe_convert_table_to_utf8mb4( $table_name );
    }

    // Insert default query tracking options
    add_option( 'lhf_queries_recent_requests', 50 );
    add_option( 'lhf_queries_max_records', 256 );

    // Security
    $table_name = $wpdb->prefix . 'lighthouse_blacklist';

    $results = $wpdb->query( "CREATE TABLE IF NOT EXISTS $table_name (id INT(11) NOT NULL AUTO_INCREMENT, domain VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id), KEY domain (domain));" );

    // Firewall
    lighthouse_fw_install();
}



function lhf_db_upgrade() {
    global $wpdb;

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    $table_name = $wpdb->prefix . 'lhf_sf_cwv';

    // Drop the CWV table from the database
    $wpdb->query( "DROP TABLE IF EXISTS $table_name" );

    update_option( 'lhf_db_version', '2.0.3' );
}

if ( version_compare( get_option( 'lhf_db_version' ), '2.0.3', '<' ) ) {
    add_action( 'admin_init', 'lhf_db_upgrade' );
}



register_activation_hook( __FILE__, 'lhf_db_install' );
register_deactivation_hook( __FILE__, 'lhf_on_deactivation' );
register_uninstall_hook( __FILE__, 'lhf_on_uninstall' );


function lhf_cron_speedfactor() {
    if ( (string) get_option( 'lhf_speedfactor_schedule' ) !== '' ) {
        lhf_speedfactor_curl();
        lhf_speedfactor_curl_beacon();
        lhf_speedfactor_curl_payload();

        $body = '<h3>Lighthouse SpeedFactor: Task(s) Finished</h3>
        <p>You are receiving this audit notification because you opted in by adding your email address to your Lighthouse plugin settings -&raquo; <b>SpeedFactor</b> -&raquo; <b>SpeedFactor Notifications</b>.</p>';

        if ( (string) get_option( 'lhf_speedfactor_audit_email' ) !== '' ) {
            wp_mail( get_option( 'lhf_speedfactor_audit_email' ), 'Lighthouse SpeedFactor: Task(s) Finished', $body, [ 'Content-Type: text/html; charset=UTF-8' ] );
        }
    }
}
add_action( 'lhf_run_cron_speedfactor', 'lhf_cron_speedfactor' );

function lhf_on_deactivation() {
    wp_clear_scheduled_hook( 'lhf_run_cron_speedfactor' );
}
function lhf_on_uninstall() {
    wp_clear_scheduled_hook( 'lhf_run_cron_speedfactor' );
}

if ( (string) get_option( 'lhf_speedfactor_schedule' ) !== '' ) {
    if ( ! wp_next_scheduled( 'lhf_run_cron_speedfactor' ) ) {
        wp_schedule_event( time(), get_option( 'lhf_speedfactor_schedule' ), 'lhf_run_cron_speedfactor' );
    }
}



function lhf_resource_hints_prefetch( $hints, $relation_type ) {
    $resource_hints = array_map( 'trim', explode( PHP_EOL, get_option( 'lhf_resource_hints_prefetch' ) ) );
    $resource_hints = array_unique( array_filter( $resource_hints ) );

    foreach ( $resource_hints as $resource_hint ) {
        if ( 'dns-prefetch' === $relation_type ) {
            $hints[] = $resource_hint;
        }
    }

    return $hints;
}

function lhf_resource_hints_preconnect( $hints, $relation_type ) {
    $resource_hints = array_map( 'trim', explode( PHP_EOL, get_option( 'lhf_resource_hints_preconnect' ) ) );
    $resource_hints = array_unique( array_filter( $resource_hints ) );

    foreach ( $resource_hints as $resource_hint ) {
        if ( 'preconnect' === $relation_type ) {
            $hints[] = $resource_hint;
        }
    }

    return $hints;
}

add_filter( 'wp_resource_hints', 'lhf_resource_hints_prefetch', 10, 2 );
add_filter( 'wp_resource_hints', 'lhf_resource_hints_preconnect', 10, 2 );

function lhf_admin_classes( $classes ) {
    if ( (int) get_option( 'lighthouse_theme_dark' ) === 1 ) {
        $current_screen = get_current_screen();

        if ( $current_screen->base === 'toplevel_page_lighthouse' || $current_screen->base === 'lighthouse_page_lighthouse-firewall' ) {
            $classes .= ' lhf--ui-dark';
        }
    }

    return $classes;
}

add_filter( 'admin_body_class', 'lhf_admin_classes' );
