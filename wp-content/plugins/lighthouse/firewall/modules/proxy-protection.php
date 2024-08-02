<?php
$cache_file = plugin_dir_path( __FILE__ ) . '/cache/proxy/' . str_replace( ':', '-', $ip ) . '.json';

// Proxy Protection, Method #1
if ( (int) get_option( 'wpg_proxy_protection' ) > 0 ) {
    $proxyv = 0;

    if ( (int) get_option( 'wpg_proxy_protection' ) === 1 ) {
        if ( lighthouse_fw_getcache( $cache_file ) === 'Lighthouse_NoCache' ) {
            $key = get_option( 'wpg_proxy_api1' );
            $ch  = curl_init();
            $url = 'http://v2.api.iphub.info/ip/' . $ip . '';

            curl_setopt_array(
                $ch,
                [
                    CURLOPT_URL            => $url,
                    CURLOPT_CONNECTTIMEOUT => 30,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER     => [ "X-Key: {$key}" ],
                ]
            );
            $block = json_decode( curl_exec( $ch ) )->block;
            curl_close( $ch );

            // Grabs API Response and Caches
            file_put_contents( $cache_file, $choutput );
        } else {
            @$block = json_decode( lighthouse_fw_getcache( $cache_file ) )->block;
        }

        if ( $block ) {
            $proxyv = 1;
        }
    } elseif ( (int) get_option( 'wpg_proxy_protection' ) === 2 ) {
        if ( lighthouse_fw_getcache( $cache_file ) === 'Lighthouse_NoCache' ) {
            $key = get_option( 'wpg_proxy_api2' );
            $ch  = curl_init( 'http://proxycheck.io/v2/' . $ip . '?key=' . $key . '&vpn=1' );

            $curl_options = [
                CURLOPT_CONNECTTIMEOUT => 30,
                CURLOPT_RETURNTRANSFER => true,
            ];
            curl_setopt_array( $ch, $curl_options );
            $response = curl_exec( $ch );
            curl_close( $ch );
            $jsonc = json_decode( $response );

            // Grabs API Response and Caches
            file_put_contents( $cache_file, $response );
        } else {
            $jsonc = json_decode( lighthouse_fw_getcache( $cache_file ) );
        }

        if ( isset( $jsonc->$ip->proxy ) && (string) $jsonc->$ip->proxy === 'yes' ) {
            $proxyv = 1;
        }
    } elseif ( (int) get_option( 'wpg_proxy_protection' ) === 3 ) {
        if ( lighthouse_fw_getcache( $cache_file ) === 'Lighthouse_NoCache' ) {
            $key = get_option( 'wpg_proxy_api3' );

            $headers = [
                'X-Key: ' . $key,
            ];

            $ch = curl_init( 'https://www.iphunter.info:8082/v1/ip/' . $ip );
            curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );

            $output      = json_decode( curl_exec( $ch ), 1 );
            $http_status = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
            curl_close( $ch );

            if ( (int) $http_status === 200 ) {
                if ( (int) $output['data']['block'] === 1 ) {
                    $proxyv = 1;
                }

                // Grabs API Response and Caches
                file_put_contents( $cache_file, $choutput );
            }
        } else {
            $output = json_decode( lighthouse_fw_getcache( $cache_file ), 1 );

            if ( (int) $output['data']['block'] === 1 ) {
                $proxyv = 1;
            }
        }
    }

    if ( (int) $proxyv === 1 ) {
        $type = 'Proxy';

        if ( (int) get_option( 'wpg_proxy_logging' ) === 1 ) {
            lighthouse_fw_logging( $type );
        }

        if ( (int) get_option( 'wpg_mail_notifications' ) === 1 && get_option( 'wpg_proxy_mail' ) ) {
            lighthouse_fw_mail( $type );
        }

        exit;
    }
}

// Proxy Protection, Method 2
if ( (int) get_option( 'wpg_proxy_protection2' ) === 1 ) {
    $proxy_headers = [
        'HTTP_VIA',
        'VIA',
        'Proxy-Connection',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_FORWARDED',
        'HTTP_CLIENT_IP',
        'HTTP_FORWARDED_FOR_IP',
        'X-PROXY-ID',
        'MT-PROXY-ID',
        'X-TINYPROXY',
        'X_FORWARDED_FOR',
        'FORWARDED_FOR',
        'X_FORWARDED',
        'FORWARDED',
        'CLIENT-IP',
        'CLIENT_IP',
        'PROXY-AGENT',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'FORWARDED_FOR_IP',
        'HTTP_PROXY_CONNECTION',
    ];

    foreach ( $proxy_headers as $x ) {
        if ( isset( $_SERVER[ $x ] ) ) {
            $type = 'Proxy';

            if ( (int) get_option( 'wpg_proxy_logging' ) === 1 ) {
                lighthouse_fw_logging( $type );
            }

            if ( (int) get_option( 'wpg_mail_notifications' ) === 1 && get_option( 'wpg_proxy_mail' ) ) {
                lighthouse_fw_mail( $type );
            }

            exit;
        }
    }
}
