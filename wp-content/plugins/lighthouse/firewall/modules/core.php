<?php
global $ip, $page, $date, $time, $browser, $browser_code, $os, $os_code, $useragent, $referer, $querya;

// Getting visitor's real IP Address
$ip      = '';
$ip_type = '';

if ( isset( $_SERVER['HTTP_CLIENT_IP'] ) ) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif ( isset($_SERVER['HTTP_CF_CONNECTING_IP'] ) ) {
    // When website is behind Cloudflare
    $ip = $_SERVER['HTTP_CF_CONNECTING_IP']; 
} elseif ( isset($_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} elseif ( isset($_SERVER['HTTP_X_FORWARDED'] ) ) {
    $ip = $_SERVER['HTTP_X_FORWARDED'];
} elseif ( isset($_SERVER['HTTP_FORWARDED_FOR'] ) ) {
    $ip = $_SERVER['HTTP_FORWARDED_FOR'];
} elseif ( isset($_SERVER['HTTP_FORWARDED'] ) ) {
    $ip = $_SERVER['HTTP_FORWARDED'];
} elseif ( isset($_SERVER['REMOTE_ADDR'] ) ) {
    $ip = $_SERVER['REMOTE_ADDR'];
}

// Getting Browser and Operating System
if ( isset( $_SERVER['HTTP_USER_AGENT'] ) ) {
    $useragent = $_SERVER['HTTP_USER_AGENT'];
} else {
    $useragent = '';
}
include dirname( __FILE__ ) . '/lib/class-useragentfactorypsec.php';
$useragent_data = UserAgentFactoryPSec::analyze( $useragent );

// Getting Visitor Information
if ($ip == "::1") {
    $ip = "127.0.0.1";
}
$ip           = strtok($ip, ',');
//$ip           = str_replace(',', '', $ip);
//$ip           = str_replace(' ', '', $ip);

if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {    
    $ip_type = "v4";
}
else if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) { 
    $ip_type = "v6";
}

if ($ip_type == "v4") {
	$ipnums       = explode(".", $ip);
	$ip_range    = $ipnums[0] . "." . $ipnums[1] . "." . $ipnums[2];
}
else if ($ip_type == "v6") {
	$ipnums       = explode(":", $ip);
	$ip_range    = $ipnums[0] . ":" . $ipnums[1] . ":" . $ipnums[2] . ":" . $ipnums[3];
}

// Browser
$browser      = $useragent_data->browser['title'];
$browsersh    = $useragent_data->browser['name'];
$browser_code = $useragent_data->browser['code'];

// Operating System
$os           = $useragent_data->os['title'];
$ossh         = $useragent_data->os['name'] . " " . $useragent_data->os['version'];
$os_code      = $useragent_data->os['code'];

// Referer
if (isset($_SERVER['HTTP_REFERER'])) {
    $referer = $_SERVER["HTTP_REFERER"];
} else {
    $referer = '';
}

// Page and Path
$page         = $_SERVER['PHP_SELF'];
$script_name  = ltrim($_SERVER["SCRIPT_NAME"], '/');
$query_string = $_SERVER['QUERY_STRING'] ?? '';
$querya       = strip_tags(addslashes($query_string));

// Date and Time
$datedf      = date_i18n(get_option('date_format'));
$timedf      = date_i18n(get_option('time_format'));
$date        = date_i18n("d F Y");
$time        = date_i18n("H:i");

// Check if Search Engine Bot
$searchengine_bot = 0;
$fake_bot         = 0;

$bots = [
    "Googlebot",
    "Bingbot",
    "Yahoo! Slurp",
    "YandexBot",
    "DuckDuckBot",
    "Baiduspider",
    "Applebot",
    "Facebook External Hit",
    "Twitterbot",
    "LinkedInBot",
    "AhrefsBot",
    "SemrushBot",
    "Pinterest",
    "TelegramBot",
    "WhatsApp",
    "Discordbot",
    "Slackbot",
    "Redditbot",
    "OutbrainBot",
    "TaboolaBot",
    "Flipboard",
    "TikTokBot",
    // Additional friendly bots
    "MJ12bot",
    "Exabot",
    "Sogou",
    "Yeti",
    "Gigabot",
    "Wget",
    "Curl",
    "DotBot",
    "SearchmetricsBot",
    "SeznamBot",
    "Uptimebot",
    "archive.org_bot",
    "Dataminr",
    "TurnitinBot",
    "Embedly",
    "rogerbot",
    "Siteimprove",
    "ZoominfoBot",
    "Blekko",
    "CompSpyBot",
    "DotBot",
    "FeedFetcher-Google",
    "Linkdex",
    "magpie-crawler",
    "Screaming Frog SEO Spider",
    "Domain Re-Animator Bot",
    "Y!J-BRW",
    "Y!J-SRD",
    "Y!J-BRS",
    "ltx71",
    "MojeekBot",
    "GrapeshotCrawler",
    "CCBot",
    "CareerBot",
    "adbeat_bot",
    "AHC",
    "KonturBot",
    "VelenPublicWebCrawler",
    "ltx71",
    "ZoomBot",
    "Mail.RU_Bot",
    "TurnitinBot",
    "Innovazion Crawler",
    "GrapeshotCrawler",
    "CCBot",
    "CareerBot",
    "adbeat_bot",
    "AHC",
    "KonturBot",
    "VelenPublicWebCrawler",
    "Lipperhey",
    "MegaIndex",
    "ahrefsbot",
    "CCXSystem",
    "Datadog",
    "monit",
    "nagios",
    "opensiteexplorer",
    "paper.li",
    "python-requests",
    "rogerbot",
    "seokicks",
    "slackbot",
    "SMTBot",
    "Slackbot-LinkExpanding",
    "Slackbot-LinkSnapshot",
    "Slackbot 1.0 (+https://api.slack.com/robots)",
    "SurveyBot",
    "vsco-crawler",
    "ZoominfoBot",
    "PostmanRuntime",
    "Fever",
    "Slack-ImgProxy",
    "YahooCacheSystem",
    "Slackbot-Periscope",
    "WordPress",
    "Hootsuite-WebFeed",
    "Googlebot-Mobile",
    "AdsBot-Google-Mobile",
    "AdsBot-Google-Mobile-Apps",
    "Feedly",
    "Google-HTTP-Java-Client",
    "Google-Ads-Overview",
    "HTTPClient",
    "Superfeedr",
    "Zabbix",
    "ZmEu",
    "Genieo",
    "ia_archiver",
    "Go-http-client",
    "ruby",
    "SyntheticHealth",
    "DeveloperExperienceBot",
    "SafetyBot",
    "SalesforceBot",
    "PycURL",
    "Apache-HttpClient",
    "Hootsuite-WebFeed",
    "Asterias",
    "python",
    "Mozilla",
    "SEMrushBot-SA",
    "TelegramBot (like TwitterBot)",
    "SeznamBot",
    "Nimbostratus-Bot",
    "AwarioSmartBot",
    "AgentSmith",
    "Thumbor",
    "cherryPicker",
    "BingPreview",
    "DuckDuckGo-Favicons-Bot",
    "FacebookBot",
    "Grapeshot",
    "GroupHigh",
    "ia_archiver",
    "LivelapBot",
    "Magpie-Crawler",
    "Python-urllib",
    "SEOENGWorldBot",
    "Slurp",
    "SlurpChina",
    "WhatsApp-UserProfile",
    "zoominfobot",
];

foreach ( $bots as $bot ) {
    if ( stripos( strtolower( $useragent ), strtolower( $bot ) ) !== false ) {
        $searchengine_bot = 1;
        $fake_bot = 0;

        break;
    }
}



// Gets the contents of cache file if it exists (valid), otherwise grabs and caches
function lighthouse_fw_getcache( $cache_file ) {
    global $cache_file;
    
    if ( $cache_file != null && file_exists( $cache_file ) ) {
        $current_time = time();
        //$expire_time  = 1 * 60 * 60; // 1 hour
        $expire_time  = 1 * 24 * 60 * 60; // 1 day
        $file_time    = filemtime( $cache_file );

        if ( $current_time - $expire_time < $file_time ) {
            return file_get_contents( $cache_file );
        } else {
            return 'Lighthouse_NoCache';
        }
    } else {
        return 'Lighthouse_NoCache';
    }
}

function lighthouse_fw_logging($type)
{
    global $wpdb;
    global $ip, $page, $date, $time, $browser, $browser_code, $os, $os_code, $useragent, $referer, $querya;
    
    $table           = $wpdb->prefix . 'lhf_logs';
    $duplicate_check = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table
                    WHERE ip = %s AND page = %s AND query = %s AND type = %s AND date = %s LIMIT 1", $ip, $page, $querya, $type, $date));
    
    if ($duplicate_check <= 0) {
        include_once "lib/ip-details.php";
        
        $data   = array(
            'ip' => $ip,
            'date' => $date,
            'time' => $time,
            'page' => $page,
            'query' => $querya,
            'type' => $type,
            'browser' => $browser,
            'browser_code' => $browser_code,
            'os' => $os,
            'os_code' => $os_code,
            'country' => $country,
            'country_code' => $country_code,
            'region' => $region,
            'city' => $city,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'isp' => $isp,
            'useragent' => $useragent,
            'referer_url' => $referer
        );
        $format = array(
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s'
        );
        $wpdb->insert($table, $data, $format);
    }
}

function lighthouse_fw_autoban( $type ) {
    global $wpdb, $ip, $date, $time;

    $table           = $wpdb->prefix . 'lhf_bans';
    $duplicate_check = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $table WHERE value = %s AND type = %s LIMIT 1", $ip, 'ip' ) );
    
    if ( $duplicate_check <= 0 ) {
        $data   = [
            'type'    => 'ip',
            'value'   => $ip,
            'date'    => $date,
            'time'    => $time,
            'reason'  => $type,
            'autoban' => '1',
        ];
        $format = [
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%d',
        ];
        $wpdb->insert( $table, $data, $format );
    }
}

function lighthouse_fw_mail( $type ) {
    global $ip, $datedf, $timedf, $browser, $os, $page, $referer, $to;

    $email   = 'notifications@' . $_SERVER['SERVER_NAME'] . '';
    $to      = get_option( 'wpg_admin_email' );
    $subject = 'Lighthouse Firewall - ' . $type . '';
    $message = '<p size="18px;">Details of Log - ' . $type . '</p>
                <hr>
                <p>IP Address: <strong>' . $ip . '</strong></p>
                <p>Date: <strong>' . $datedf . '</strong> at <strong>' . $timedf . '</strong></p>
                <p>Browser: <strong>' . $browser . '</strong></p>
                <p>Operating System:  <strong>' . $os . '</strong></p>
                <p>Threat Type: <strong>' . $type . '</strong></p>
                <p>Page: <strong>' . $page . '</strong></p>
                <p>Referer URL: <strong>' . $referer . '</strong></p>
                <p>Site URL: <strong>' . get_site_url() . '</strong></p>';
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers .= 'To: ' . $to . ' <' . $to . '>' . "\r\n";
    $headers .= 'From: ' . $email . ' <' . $email . '>' . "\r\n";

    wp_mail( $to, $subject, $message, $headers );
}
