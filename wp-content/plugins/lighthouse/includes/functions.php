<?php
/**
 * Main Lighthouse functions
 *
 * @since 2.2.0
 */

/**
 * Plugin installation.
 *
 * Add options and remove unused/old ones.
 */
function lighthouse_install() {
    add_option( 'lighthouse_zen', 0 );

    add_option( 'lighthouse_version_parameter', 0 );
    add_option( 'lighthouse_emoji', 0 );
    add_option( 'lighthouse_canonical', 0 );
    add_option( 'lighthouse_author_archive', 0 );

    add_option( 'lighthouse_normalize_scheme', 0 );

    add_option( 'lighthouse_head_cleanup', 0 );
    add_option( 'lighthouse_rss_links', 0 );

    add_option( 'lighthouse_xmlrpc', 0 );
    add_option( 'lighthouse_comment_cookies', 0 );
    add_option( 'lighthouse_embed', 0 );

    add_option( 'lighthouse_http_headers', 0 );

    add_option( 'lighthouse_comment_html', 0 );
    add_option( 'lighthouse_comment_reply', 0 );
    add_option( 'lighthouse_jquery_migrate', 0 );

    add_option( 'lhf_speedfactor_results', 30 );

    lhf_tidy();
}

/**
 * Delete folder and contents
 *
 */
function lhf_delete_tree( $dir ) {
    $files = glob( $dir . '*', GLOB_MARK );

    foreach ( $files as $file ) {
        if ( substr( $file, -1 ) === '/' ) {
            lhf_delete_tree( $file );
        } else {
            unlink( $file );
        }
    }

    rmdir( $dir );
}

function lhf_tidy() {
    // Delete old options
    delete_option( 'lighthouse_smilies' );
    delete_option( 'lighthouse_canonical_sf' );
    delete_option( 'lighthouse_rsd_links' );
    delete_option( 'lighthouse_wlw_links' );
    delete_option( 'lighthouse_shortlink' );
    delete_option( 'lighthouse_generator' );
    delete_option( 'lighthouse_xmlrpc_safe' );
    delete_option( 'lighthouse_hsts_simple' );
    delete_option( 'lighthouse_nofollow_author' );
    delete_option( 'lighthouse_backup' );
    delete_option( 'lighthouse_backup' );
    delete_option( 'lighthouse_remove_pings' );

    delete_option( 'lighthouse_clean_style_tag' );
    delete_option( 'lighthouse_clean_script_tag' );
    delete_option( 'lighthouse_clean_css_attr' );
    delete_option( 'lighthouse_opensans_frontend' );
    delete_option( 'lighthouse_attribution' );
    delete_option( 'lighthouse_gravatar_alt' );

    delete_option( 'lighthouse_adjacent' );
    delete_option( 'lighthouse_genericons_frontend' );
    delete_option( 'lighthouse_content_conversion' );
    delete_option( 'lighthouse_fancybox' );

    delete_option( 'lighthouse_bad_queries' );
    delete_option( 'lighthouse_jqueryui' );
    delete_option( 'lighthouse_nofollow_comment' );

    delete_option( 'lighthouse_script_html5shiv' );
    delete_option( 'lighthouse_style_masonry' );
    delete_option( 'lighthouse_script_modernizr' );
    delete_option( 'lighthouse_script_jquery' );
    delete_option( 'lighthouse_style_normalize' );
    delete_option( 'lighthouse_style_pure' );
    delete_option( 'lighthouse_style_dashicons' );
    delete_option( 'lighthouse_style_entypo' );
    delete_option( 'lighthouse_style_fa' );

    delete_option( 'lighthouse_gravatar_cache' );
    delete_option( 'wpgc_dir' );
    delete_option( 'wpgc_url' );
    delete_option( 'wpgc_exp' );
    delete_option( 'wpgc_cc' );
    delete_option( 'wpgc_dir' );
    delete_option( 'lighthouse_compress_scripts' );
    delete_option( 'lighthouse_transients' );
    delete_option( 'lighthouse_devicepx' );

    delete_option( 'lighthouse_disable_author_archives' );
    delete_option( 'lighthouse_http_headers' );

    delete_option( 'lighthouse_recent_comments_css' );
    delete_option( 'lighthouse_remove_gallery_style' );
    delete_option( 'lighthouse_remove_srcset' );

    delete_option( 'lighthouse_clean_attributes' );
    delete_option( 'lighthouse_scripts_to_footer' );

    delete_option( 'lighthouse_taxonomy_archive' );

    delete_option( 'lhf_error_reporting' );
    delete_option( 'lhf_error_log' );
    delete_option( 'lhf_error_log_size' );
    delete_option( 'lhf_error_monitoring' );
    delete_option( 'lhf_error_monitoring_dashboard' );
    delete_option( 'lighthouse_compress_html' );

    delete_option( 'lighthouse_widget_pages' );
    delete_option( 'lighthouse_widget_calendar' );
    delete_option( 'lighthouse_widget_archives' );
    delete_option( 'lighthouse_widget_links' );
    delete_option( 'lighthouse_widget_meta' );
    delete_option( 'lighthouse_widget_search' );
    delete_option( 'lighthouse_widget_text' );
    delete_option( 'lighthouse_widget_categories' );
    delete_option( 'lighthouse_widget_posts' );
    delete_option( 'lighthouse_widget_comments' );
    delete_option( 'lighthouse_widget_rss' );
    delete_option( 'lighthouse_widget_tag' );

    delete_option( 'lighthouse_widget_html' );
    delete_option( 'lighthouse_widget_media' );
    delete_option( 'lighthouse_widget_tag' );

    delete_option( 'lighthouse_disable_rest_api' );
    delete_option( 'lighthouse_hsts' );

    delete_option( 'lighthouse_dashicons_frontend' );

    delete_option( 'lighthouse_js_lazy_loading' );
    delete_option( 'lighthouse_theme_support_srcset' );

    delete_option( 'lighthouse_no_webp' );

    delete_option( 'lighthouse_plugin_notifications' );
    delete_option( 'lighthouse_theme_notifications' );
    delete_option( 'lighthouse_core_autoupdates' );
    delete_option( 'lighthouse_plugin_autoupdates' );

    delete_option( 'lighthouse_blacklist_log' );
    delete_option( 'lhf_speedfactor_lighthouse_api' );

    delete_option( 'lhf_minify_html_active' );
    delete_option( 'lhf_minify_javascript' );
    delete_option( 'lhf_minify_html_comments' );
    delete_option( 'lhf_minify_html_xhtml' );
    delete_option( 'lhf_minify_html_utf8' );

    if ( (int) get_option( 'lhf_queries_enable' ) !== 1 ) {
        wp_clear_scheduled_hook( 'lt_clear_max' );
    }

    if ( file_exists( WP_CONTENT_DIR . '/lighthouse-cache' ) ) {
        lhf_delete_tree( WP_CONTENT_DIR . '/lighthouse-cache' );
    }

    if ( file_exists( WP_CONTENT_DIR . '/uploads/lighthouse' ) ) {
        lhf_delete_tree( WP_CONTENT_DIR . '/uploads/lighthouse' );
    }

    if ( file_exists( WP_CONTENT_DIR . '/lighthouse-blacklist.log' ) ) {
        unlink( WP_CONTENT_DIR . '/uploads/lighthouse' );
    }

    global $wpdb;

    $table_name = $wpdb->prefix . 'lhf_sf_cwv';

    // Drop the CWV table from the database
    $wpdb->query( "DROP TABLE IF EXISTS $table_name" );
}

function lhf_apply_preset( $mode = 'safe' ) {
    if ( $mode === 'none' ) {
        update_option( 'lighthouse_zen', 0 );
        update_option( 'lighthouse_prefetch', 0 );
        update_option( 'lighthouse_prefetch_throttle', 0 );
        update_option( 'lighthouse_version_parameter', 0 );
        update_option( 'lighthouse_emoji', 0 );
        update_option( 'lighthouse_canonical', 0 );
        update_option( 'lighthouse_author_archive', 0 );
        update_option( 'lighthouse_prepend_attachment', 0 );
        update_option( 'lighthouse_normalize_scheme', 0 );
        update_option( 'lighthouse_head_cleanup', 0 );
        update_option( 'lighthouse_rss_links', 0 );
        update_option( 'lighthouse_comment_cookies', 0 );
        update_option( 'lighthouse_embed', 0 );
        update_option( 'lighthouse_mediaelement', 0 );
        update_option( 'lighthouse_heartbeat', 0 );

        update_option( 'lighthouse_xmlrpc', 0 );
        update_option( 'lighthouse_brute_force', 0 );

        update_option( 'lighthouse_no_big_images', 0 );
        update_option( 'lighthouse_no_intermediate_images', 0 );
        update_option( 'lhfm_lazy_loading', 0 );
        update_option( 'lhfm_responsive', 0 );
        update_option( 'lhfm_compression_level', 82 );

        update_option( 'lighthouse_comment_html', 0 );
        update_option( 'lighthouse_comment_reply', 0 );
        update_option( 'lighthouse_no_lazy_loading', 0 );
        update_option( 'lighthouse_no_jetpack_css', 0 );
        update_option( 'lighthouse_no_classic_css', 0 );
        update_option( 'lighthouse_jquery_migrate', 0 );
    } elseif ( $mode === 'safe' ) {
        update_option( 'lighthouse_zen', 0 );
        update_option( 'lighthouse_prefetch', 0 );
        update_option( 'lighthouse_prefetch_throttle', 150 );
        update_option( 'lighthouse_version_parameter', 0 );
        update_option( 'lighthouse_emoji', 1 );
        update_option( 'lighthouse_canonical', 1 );
        update_option( 'lighthouse_author_archive', 1 );
        update_option( 'lighthouse_prepend_attachment', 0 );
        update_option( 'lighthouse_normalize_scheme', 0 );
        update_option( 'lighthouse_head_cleanup', 1 );
        update_option( 'lighthouse_rss_links', 1 );
        update_option( 'lighthouse_comment_cookies', 0 );
        update_option( 'lighthouse_embed', 0 );
        update_option( 'lighthouse_mediaelement', 0 );
        update_option( 'lighthouse_heartbeat', 1 );

        update_option( 'lighthouse_xmlrpc', 0 );
        update_option( 'lighthouse_brute_force', 0 );

        update_option( 'lighthouse_no_big_images', 0 );
        update_option( 'lighthouse_no_intermediate_images', 0 );
        update_option( 'lhfm_lazy_loading', 1 );
        update_option( 'lhfm_responsive', 1 );
        update_option( 'lhfm_compression_level', 82 );

        update_option( 'lighthouse_comment_html', 0 );
        update_option( 'lighthouse_comment_reply', 0 );
        update_option( 'lighthouse_no_lazy_loading', 0 );
        update_option( 'lighthouse_no_jetpack_css', 0 );
        update_option( 'lighthouse_no_classic_css', 1 );
        update_option( 'lighthouse_jquery_migrate', 0 );
    } elseif ( $mode === 'advanced' ) {
        update_option( 'lighthouse_zen', 0 );
        update_option( 'lighthouse_prefetch', 2 );
        update_option( 'lighthouse_prefetch_throttle', 150 );
        update_option( 'lighthouse_version_parameter', 0 );
        update_option( 'lighthouse_emoji', 1 );
        update_option( 'lighthouse_canonical', 1 );
        update_option( 'lighthouse_author_archive', 1 );
        update_option( 'lighthouse_prepend_attachment', 0 );
        update_option( 'lighthouse_normalize_scheme', 0 );
        update_option( 'lighthouse_head_cleanup', 1 );
        update_option( 'lighthouse_rss_links', 1 );
        update_option( 'lighthouse_comment_cookies', 0 );
        update_option( 'lighthouse_embed', 1 );
        update_option( 'lighthouse_mediaelement', 1 );
        update_option( 'lighthouse_heartbeat', 1 );

        update_option( 'lighthouse_xmlrpc', 1 );
        update_option( 'lighthouse_brute_force', 0 );

        update_option( 'lighthouse_no_big_images', 1 );
        update_option( 'lighthouse_no_intermediate_images', 1 );
        update_option( 'lhfm_lazy_loading', 1 );
        update_option( 'lhfm_responsive', 1 );
        update_option( 'lhfm_compression_level', 82 );

        update_option( 'lighthouse_comment_html', 0 );
        update_option( 'lighthouse_comment_reply', 0 );
        update_option( 'lighthouse_no_lazy_loading', 0 );
        update_option( 'lighthouse_no_jetpack_css', 0 );
        update_option( 'lighthouse_no_classic_css', 1 );
        update_option( 'lighthouse_jquery_migrate', 1 );
    }
}

/**
 * Remove jQuery Migrate.
 *
 * Remove jQuery Migrate as a jQuery dependency.
 */
function lhf_remove_jquery_migrate( $scripts ) {
    if ( ! empty( $scripts->registered['jquery'] ) ) {
        $jquery_dependencies                 = $scripts->registered['jquery']->deps;
        $scripts->registered['jquery']->deps = array_diff( $jquery_dependencies, [ 'jquery-migrate' ] );
    }
}

/**
 * Remove version parameter.
 *
 * Remove version parameter ('ver', 'v', 'sv') from scripts and styles.
 *
 * @return string
 */
function lhf_remove_script_version( $src ) {
    return esc_url( remove_query_arg( [ 'ver', 'v', 'sv' ], $src ) );
}

/**
 * Remove version parameter.
 *
 * Remove version parameter ('ver', 'v', 'sv') from scripts and styles.
 */
function lhf_disable_emojis() {
    if ( (int) get_option( 'lighthouse_emoji' ) === 1 ) {
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'wp_print_styles', 'wp_enqueue_emoji_styles' );
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'admin_print_styles', 'wp_enqueue_emoji_styles' );
        remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
        remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
        remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

        remove_action( 'init', 'smilies_init', 5 );

        remove_filter( 'comment_text', 'make_clickable', 9 );
        remove_filter( 'the_content', 'convert_bbcode' );
        remove_filter( 'the_content', 'convert_gmcode' );
        remove_filter( 'the_content', 'convert_smilies' );
        remove_filter( 'the_content', 'convert_chars' );

        //add_filter( 'option_use_smilies', '__return_false' );

        if ( ! is_admin() ) {
            add_filter( 'emoji_svg_url', '__return_false' );
        }
    }
}

function lhf_disable_author_archive() {
    // If we are on author archive
    if ( is_author() ) {
        global $wp_query;

        $wp_query->set_404();
    } else {
        redirect_canonical();
    }
}

function lhf_get_message() {
    global $wpdb, $wp_version;

    $all_pass = true;

    $php_min_version_check = version_compare( LIGHTHOUSE_CHECK_PHP_MIN_VERSION, PHP_VERSION, '<=' );
    $php_rec_version_check = version_compare( LIGHTHOUSE_CHECK_PHP_REC_VERSION, PHP_VERSION, '<=' );

    $wp_min_version_check = version_compare( LIGHTHOUSE_CHECK_WP_MIN_VERSION, $wp_version, '<=' );
    $wp_rec_version_check = version_compare( LIGHTHOUSE_CHECK_WP_REC_VERSION, $wp_version, '<=' );

    // Memory usage
    $memory = [];

    $memory['limit'] = (int) ini_get( 'memory_limit' );
    $memory['usage'] = function_exists( 'memory_get_peak_usage' ) ? round( memory_get_peak_usage( true ) / 1024 / 1024, 2 ) : 0;

    // Images
    $check  = '
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16"><path fill="currentColor" d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z"></path></svg>';
    $x      = '
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16"><path fill="currentColor" d="M3.72 3.72a.75.75 0 0 1 1.06 0L8 6.94l3.22-3.22a.749.749 0 0 1 1.275.326.749.749 0 0 1-.215.734L9.06 8l3.22 3.22a.749.749 0 0 1-.326 1.275.749.749 0 0 1-.734-.215L8 9.06l-3.22 3.22a.751.751 0 0 1-1.042-.018.751.751 0 0 1-.018-1.042L6.94 8 3.72 4.78a.75.75 0 0 1 0-1.06Z"></path></svg>';
    $preset = '<img src="' . LIGHTHOUSE_PLUGIN_URL . '/assets/icons/preset.svg" alt="" width="16" height="16">';
    //

    if ( ! empty( $memory['usage'] ) && ! empty( $memory['limit'] ) ) {
        $memory['percent'] = round( $memory['usage'] / $memory['limit'] * 100, 0 );
        $memory['color']   = 'font-weight:normal;';

        if ( $memory['percent'] > 75 ) {
            $memory['color'] = 'font-weight:bold;color:#E66F00';
        }

        if ( $memory['percent'] > 90 ) {
            $memory['color'] = 'font-weight:bold;color:red';
        }
    }

    $server_ip_address = ( ! empty( $_SERVER['SERVER_ADDR'] ) ? $_SERVER['SERVER_ADDR'] : '' );

    if ( $server_ip_address === '' ) {
        $server_ip_address = ( ! empty( $_SERVER['LOCAL_ADDR'] ) ? $_SERVER['LOCAL_ADDR'] : '' );
    }
    //

    $message = '<section class="lhf--grid lhf--grid-4">
        <div class="lhf--grid-item">
            <span class="lhf--metric-name">Server Platform</span>
            <p>
                <span class="lhf-sf-metric-value">' . sanitize_text_field( $_SERVER['SERVER_SOFTWARE'] ) . '</span>
                <small>' . ( PHP_INT_SIZE * 8 ) . 'bit</small>
                <br>Server IP <code>' . $server_ip_address . '</code> (' . gethostname() . ')
                <br>' . OPENSSL_VERSION_TEXT . '
            </p>
            <p>';

            if ( $_SERVER['HTTP_ACCEPT_ENCODING'] === 'gzip' || function_exists( 'ob_gzhandler' ) || ini_get( 'zlib.output_compression' ) ) {
                $message .= '<span class="lhfr">' . $check . ' gzip</span>';
            } else {
                $message .= '<span class="lhfw">' . $x . ' gzip</span>';
            }

            $is_protocol = wp_get_server_protocol();

            if ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ) {
                $message .= '<span class="lhfr">' . $check . ' HTTPS</span><span class="lhfr">' . $check . ' ' . $is_protocol . '</span></p>';
            } elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' || ! empty( $_SERVER['HTTP_X_FORWARDED_SSL'] ) && $_SERVER['HTTP_X_FORWARDED_SSL'] === 'on' ) {
                $message .= '<span class="lhfw">' . $x . ' HTTP</span>';
            }

            $message .= '</p>
        </div>
        <div class="lhf--grid-item">
            <span class="lhf--metric-name">Server Stack</span>
            <p>
                <b>PHP</b> <span class="lhf-sf-metric-value"><code>' . PHP_VERSION . '</code></span> with <b>cURL</b> <code>' . curl_version()['version'] . '</code>
                <br><b>MySQL</b> <span class="lhf-sf-metric-value"><code>' . $wpdb->db_version() . '</code></span>
            </p>
        </div>
        <div class="lhf--grid-item">
            <span class="lhf--metric-name">Memory</span>
            <p>
                WordPress/server memory and peak usage
                <br><span class="lhf-sf-metric-value"><code>' . WP_MEMORY_LIMIT . '</code></span>
                <br>Peak usage: ' . $memory['usage'] . '/' . $memory['limit'] . 'MB (<span style="' . $memory['color'] . '">' . $memory['percent'] . '%</span>)
            </p>
        </div>
        <div class="lhf--grid-item">
            <span class="lhf--metric-name">Optimization</span>
            <p>Lighthouse optimization preset</p>
            <p><span class="lhfn">' . $preset . ' ' . ( (string) get_option( 'lighthouse_preset' ) !== '' ? get_option( 'lighthouse_preset' ) : 'custom' ) . '</span></p>
        </div>

        <div class="lhf--grid-item" style="grid-column: span 2;">';

            $data         = lhf_host_info();
            $data         = explode( '::', $data );
            $host_ip      = $data[0];
            $serverip     = getHostByName( getHostName() );
            $host_country = $data[1];
            $host_isp     = $data[2];

            $message .= '<span class="lhf--metric-name">Hosting</span>
            <p>
                Hosting IP (proxied): <code>' . esc_html( $serverip ) . '</code><br>
                Hosting Country: ' . esc_html( $host_country ) . '<br>
                ISP: ' . esc_html( $host_isp ) .
            '</p>
        </div>

        <div class="lhf--grid-item" style="grid-column: span 2;">';

            // Response time
            $ch_resptime = curl_init( get_site_url() );
            curl_setopt( $ch_resptime, CURLOPT_RETURNTRANSFER, 1 );
            if ( curl_exec( $ch_resptime ) ) {
                $curl_resptime = curl_getinfo( $ch_resptime );
                $response_time = $curl_resptime['total_time'];
            } else {
                $response_time = 0.01;
            }

            $inipath = php_ini_loaded_file();

            if ( $inipath ) {
                $iniflp = $inipath;
            } else {
                $iniflp = esc_html__("A php.ini file is not loaded", 'lighthouse');
            }

            $errorlog_path = ini_get('error_log');

            $message .= '<span class="lhf--metric-name">Site Information</span>
            <p>
                Response Time: ' . number_format( $response_time, 2 ) . ' seconds<br>
                PHP Configuration File: <code>' . esc_html( $iniflp ) . '</code><br>
                PHP Error Log: <code>' . esc_html( $errorlog_path ) . '</code><br>
                Default Timezone: ' . date_default_timezone_get() .
            '</p>
        </div>

        <div class="lhf--grid-item">
            <span class="lhf--metric-name">Lighthouse Beacon</span>
            <p>
                Track your real <abbr title="Time to First Byte">TTFB</abbr>
                <br>';

                if ( ! file_exists( trailingslashit( ABSPATH ) . 'beacon.html' ) ) {
                    $message .= '<br>' . $x . ' Beacon file does not exist
                    <br><a href="' . admin_url( 'admin.php?page=lighthouse&tab=lhf_speedfactor' ) . '&action=create-config" class="button button-secondary">Attempt Beacon file creation</a>';
                } else {
                    $message .= '<br>' . $check . ' Beacon file found';
                }

            $message .= '</p>
        </div>
        <div class="lhf--grid-item">
            <span class="lhf--metric-name">SpeedFactor Tracking</span>
            <p>
                WordPress performance, assets and connection speed
                <br>';

                if ( (string) get_option( 'lhf_speedfactor_schedule' ) !== '' ) {
                    $message .= '<br>' . $check . ' SpeedFactor is active';
                } else {
                    $message .= '<br>' . $x . ' SpeedFactor is not active
                    <br><a href="' . admin_url( 'admin.php?page=lighthouse&tab=lhf_speedfactor' ) . '" class="button button-secondary">Enable SpeedFactor</a>';
                }

            $message .= '</p>
        </div>
        <div class="lhf--grid-item">
            <span class="lhf--metric-name">Registration Spam</span>
            <p>
                <span class="lhf-sf-metric-value">' . number_format( get_option( 'lighthouse_spam_registration_count', 0 ) ) . '</span> 
                <span data-title="isspammy.com">' . number_format( get_option( 'lighthouse_isspammy_count', 0 ) ) . '</span>,
                <span data-title="Akismet">' . number_format( get_option( 'lighthouse_blocked_by_akismet', 0 ) ) . '</span>,
                <span data-title="Pattern #1: Periods">' . number_format( get_option( 'lighthouse_spam_registration_pattern1_count', 0 ) ) . '</span>
            </p>
            <p>
                Total spam registrations blocked on your site.
                <br><small style="color:var(--color-grey)">This module protects your site from direct or injected spam registration.</small>
            </p>
        </div>
        <div class="lhf--grid-item">
            <span class="lhf--metric-name">Brute Force Protection</span>
            <p>
                <span class="lhf-sf-metric-value">' . number_format( get_option( 'lighthouse_failed_login_count', 0 ) ) . '</span>
            </p>
            <p>
                Total malicious attacks blocked on your site.
                <br><small style="color:var(--color-grey)">This module protects your site from traditional and distributed brute force login attacks.</small>
            </p>
        </div>
    </section>';

    $success = '';
    $warning = '';
    $error   = '';

    if ( function_exists( 'classicpress_version' ) ) {
        // ClassicPress check
        global $cp_version;

        if ( version_compare( $cp_version, LIGHTHOUSE_CHECK_CP_REC_VERSION, '<' ) ) {
            $error   .= '<p><b>' . __( 'Warning:', 'lighthouse' ) . '</b> Lighthouse recommends ClassicPress ' . LIGHTHOUSE_CHECK_CP_REC_VERSION . ' or higher.</p>';
            $all_pass = false;
        }
    } else {
        // WordPress check
        if ( ! $wp_min_version_check ) {
            $error   .= '<p><b>' . __( 'Warning:', 'lighthouse' ) . '</b> Lighthouse requires WordPress ' . LIGHTHOUSE_CHECK_WP_MIN_VERSION . ' or higher.</p>';
            $all_pass = false;
        }
        if ( ! $wp_rec_version_check ) {
            $error   .= '<p><b>' . __( 'Warning:', 'lighthouse' ) . '</b> Lighthouse recommends WordPress ' . LIGHTHOUSE_CHECK_WP_REC_VERSION . ' or higher.</p>';
            $all_pass = false;
        }
    }

    if ( ! $php_min_version_check ) {
        $error   .= '<p><b>' . __( 'Warning:', 'lighthouse' ) . '</b> WordPress 4.3+ requires PHP version ' . LIGHTHOUSE_CHECK_PHP_MIN_VERSION . ' or higher.</p>';
        $all_pass = false;
    }
    if ( version_compare( $wpdb->db_version(), '5.5.3', '<' ) ) {
        $warning .= '<p><b>' . __( 'Error:', 'lighthouse' ) . '</b> WordPress <code>utf8mb4</code> support requires MySQL version 5.5.3 or higher.</p>';
        $all_pass = false;
    }

    if ( ! $php_rec_version_check ) {
        $warning .= '<p><strong>' . __( 'Warning:', 'lighthouse' ) . '</strong> For performance and security reasons, we recommend running PHP version ' . LIGHTHOUSE_CHECK_PHP_REC_VERSION . ' or higher.</p>';
        $all_pass = false;
    }

    if ( $error ) {
        $message .= '<div class="lhf-notice lhf-notice-error">' . $error . '</div>';
    }
    if ( $warning ) {
        $message .= '<div class="lhf-notice lhf-notice-warning">' . $warning . '</div>';
    }
    if ( $success ) {
        $message .= '<div class="lhf-notice lhf-notice-success">' . $success . '</div>';
    }

    return $message;
}



//Host Info Check
function lhf_host_info() {
    $useragent = $_SERVER['HTTP_USER_AGENT'];

    $ip  = gethostbyname( site_url() );
    $url = 'https://ipapi.co/' . $ip . '/json/';
    $ch  = curl_init();

    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
    curl_setopt( $ch, CURLOPT_ENCODING, 'gzip,deflate' );
    curl_setopt( $ch, CURLOPT_USERAGENT, $useragent );
    curl_setopt( $ch, CURLOPT_REFERER, 'https://www.google.com' );
    $ipcontent = curl_exec( $ch );
    curl_close( $ch );

    $ip_data = json_decode( $ipcontent );
    if ( $ip_data && ! isset( $ip_data->{'error'} ) ) {
        $country = $ip_data->{'country_name'};
        $isp     = $ip_data->{'org'};
    } else {
        $country = 'Unknown';
        $isp     = 'Unknown';
    }

    if ( (string) $country === '' ) {
        $country = 'Unknown';
    }

    if ( (string) $isp === '' ) {
        $isp = 'Unknown';
    }

    $data = $ip . '::' . $country . '::' . $isp . '::';

    return $data;
}



function lhf_src_scheme( $url ) {
    if ( is_admin() ) {
        return $url;
    }

    return str_replace( [ 'http:', 'https:' ], '', $url );
}



function lhf_remove_xmlrpc_methods( $methods ) {
    unset( $methods['pingback.ping'] );
    unset( $methods['pingback.extensions.getPingbacks'] );

    unset( $methods['system.multicall'] );
    unset( $methods['system.listMethods'] );
    unset( $methods['system.getCapabilities'] );

    unset( $methods['wp.getUsersBlogs'] );

    return $methods;
}
function lhf_remove_x_pingback( $headers ) {
    unset( $headers['X-Pingback'] );

    return $headers;
}
function lhf_remove_pingback_url( $output, $show ) {
    if ( (string) $show === 'pingback_url' ) {
        $output = '';
    }

    return $output;
}



// No self pings
function lhf_no_self_ping( $links ) {
    $home = get_option( 'home' );
    foreach ( $links as $l => $link ) {
        if ( 0 === strpos( $link, $home ) ) {
            unset( $links[ $l ] );
        }
    }
}



/**
 * Disable embeds on init.
 *
 * - Removes the needed query vars.
 * - Disables oEmbed discovery.
 * - Completely removes the related JavaScript.
 *
 */
function lhf_disable_embeds_init() {
    if ( (int) get_option( 'lighthouse_embed' ) === 1 ) {
        global $wp;

        $wp->public_query_vars = array_diff(
            $wp->public_query_vars,
            [
                'embed',
            ]
        );

        add_filter( 'embed_oembed_discover', '__return_false' );
        remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
        remove_action( 'rest_api_init', 'wp_oembed_register_route' );
        remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
        remove_action( 'wp_head', 'wp_oembed_add_host_js' );

        remove_filter( 'pre_oembed_result', 'wp_filter_pre_oembed_result', 10 );

        if ( ! is_admin() ) {
            wp_deregister_script( 'wp-embed' );
        }
    }
}

function lhf_capital_p_bangit() {
    remove_filter( 'the_title', 'capital_P_dangit', 11 );
    remove_filter( 'the_content', 'capital_P_dangit', 11 );
    remove_filter( 'comment_text', 'capital_P_dangit', 31 );
}
function lhf_taxonomies() {
    global $wp_taxonomies;

    unset( $wp_taxonomies['link_category'] );
    unset( $wp_taxonomies['post_format'] );
}
function lhf_admin_bar() {
    global $wp_admin_bar;

    if ( ! is_admin_bar_showing() ) {
        return;
    }

    $wp_admin_bar->remove_menu( 'wp-logo' );
    $wp_admin_bar->remove_menu( 'comments' );
    $wp_admin_bar->remove_menu( 'my-account' );
    $wp_admin_bar->remove_menu( 'appearance' );
    $wp_admin_bar->remove_menu( 'new-content' );
    $wp_admin_bar->remove_menu( 'my-account-with-avatar' );
}
function lhf_dashboard_widgets() {
    remove_meta_box( 'dashboard_browser_nag', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );

    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
}
function lhf_note() {
    $screen = get_current_screen();

    if ( $screen->id === 'settings_page_lighthouse' ) {
        print '<div id="message" class="updated notice is-dismissible"><p>' . __( 'Lighthouse Zen mode is active.', 'lighthouse' ) . '</p></div>';
    }
}



function lighthouse_disable_wp_media_elements_js() {
    wp_deregister_script( 'wp-mediaelement' );
    wp_deregister_style( 'wp-mediaelement' );
}



function lighthouse_custom_footer() {
    if ( (int) get_option( 'lighthouse_thank_you' ) === 1 ) {
        echo '<p class="has-text-align-center has-small-font-size has-powered-by-lighthouse" style="text-align:center;margin:.5em 0"><a href="https://getbutterfly.com/wordpress-plugins/lighthouse/" rel="external follow noopener">Pagespeed Optimization</a> by <a href="https://getbutterfly.com/wordpress-plugins/lighthouse/" rel="external follow noopener">Lighthouse</a>.</p>';
    }
}

add_action( 'wp_footer', 'lighthouse_custom_footer' );



if ( (int) get_option( 'lighthouse_no_app_passwords' ) === 1 ) {
    add_filter( 'wp_is_application_passwords_available', '__return_false' );
}



if ( (int) get_option( 'lighthouse_no_big_images' ) === 1 ) {
    add_filter( 'big_image_size_threshold', '__return_false' );
}


function lighthouse_remove_default_image_sizes( $sizes ) {
    unset( $sizes['medium_large'] );
    unset( $sizes['1536x1536'] );
    unset( $sizes['2048x2048'] );

    return $sizes;
}

function lighthouse_filter_image_sizes() {
    foreach ( get_intermediate_image_sizes() as $size ) {
        if ( in_array( $size, [ '1536x1536', '2048x2048', 'medium_large' ] ) ) {
            remove_image_size( $size );
        }
    }
}

if ( (int) get_option( 'lighthouse_no_intermediate_images' ) === 1 ) {
    add_action( 'init', 'lighthouse_filter_image_sizes' );
    add_filter( 'intermediate_image_sizes_advanced', 'lighthouse_remove_default_image_sizes' );
}



/**
 * Add 'loading="lazy" to all images.
 *
 * @param string $content The content to check.
 * @return string
 */
function lhfm_lazy_load_image( $content ) {
    return (string) preg_replace(
        '/<img /',
        '<img loading="lazy" ',
        $content
    );
}

/**
 * Add 'loading="lazy" to all Iframes.
 *
 * @param string $content The content to check.
 * @return string
 */
function lhfm_lazy_load_iframe( $content ) {
    return (string) preg_replace(
        '/<iframe /',
        '<iframe loading="lazy" ',
        $content
    );
}

if ( (int) get_option( 'lhfm_lazy_loading' ) ) {
    add_filter( 'the_content', 'lhfm_lazy_load_image', 100 );
    add_filter( 'the_content', 'lhfm_lazy_load_iframe', 100 );
    add_filter( 'get_avatar', 'lhfm_lazy_load_image', 100 );
}



if ( (int) get_option( 'lhfm_compression_level' ) > 0 ) {
    add_filter(
        'jpeg_quality',
        function ( $arg ) {
            return (int) get_option( 'lhfm_compression_level' );
        }
    );
}



// Slow down the default heartbeat
if ( (int) get_option( 'lighthouse_heartbeat' ) === 1 ) {
    add_filter(
        'heartbeat_settings',
        function ( $settings ) {
            // 60 seconds
            $settings['interval'] = 60;

            return $settings;
        }
    );
}



if ( (int) get_option( 'lighthouse_disable_rest' ) === 1 ) {
    add_filter(
        'rest_authentication_errors',
        function( $result ) {
            // If a previous authentication check was applied, pass that result along without modification.
            if ( true === $result || is_wp_error( $result ) ) {
                return $result;
            }

            // No authentication has been performed yet.
            // Return an error if user is not logged in.
            if ( ! is_user_logged_in() ) {
                return new WP_Error(
                    'rest_not_logged_in',
                    __( 'You are not currently logged in.' ),
                    [ 'status' => 401 ]
                );
            }

            // Our custom authentication check should have no effect on logged-in requests
            return $result;
        }
    );
}

if ( (int) get_option( 'lighthouse_disable_user_enumeration' ) === 1 ) {
    if ( ! is_admin() ) {
        if ( preg_match( '/author=([0-9]*)/i', $_SERVER['QUERY_STRING'] ) ) {
            die();
        }

        add_filter( 'redirect_canonical', 'lhf_check_enum', 10, 2 );
    }

    function lhf_check_enum( $redirect, $request ) {
        if ( preg_match( '/\?author=([0-9]*)(\/*)/i', $request ) ) {
            die();
        } else {
            return $redirect;
        }
    }
}



/**
 * Adds a custom action link to each user in the WordPress admin Users page.
 *
 * This function hooks into the 'user_row_actions' filter and adds a new link 
 * that allows admins to mark the email domain of a user as spam. This link 
 * is added to the row actions for each user in the Users list.
 *
 * @param array    $actions An array of action links to be displayed.
 *                           Default 'Edit', 'Delete' for single site, and
 *                           'Edit', 'Remove' for multisite.
 * @param WP_User  $user    WP_User object for the currently-listed user.
 * @return array   Updated array of action links for each user.
 */
function lighthouse_add_spam_domain_link( $actions, $user ) {
    $url = add_query_arg(
        [
            'action'  => 'mark_as_spam',
            'user_id' => $user->ID,
        ],
        admin_url( 'users.php' )
    );

    $actions['mark_as_spam'] = "<a href='" . wp_nonce_url( $url, 'mark_as_spam_' . $user->ID ) . "'>Mark domain as spam</a>";

    return $actions;
}

add_filter( 'user_row_actions', 'lighthouse_add_spam_domain_link', 10, 2 );



/**
 * Handles the custom 'Mark this domain as spam' action in the admin Users page.
 *
 * When the custom link generated by 'lighthouse_add_spam_domain_link()' is clicked, this function
 * is triggered. It checks if the current user has the required capability to perform
 * the action, validates the request for security, extracts the domain from the user's
 * email, and then adds it to a custom database table if it doesn't already exist.
 *
 * This function should be hooked into 'admin_init'.
 *
 * @global wpdb    $wpdb   WordPress database abstraction object.
 */
function lighthouse_mark_as_spam_action() {
    if ( isset( $_GET['action'] ) && (string) $_GET['action'] === 'mark_as_spam' && isset( $_GET['user_id'] ) ) {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'You do not have sufficient permissions to perform this action.' );
        }

        check_admin_referer( 'mark_as_spam_' . $_GET['user_id'] );

        $user_id = intval( $_GET['user_id'] );
        $user    = get_userdata( $user_id );
        $domain  = substr( strrchr( $user->user_email, '@' ), 1 );

        global $wpdb;

        $table_name = $wpdb->prefix . 'lighthouse_blacklist';

        if ( $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE domain = '$domain'" ) == 0 ) {
            $wpdb->insert(
                $table_name,
                [ 'domain' => $domain ],
                [ '%s' ]
            );
        }

        wp_redirect( admin_url( 'users.php' ) );

        exit;
    }
}

add_action( 'admin_init', 'lighthouse_mark_as_spam_action' );



add_filter( 'registration_errors', 'lighthouse_akismet_block_spam_registrations', 10, 3 );

function lighthouse_akismet_block_spam_registrations( $errors, $sanitized_user_login, $user_email ) {
    if ( (int) get_option( 'lighthouse_use_akismet' ) !== 1 ) {
        return $errors;
    }

    global $akismet_api_key;

    if ( empty( $akismet_api_key ) ) {
        return $errors;
    }

    if ( ! empty( $user_email ) && ! empty( $sanitized_user_login ) ) {
        $comment = [
            'comment_author'       => $sanitized_user_login,
            'comment_author_email' => $user_email,
            'comment_type'         => 'registration',
        ];

        $response = \Akismet::httpPost( \Akismet::buildQuery( $comment ), $akismet_api_key, 'rest.akismet.com', '/1.1/comment-check' );

        if ( 'true' == $response[1] ) {
            $blocked_registrations = get_option( 'lighthouse_blocked_by_akismet', 0 );
            update_option( 'lighthouse_blocked_by_akismet', $blocked_registrations + 1 );

            apply_filters( 'lighthouse_spam_check_result', true, $sanitized_user_login, $user_email, 'Akismet' );

            $errors->add( 'spam', __( 'Registration blocked by Akismet.' ) );
        }
    }

    return $errors;
}



/**
 * Page caching (browser caching)
 */
function lighthouse_set_caching_headers() {
    if ( ! headers_sent() ) {
        $last_modified_time   = filemtime( __FILE__ );
        $client_last_modified = isset( $_SERVER['HTTP_IF_MODIFIED_SINCE'] ) ? strtotime( $_SERVER['HTTP_IF_MODIFIED_SINCE'] ) : false;

        if ( (int) get_option( 'lighthouse_caching_etag', 0 ) === 1 ) {
            $etag        = '"' . md5_file( __FILE__ ) . '"';
            $client_etag = isset( $_SERVER['HTTP_IF_NONE_MATCH'] ) ? trim( $_SERVER['HTTP_IF_NONE_MATCH'] ) : false;

            // Check both ETag and Last-Modified conditions
            if ( ( $client_etag && $client_etag === $etag ) || ( $client_last_modified && $client_last_modified >= $last_modified_time ) ) {
                header( 'HTTP/1.1 304 Not Modified' );
                exit;
            }

            // Send ETag header if the option is enabled
            header( "ETag: $etag" );
        } elseif ( $client_last_modified && $client_last_modified >= $last_modified_time ) {
            // Only check Last-Modified if ETag is not used
            header( 'HTTP/1.1 304 Not Modified' );
            exit;
        }

        // Standard Cache-Control used by browsers and Cloudflare
        header( "Cache-Control: public, max-age=3600, must-revalidate" );
        header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s', $last_modified_time ) . ' GMT' );

        // Cloudflare-specific cache control
        if ( (int) get_option( 'lighthouse_caching_cf' ) === 1 ) {
            header( 'Edge-Cache-TTL: 3600' );
            header( 'Surrogate-Control: max-age=3600' );
        }
    }
}

if ( (int) get_option( 'lighthouse_caching' ) === 1 ) {
    add_action( 'init', 'lighthouse_set_caching_headers' );
}
