<?php
function lighthouse_options_page() {
    wp_enqueue_style( 'lighthouse-inter' );

    global $wpdb;

    if ( isset( $_POST['info_preset_no_update'] ) ) {
        lhf_tidy();
        lhf_apply_preset( 'none' );

        update_option( 'lighthouse_preset', 'none' );

        echo '<div class="updated notice is-dismissible"><p>Safe optimizations preset applied!</p></div>';
    } elseif ( isset( $_POST['info_preset_safe_update'] ) ) {
        lhf_tidy();
        lhf_apply_preset( 'safe' );

        update_option( 'lighthouse_preset', 'safe' );

        echo '<div class="updated notice is-dismissible"><p>Safe optimizations preset applied!</p></div>';
    } elseif ( isset( $_POST['info_preset_advanced_update'] ) ) {
        lhf_tidy();
        lhf_apply_preset( 'advanced' );

        update_option( 'lighthouse_preset', 'advanced' );

        echo '<div class="updated notice is-dismissible"><p>Advanced optimizations preset applied!</p></div>';
    } elseif ( isset( $_POST['info_preset_tidy'] ) ) {
        lhf_tidy();

        echo '<div class="updated notice is-dismissible"><p>Old settings and tables removed successfully!</p></div>';
    } elseif ( isset( $_POST['info_settings_update'] ) ) {
        update_option( 'lighthouse_thank_you', (int) $_POST['lighthouse_thank_you'] );
        update_option( 'lighthouse_auto_update', (int) $_POST['lighthouse_auto_update'] );

        update_option( 'lighthouse_zen', (int) $_POST['lighthouse_zen'] );
        update_option( 'lighthouse_prefetch', (int) $_POST['lighthouse_prefetch'] );
        update_option( 'lighthouse_prefetch_throttle', (int) $_POST['lighthouse_prefetch_throttle'] );

        update_option( 'lighthouse_caching', (int) $_POST['lighthouse_caching'] );
        update_option( 'lighthouse_caching_etag', (int) $_POST['lighthouse_caching_etag'] );
        update_option( 'lighthouse_caching_cf', (int) $_POST['lighthouse_caching_cf'] );

        update_option( 'lighthouse_version_parameter', (int) $_POST['lighthouse_version_parameter'] );
        update_option( 'lighthouse_emoji', (int) $_POST['lighthouse_emoji'] );

        if ( (int) $_POST['lighthouse_emoji'] === 1 ) {
            update_option( 'use_smilies', 0 );
        }

        update_option( 'lighthouse_canonical', (int) $_POST['lighthouse_canonical'] );
        update_option( 'lighthouse_author_archive', (int) $_POST['lighthouse_author_archive'] );
        update_option( 'lighthouse_prepend_attachment', (int) $_POST['lighthouse_prepend_attachment'] );

        update_option( 'lighthouse_head_cleanup', (int) $_POST['lighthouse_head_cleanup'] );
        update_option( 'lighthouse_rss_links', (int) $_POST['lighthouse_rss_links'] );

        update_option( 'lighthouse_comment_cookies', (int) $_POST['lighthouse_comment_cookies'] );
        update_option( 'lighthouse_embed', (int) $_POST['lighthouse_embed'] );
        update_option( 'lighthouse_mediaelement', (int) $_POST['lighthouse_mediaelement'] );
        update_option( 'lighthouse_jquery_migrate', (int) $_POST['lighthouse_jquery_migrate'] );

        update_option( 'lighthouse_heartbeat', (int) $_POST['lighthouse_heartbeat'] );
        update_option( 'lighthouse_remove_custom_fields_metabox', (int) $_POST['lighthouse_remove_custom_fields_metabox'] );

        update_option( 'lhf_resource_hints_prefetch', sanitize_textarea_field( $_POST['lhf_resource_hints_prefetch'] ) );
        update_option( 'lhf_resource_hints_preconnect', sanitize_textarea_field( $_POST['lhf_resource_hints_preconnect'] ) );

        echo '<div id="message" class="updated notice is-dismissible"><p>' . __( 'Options updated successfully!', 'lighthouse' ) . '</p></div>';
    } elseif ( isset( $_POST['info_security_update'] ) ) {
        update_option( 'lighthouse_normalize_scheme', (int) $_POST['lighthouse_normalize_scheme'] );
        update_option( 'lighthouse_xmlrpc', (int) $_POST['lighthouse_xmlrpc'] );

        update_option( 'lighthouse_disable_user_enumeration', (int) $_POST['lighthouse_disable_user_enumeration'] );
        update_option( 'lighthouse_disable_rest', (int) $_POST['lighthouse_disable_rest'] );

        update_option( 'lighthouse_brute_force', (int) $_POST['lighthouse_brute_force'] );
        update_option( 'lighthouse_firewall', (int) $_POST['lighthouse_firewall'] );

        // Security
        update_option( 'lighthouse_check_registration_spam', (int) $_POST['lighthouse_check_registration_spam'] );
        update_option( 'lighthouse_check_registration_periods', (int) $_POST['lighthouse_check_registration_periods'] );
        update_option( 'lighthouse_check_registration_periods_count', (int) $_POST['lighthouse_check_registration_periods_count'] );
        update_option( 'lighthouse_use_akismet', (int) $_POST['lighthouse_use_akismet'] );
        update_option( 'lighthouse_use_external_blacklist', (int) $_POST['lighthouse_use_external_blacklist'] );
        update_option( 'lighthouse_use_isspammy', (int) $_POST['lighthouse_use_isspammy'] );
        update_option( 'lighthouse_blacklist_email_message', wp_kses_post( $_POST['lighthouse_blacklist_email_message'] ) );

        // Create the table name
        $table_name = $wpdb->prefix . 'lighthouse_blacklist';

        // Truncate table
        $results = $wpdb->query( "TRUNCATE TABLE $table_name" );

        // Update the Blacklist
        if ( $blacklist = $_POST['blacklist'] ) {
            $blacklist_array = explode( "\n", $blacklist );

            sort( $blacklist_array );

            foreach ( $blacklist_array as $blacklist_current ) {
                $blacklist_current = strtolower( trim( $blacklist_current ) );

                if ( (string) $blacklist_current !== '' ) {
                    $wpdb->query( "INSERT INTO $table_name (domain) VALUES ('" . $wpdb->escape( $blacklist_current ) . "')" );
                }
            }
        }
        //

        if ( (int) get_option( 'lighthouse_xmlrpc' ) === 1 ) {
            update_option( 'default_ping_status', 'closed' );
            update_option( 'default_pingback_flag', '' );
        }

        echo '<div id="message" class="updated notice is-dismissible"><p>' . __( 'Options updated successfully!', 'lighthouse' ) . '</p></div>';
    } elseif ( isset( $_POST['info_queries_update'] ) ) {
        update_option( 'lhf_queries_enable', (int) $_POST['lhf_queries_enable'] );
        update_option( 'lhf_queries_recent_requests', (int) $_POST['lhf_queries_recent_requests'] );
        update_option( 'lhf_queries_max_records', (int) $_POST['lhf_queries_max_records'] );

        if ( (int) $_POST['lhf_queries_enable'] === 1 ) {
            // Register the cron job to limit max records
            wp_schedule_event( time(), 'hourly', 'lt_clear_max' );
        } else {
            wp_clear_scheduled_hook( 'lt_clear_max' );
        }

        echo '<div id="message" class="updated notice is-dismissible"><p>' . __( 'Options updated successfully!', 'lighthouse' ) . '</p></div>';
    } elseif ( isset( $_POST['info_speedfactor_update'] ) ) {
        update_option( 'lhf_speedfactor_results', (int) $_POST['lhf_speedfactor_results'] );
        update_option( 'lhf_speedfactor_audit_email', sanitize_email( $_POST['lhf_speedfactor_audit_email'] ) );

        update_option( 'lhf_speedfactor_audit_http', sanitize_text_field( $_POST['lhf_speedfactor_audit_http'] ) );
        update_option( 'lhf_speedfactor_audit_tls', sanitize_text_field( $_POST['lhf_speedfactor_audit_tls'] ) );
        update_option( 'lhf_speedfactor_audit_ipv4', sanitize_text_field( $_POST['lhf_speedfactor_audit_ipv4'] ) );

        update_option( 'lhf_speedfactor_schedule', sanitize_text_field( $_POST['lhf_speedfactor_schedule'] ) );

        wp_clear_scheduled_hook( 'lhf_run_cron_speedfactor' );
        wp_schedule_event( time(), get_option( 'lhf_speedfactor_schedule' ), 'lhf_run_cron_speedfactor' );

        echo '<div id="message" class="updated notice is-dismissible"><p>' . __( 'Options updated successfully!', 'lighthouse' ) . '</p></div>';
    } elseif ( isset( $_POST['info_payment_update'] ) ) {
        update_option( 'lighthouse_theme_dark', (int) $_POST['lighthouse_theme_dark'] );

        update_option( 'lighthouse_comment_html', (int) $_POST['lighthouse_comment_html'] );
        update_option( 'lighthouse_comment_reply', (int) $_POST['lighthouse_comment_reply'] );

        update_option( 'lighthouse_no_lazy_loading', (int) $_POST['lighthouse_no_lazy_loading'] );
        update_option( 'lighthouse_no_jetpack_css', (int) $_POST['lighthouse_no_jetpack_css'] );
        update_option( 'lighthouse_no_classic_css', (int) $_POST['lighthouse_no_classic_css'] );

        update_option( 'lighthouse_no_app_passwords', (int) $_POST['lighthouse_no_app_passwords'] );

        update_option( 'lighthouse_theme_support_formats', (int) $_POST['lighthouse_theme_support_formats'] );
        update_option( 'lighthouse_theme_support_block_widgets', (int) $_POST['lighthouse_theme_support_block_widgets'] );
        update_option( 'lighthouse_theme_support_responsive_embeds', (int) $_POST['lighthouse_theme_support_responsive_embeds'] );
        update_option( 'lighthouse_theme_support_editor_styles', (int) $_POST['lighthouse_theme_support_editor_styles'] );
        update_option( 'lighthouse_theme_support_block_styles', (int) $_POST['lighthouse_theme_support_block_styles'] );
        update_option( 'lighthouse_theme_support_block_templates', (int) $_POST['lighthouse_theme_support_block_templates'] );
        update_option( 'lighthouse_theme_support_core_block_patterns', (int) $_POST['lighthouse_theme_support_core_block_patterns'] );
        update_option( 'lighthouse_theme_support_woocommerce', (int) $_POST['lighthouse_theme_support_woocommerce'] );

        echo '<div id="message" class="updated notice is-dismissible"><p>' . __( 'Options updated successfully!', 'lighthouse' ) . '</p></div>';
    } elseif ( isset( $_POST['info_storage_update'] ) ) {
        update_option( 'lighthouse_no_big_images', (int) $_POST['lighthouse_no_big_images'] );
        update_option( 'lighthouse_no_intermediate_images', (int) $_POST['lighthouse_no_intermediate_images'] );
        update_option( 'lhfm_compression_level', (int) $_POST['lhfm_compression_level'] );

        update_option( 'lhfm_lazy_loading', (int) $_POST['lhfm_lazy_loading'] );

        // Switch off main Lighthouse's option
        if ( isset( $_POST['lhfm_lazy_loading'] ) && $_POST['lhfm_lazy_loading'] === 1 ) {
            update_option( 'lighthouse_no_lazy_loading', 0 );
        }
        //

        update_option( 'lhfm_responsive', (int) $_POST['lhfm_responsive'] );
    }

    $active_page = admin_url( 'admin.php?page=lighthouse' );
    $active_tab  = isset( $_GET['tab'] ) ? $_GET['tab'] : 'lhf_dashboard';
    ?>
    <div class="wrap lhf--ui">
        <h1>Lighthouse</h1>

        <h2 class="nav-tab-wrapper lhf--ui">
            <a href="<?php echo $active_page; ?>&amp;tab=lhf_dashboard" class="nav-tab <?php echo $active_tab === 'lhf_dashboard' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Dashboard', 'lighthouse' ); ?></a>

            <a href="<?php echo $active_page; ?>&amp;tab=lhf_settings" class="nav-tab <?php echo $active_tab === 'lhf_settings' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Performance', 'lighthouse' ); ?></a>
            <a href="<?php echo $active_page; ?>&amp;tab=lhf_tweaks" class="nav-tab <?php echo $active_tab === 'lhf_tweaks' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Theme Tweaks', 'lighthouse' ); ?></a>
            <a href="<?php echo $active_page; ?>&amp;tab=lhf_storage" class="nav-tab <?php echo $active_tab === 'lhf_storage' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Media & Storage', 'lighthouse' ); ?></a>

            <a href="<?php echo $active_page; ?>&amp;tab=lhf_speedfactor" class="nav-tab <?php echo $active_tab === 'lhf_speedfactor' ? 'nav-tab-active' : ''; ?>"><?php _e( 'SpeedFactor', 'lighthouse' ); ?></a>
            <a href="<?php echo $active_page; ?>&amp;tab=lhf_speed_metrics" class="nav-tab <?php echo $active_tab === 'lhf_speed_metrics' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Speed Metrics', 'lighthouse' ); ?></a>

            <a href="<?php echo $active_page; ?>&amp;tab=lhf_security" class="nav-tab <?php echo $active_tab === 'lhf_security' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Security', 'lighthouse' ); ?></a>
            <a href="<?php echo $active_page; ?>&amp;tab=lhf_captcha" class="nav-tab <?php echo $active_tab === 'lhf_captcha' ? 'nav-tab-active' : ''; ?>"><?php _e( 'CAPTCHA', 'lighthouse' ); ?></a>

            <a href="<?php echo $active_page; ?>&amp;tab=lhf_queries" class="nav-tab <?php echo $active_tab === 'lhf_queries' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Query Tracker', 'lighthouse' ); ?></a>

            <a href="<?php echo $active_page; ?>&amp;tab=lhf_tips" class="nav-tab <?php echo $active_tab === 'lhf_tips' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Tips & Tricks', 'lighthouse' ); ?></a>
        </h2>

        <?php if ( $active_tab === 'lhf_dashboard' ) {
            echo lhf_get_message();
            ?>

            <section class="lhf--grid lhf--grid-2">
                <div class="lhf--grid-item">
                    <span class="lhf--metric-name"><?php _e( 'Lighthouse Optimization Presets', 'lighthouse' ); ?></span>

                    <form method="post" action="">
                        <p>
                            <input type="submit" name="info_preset_no_update" class="button button-secondary" value="None (Reset Plugin)">
                            <input type="submit" name="info_preset_safe_update" class="button button-secondary" value="Safe" style="font-weight:700">
                            <input type="submit" name="info_preset_advanced_update" class="button button-secondary" value="Advanced">
                        </p>
                        <br><small>The <b>Safe</b> optimizations preset will enable moderate/safe settings for your website. The risk of Lighthouse breaking your website or conflicting with other plugins is very low. The <b>Advanced</b> optimizations preset will enable recommended/advanced settings for your website. The risk of Lighthouse breaking your website or conflicting with other plugins is moderate.</small>

                        <hr>
                        <p>
                            <input type="submit" name="info_preset_tidy" class="button button-secondary" value="Remove Old/Deprecated Settings">
                        </p>
                        <br><small>This action is recommended after every major update, in order to keep the plugin <i>lean and mean</i>.</b></small>

                        <hr>
                        <p>You are using <b>Lighthouse</b> version <b><?php echo LIGHTHOUSE_VERSION; ?></b> with LighthouseDB version <b><?php echo get_option( 'lhf_db_version' ); ?></b>.</p>
                        <p><a href="https://getbutterfly.com/support/documentation/lighthouse/" rel="external">Documentation</a> | <a href="https://getbutterfly.com/wordpress-plugins/lighthouse/" rel="external">Support</a> | <a href="<?php echo admin_url( 'site-health.php' ); ?>">Site Health</a></p>
                    </form>
                </div>
                <div class="lhf--grid-item">
                    <span class="lhf--metric-name">Frequently Asked Questions</span>

                    <ul>
                        <li><b>Q:</b> Is Lighthouse compatible with other performance/caching/minification plugins?</li>
                        <li><b>A:</b> <b>Yes.</b> Just make sure you don't enable the same functionality on multiple plugins (e.g. minification, caching, feature removal).</a></li>
                    </ul>
                    <ul>
                        <li><b>Q:</b> Will Lighthouse improve the speed of my WordPress back-end?</li>
                        <li><b>A:</b> <b>No.</b> The WordPress back-end performance is influenced by many other factors, such as theme options and active plugins.</a></li>
                    </ul>
                    <ul>
                        <li><b>Q:</b> Will Lighthouse break my WordPress functionality?</li>
                        <li><b>A:</b> <b>It might.</b> But it can be reverted by selecting a different preset below.</a></li>
                    </ul>
                    <ul>
                        <li><b>Q:</b> How do I get automatic updates?</li>
                        <li><b>A:</b> Lighthouse offers automatic lifetime updates. Starting with Lighthouse 3.8.7, a zero-dependency updater is available. <b>Make sure you update the plugin whenever an update notification appears.</b></li>
                    </ul>
                </div>
            </section>
        <?php } elseif ( $active_tab === 'lhf_settings' ) { ?>

            <form method="post" action="">
                <h2><?php _e( 'Performance Settings', 'lighthouse' ); ?></h2>
                <p>
                    Tick the checkboxes below to selectively remove/disable WordPress actions and filters. These options will reduce database queries and HTTP(S) requests, making the site lighter.
                    <br><small>A database query is a request for information from a database. An HTTP(S) request is a browser request for a file (a CSS stylesheet, a JS script, an image or the actual HTML/PHP document).</small>
                </p>

                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row"><label>"Thank You" Link</label></th>
                            <td>
                                <p>
                                    <input type="checkbox" name="lighthouse_thank_you" value="1" <?php checked( 1, (int) get_option( 'lighthouse_thank_you' ) ); ?>> <label>Add a discrete "Pagespeed Optimization by Lighthouse" link in the footer</label> <span class="lhfr">recommended</span>
                                </p>
                                <p>
                                    Link preview: <small><a href="https://getbutterfly.com/wordpress-plugins/lighthouse/" target="_blank">Pagespeed Optimization</a> by <a href="https://getbutterfly.com/wordpress-plugins/lighthouse/" target="_blank">Lighthouse</a>.</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="lighthouse_auto_update">Automatic Background Updates</label></th>
                            <td>
                                <p>
                                    <input type="checkbox" id="lighthouse_auto_update" name="lighthouse_auto_update" value="1" <?php checked( 1, (int) get_option( 'lighthouse_auto_update' ) ); ?>> <label for="lighthouse_auto_update">Enable automatic updates</label>
                                    <br><small>Enable to allow Lighthouse to download and install bug fixes and security updates automatically in the background.</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label>Zen Mode</label></th>
                            <td>
                                <p>
                                    <input type="checkbox" name="lighthouse_zen" value="1" <?php checked( 1, (int) get_option( 'lighthouse_zen' ) ); ?>> <span class="lhfn">use if needed</span> <label>Zen mode</label><br>
                                    <small>Remove most of WordPress-related clutter, notifications, meta boxes and filters in Dashboard view</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label>Performance</label></th>
                            <td>
                                <p>
                                    <select name="lighthouse_prefetch" id="lighthouse_prefetch">
                                        <option value="0" <?php selected( (int) get_option( 'lighthouse_prefetch' ), 0 ); ?>>No resource prerender</option>
                                        <option value="1" <?php selected( (int) get_option( 'lighthouse_prefetch' ), 1 ); ?>>Prerender links</option>
                                        <option value="2" <?php selected( (int) get_option( 'lighthouse_prefetch' ), 2 ); ?>>Prerender and prefetch links</option>
                                    </select>
                                    <select name="lighthouse_prefetch_throttle" id="lighthouse_prefetch_throttle">
                                        <option value="500" <?php selected( (int) get_option( 'lighthouse_prefetch_throttle' ), 500 ); ?>>500ms</option>
                                        <option value="300" <?php selected( (int) get_option( 'lighthouse_prefetch_throttle' ), 300 ); ?>>300ms</option>
                                        <option value="150" <?php selected( (int) get_option( 'lighthouse_prefetch_throttle' ), 150 ); ?>>150ms (recommended)</option>
                                        <option value="100" <?php selected( (int) get_option( 'lighthouse_prefetch_throttle' ), 100 ); ?>>100ms</option>
                                        <option value="65" <?php selected( (int) get_option( 'lighthouse_prefetch_throttle' ), 65 ); ?>>65ms</option>
                                        <option value="0" <?php selected( (int) get_option( 'lighthouse_prefetch_throttle' ), 0 ); ?>>No throttle/delay</option>
                                    </select> <span class="lhfr">recommended</span> <span class="lhfn">use if needed</span>

                                    <br><small>When a user hovers over a link, <code>prerender</code> and/or <code>prefetch</code> hints are dynamically appended to the <code>&lt;head&gt;</code> of the document, but only if those respective hints haven't already been generated in the past.</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label>Caching</label></th>
                            <td>
                                <p>
                                    <input type="checkbox" name="lighthouse_caching" value="1" <?php checked( 1, (int) get_option( 'lighthouse_caching' ) ); ?>> <span class="lhfr">recommended</span> <label>Enable page caching (browser caching)</label>
                                </p>
                                <p>
                                    <input type="checkbox" name="lighthouse_caching_etag" value="1" <?php checked( 1, (int) get_option( 'lighthouse_caching_etag' ) ); ?>> <span class="lhfn">use if needed</span> <label>Enable ETag header</label>
                                </p>
                                <p>
                                    <input type="checkbox" name="lighthouse_caching_cf" value="1" <?php checked( 1, (int) get_option( 'lighthouse_caching_cf' ) ); ?>> <span class="lhfn">use if needed</span> <label>Enable Cloudflare-specific caching headers</label>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label>Theme Clean-up</label></th>
                            <td>
                                <p>
                                    <input type="checkbox" name="lighthouse_version_parameter" value="1" <?php checked( 1, (int) get_option( 'lighthouse_version_parameter' ) ); ?>> <span class="lhfr">recommended</span> <label>Remove version parameter from scripts and stylesheets</label><br>
                                    <small>Remove version parameter from scripts and stylesheets URLs in order to help with browser caching</small><br>

                                    <input type="checkbox" name="lighthouse_emoji" value="1" <?php checked( 1, (int) get_option( 'lighthouse_emoji' ) ); ?>> <span class="lhfr">recommended</span> <label>Disable emojis and smilies</label><br>
                                    <small>Disable replacing special characters with emojis and smilies</small><br>

                                    <input type="checkbox" name="lighthouse_canonical" value="1" <?php checked( 1, (int) get_option( 'lighthouse_canonical' ) ); ?>> <span class="lhfn">use if needed</span> <label>Disable canonical URL redirection</label><br>
                                    <small>Disable URL redirection when page not found</small><br>

                                    <input type="checkbox" name="lighthouse_author_archive" value="1" <?php checked( 1, (int) get_option( 'lighthouse_author_archive' ) ); ?>> <span class="lhfn">use if needed</span> <label>Disable author archive</label><br>
                                    <small>Disable author archive (helps with search engine indexation, duplicate content and security)</small><br>

                                    <input type="checkbox" name="lighthouse_prepend_attachment" value="1" <?php checked( 1, (int) get_option( 'lighthouse_prepend_attachment' ) ); ?>> <span class="lhfn">use if needed</span> <label>Remove <code>prepend_attachment</code> filter from <code>the_content()</code></label><br>
                                    <small>Remove <code>prepend_attachment</code> filter from <code>the_content()</code> to fix conflicts with specific page builders</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label><code>&lt;head&gt;</code> Clean-up</label></th>
                            <td>
                                <p>
                                    <input type="checkbox" name="lighthouse_head_cleanup" value="1" <?php checked( 1, (int) get_option( 'lighthouse_head_cleanup' ) ); ?>> <span class="lhfr">recommended</span> <label>Clean up theme <code>&lt;head&gt;</code></label><br>
                                    <small>Clean up RSD, WLW references, WordPress generator tag and post shortlinks (also remove WordPress-generated <code>&lt;rel&gt;</code> tags)</small><br>

                                    <input type="checkbox" name="lighthouse_rss_links" value="1" <?php checked( 1, (int) get_option( 'lighthouse_rss_links' ) ); ?>> <label>Hide RSS links</label><br>
                                    <small>Remove RSS links and prevent content copying and republishing</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label>System Clean-up</label></th>
                            <td>
                                <p>
                                    <input type="checkbox" name="lighthouse_comment_cookies" value="1" <?php checked( 1, (int) get_option( 'lighthouse_comment_cookies' ) ); ?>> <label>Disable comment cookies</label><br>
                                    <small>Disable the user information - name, email and website - being saved in browser</small><br>

                                    <input type="checkbox" name="lighthouse_embed" value="1" <?php checked( 1, (int) get_option( 'lighthouse_embed' ) ); ?>> <label>Disable WordPress embeds</label><br>
                                    <small>Remove embed query vars, disable oEmbed discovery and completely remove the related scripts (disallow WordPress posts to be embedded on remote sites)</small><br>

                                    <input type="checkbox" name="lighthouse_mediaelement" value="1" <?php checked( 1, (int) get_option( 'lighthouse_mediaelement' ) ); ?>> <label>Disable mediaelement.js</label><br>
                                    <small>Remove <code>mediaelement.js</code> if not required by any page functionality</small><br>

                                    <input type="checkbox" name="lighthouse_jquery_migrate" value="1" <?php checked( 1, (int) get_option( 'lighthouse_jquery_migrate' ) ); ?>> <label>Remove jQuery Migrate</label><br>
                                    <small>Remove jQuery Migrate if not required by any page functionality</small>
                                </p>
                            </td>
                        </tr>
                            <th scope="row"><label>Server Load</label></th>
                            <td>
                                <p>
                                    <input type="checkbox" name="lighthouse_heartbeat" value="1" <?php checked( 1, (int) get_option( 'lighthouse_heartbeat' ) ); ?>> <span class="lhfn">use if needed</span> <label>Slow down the WordPress heartbeat</label><br>
                                </p>
                                <p>
                                    <input type="checkbox" name="lighthouse_remove_custom_fields_metabox" value="1" <?php checked( 1, (int) get_option( 'lighthouse_remove_custom_fields_metabox' ) ); ?>> <span class="lhfn">use if needed</span> <label>Remove Custom Fields metabox from post editor</label>
                                    <br><small>Remove the Custom Fields metabox from the post editor because it uses a very slow <code>meta_key</code> sort query</small><br>
                                </p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><label for="lhf_resource_hints_prefetch">Custom Resource Hints (DNS Prefetch)</label></th>
                            <td>
                                <p>
                                    All URLs added below will be added to your document's <code>&lt;head&gt;</code> section as <code>&lt;link rel="dns-prefetch" href="https://example.com"&gt;</code>.
                                    <br>Check out the <a href="<?php echo admin_url( 'admin.php?page=lighthouse&tab=lhf_tips' ); ?>">Tips & Tricks</a> section for more details on prefetching and preconnecting.
                                </p>
                                <p>
                                    <textarea class="large-text" rows="6" name="lhf_resource_hints_prefetch"><?php echo get_option( 'lhf_resource_hints_prefetch' ); ?></textarea>
                                    <br><small>Add one or more URLs (one URL per line).</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="lhf_resource_hints_preconnect">Custom Resource Hints (Preconnect)</label></th>
                            <td>
                                <p>
                                    All URLs added below will be added to your document's <code>&lt;head&gt;</code> section as <code>&lt;link rel="preconnect" href="https://example.com"&gt;</code>.
                                    <br>Check out the <a href="<?php echo admin_url( 'admin.php?page=lighthouse&tab=lhf_tips' ); ?>">Tips & Tricks</a> section for more details on prefetching and preconnecting.
                                </p>
                                <p>
                                    <textarea class="large-text" rows="6" name="lhf_resource_hints_preconnect"><?php echo get_option( 'lhf_resource_hints_preconnect' ); ?></textarea>
                                    <br><small>Add one or more URLs (one URL per line).</small>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <hr>

                <h2><?php _e( 'Legend', 'lighthouse' ); ?></h2>

                <p>
                    <span class="lhfr">recommended</span> We recommend enabling this option<br>
                    <span class="lhfb">not recommended</span> We do not recommend enabling this option<br>
                    <span class="lhfw">use with caution</span> Only enable this option if you know what you are doing<br>
                    <span class="lhfn">use if needed</span> Only enable this option of you need it
                </p>

                <hr>

                <p><input type="submit" name="info_settings_update" class="button button-primary" value="Save Changes"></p>
            </form>
        <?php } elseif ( $active_tab === 'lhf_speed_metrics' ) { ?>
            <?php include 'settings-speed-metrics.php'; ?>
        <?php } elseif ( $active_tab === 'lhf_security' ) { ?>
            <?php include 'settings-security.php'; ?>
        <?php } elseif ( $active_tab === 'lhf_captcha' ) { ?>
            <?php include 'settings-captcha.php'; ?>
        <?php } elseif ( $active_tab === 'lhf_queries' ) { ?>
            <?php include 'settings-queries.php'; ?>
        <?php } elseif ( $active_tab === 'lhf_speedfactor' ) { ?>
            <?php include 'settings-speedfactor.php'; ?>
        <?php } elseif ( $active_tab === 'lhf_tweaks' ) { ?>
            <form method="post" action="">
                <h2><?php _e( 'Theme Tweaks', 'lighthouse' ); ?></h2>

                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row"><label>Lighthouse Tweaks</label></th>
                            <td>
                                <p>
                                    <input type="checkbox" name="lighthouse_theme_dark" value="1" <?php checked( 1, (int) get_option( 'lighthouse_theme_dark' ) ); ?>> <label>Enable dark theme for Lighthouse settings and panels</label>
                                    <br><small>This will enable a dark theme for Lighthouse settings and panels, in the WordPress admin area only.</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label>Theme Tweaks</label></th>
                            <td>
                                <p>
                                    <input type="checkbox" name="lighthouse_comment_html" value="1" <?php checked( 1, (int) get_option( 'lighthouse_comment_html' ) ); ?>> <label>Disable HTML in WordPress comments</label><br>
                                    <input type="checkbox" name="lighthouse_comment_reply" value="1" <?php checked( 1, (int) get_option( 'lighthouse_comment_reply' ) ); ?>> <label>Remove comment reply script (if using a third-party comment plugin)</label>
                                </p>
                                <p>
                                    <input type="checkbox" name="lighthouse_no_lazy_loading" value="1" <?php checked( 1, (int) get_option( 'lighthouse_no_lazy_loading' ) ); ?>> <label>Remove native/core lazy loading (if using a third-party lazy-loading plugin)</label> <span class="lhfb">not recommended</span> <span class="lhfn">use if needed</span>
                                </p>
                                <p>
                                    <input type="checkbox" name="lighthouse_no_jetpack_css" value="1" <?php checked( 1, (int) get_option( 'lighthouse_no_jetpack_css' ) ); ?>> <label>Remove <code>jetpack.css</code> if not needed</label> <span class="lhfn">use if needed</span><br>
                                    <input type="checkbox" name="lighthouse_no_classic_css" value="1" <?php checked( 1, (int) get_option( 'lighthouse_no_classic_css' ) ); ?>> <label>Remove <code>classic-themes.min.css</code> if not needed (WordPress 6.1+)</label> <span class="lhfn">use if needed</span>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label>User Tweaks</label></th>
                            <td>
                                <p>
                                    <input type="checkbox" name="lighthouse_no_app_passwords" value="1" <?php checked( 1, (int) get_option( 'lighthouse_no_app_passwords' ) ); ?>> <label>Remove application passwords feature</label>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label>Block Editor Tweaks</label></th>
                            <td>
                                <p>Note that some of these options are theme specific and some of them might be required for proper theme functionality. Only remove if you know what you are doing.</p>
                                <p>Also note that some of these options are Gutenberg-specific and they might either go away or be superseded by the <code>theme.json</code> theme configuration file.</p>
                                <p>
                                    <input type="checkbox" name="lighthouse_theme_support_formats" value="1" <?php checked( 1, (int) get_option( 'lighthouse_theme_support_formats' ) ); ?>> <label>Remove <code>post-formats</code> theme support</label><br>
                                    <input type="checkbox" name="lighthouse_theme_support_block_widgets" value="1" <?php checked( 1, (int) get_option( 'lighthouse_theme_support_block_widgets' ) ); ?>> <label>Remove <code>widgets-block-editor</code> theme support</label> <span class="lhfn">use if needed</span><br>
                                    <input type="checkbox" name="lighthouse_theme_support_responsive_embeds" value="1" <?php checked( 1, (int) get_option( 'lighthouse_theme_support_responsive_embeds' ) ); ?>> <label>Remove <code>responsive-embeds</code> theme support</label> <span class="lhfb">not recommended</span><br>
                                    <input type="checkbox" name="lighthouse_theme_support_editor_styles" value="1" <?php checked( 1, (int) get_option( 'lighthouse_theme_support_editor_styles' ) ); ?>> <label>Remove <code>editor-styles</code> theme support</label> <span class="lhfb">not recommended</span><br>
                                    <input type="checkbox" name="lighthouse_theme_support_block_styles" value="1" <?php checked( 1, (int) get_option( 'lighthouse_theme_support_block_styles' ) ); ?>> <label>Remove <code>wp-block-styles</code> theme support</label> <span class="lhfb">not recommended</span><br>
                                    <input type="checkbox" name="lighthouse_theme_support_block_templates" value="1" <?php checked( 1, (int) get_option( 'lighthouse_theme_support_block_templates' ) ); ?>> <label>Remove <code>block-templates</code> theme support</label> <span class="lhfn">use if needed</span><br>
                                    <input type="checkbox" name="lighthouse_theme_support_core_block_patterns" value="1" <?php checked( 1, (int) get_option( 'lighthouse_theme_support_core_block_patterns' ) ); ?>> <label>Remove <code>core-block-patterns</code> theme support</label> <span class="lhfn">use if needed</span><br>
                                    <input type="checkbox" name="lighthouse_theme_support_woocommerce" value="1" <?php checked( 1, (int) get_option( 'lighthouse_theme_support_woocommerce' ) ); ?>> <label>Remove WooCommerce theme support</label> <span class="lhfn">use if needed</span><br>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <?php include 'settings-cms.php'; ?>

                <hr>
                <p><input type="submit" name="info_payment_update" class="button button-primary" value="Save Changes"></p>
            </form>
        <?php } elseif ( $active_tab === 'lhf_storage' ) { ?>
            <?php include 'settings-storage.php'; ?>
        <?php } elseif ( $active_tab === 'lhf_tips' ) { ?>
            <?php include 'settings-tips.php'; ?>
        <?php } ?>
    </div>
    <?php
}
