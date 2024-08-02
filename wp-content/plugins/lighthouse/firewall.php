<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( 'Error 404' );
}

if ( is_admin() ) {
    add_option('wpg_mail_notifications', '0', '', 'yes');
    add_option('wpg_sqli_protection', '1', '', 'yes');
    add_option('wpg_sqli_protection2', '1', '', 'yes');
    add_option('wpg_sqli_protection3', '0', '', 'yes');
    add_option('wpg_sqli_protection4', '1', '', 'yes');
    add_option('wpg_sqli_protection5', '1', '', 'yes');
    add_option('wpg_sqli_protection6', '1', '', 'yes');
    add_option('wpg_sqli_logging', '1', '', 'yes');
    add_option('wpg_sqli_autoban', '0', '', 'yes');
    add_option('wpg_sqli_mail', '0', '', 'yes');
    add_option('wpg_badbot_protection', '1', '', 'yes');
    add_option('wpg_badbot_protection2', '1', '', 'yes');
    add_option('wpg_badbot_protection3', '1', '', 'yes');
    add_option('wpg_badbot_logging', '1', '', 'yes');
    add_option('wpg_badbot_autoban', '0', '', 'yes');
    add_option('wpg_badbot_mail', '0', '', 'yes');
    add_option('wpg_proxy_protection', '0', '', 'yes');
    add_option('wpg_proxy_protection2', '0', '', 'yes');
	add_option('wpg_proxy_api1', '', '', 'yes');
	add_option('wpg_proxy_api2', '', '', 'yes');
	add_option('wpg_proxy_api3', '', '', 'yes');
    add_option('wpg_proxy_logging', '1', '', 'yes');
    add_option('wpg_proxy_mail', '0', '', 'yes');
    add_option('wpg_spam_protection', '0', '', 'yes');
    add_option('wpg_spam_protection_sfs', '0', '', 'yes');
    add_option('wpg_spam_logging', '1', '', 'yes');
    add_option('wpg_spam_mail', '0', '', 'yes');

    function lighthouse_fw_install() {
        global $wpdb;
        
        $table_name      = $wpdb->prefix . "lhf_logs";
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
  id int(11) NOT NULL AUTO_INCREMENT,
  ip char(45) NOT NULL,
  date varchar(50) NOT NULL,
  time char(10) NOT NULL,
  page varchar(255) NOT NULL,
  query text NOT NULL,
  type varchar(50) NOT NULL,
  browser varchar(255) DEFAULT 'Unknown' NOT NULL,
  browser_code varchar(50) NOT NULL,
  os varchar(255) DEFAULT 'Unknown' NOT NULL,
  os_code varchar(40) NOT NULL,
  country varchar(120) DEFAULT 'Unknown' NULL,
  country_code char(2) DEFAULT 'XX' NULL,
  region varchar(120) DEFAULT 'Unknown' NULL,
  city varchar(120) DEFAULT 'Unknown' NULL,
  latitude varchar(30) DEFAULT '0' NULL,
  longitude varchar(30) DEFAULT '0' NULL,
  isp varchar(255) DEFAULT 'Unknown' NULL,
  useragent text NOT NULL,
  referer_url varchar(255) NULL,
  PRIMARY KEY (id)
) $charset_collate;";
        
        $table_name2 = $wpdb->prefix . "lhf_bans";
        $sql2        = "CREATE TABLE IF NOT EXISTS $table_name2 (
  id int(11) NOT NULL AUTO_INCREMENT,
  type varchar(50) NOT NULL,
  value varchar(255) NOT NULL,
  date varchar(50) NULL,
  time char(10) NULL,
  reason varchar(255) NULL,
  autoban tinyint(1) DEFAULT '0' NULL,
  PRIMARY KEY (id)
) $charset_collate;";
        
        $table_name3 = $wpdb->prefix . "lhf_ipwhitelist";
        $sql3        = "CREATE TABLE IF NOT EXISTS $table_name3 (
  id int(11) NOT NULL AUTO_INCREMENT,
  ip varchar(45) NOT NULL,
  notes varchar(255) NULL,
  PRIMARY KEY (id)
) $charset_collate;";
        
        $table_name4 = $wpdb->prefix . "lhf_dnsbl";
        $sql4        = "CREATE TABLE IF NOT EXISTS $table_name4 (
  id int(11) NOT NULL AUTO_INCREMENT,
  dnsbl_database varchar(30) NOT NULL,
  PRIMARY KEY (id)
) $charset_collate;";
        
        $table_name6 = $wpdb->prefix . "lhf_loginhistory";
        $sql6        = "CREATE TABLE IF NOT EXISTS $table_name6 (
  id int(11) NOT NULL AUTO_INCREMENT,
  username varchar(255) NOT NULL,
  ip char(45) NULL,
  date varchar(30) NULL,
  time char(5) NULL,
  successful int(1) NULL,
  PRIMARY KEY (id)
) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        dbDelta($sql2);
        dbDelta($sql3);
        dbDelta($sql4);
        dbDelta($sql6);
        
        $dnsblc1 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name4
                    WHERE dnsbl_database = %s LIMIT 1", 'sbl.spamhaus.org'));
        if ($dnsblc1 <= 0) {
            $wpdb->insert($table_name4, array(
                'dnsbl_database' => 'sbl.spamhaus.org'
            ), array(
                '%s'
            ));
        }
        
        $dnsblc1 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name4
                    WHERE dnsbl_database = %s LIMIT 1", 'xbl.spamhaus.org'));
        if ($dnsblc1 <= 0) {
            $wpdb->insert($table_name4, array(
                'dnsbl_database' => 'xbl.spamhaus.org'
            ), array(
                '%s'
            ));
        }
    }
	
    // CSS Styles
    function lighthouse_fw_styles()
    {
        if (isset($_GET['page']) && strpos($_GET['page'], 'lighthouse-firewall') === 0) {
            wp_enqueue_style('fontawesome', 'https://use.fontawesome.com/releases/v5.15.4/css/all.css');
            wp_enqueue_style('datatablesc', 'https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.css');

            $wpgcustom_css = "
            body {
				background: #f1f1f1;
			}
			h1.protmodg {
				color:#47A447;
			}
			h1.protmodr {
				color:#d2322d;
			}
			h1.protmodb {
				color:#007bff;
			}
			h4.dashboardlb {
				background-color:#f7f7f7; 
				font-size: 16px; 
				text-align: center;
				padding: 7px 10px; 
				margin-top: 0;
			}";
            wp_register_style('lhf-fw-css', false);
            wp_enqueue_style('lhf-fw-css');
            wp_add_inline_style('lhf-fw-css', $wpgcustom_css);
        }
    }
    add_action('admin_enqueue_scripts', 'lighthouse_fw_styles');
    
    // JS Scripts
    function lighthouse_fw_scripts() {
        if ( isset( $_GET['page'] ) && strpos( $_GET['page'], 'lighthouse-firewall' ) === 0) {
            wp_enqueue_script( 'jquery361', 'https://code.jquery.com/jquery-3.6.1.min.js' );

            if ( (string) sanitize_text_field( $_GET['page'] ) === 'lighthouse-firewall' ) {
                wp_enqueue_script( 'chartjs', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js', [], '4.4.1', true );
                wp_enqueue_script( 'openlayers', 'https://openlayers.org/api/OpenLayers.js' );
            }

            wp_enqueue_script( 'datatables', 'https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.js' );

            $wpgcustom_js = 'jQuery(document).ready(function($) {
                $("#dt-basic").dataTable({
                    "responsive": true,
                    "order": [[ 2, "desc" ]] // order by second column, date
                });
                $("#dt-basic2").dataTable({
                    "responsive": true,
                    "order": [[ 0, "desc" ]]
                });
                $("#dt-basiclt").dataTable({
                    "responsive": true,
                    "order": [[ 2, "asc" ]]
                });
                $("#dt-basiclt1").dataTable({
                    "responsive": true,
                    "order": [[ 5, "desc" ]]
                });
                $("#dt-basicdb").dataTable({
                    "responsive": true,
                    "order": [[ 1, "desc" ]]
                });
            });';
			
            wp_register_script( 'lhf-fw-js', '', [], '', true );
            wp_enqueue_script( 'lhf-fw-js' );
            wp_add_inline_script( 'lhf-fw-js', $wpgcustom_js );
			
			if ( (string) sanitize_text_field( $_GET['page'] ) === 'lighthouse-firewall' && (string) sanitize_text_field( $_GET['tab'] ) === 'bans' ) {
				$wpgcustom_js2 = 'jQuery(document).ready(function() {
                    jQuery("#dt-basic3").dataTable({
                        "responsive": true,
                        "order": [[ 0, "desc" ]]
                    });
                });';

                wp_register_script( 'lhf-fw-js2', '', [], '', true );
				wp_enqueue_script( 'lhf-fw-js2');
				wp_add_inline_script( 'lhf-fw-js2', $wpgcustom_js2 );
			}
        }
    }

    add_action( 'admin_enqueue_scripts', 'lighthouse_fw_scripts' );
	


    function lighthouse_fw_dashboard() {
        $active_page = admin_url( 'admin.php?page=lighthouse-firewall' );
        $active_tab  = isset( $_GET['tab'] ) ? $_GET['tab'] : 'dashboard';
        ?>
        <div class="wrap lhf--ui">
            <?php
            global $wpdb;

            $table  = $wpdb->prefix . 'lhf_logs';
            $count  = $wpdb->get_var( "SELECT COUNT(*) FROM $table" );
            $table2 = $wpdb->prefix . 'lhf_bans';
            $count2 = $wpdb->get_var( "SELECT COUNT(*) FROM $table2" );
            ?>
            <h1>Lighthouse Firewall</h1>

            <h2 class="nav-tab-wrapper lhf--ui">
                <a href="<?php echo $active_page; ?>&amp;tab=dashboard" class="nav-tab <?php echo $active_tab === 'dashboard' ? 'nav-tab-active' : ''; ?>"><?php echo __( 'Dashboard', 'lighthouse' ); ?></a>
                <a href="<?php echo $active_page; ?>&amp;tab=settings" class="nav-tab <?php echo $active_tab === 'settings' ? 'nav-tab-active' : ''; ?>"><?php echo __( 'Settings', 'lighthouse' ); ?></a>
                <a href="<?php echo $active_page; ?>&amp;tab=modules" class="nav-tab <?php echo $active_tab === 'modules' ? 'nav-tab-active' : ''; ?>"><?php echo __( 'Protection Modules', 'lighthouse' ); ?></a>

                <a href="<?php echo $active_page; ?>&amp;tab=logs" class="nav-tab <?php echo $active_tab === 'logs' ? 'nav-tab-active' : ''; ?>">
                    <?php echo __( "Logs", 'lighthouse' ); ?>
                    <sup><?php echo number_format( $count ); ?></sup>
                </a>
                <a href="<?php echo $active_page; ?>&amp;tab=log" class="nav-tab <?php echo $active_tab === 'log' ? 'nav-tab-active' : ''; ?>"><?php echo __( 'Log Details', 'lighthouse' ); ?></a>
                <a href="<?php echo $active_page; ?>&amp;tab=bans" class="nav-tab <?php echo $active_tab === 'bans' ? 'nav-tab-active' : ''; ?>">
                    <?php echo __( "Bans", 'lighthouse' ); ?>
                    <sup><?php echo number_format( $count2 ); ?></sup>
                </a>

                <a href="<?php echo $active_page; ?>&amp;tab=whitelist" class="nav-tab <?php echo $active_tab === 'whitelist' ? 'nav-tab-active' : ''; ?>"><?php echo __( "Whitelist", 'lighthouse' ); ?></a>
                <a href="<?php echo $active_page; ?>&amp;tab=loginhistory" class="nav-tab <?php echo $active_tab === 'loginhistory' ? 'nav-tab-active' : ''; ?>"><?php echo __( "Login History", 'lighthouse' ); ?></a>
            </h2>

            <?php
            if ( $active_tab === 'dashboard' ) {
                include_once 'firewall/dashboard.php';
            } elseif ( $active_tab === 'settings' ) {
                include_once 'firewall/settings.php';
            } elseif ( $active_tab === 'modules' ) {
                include_once 'firewall/protection-modules.php';
            } elseif ( $active_tab === 'logs' ) {
                include_once 'firewall/logs.php';
            } elseif ( $active_tab === 'log' ) {
                include_once 'firewall/log-details.php';
            } elseif ( $active_tab === 'bans' ) {
                include_once 'firewall/bans.php';
            } elseif ( $active_tab === 'whitelist' ) {
                include_once 'firewall/whitelist.php';
            } elseif ( $active_tab === 'loginhistory' ) {
                include_once 'firewall/login-history.php';
            }

        echo '</div>';
    }

    register_uninstall_hook( __FILE__, 'lighthouse_fw_uninstall' );
    
    function lighthouse_fw_uninstall() {
        global $wpdb;

        include_once 'uninstall.php';
    }
} else {
    // Lighthouse Firewall Init
    if ( (int) get_option( 'lighthouse_firewall' ) === 1 ) {
        // This will be included on both front-end and wp-login.php (no need for login_init hook)
        add_action( 'init', 'lighthouse_fw_include' );
        //add_action( 'login_init', 'lighthouse_fw_include' );
    }

    function lighthouse_fw_include() {
        global $wpdb;

        include plugin_dir_path( __FILE__ ) . 'firewall/modules/core.php';

        // IP Whitelist
        $table           = $wpdb->prefix . 'lhf_ipwhitelist';
        $whitelist_check = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $table WHERE ip = %s LIMIT 1", $ip ) );

        if ( $whitelist_check <= 0 ) {
            include plugin_dir_path( __FILE__ ) . 'firewall/modules/ban-system.php';
            include plugin_dir_path( __FILE__ ) . 'firewall/modules/sqli-protection.php';

            include plugin_dir_path( __FILE__ ) . 'firewall/modules/badbots-protection.php';
            include plugin_dir_path( __FILE__ ) . 'firewall/modules/fakebots-protection.php';
            include plugin_dir_path( __FILE__ ) . 'firewall/modules/headers-check.php';

            if ( (int) $searchengine_bot === 0 ) {
                include plugin_dir_path( __FILE__ ) . 'firewall/modules/proxy-protection.php';
                include plugin_dir_path( __FILE__ ) . 'firewall/modules/spam-protection.php';
            }
        }
    }
}

function lhf_fw_login_icon() {
    if ( strpos($_SERVER['REQUEST_URI'], 'wp-login.php') !== false ) {
        echo '<span class="dashicons dashicons-shield-alt" title="Protected by Lighthouse Firewall" style="margin:1em auto;display:block;cursor:help"></span>';
    }
}
add_action( 'login_footer', 'lhf_fw_login_icon' );

// Login History
if ( (int) get_option( 'lighthouse_firewall' ) === 1 ) {
    add_action('wp_login', 'lighthouse_fw_saveslogin', 10, 1);
    add_action('wp_login_failed', 'lighthouse_fw_saveflogin', 10, 1);
}

if ( (int) get_option( 'lighthouse_firewall' ) === 1 ) {
    $ip = $_SERVER['REMOTE_ADDR'];
    if ( (string) $ip === '::1' ) {
        $ip = '127.0.0.1';
    }
    $date = date_i18n( get_option( 'date_format' ) );
    $time = date_i18n( get_option( 'time_format' ) );
}

function lighthouse_fw_saveslogin( $user_login ) {
    global $wpdb, $ip, $date, $time;

	$table  = $wpdb->prefix . 'lhf_loginhistory';
	$data   = [
        'username'   => $user_login,
        'ip'         => $ip,
        'date'       => $date,
        'time'       => $time,
        'successful' => '1',
    ];
    $format = [
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%d',
    ];
    $wpdb->insert( $table, $data, $format );

    // Delete older entries (keep most recent 10,000 records)
    $wpdb->query(
        "DELETE FROM $table
        WHERE id NOT IN (
            SELECT id
            FROM (
                SELECT id
                FROM $table
                ORDER BY id DESC
                LIMIT 10000
            ) AS recent_entries
        );"
    );
}

function lighthouse_fw_saveflogin( $user_login ) {
    global $wpdb, $ip, $date, $time;

	$table  = $wpdb->prefix . 'lhf_loginhistory';
	$data   = [
        'username'   => $user_login,
        'ip'         => $ip,
        'date'       => $date,
        'time'       => $time,
        'successful' => '0',
    ];
    $format = [
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%d',
    ];
    $wpdb->insert( $table, $data, $format );

    // Delete older entries (keep most recent 10,000 records)
    $wpdb->query(
        "DELETE FROM $table
        WHERE id NOT IN (
            SELECT id
            FROM (
                SELECT id
                FROM $table
                ORDER BY id DESC
                LIMIT 10000
            ) AS recent_entries
        );"
    );
}



/**
 * Get banned IP
 *
 * @param string $ip
 *
 * @return int
 */
function lighthouse_fw_get_banned( $ip ) {
    global $wpdb, $ip;
    
    $table = $wpdb->prefix . 'lhf_bans';
    $count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(id) FROM $table WHERE value = %s AND type = %s LIMIT 1", $ip, 'ip' ) );

    if ( $count > 0 ) {
        return 1;
    } else {
        return 0;
    }
}



/**
 * Get banned IP ID
 *
 * @param string $ip
 *
 * @return int
 */
function lighthouse_fw_get_banned_id( $ip ) {
    global $wpdb, $ip;
    
    $table = $wpdb->prefix . 'lhf_bans';
    $row   = $wpdb->get_row( $wpdb->prepare( "SELECT id FROM $table WHERE value = %s AND type = %s LIMIT 1", $ip, 'ip' ) );

    return $row->id;
}
