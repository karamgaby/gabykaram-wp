<?php
if ( (int) get_option( 'wpg_badbot_protection2' ) === 1 ) {
    if ( (int) $fake_bot === 1 ) {
        $type = 'Fake Bot';

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
