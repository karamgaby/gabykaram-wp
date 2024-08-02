<?php
if ( (int) get_option( 'wpg_spam_protection' ) === 1 ) {
    $dnsbl_lookup = [];
    $table        = $wpdb->prefix . 'lhf_dnsbl';
    $dnsbldbs     = $wpdb->get_results( "SELECT dnsbl_database FROM $table" );

    foreach ( $dnsbldbs as $row ) {
        $dnsbl_lookup[] = $row->dnsbl_database;
        $reverse_ip     = implode( '.', array_reverse( explode( '.', $ip ) ) );

        foreach ( $dnsbl_lookup as $host ) {
            if ( checkdnsrr( $reverse_ip . '.' . $host . '.', 'A' ) ) {
                $type = 'Spammer';

                if ( (int) get_option( 'wpg_spam_logging' ) === 1 ) {
                    lighthouse_fw_logging( $type );
                }

                if ( (int) get_option( 'wpg_mail_notifications' ) === 1 && get_option( 'wpg_spam_mail' ) ) {
                    lighthouse_fw_mail( $type );
                }

                exit;
            }
        }
    }

    if ( array_key_exists( 'HTTP_ACCEPT', $_SERVER ) ) {
        // Has HTTP_ACCEPT
    } else {
        $type = 'Spammer';

        if ( (int) get_option( 'wpg_spam_logging' ) === 1 ) {
            lighthouse_fw_logging( $type );
        }

        if ( (int) get_option( 'wpg_mail_notifications' ) === 1 && get_option( 'wpg_spam_mail' ) ) {
            lighthouse_fw_mail( $type );
        }

        exit;
    }
}

if ( (int) get_option( 'wpg_spam_protection_sfs' ) === 1 ) {
    if ( lighthouse_is_spam_sfs_ip( $ip ) ) {
        $type = 'Spammer';

        if ( (int) get_option( 'wpg_spam_logging' ) === 1 ) {
            lighthouse_fw_logging( $type );
        }

        if ( (int) get_option( 'wpg_mail_notifications' ) === 1 && get_option( 'wpg_spam_mail' ) ) {
            lighthouse_fw_mail( $type );
        }

        exit;
    }
}

function lighthouse_is_spam_sfs_ip( $ip ) {
    $api_url = 'https://www.stopforumspam.com/api?ip=' . urlencode( $ip );

    $response = file_get_contents( $api_url );

    $xml = simplexml_load_string( $response );

    return strtolower( $xml->appears ) === 'yes';
}
