<?php
$cache_file = plugin_dir_path( __FILE__ ) . '/cache/ip-details/' . str_replace( ':', '-', $ip ) . '.json';

//Ban System
$table    = $wpdb->prefix . 'lhf_bans';
$bannedip = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $table WHERE type = %s AND value = %s LIMIT 1", 'ip', $ip ) );

if ( $bannedip > 0 ) {
    exit;
}

// IP Ranges
$bannedipr = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $table WHERE type = %s AND value = %s LIMIT 1", 'ip_range', $ip_range ) );

if ( $bannedipr > 0 ) {
    exit;
}
