<form method="post" action="">
    <h2><?php _e( 'Security Settings', 'lighthouse' ); ?></h2>

    <p>Read the <a href="https://wordpress.org/support/article/hardening-wordpress/" rel="external" target="_blank">official WordPress guidelines</a> for hardening and securing your site.</p>

    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row"><label>Basic Security</label></th>
                <td>
                    <p>
                        <input type="checkbox" name="lighthouse_normalize_scheme" value="1" <?php checked( 1, (int) get_option( 'lighthouse_normalize_scheme' ) ); ?>> <span class="lhfr">recommended</span> <label>Normalize HTTP(S) scheme</label><br>
                        <small>Use the scheme/protocol of the current page or do not force a certain scheme (useful when switching from HTTP to HTTPS or to minimize mixed content warnings)</small><br>
                    </p>
                    <p>
                        <input type="checkbox" name="lighthouse_xmlrpc" value="1" <?php checked( 1, (int) get_option( 'lighthouse_xmlrpc' ) ); ?>> <span class="lhfr">recommended</span> <span class="lhfw">use with caution</span> <label>Disable XML-RPC</label><br>
                        <small>Disable remote access to your WordPress site (may cause issues with some plugins)</small>
                    </p>
                    <p>
                        <input type="checkbox" name="lighthouse_disable_rest" value="1" <?php checked( 1, (int) get_option( 'lighthouse_disable_rest' ) ); ?>> <span class="lhfw">use with caution</span> <label>Disallow unauthorized REST requests</label><br>
                        <small>Disallow unauthorized REST API requests (may cause issues with some plugins)</small>
                    </p>
                    <p>
                        <input type="checkbox" name="lighthouse_disable_user_enumeration" value="1" <?php checked( 1, (int) get_option( 'lighthouse_disable_user_enumeration' ) ); ?>> <span class="lhfw">use with caution</span> <label>Disable user enumeration</label><br>
                        <small>Disable user enumeration (may cause issues with some plugins or themes)</small>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label>Brute Force Protection</label></th>
                <td>
                    <p>
                        <input type="checkbox" name="lighthouse_brute_force" value="1" <?php checked( 1, (int) get_option( 'lighthouse_brute_force' ) ); ?>> <span class="lhfr">recommended</span> <span class="lhfw">use with caution</span> <label>Enable brute force protection</label><br>
                        <small>Enabling brute force protection will prevent bots and hackers from attempting to log in to your website with common username and password combinations</small>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label>Firewall</label></th>
                <td>
                    <p>
                        <input type="checkbox" name="lighthouse_firewall" value="1" <?php checked( 1, (int) get_option( 'lighthouse_firewall' ) ); ?>> <label>Enable firewall</label><br>
                        <small></small>
                    </p>
                </td>
            </tr>
        </tbody>
    </table>

    <h2>Registration Spam</h2>

    <p>Restricted/spam registrations: <?php echo number_format( get_option( 'lighthouse_spam_registration_count' ) ); ?></p>

    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row"><label>User Registration</label></th>
                <td>
                    <p>
                        <input type="checkbox" name="lighthouse_check_registration_spam" value="1" <?php checked( 1, (int) get_option( 'lighthouse_check_registration_spam' ) ); ?>> <label>Check registration spam</label><br>
                        <small>Prevent users or bots from registering with a disposable or spam email addresses. Only use if you allow public user registration.</small>
                    </p>
                    <p>
                        <input type="checkbox" name="lighthouse_check_registration_periods" value="1" <?php checked( 1, (int) get_option( 'lighthouse_check_registration_periods' ) ); ?>> <label>Enable Spam Pattern Detection: Periods</label><br>
                        <small>Detect spammers by checking for email addresses with excessive periods to evade filters and deceive recipients.</small>
                    </p>
                    <p>
                        <input type="checkbox" name="lighthouse_use_akismet" value="1" <?php checked( 1, (int) get_option( 'lighthouse_use_akismet' ) ); ?>> <label>Akismet integration</label><br>
                        <small>Protect your form entries from spam using Akismet.</small>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label>User Registration Patterns</label></th>
                <td>
                    <p>
                        <input type="number" name="lighthouse_check_registration_periods_count" value="<?php echo get_option( 'lighthouse_check_registration_periods_count' ); ?>" min="1"> <label>Maximum number of periods allowed in an email address (including the domain name - recommended is 2)</label>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label>User Error Message</label></th>
                <td>
                    <p>
                        <textarea name="lighthouse_blacklist_email_message" class="large-text" rows="4"><?php echo get_option( 'lighthouse_blacklist_email_message' ); ?></textarea>
                        <br><small>Custom error message to display when a user tries to register with a blacklisted email address (e.g. <strong>Error:</strong> This email address is banned from registration).</small>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label>Blacklisted Words</label>
                </th>
                <td>
                    <?php
                    global $wpdb;

                    // Check if the table exists
                    $table_name   = $wpdb->prefix . 'lighthouse_blacklist';
                    $table_exists = $wpdb->get_var( $wpdb->prepare( "SHOW TABLES LIKE %s", $table_name ) );

                    // If the table doesn't exist, create it
                    if ( $table_exists !== $table_name ) {
                        $table_name = $wpdb->prefix . 'lighthouse_blacklist';

                        $results = $wpdb->query( "CREATE TABLE IF NOT EXISTS $table_name (id INT(11) NOT NULL AUTO_INCREMENT, domain VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id), KEY domain (domain));" );

                        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
                        dbDelta( $sql );

                        echo '<div id="message" class="updated notice is-dismissible"><p>' . __( 'Lighthouse blacklist table created successfully!', 'lighthouse' ) . '</p></div>';
                    }

                    $record = $wpdb->get_results( "SELECT * FROM $table_name" );
                    ?>
                    <p>When a new registration email or username contains any of these words or domains in its content, it will be banned from registration. One word or domain per line. It will match inside words, so ".info" will match all <code>.info</code> domains.</p>
                    <p>
                        <textarea name="blacklist" class="large-text code" rows="8">
<?php
foreach ( $record as $record ) {
    echo $record->domain . "\r\n";
}
?></textarea>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label>Blacklist Providers</label>
                </th>
                <td>
                    <p>
                        <input type="checkbox" id="lighthouse_use_external_blacklist" name="lighthouse_use_external_blacklist" value="1" <?php checked( (int) get_option( 'lighthouse_use_external_blacklist' ), 1 ); ?>>
                        <label for="lighthouse_use_external_blacklist">🔒 Use <b>4P</b> external blacklist</label>
                        <br><small><b>4P</b> is the official Lighthouse blacklist. It is updated regularly and contains the most common spam domains.</small>
                    </p>
                    <p>
                        <input type="checkbox" id="lighthouse_use_isspammy" name="lighthouse_use_isspammy" value="1" <?php checked( (int) get_option( 'lighthouse_use_isspammy' ), 1 ); ?>>
                        <label for="lighthouse_use_isspammy">🔒 Use <b>Is Spammy</b> (https://isspammy.com/)</label>
                    </p>
                </td>
            </tr>
        </tbody>
    </table>

    <hr>
    <p><input type="submit" name="info_security_update" class="button button-primary" value="Save Changes"></p>
</form>
