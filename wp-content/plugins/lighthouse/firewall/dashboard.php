<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( 'Page not found' );
}

global $wpdb;

// Check if tables exist and, if not, create them
function lighthouse_fw_admin_notice() {
    ?>
    <div class="notice notice-success is-dismissible">
        <p><?php _e( 'Firewall tables have been successfully created.', 'lighthouse' ); ?></p>
    </div>
    <?php
}

$table_logs   = $wpdb->prefix . 'lhf_logs';
$table_bans   = $wpdb->prefix . 'lhf_bans';
$table_ips    = $wpdb->prefix . 'lhf_ipwhitelist';
$table_dnsbl  = $wpdb->prefix . 'lhf_dnsbl';
$table_logins = $wpdb->prefix . 'lhf_loginhistory';

// Check if the tables exist
if (
    $wpdb->get_var( "SHOW TABLES LIKE '$table_logs'") !== $table_logs ||
    $wpdb->get_var( "SHOW TABLES LIKE '$table_bans'") !== $table_bans ||
    $wpdb->get_var( "SHOW TABLES LIKE '$table_ips'") !== $table_ips ||
    $wpdb->get_var( "SHOW TABLES LIKE '$table_dnsbl'") !== $table_dnsbl ||
    $wpdb->get_var( "SHOW TABLES LIKE '$table_logins'") !== $table_logins
) {
    add_action( 'admin_notices', 'lighthouse_fw_admin_notice' );

    lighthouse_fw_install();
}



// Delete outdated cache files
$now   = time();
$files = glob( plugin_dir_path( __FILE__ ) . 'modules/cache/ip-details' . '/*' );

foreach ( $files as $file ) {
    if ( is_file( $file ) ) {
        if ( ( $now - filemtime( $file ) ) >= ( 1 * 24 * 60 * 60 ) ) { // 1 day
            unlink( $file );
        }
    }
}

$files = glob( plugin_dir_path( __FILE__ ) . 'modules/cache/proxy' . '/*' );

foreach ( $files as $file ) {
    if ( is_file( $file ) ) {
        if ( ( $now - filemtime( $file ) ) >= ( 1 * 24 * 60 * 60 ) ) { // 1 day
            unlink( $file );
        }
    }
}

// Today
$date   = date_i18n( 'd F Y' );
$count  = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $table_logs WHERE type = %s AND date = %s", 'SQLi', $date ) );
$count2 = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $table_logs WHERE date = %s AND (type = %s OR type = %s OR type = %s OR type = %s OR type = %s)", $date, 'Bad Bot', 'Fake Bot', 'Missing User-Agent header', 'Missing header Accept', 'Invalid IP Address header' ) );
$count3 = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $table_logs WHERE type = %s AND date = %s", 'Proxy', $date ) );
$count4 = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $table_logs WHERE type = %s AND date = %s", 'Spammer', $date ) );

// Overall
$countm  = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(id) FROM $table_logs WHERE type = %s", 'SQLi' ) );
$countm2 = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(id) FROM $table_logs WHERE type = %s OR type = %s OR type = %s OR type = %s OR type = %s", 'Bad Bot', 'Fake Bot', 'Missing User-Agent header', 'Missing header Accept', 'Invalid IP Address header' ) );
$countm3 = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(id) FROM $table_logs WHERE type = %s", 'Proxy' ) );
$countm4 = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(id) FROM $table_logs WHERE type = %s", 'Spammer' ) );
?>

<div class="lhf--grid lhf--grid-4">
    <div class="lhf--grid-item">
        <div class="lhf--metric-name">
            <?php echo __( 'SQL Injection', 'lighthouse' ); ?>
            <span class="lhf-fw-metric-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path fill="#97a3b8" d="M18.33 5.67 6.59 17.41a1 1 0 0 1-1.54-.14 10.94 10.94 0 0 1-1.97-6.15V6.73c0-.82.62-1.75 1.38-2.06l5.57-2.28a5.12 5.12 0 0 1 3.92 0l4.04 1.65a1 1 0 0 1 .34 1.63Z" opacity=".5"/><path fill="#97a3b8" d="M19.27 7.04a1 1 0 0 1 1.64.77v3.31c0 4.89-3.55 9.47-8.4 10.81a2 2 0 0 1-1.03 0 11.3 11.3 0 0 1-3.87-1.95 1 1 0 0 1-.11-1.5c2.18-2.23 8.56-8.73 11.77-11.44Z"/></svg>
            </span>
        </div>
        <div class="lhf-fw-metric-value"><?php echo number_format( $count ); ?> <small><?php echo __( 'Today', 'lighthouse' ); ?></small></div>
        <hr>
        <div class="lhf-fw-metric-value--faded"><?php echo number_format( $countm ); ?> Total</div>
    </div>
    <div class="lhf--grid-item">
        <div class="lhf--metric-name">
            <?php echo __( 'Bad Bots & DDoS', 'lighthouse' ); ?>
            <span class="lhf-fw-metric-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path fill="#97a3b8" d="M18.33 5.67 6.59 17.41a1 1 0 0 1-1.54-.14 10.94 10.94 0 0 1-1.97-6.15V6.73c0-.82.62-1.75 1.38-2.06l5.57-2.28a5.12 5.12 0 0 1 3.92 0l4.04 1.65a1 1 0 0 1 .34 1.63Z" opacity=".5"/><path fill="#97a3b8" d="M19.27 7.04a1 1 0 0 1 1.64.77v3.31c0 4.89-3.55 9.47-8.4 10.81a2 2 0 0 1-1.03 0 11.3 11.3 0 0 1-3.87-1.95 1 1 0 0 1-.11-1.5c2.18-2.23 8.56-8.73 11.77-11.44Z"/></svg>
            </span>
        </div>
        <div class="lhf-fw-metric-value"><?php echo number_format( $count2 ); ?> <small><?php echo __( 'Today', 'lighthouse' ); ?></small></div>
        <hr>
        <div class="lhf-fw-metric-value--faded"><?php echo number_format( $countm2 ); ?> Total</div>
    </div>
    <div class="lhf--grid-item">
        <div class="lhf--metric-name">
            <?php echo __( 'Proxy Servers', 'lighthouse' ); ?>
            <span class="lhf-fw-metric-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path fill="#97a3b8" d="M18.33 5.67 6.59 17.41a1 1 0 0 1-1.54-.14 10.94 10.94 0 0 1-1.97-6.15V6.73c0-.82.62-1.75 1.38-2.06l5.57-2.28a5.12 5.12 0 0 1 3.92 0l4.04 1.65a1 1 0 0 1 .34 1.63Z" opacity=".5"/><path fill="#97a3b8" d="M19.27 7.04a1 1 0 0 1 1.64.77v3.31c0 4.89-3.55 9.47-8.4 10.81a2 2 0 0 1-1.03 0 11.3 11.3 0 0 1-3.87-1.95 1 1 0 0 1-.11-1.5c2.18-2.23 8.56-8.73 11.77-11.44Z"/></svg>
            </span>
        </div>
        <div class="lhf-fw-metric-value"><?php echo number_format( $count3 ); ?> <small><?php echo __( 'Today', 'lighthouse' ); ?></small></div>
        <hr>
        <div class="lhf-fw-metric-value--faded"><?php echo number_format( $countm3 ); ?> Total</div>
    </div>
    <div class="lhf--grid-item">
        <div class="lhf--metric-name">
            <?php echo __( 'Spam Users', 'lighthouse' ); ?>
            <span class="lhf-fw-metric-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path fill="#97a3b8" d="M18.33 5.67 6.59 17.41a1 1 0 0 1-1.54-.14 10.94 10.94 0 0 1-1.97-6.15V6.73c0-.82.62-1.75 1.38-2.06l5.57-2.28a5.12 5.12 0 0 1 3.92 0l4.04 1.65a1 1 0 0 1 .34 1.63Z" opacity=".5"/><path fill="#97a3b8" d="M19.27 7.04a1 1 0 0 1 1.64.77v3.31c0 4.89-3.55 9.47-8.4 10.81a2 2 0 0 1-1.03 0 11.3 11.3 0 0 1-3.87-1.95 1 1 0 0 1-.11-1.5c2.18-2.23 8.56-8.73 11.77-11.44Z"/></svg>
            </span>
        </div>
        <div class="lhf-fw-metric-value"><?php echo number_format( $count4 ); ?> <small><?php echo __( 'Today', 'lighthouse' ); ?></small></div>
        <hr>
        <div class="lhf-fw-metric-value--faded"><?php echo number_format( $countm4 ); ?> Total</div>
    </div>
</div>

<div class="lhf--grid lhf--grid-2">
    <div class="lhf--grid-item">
        <h3>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="-.5 0 25 25" style="height: 24px;"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9.03a7 7 0 0 0-7.12-7A7.1 7.1 0 0 0 5 8.77a7 7 0 0 0 3.1 6.06A2 2 0 0 1 9 16.5v1.53h6V16.5a2 2 0 0 1 .9-1.67 7 7 0 0 0 3.1-5.8Zm-4 12.01a5 5 0 0 1-6 0"/><path stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m11.99 5.64-1.66 2.78a.8.8 0 0 0 .69 1.22h2a.8.8 0 0 1 .69 1.21l-1.68 2.79"/></svg>
            <?php echo __( 'Overall Statistics', 'lighthouse' ); ?>
        </h3>

        <canvas id="log-stats"></canvas>
    </div>
    <div class="lhf--grid-item">
        <h3>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="-1 0 25 25" style="height: 24px;"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8h10M2 8h2m16 9h2M2 17h10m-4-5a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm8 9a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"></path></svg>
            <?php echo __( 'Protection Modules & Logging Settings', 'lighthouse' ); ?>
        </h3>

        <div class="lhf--grid lhf--grid-2">
            <div class="lhf--grid-item">
                <div class="lhf-fw-metric-option">
                    <?php
                    echo __( 'SQLi Protection', 'lighthouse' );

                    if ( (int) get_option( 'wpg_sqli_protection' ) === 1 ) {
                        echo '<span class="lhfr"><i class="fas fa-check"></i> ' . __( 'ON', 'lighthouse' ) . '</span>';
                    } else {
                        echo '<span class="lhfw"><i class="fas fa-times"></i> ' . __( 'OFF', 'lighthouse' ) . '</span>';
                    }
                    ?>
                </div>
            </div>
            <div class="lhf--grid-item">
                <div class="lhf-fw-metric-option">
                    <?php
                    echo __( 'Bad Bots Protection', 'lighthouse' );

                    if ( (int) get_option( 'wpg_badbot_protection' ) === 1 || (int) get_option( 'wpg_badbot_protection2' ) === 1 || (int) get_option( 'wpg_badbot_protection3' ) === 1 ) {
                        echo '<span class="lhfr"><i class="fas fa-check"></i> ' . __( 'ON', 'lighthouse' ) . '</span>';
                    } else {
                        echo '<span class="lhfw"><i class="fas fa-times"></i> ' . __( 'OFF', 'lighthouse' ) . '</span>';
                    }
                    ?>
                </div>
            </div>
            <div class="lhf--grid-item">
                <div class="lhf-fw-metric-option">
                    <?php
                    echo __( 'Proxy Protection', 'lighthouse' );

                    if ( (int) get_option( 'wpg_proxy_protection' ) > 1 || (int) get_option( 'wpg_proxy_protection2' ) === 1 ) {
                        echo '<span class="lhfr"><i class="fas fa-check"></i> ' . __( 'ON', 'lighthouse' ) . '</span>';
                    } else {
                        echo '<span class="lhfw"><i class="fas fa-times"></i> ' . __( 'OFF', 'lighthouse' ) . '</span>';
                    }
                    ?>
                </div>
            </div>
            <div class="lhf--grid-item">
                <div class="lhf-fw-metric-option">
                    <?php
                    echo __( 'Spam Protection', 'lighthouse' );

                    $countsp = $wpdb->get_var( "SELECT COUNT(*) FROM $table_dnsbl" );

                    if ( (int) get_option( 'wpg_spam_protection' ) === 1 && $countsp > 0 ) {
                        echo '<span class="lhfr"><i class="fas fa-check"></i> ' . __( 'ON', 'lighthouse' ) . '</span>';
                    } else {
                        echo '<span class="lhfw"><i class="fas fa-times"></i> ' . __( 'OFF', 'lighthouse' ) . '</span>';
                    }
                    ?>
                </div>
            </div>

            <hr style="grid-column: span 2;">

            <div class="lhf--grid-item">
                <div class="lhf-fw-metric-option">
                    <?php
                    echo __( 'SQLi Logging', 'lighthouse' );

                    if ( (int) get_option( 'wpg_sqli_logging' ) === 1 ) {
                        echo '<span class="lhfr"><i class="fas fa-check"></i> ' . __( 'ON', 'lighthouse' ) . '</span>';
                    } else {
                        echo '<span class="lhfw"><i class="fas fa-times"></i> ' . __( 'OFF', 'lighthouse' ) . '</span>';
                    }
                    ?>
                </div>
            </div>
            <div class="lhf--grid-item">
                <div class="lhf-fw-metric-option">
                    <?php
                    echo __( 'Bad Bots Logging', 'lighthouse' );

                    if ( (int) get_option( 'wpg_badbot_logging' ) === 1 ) {
                        echo '<span class="lhfr"><i class="fas fa-check"></i> ' . __( 'ON', 'lighthouse' ) . '</span>';
                    } else {
                        echo '<span class="lhfw"><i class="fas fa-times"></i> ' . __( 'OFF', 'lighthouse' ) . '</span>';
                    }
                    ?>
                </div>
            </div>
            <div class="lhf--grid-item">
                <div class="lhf-fw-metric-option">
                    <?php
                    echo __( 'Proxy Logging', 'lighthouse' );

                    if ( (int) get_option( 'wpg_proxy_logging' ) === 1 ) {
                        echo '<span class="lhfr"><i class="fas fa-check"></i> ' . __( 'ON', 'lighthouse' ) . '</span>';
                    } else {
                        echo '<span class="lhfw"><i class="fas fa-times"></i> ' . __( 'OFF', 'lighthouse' ) . '</span>';
                    }
                    ?>
                </div>
            </div>
            <div class="lhf--grid-item">
                <div class="lhf-fw-metric-option">
                    <?php
                    echo __( 'Spam Logging', 'lighthouse' );

                    if ( (int) get_option( 'wpg_spam_logging' ) === 1 ) {
                        echo '<span class="lhfr"><i class="fas fa-check"></i> ' . __( 'ON', 'lighthouse' ) . '</span>';
                    } else {
                        echo '<span class="lhfw"><i class="fas fa-times"></i> ' . __( 'OFF', 'lighthouse' ) . '</span>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>



<?php
$url = 'https://ipapi.co/8.8.8.8/json/';
$ch  = curl_init();

curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
curl_setopt( $ch, CURLOPT_ENCODING, 'gzip,deflate' );
curl_setopt( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60' );
curl_setopt( $ch, CURLOPT_REFERER, 'https://google.com' );

$ipcontent = curl_exec( $ch );

curl_close( $ch );

$ip_data = json_decode( $ipcontent );
$gstatus = '<span class="lhfw">' . __( 'Offline', 'lighthouse' ) . '</span>';

if ( $ip_data && ! isset( $ip_data->{'error'} ) ) {
    $gstatus = '<span class="lhfr">' . __( 'Online', 'lighthouse' ) . '</span>';
}



// Proxy Check
$proxy_check = 0;

if ( (int) get_option( 'wpg_proxy_protection' ) > 0 ) {
    $apik = 'wpg_proxy_api' . get_option( 'wpg_proxy_protection' );
    $key  = get_option( $apik );
}

if ( (int) get_option( 'wpg_proxy_protection' ) === 1 ) {
    // Invalid API Key ==> Offline
    $ch  = curl_init();
    $url = 'https://v2.api.iphub.info';
    curl_setopt_array(
        $ch,
        [
            CURLOPT_URL            => $url,
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_RETURNTRANSFER => true,
        ]
    );
    $response = curl_exec( $ch );
    $http_code = curl_getinfo( $ch, CURLINFO_RESPONSE_CODE );
    curl_close( $ch );

    if ( $http_code >= 200 && $http_code < 300 ) {
        $proxy_check = 1;
    }
} elseif ( (int) get_option( 'wpg_proxy_protection' ) === 2 ) {
    $ch           = curl_init( 'https://proxycheck.io/v2/8.8.8.8' );
    $curl_options = [
        CURLOPT_CONNECTTIMEOUT => 30,
        CURLOPT_RETURNTRANSFER => true,
    ];
    curl_setopt_array( $ch, $curl_options );
    $response = curl_exec( $ch );
    $http_code = curl_getinfo( $ch, CURLINFO_RESPONSE_CODE );
    curl_close( $ch );

    if ( $http_code >= 200 && $http_code < 300 ) {
        $proxy_check = 1;
    }
} elseif ( (int) get_option( 'wpg_proxy_protection' ) === 3 ) {
    // Invalid API Key ==> Offline
    $headers = [
        'X-Key: ' . $key,
    ];
    $ch      = curl_init( 'https://www.iphunter.info:8082/v1/ip/8.8.8.8' );
    curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
    $response  = curl_exec( $ch );
    $http_code = curl_getinfo( $ch, CURLINFO_RESPONSE_CODE );
    curl_close( $ch );

    if ( $http_code >= 200 && $http_code < 300 ) {
        $proxy_check = 1;
    }
} else {
    $proxy_check = -1;
}

if ( (int) $proxy_check === 1 ) {
    $pstatus = '<span class="lhfr">' . __( 'Online', 'lighthouse' ) . '</span>';
} elseif ( (int) $proxy_check === 0 ) {
    $pstatus = '<span class="lhfw">' . __( 'Offline', 'lighthouse' ) . '</span>';
} else {
    $pstatus = '<span class="lhfw">' . __( 'Disabled', 'lighthouse' ) . '</span>';
}
?>

<div class="lhf--grid lhf--grid-2">
    <div class="lhf--grid-item">
        <span class="dashicons dashicons-block-default"></span>
        <?php echo __( 'GeoIP API Status', 'lighthouse' ); ?>
        <?php echo $gstatus; ?>
    </div>
    <div class="lhf--grid-item">
        <span class="dashicons dashicons-block-default"></span>
        <?php echo __( 'Proxy API Status', 'lighthouse' ); ?>
        <?php echo $pstatus; ?>
    </div>
</div>

<div class="lhf--grid lhf--grid-2">
    <div class="lhf--grid-item">
        <h3>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="-.5 0 25 25" style="height: 24px;"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9.03a7 7 0 0 0-7.12-7A7.1 7.1 0 0 0 5 8.77a7 7 0 0 0 3.1 6.06A2 2 0 0 1 9 16.5v1.53h6V16.5a2 2 0 0 1 .9-1.67 7 7 0 0 0 3.1-5.8Zm-4 12.01a5 5 0 0 1-6 0"/><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m11.99 5.64-1.66 2.78a.8.8 0 0 0 .69 1.22h2a.8.8 0 0 1 .69 1.21l-1.68 2.79"/></svg>
            <?php echo __( 'Statistics', 'lighthouse' ); ?>
        </h3>

        <table class="wp-list-table widefat striped table-view-list">
            <thead>
                <tr>
                    <th scope="col"><?php echo __( 'Potential Threats Logged', 'lighthouse' ); ?></th>
                    <th scope="col"><?php echo __( 'Count', 'lighthouse' ); ?></th>
                </tr>
            </thead>
            <tbody>

                <?php
                $count = $wpdb->get_var( "SELECT COUNT(id) FROM $table_logs" );

                $date2  = date_i18n( 'd F Y' );
                $count2 = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(id) FROM $table_logs WHERE date = %s", $date2 ) );

                $date3  = date_i18n( 'F Y' );
                $count3 = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(id) FROM $table_logs WHERE date LIKE %s", "% $date3" ) );

                $date4  = date_i18n( 'Y' );
                $count4 = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(id) FROM $table_logs WHERE date LIKE %s", "% $date4" ) );
                ?>
                <tr>
                    <td><?php echo __( 'Total', 'lighthouse' ); ?></td>
                    <td><?php echo number_format( $count ); ?></td>
                </tr>
                <tr>
                    <td><?php echo __( 'Today', 'lighthouse' ); ?></td>
                    <td><?php echo number_format( $count2 ); ?></td>
                </tr>
                <tr>
                    <td><?php echo __( 'This month', 'lighthouse' ); ?></td>
                    <td><?php echo number_format( $count3 ); ?></td>
                </tr>
                <tr>
                    <td><?php echo __( 'This year', 'lighthouse' ); ?></td>
                    <td><?php echo number_format( $count4 ); ?></td>
                </tr>
            </tbody>
        </table>

        <br>

        <table class="wp-list-table widefat striped table-view-list">
            <thead class="thead-light">
                <tr>
                    <th scope="col"><?php echo __( 'Banned IPs', 'lighthouse' ); ?></th>
                    <th scope="col"><?php echo __( 'Count', 'lighthouse' ); ?></th>
                </tr>
            </thead>
            <tbody>

                <?php
                $count5 = $wpdb->get_var( "SELECT COUNT(id) FROM $table_bans WHERE type='ip'" );

                $date6  = date_i18n( get_option( 'date_format' ) );
                $count6 = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(id) FROM $table_bans WHERE date = %s AND type='ip'", $date6 ) );

                $date7  = date_i18n( 'F Y' );
                $count7 = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(id) FROM $table_bans WHERE date LIKE %s AND type='ip'", "% $date7" ) );

                $date8  = date_i18n( 'Y' );
                $count8 = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(id) FROM $table_bans WHERE date LIKE %s AND type='ip'", "% $date8" ) );
                ?>
                <tr>
                    <td><?php echo __( 'Total', 'lighthouse' ); ?></td>
                    <td><?php echo number_format( $count5 ); ?></td>
                </tr>
                <tr>
                    <td><?php echo __( 'Today', 'lighthouse' ); ?></td>
                    <td><?php echo number_format( $count6 ); ?></td>
                </tr>
                <tr>
                    <td><?php echo __( 'This month', 'lighthouse' ); ?></td>
                    <td><?php echo number_format( $count7 ); ?></td>
                </tr>
                <tr>
                    <td><?php echo __( 'This year', 'lighthouse' ); ?></td>
                    <td><?php echo number_format( $count8 ); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="lhf--grid-item">
        <h3>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="-.5 0 25 25" style="height: 24px;"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 22.32a10 10 0 1 0 0-20 10 10 0 0 0 0 20Zm-10-10h20"/><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 22.32c1.93 0 3.5-4.48 3.5-10s-1.57-10-3.5-10-3.5 4.48-3.5 10 1.57 10 3.5 10Z"/></svg>
            <?php echo __( 'Potential Threats by Country', 'lighthouse' ); ?>
        </h3>

        <table id="dt-basicdb" class="stripe hover order-column row-border" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th><?php echo __( 'Country', 'lighthouse' ); ?></th>
                    <th><?php echo __( 'Potential Threats', 'lighthouse' ); ?></th>
                </tr>
            </thead>
            <tbody>

            <?php
            $countries = [
                'Afghanistan',
                'Albania',
                'Algeria',
                'Andorra',
                'Angola',
                'Antigua and Barbuda',
                'Argentina',
                'Armenia',
                'Australia',
                'Austria',
                'Azerbaijan',
                'Bahamas',
                'Bahrain',
                'Bangladesh',
                'Barbados',
                'Belarus',
                'Belgium',
                'Belize',
                'Benin',
                'Bhutan',
                'Bolivia',
                'Bosnia and Herzegovina',
                'Botswana',
                'Brazil',
                'Brunei',
                'Bulgaria',
                'Burkina Faso',
                'Burundi',
                'Cambodia',
                'Cameroon',
                'Canada',
                'Cape Verde',
                'Central African Republic',
                'Chad',
                'Chile',
                'China',
                'Colombi',
                'Comoros',
                'Congo (Brazzaville)',
                'Congo',
                'Costa Rica',
                "Cote d\'Ivoire",
                'Croatia',
                'Cuba',
                'Cyprus',
                'Czech Republic',
                'Denmark',
                'Djibouti',
                'Dominica',
                'Dominican Republic',
                'East Timor (Timor Timur)',
                'Ecuador',
                'Egypt',
                'El Salvador',
                'Equatorial Guinea',
                'Eritrea',
                'Estonia',
                'Ethiopia',
                'Fiji',
                'Finland',
                'France',
                'Gabon',
                'Gambia, The',
                'Georgia',
                'Germany',
                'Ghana',
                'Greece',
                'Grenada',
                'Guatemala',
                'Guinea',
                'Guinea-Bissau',
                'Guyana',
                'Haiti',
                'Honduras',
                'Hungary',
                'Iceland',
                'India',
                'Indonesia',
                'Iran',
                'Iraq',
                'Ireland',
                'Israel',
                'Italy',
                'Jamaica',
                'Japan',
                'Jordan',
                'Kazakhstan',
                'Kenya',
                'Kiribati',
                'Korea, North',
                'Korea, South',
                'Kuwait',
                'Kyrgyzstan',
                'Laos',
                'Latvia',
                'Lebanon',
                'Lesotho',
                'Liberia',
                'Libya',
                'Liechtenstein',
                'Lithuania',
                'Luxembourg',
                'Macedonia',
                'Madagascar',
                'Malawi',
                'Malaysia',
                'Maldives',
                'Mali',
                'Malta',
                'Marshall Islands',
                'Mauritania',
                'Mauritius',
                'Mexico',
                'Micronesia',
                'Moldova',
                'Monaco',
                'Mongolia',
                'Morocco',
                'Mozambique',
                'Myanmar',
                'Namibia',
                'Nauru',
                'Nepal',
                'Netherlands',
                'New Zealand',
                'Nicaragua',
                'Niger',
                'Nigeria',
                'Norway',
                'Oman',
                'Pakistan',
                'Palau',
                'Panama',
                'Papua New Guinea',
                'Paraguay',
                'Peru',
                'Philippines',
                'Poland',
                'Portugal',
                'Qatar',
                'Romania',
                'Russia',
                'Rwanda',
                'Saint Kitts and Nevis',
                'Saint Lucia',
                'Saint Vincent',
                'Samoa',
                'San Marino',
                'Sao Tome and Principe',
                'Saudi Arabia',
                'Senegal',
                'Serbia and Montenegro',
                'Seychelles',
                'Sierra Leone',
                'Singapore',
                'Slovakia',
                'Slovenia',
                'Solomon Islands',
                'Somalia',
                'South Africa',
                'Spain',
                'Sri Lanka',
                'Sudan',
                'Suriname',
                'Swaziland',
                'Sweden',
                'Switzerland',
                'Syria',
                'Taiwan',
                'Tajikistan',
                'Tanzania',
                'Thailand',
                'Togo',
                'Tonga',
                'Trinidad and Tobago',
                'Tunisia',
                'Turkey',
                'Turkmenistan',
                'Tuvalu',
                'Uganda',
                'Ukraine',
                'United Arab Emirates',
                'United Kingdom',
                'United States',
                'Uruguay',
                'Uzbekistan',
                'Vanuatu',
                'Vatican City',
                'Venezuela',
                'Vietnam',
                'Yemen',
                'Zambia',
                'Zimbabwe',
                'Unknown',
            ];

            foreach ( $countries as $country ) {
                $log_result = $wpdb->get_row( $wpdb->prepare( "SELECT country, country_code FROM `$table_logs` WHERE `country` LIKE %s LIMIT 1", "%$country%" ) );
                $log_rows   = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(id) FROM `$table_logs` WHERE `country` LIKE %s", "%$country%" ) );

                if ( $log_rows > 0 ) {
                    echo '<tr>
                        <td data-country="' . strtolower( $log_result->country_code ) . '">' . $country . '</td>
                        <td>' . esc_html( $log_rows ) . '</td>
                    </tr>';
                }
            }
            ?>
            </tbody>
        </table>
    </div>
</div>



<?php
$wpgcustom_js4 = 'var barChartData = {
    labels: [';

        $i = 1;

        while ( $i <= 12 ) {
            $date = date_i18n( 'F', mktime( 0, 0, 0, $i, 1 ) );
            $wpgcustom_js4 .= "'$date'";
            if ( $i != 12 ) {
                $wpgcustom_js4 .= ',';
            }
            $i++;
        }

    $wpgcustom_js4 .= '],
    datasets: [{
        label: \'SQLi\',
        backgroundColor: \'#ff8080\',
        stack: \'1\',
        data: [';

            $i = 1;

            while ( $i <= 12 ) {
                $date   = date_i18n( 'F Y', mktime( 0, 0, 0, $i, 1 ) );
                $tcount = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(id) FROM $table_logs WHERE date LIKE %s AND type = %s", "%$date", 'SQLi' ) );
                $wpgcustom_js4 .= "'$tcount'";
                if ( $i != 12 ) {
                    $wpgcustom_js4 .= ',';
                }
                $i++;
            }

        $wpgcustom_js4 .= ']
    }, {
        label: \'Bad Bots\',
        backgroundColor: \'#FFCF96\',
        stack: \'2\',
        data: [';
$i = 1;
while ($i <= 12) {
    $date   = date_i18n('F Y', mktime(0, 0, 0, $i, 1));
    $tcount = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table_logs
                    WHERE date LIKE %s AND (type = %s OR type = %s OR type = %s OR type = %s OR type = %s)", "%$date", 'Bad Bot', 'Fake Bot', 'Missing User-Agent header', 'Missing header Accept', 'Invalid IP Address header'));
    $wpgcustom_js4 .= "'$tcount'";
    if ($i != 12) {
        $wpgcustom_js4 .= ',';
    }
    $i++;
}
$wpgcustom_js4 .= '
				]
			}, {
				label: \'Proxies\',
				backgroundColor: \'#F6FDC3\',
				stack: \'3\',
				data: [';
$i = 1;
while ($i <= 12) {
    $date   = date_i18n('F Y', mktime(0, 0, 0, $i, 1));
    $tcount = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table_logs
                    WHERE date LIKE %s AND type = %s", "%$date", 'Proxy'));
    $wpgcustom_js4 .= "'$tcount'";
    if ($i != 12) {
        $wpgcustom_js4 .= ',';
    }
    $i++;
}
$wpgcustom_js4 .= '
				]
			}, {
				label: \'Spammers\',
				backgroundColor: \'#CDFAD5\',
				stack: \'4\',
				data: [';
$i = 1;
while ($i <= 12) {
    $date   = date_i18n('F Y', mktime(0, 0, 0, $i, 1));
    $tcount = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table_logs
                    WHERE date LIKE %s AND type = %s", "%$date", 'Spammer'));
    $wpgcustom_js4 .= "'$tcount'";
    if ($i != 12) {
        $wpgcustom_js4 .= ',';
    }
    $i++;
}
$wpgcustom_js4 .= '
				]
			}]

		};
document.addEventListener("DOMContentLoaded", () => {
    if (document.getElementById("log-stats")) {
        let ctx = document.getElementById("log-stats").getContext("2d");

        window.myBar = new Chart(ctx, {
            type: "bar",
            data: barChartData,
            options: {
                tooltips: {
                    mode: "index",
                    intersect: false
                },
                responsive: true,
                scales: {
                    x: {
                        stacked: true
                    },
                    y: {
                        stacked: true
                    }
                }
            }
        });
    }
});';

wp_register_script( 'lhf-fw-js4', '', [], '', true );
wp_enqueue_script( 'lhf-fw-js4' );
wp_add_inline_script( 'lhf-fw-js4', $wpgcustom_js4 );
