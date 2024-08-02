<?php
if ( (int) get_option( 'wpg_badbot_protection3' ) === 1 ) {
    // Detect Missing User-Agent Header
    if ( empty( $useragent ) ) {
        $type = 'Missing User-Agent header';

        if ( (int) get_option( 'wpg_badbot_logging' ) === 1 ) {
            lighthouse_fw_logging( $type );
        }

        if ( (int) get_option( 'wpg_badbot_autoban' ) === 1 ) {
            lighthouse_fw_autoban( $type );
        }

        if ( (int) get_option( 'wpg_mail_notifications' ) === 1 && get_option( 'wpg_badbot_mail' ) ) {
            lighthouse_fw_mail( $type );
        }

        exit;
    }

    if ( ! filter_var( $ip, FILTER_VALIDATE_IP ) ) {
        $type = 'Invalid IP Address header';

        if ( (int) get_option( 'wpg_badbot_logging' ) === 1 ) {
            lighthouse_fw_logging( $type );
        }

        if ( (int) get_option( 'wpg_badbot_autoban' ) === 1 ) {
            lighthouse_fw_autoban( $type );
        }

        if ( (int) get_option( 'wpg_mail_notifications' ) === 1 && get_option( 'wpg_badbot_mail' ) ) {
            lighthouse_fw_mail( $type );
        }

        exit;
    }
}
