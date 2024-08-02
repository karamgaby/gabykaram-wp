<?php
function lighthouse_check_attempted_login( $user, $username, $password ) {
    if ( get_transient( 'attempted_login' ) ) {
        $datas = get_transient( 'attempted_login' );

        if ( $datas['tried'] >= 3 ) {
            $until = get_option( '_transient_timeout_' . 'attempted_login' );
            $time  = lighthouse_time_to_go( $until );

            // Increment counter
            $count = get_option( 'lighthouse_failed_login_count', 0 );
            $count++;
            update_option( 'lighthouse_failed_login_count', $count );

            return new WP_Error( 'too_many_tried', "<strong>ERROR</strong>: You have reached authentication limit, you will be able to try again in $time." );
        }
    }

    return $user;
}

add_filter( 'authenticate', 'lighthouse_check_attempted_login', 30, 3 );

function lighthouse_login_failed( $username ) {
    if ( get_transient( 'attempted_login' ) ) {
        $datas = get_transient( 'attempted_login' );

        $datas['tried']++;

        if ( $datas['tried'] <= 3 ) {
            set_transient( 'attempted_login', $datas, 300 );
        }
    } else {
        $datas = [
            'tried' => 1,
        ];

        set_transient( 'attempted_login', $datas, 300 );
    }
}

add_action( 'wp_login_failed', 'lighthouse_login_failed', 10, 1 );

function lighthouse_time_to_go( $timestamp ) {
    // Convert the MySQL timestamp to PHP time
    $periods = [
        'second',
        'minute',
        'hour',
        'day',
        'week',
        'month',
        'year',
    ];

    $lengths = [
        '60',
        '60',
        '24',
        '7',
        '4.35',
        '12',
    ];

    $current_timestamp = time();
    $difference        = abs( $current_timestamp - $timestamp );

    for ( $i = 0; $difference >= $lengths[ $i ] && $i < count( $lengths ) - 1; $i++ ) {
        $difference /= $lengths[ $i ];
    }

    $difference = round( $difference );

    if ( isset( $difference ) ) {
        if ( (int) $difference !== 1 ) {
            $periods[ $i ] .= 's';
        }

        $output = "$difference $periods[$i]";

        return $output;
    }
}
