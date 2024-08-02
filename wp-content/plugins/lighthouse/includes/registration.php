<?php
function lighthouse_run_blacklist_email( $sanitized_user_login, $user_email, $errors ) {
    global $wpdb;

    // Create the table name
    $table_name = $wpdb->prefix . 'lighthouse_blacklist';

    // Get the domain name and clean it
    [$username, $domain] = explode( '@', $user_email );
    $domain              = esc_sql( strtolower( trim( $domain ) ) );

    // Check the blacklist
    $blacklist_domain = $wpdb->get_results( "SELECT * FROM $table_name WHERE domain LIKE '%$domain%'" );

    if ( ! empty( $blacklist_domain ) || substr_count( $sanitized_user_login, '.' ) > 5 ) {
        apply_filters( 'lighthouse_spam_check_result', true, $sanitized_user_login, $user_email, 'local blacklist' );

        $errors->add( 'invalid_email', get_option( 'lighthouse_blacklist_email_message' ) );
    }

    if ( (int) get_option( 'lighthouse_use_external_blacklist' ) === 1 ) {
        // Check external blacklist and get the contents of the txt file
        $ch = curl_init();

        curl_setopt( $ch, CURLOPT_URL, 'https://raw.githubusercontent.com/wolffe/lighthouse-spam-emails/master/blacklist.txt' );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $blacklist_data = curl_exec( $ch );
        curl_close( $ch );

        // Split the contents into an array of domain names
        $blacklist_domains = explode( "\n", $blacklist_data );
        $blacklist_domains = array_map( 'trim', $blacklist_domains );
        $blacklist_domains = array_filter( $blacklist_domains );

        // Check if the domain matches any of the blacklisted domains
        foreach ( $blacklist_domains as $blacklist_domain ) {
            // Check if the blacklisted domain is a substring of the input domain
            if ( trim( $blacklist_domain ) === $domain || strstr( $domain, trim( $blacklist_domain ) ) !== false ) {
                apply_filters( 'lighthouse_spam_check_result', true, $sanitized_user_login, $user_email, '4P blacklist' );

                $errors->add( 'invalid_email', get_option( 'lighthouse_blacklist_email_message' ) );
                break; // Exit the loop if a match is found
            }
        }
        // End external blacklist
    }

    if ( (int) get_option( 'lighthouse_use_isspammy' ) === 1 ) {
        $curl = curl_init();

        curl_setopt_array(
            $curl,
            [
                CURLOPT_URL            => 'https://isspammy.com/?check=' . $user_email,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING       => '',
                CURLOPT_MAXREDIRS      => 10,
                CURLOPT_TIMEOUT        => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST  => 'GET',
            ]
        );

        $response = curl_exec( $curl );

        curl_close( $curl );

        // Decode the JSON response
        $data = json_decode( $response, true );

        if ( $data && isset( $data['spammer_found'] ) ) {
            $spammer_found = (string) $data['spammer_found'];

            if ( $spammer_found === 'yes' ) {
                // Spammer found
                apply_filters( 'lighthouse_spam_check_result', true, $sanitized_user_login, $user_email, 'isspammy.com' );

                $errors->add( 'invalid_email', get_option( 'lighthouse_blacklist_email_message' ) );

                // Increment counter
                $count = get_option( 'lighthouse_isspammy_count', 0 );
                $count++;
                update_option( 'lighthouse_isspammy_count', $count );
            } elseif ( $spammer_found === 'no' ) {
                // No spammer found
            } else {
                // Unknown spammer status
            }
        } else {
            // Error parsing JSON response
        }
    }

    if ( (int) get_option( 'lighthouse_check_registration_periods' ) === 1 ) {
        $period_count        = substr_count( $user_email, '.' );
        $max_periods_allowed = (int) get_option( 'lighthouse_check_registration_periods_count' );
        $max_periods_allowed = $max_periods_allowed > 0 ? $max_periods_allowed : 2;

        if ( (int) $period_count > $max_periods_allowed ) {
            // The email address has more than max allowed number of periods
            apply_filters( 'lighthouse_spam_check_result', true, $sanitized_user_login, $user_email, 'Pattern #1: Periods' );

            $errors->add( 'invalid_email', get_option( 'lighthouse_blacklist_email_message' ) );

            // Increment counter
            $count = get_option( 'lighthouse_spam_registration_pattern1_count', 0 );
            $count++;
            update_option( 'lighthouse_spam_registration_pattern1_count', $count );
        }
    }

    // Increment counter
    $count = get_option( 'lighthouse_spam_registration_count', 0 );
    $count++;
    update_option( 'lighthouse_spam_registration_count', $count );

    return $errors;
}

if ( (int) get_option( 'lighthouse_check_registration_spam' ) === 1 ) {
    add_filter( 'register_post', 'lighthouse_run_blacklist_email', 20, 3 );
}
