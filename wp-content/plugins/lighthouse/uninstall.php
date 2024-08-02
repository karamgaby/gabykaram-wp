<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

delete_option( 'wpg_mail_notifications' );
delete_option( 'wpg_sqli_protection' );
delete_option( 'wpg_sqli_protection2' );
delete_option( 'wpg_sqli_protection3' );
delete_option( 'wpg_sqli_protection4' );
delete_option( 'wpg_sqli_protection5' );
delete_option( 'wpg_sqli_protection6' );
delete_option( 'wpg_sqli_logging' );
delete_option( 'wpg_sqli_autoban' );
delete_option( 'wpg_sqli_mail' );
delete_option( 'wpg_badbot_protection' );
delete_option( 'wpg_badbot_protection2' );
delete_option( 'wpg_badbot_protection3' );
delete_option( 'wpg_badbot_logging' );
delete_option( 'wpg_badbot_autoban' );
delete_option( 'wpg_badbot_mail' );
delete_option( 'wpg_proxy_protection' );
delete_option( 'wpg_proxy_protection2' );
delete_option( 'wpg_proxy_api1' );
delete_option( 'wpg_proxy_api2' );
delete_option( 'wpg_proxy_api3' );
delete_option( 'wpg_proxy_logging' );
delete_option( 'wpg_proxy_mail' );
delete_option( 'wpg_spam_protection' );
delete_option( 'wpg_spam_protection_sfs' );
delete_option( 'wpg_spam_logging' );
delete_option( 'wpg_spam_mail' );
delete_option( 'lhf_minify_html_active' );
delete_option( 'lhf_minify_javascript' );
delete_option( 'lhf_minify_html_comments' );
delete_option( 'lhf_minify_html_xhtml' );
delete_option( 'lhf_minify_html_utf8' );

delete_site_option( 'wpg_mail_notifications' );
delete_site_option( 'wpg_sqli_protection' );
delete_site_option( 'wpg_sqli_protection2' );
delete_site_option( 'wpg_sqli_protection3' );
delete_site_option( 'wpg_sqli_protection4' );
delete_site_option( 'wpg_sqli_protection5' );
delete_site_option( 'wpg_sqli_protection6' );
delete_site_option( 'wpg_sqli_logging' );
delete_site_option( 'wpg_sqli_autoban' );
delete_site_option( 'wpg_sqli_mail' );
delete_site_option( 'wpg_badbot_protection' );
delete_site_option( 'wpg_badbot_protection2' );
delete_site_option( 'wpg_badbot_protection3' );
delete_site_option( 'wpg_badbot_logging' );
delete_site_option( 'wpg_badbot_autoban' );
delete_site_option( 'wpg_badbot_mail' );
delete_site_option( 'wpg_proxy_protection' );
delete_site_option( 'wpg_proxy_protection2' );
delete_site_option( 'wpg_proxy_api1' );
delete_site_option( 'wpg_proxy_api2' );
delete_site_option( 'wpg_proxy_api3' );
delete_site_option( 'wpg_proxy_logging' );
delete_site_option( 'wpg_proxy_autoban' );
delete_site_option( 'wpg_proxy_mail' );
delete_site_option( 'wpg_spam_protection' );
delete_site_option( 'wpg_spam_protection_sfs' );
delete_site_option( 'wpg_spam_logging' );
delete_site_option( 'wpg_spam_autoban' );
delete_site_option( 'wpg_spam_mail' );
delete_site_option( 'lhf_minify_html_active' );
delete_site_option( 'lhf_minify_javascript' );
delete_site_option( 'lhf_minify_html_comments' );
delete_site_option( 'lhf_minify_html_xhtml' );
delete_site_option( 'lhf_minify_html_utf8' );

// Drop custom database tables
global $wpdb;

$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}lhf_logs" );
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}lhf_bans" );
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}lhf_ipwhitelist" );
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}lhf_dnsbl" );
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}lhf_loginhistory" );
