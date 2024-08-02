<?php
if ( (int) get_option( 'wpg_sqli_protection' ) === 1 ) {
    // XSS Protection - Sanitize infected requests
    if ( (int) get_option( 'wpg_sqli_protection2' ) === 1 ) {
        header( 'X-XSS-Protection: 1' );
    }

    // Clickjacking Protection
    if ( (int) get_option( 'wpg_sqli_protection3' ) === 1 ) {
        header( 'X-Frame-Options: sameorigin' );
    }

    // Prevents attacks based on MIME-type mismatch
    if ( (int) get_option( 'wpg_sqli_protection4' ) === 1 ) {
        header( 'X-Content-Type-Options: nosniff' );
    }

    // Force secure connection
    if ( (int) get_option( 'wpg_sqli_protection5' ) === 1 ) {
        header( 'Strict-Transport-Security: max-age=15552000; preload' );
    }

    // Hide PHP Version
    if ( (int) get_option( 'wpg_sqli_protection6' ) === 1 ) {
        header( 'X-Powered-By: Lighthouse' );
    }

    $query_string = ( isset( $_SERVER['QUERY_STRING'] ) ) ? $_SERVER['QUERY_STRING'] : '';

    // Patterns, used for malicious requests
    $patterns = [
        '**/',
        '/**',
        '0x3a',
        '/*',
        '*/',
        '||',
        "' #",
        'or 1=1',
        'or%201=1',
        "'1'='1",
        'S@BUN',
        '`',
        "'",
        '"',
        '<',
        '>',
        '1,1',
        '1=1',
        '<?',
        '<?php',
        '?>',
        '../',
        '%0A',
        '%0D',
        '%3C',
        '%3E',
        '%00',
        '%2e%2e',
        'input_file',
        'path=.',
        'mod=.',
        'eval\(',
        'javascript:',
        'base64_',
        'boot.ini',
        'etc/passwd',
        'self/environ',
        'echo.*kae',
        '=%27$',

        'SELECT%20*%20FROM',
        'INSERT%20INTO',
        'UPDATE',
        'DELETE%20FROM',
        'DROP%20TABLE',
        'TRUNCATE%20TABLE',
        'ALTER%20TABLE',
        'CREATE%20TABLE',
        'UNION%20ALL%20SELECT',
        'AND%201=1',
        'OR%201=1',
        '%3B--', // encoded semicolon and SQL comment
        '%2F%2A', // encoded SQL comment start
        '%2A%2F', // encoded SQL comment end
        'xp_cmdshell',
        'exec',
        'sp_executesql',
        'sleep',
        'benchmark',
        'waitfor%20delay',
        'information_schema.tables',
        'schema.tables',
        'concat',
        'user()',
        'current_user()',
        'database()',
        'version()',
        'procedure%20analyse',
        'CHAR%28', // encoded SQL CHAR(
        'CHR%28', // encoded SQL CHR(
        'UNICODE%28', // encoded SQL UNICODE(
        'ASCII%28', // encoded SQL ASCII(
        '1%3B1', // encoded 1;1
        "1'%20OR%20'1'%20=%20'", // SQL injection attempt using boolean-based blind technique
        "1'%20OR%20EXISTS(SELECT%201%20FROM%20table_name)%20OR%20'", // SQL injection attempt using EXISTS clause
        "1'%20OR%20(SELECT%201%20FROM%20table_name)%20OR%20'", // SQL injection attempt using subquery
        "1'%20UNION%20SELECT%201,2,3,4%20FROM%20information_schema.tables%20--", // SQL injection attempt using UNION SELECT
        "1'%20OR%20SLEEP(5)%20AND%20'", // SQL injection attempt causing a delay
        "1'%20AND%20(SELECT%20COUNT(*)%20FROM%20table_name)%20BETWEEN%201%20AND%2010%20AND%20'", // SQL injection attempt using BETWEEN clause
        "1'%20AND%20ASCII(SUBSTR((SELECT%20password%20FROM%20users%20WHERE%20username='admin'),1,1))%20BETWEEN%2097%20AND%20122%20AND%20'", // SQL injection attempt retrieving password character by character
        "1'%20AND%20(SELECT%20COUNT(*)%20FROM%20information_schema.tables)%20%3E%200%20AND%20'", // SQL injection attempt checking if information_schema.tables exists
        "1'%20OR%20ROWNUM%20=%20ROWNUM%20AND%20'", // SQL injection attempt in Oracle databases
    ];

    foreach ( $patterns as $pattern ) {
        if ( strpos( strtolower( $query_string ), strtolower( $pattern ) ) !== false ) {
            $type = 'SQLi';

            if ( (int) get_option( 'wpg_sqli_logging' ) === 1 ) {
                lighthouse_fw_logging( $type );
            }

            if ( (int) get_option( 'wpg_sqli_autoban' ) === 1 ) {
                lighthouse_fw_autoban( $type );
            }

            if ( (int) get_option( 'wpg_mail_notifications' ) === 1 && get_option( 'wpg_sqli_mail' ) ) {
                lighthouse_fw_mail( $type );
            }

            exit;
        }
    }
}
