<?php
if ( isset( $_POST['submit'] ) ) {
    if ( ! isset( $_POST['wpcatpcha_update_admin_options_nonce'] ) || ! wp_verify_nonce( $_POST['wpcatpcha_update_admin_options_nonce'], 'wpcatpcha_update_admin_options' ) ) {
        ?>
        <div id="message" class="updated fade"><p><strong><?php _e( 'An error occurred.', 'lighthouse' ); ?></strong></p></div>
    <?php } else { ?>
        <div id="message" class="updated fade"><p><strong><?php _e( 'Options saved.', 'lighthouse' ); ?></strong></p></div>
        <?php
        update_option( 'lighthouse_captcha_enable', sanitize_text_field( $_POST['lighthouse_captcha_enable'] ) );

        if ( isset( $_POST['captcha_login'] ) ) {
            update_option( 'wpcaptcha_login', sanitize_text_field( $_POST['captcha_login'] ) );
        }
        if ( isset( $_POST['captcha_register'] ) ) {
            update_option( 'wpcaptcha_register', sanitize_text_field( $_POST['captcha_register'] ) );
        }
        if ( isset( $_POST['captcha_lost'] ) ) {
            update_option( 'wpcaptcha_lost', sanitize_text_field( $_POST['captcha_lost'] ) );
        }
        if ( isset( $_POST['captcha_comments'] ) ) {
            update_option( 'wpcaptcha_comments', sanitize_text_field( $_POST['captcha_comments'] ) );
        }
        if ( isset( $_POST['captcha_registered'] ) ) {
            update_option( 'wpcaptcha_registered', sanitize_text_field( $_POST['captcha_registered'] ) );
        }
        if ( isset( $_POST['captcha_type'] ) ) {
            update_option( 'wpcaptcha_type', sanitize_text_field( $_POST['captcha_type'] ) );
        }
        if ( isset( $_POST['captcha_letters'] ) ) {
            update_option( 'wpcaptcha_letters', sanitize_text_field( $_POST['captcha_letters'] ) );
        }
        if ( isset( $_POST['total_no_of_characters'] ) ) {
            update_option( 'wpcaptcha_total_no_of_characters', sanitize_text_field( $_POST['total_no_of_characters'] ) );
        }
    }
}
?>
<form method="post" action="">
    <h2><?php _e( 'CAPTCHA Settings', 'lighthouse' ); ?></h2>

    <?php wp_nonce_field( 'wpcatpcha_update_admin_options', 'wpcatpcha_update_admin_options_nonce' ); ?>

    <table class="form-table">
        <tr>
            <th scope="row"><label>Enable CAPTCHA</label></th>
            <td>
                <p>
                    <input type="checkbox" name="lighthouse_captcha_enable" value="1" <?php checked( 1, (int) get_option( 'lighthouse_captcha_enable' ) ); ?>> <label>Enable CAPTCHA module</label>
                </p>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e( 'Appearance', 'lighthouse' ); ?></th>
            <td>
                <select name="total_no_of_characters">
                    <?php for ( $i = 3; $i <= 6; $i++ ) { ?>
                        <option value="<?php echo $i; ?>" <?php selected( $i, (int) get_option( 'wpcaptcha_total_no_of_characters' ) ); ?>><?php echo $i; ?></option>
                    <?php } ?>
                </select>
                <select name="captcha_letters">
                    <option value="capital" <?php selected( 'capital', (string) get_option( 'wpcaptcha_letters' ) ); ?>><?php _e( 'Uppercase', 'lighthouse' ); ?></option>
                    <option value="small" <?php selected( 'small', (string) get_option( 'wpcaptcha_letters' ) ); ?>><?php _e( 'Lowercase', 'lighthouse' ); ?></option>
                    <option value="capitalsmall" <?php selected( 'capitalsmall', (string) get_option( 'wpcaptcha_letters' ) ); ?>><?php _e( 'Uppercase and lowercase', 'lighthouse' ); ?></option>
                </select>
                <select name="captcha_type">
                    <option value="alphanumeric" <?php selected( 'alphanumeric', (string) get_option( 'wpcaptcha_type' ) ); ?>><?php _e( 'Alphanumeric characters', 'lighthouse' ); ?></option>
                    <option value="alphabets" <?php selected( 'alphabets', (string) get_option( 'wpcaptcha_type' ) ); ?>><?php _e( 'Letters', 'lighthouse' ); ?></option>
                    <option value="numbers" <?php selected( 'numbers', (string) get_option( 'wpcaptcha_type' ) ); ?>><?php _e( 'Numbers', 'lighthouse' ); ?></option>
                </select>
            </td>
        </tr>
    </table>

    <h3><?php _e( 'CAPTCHA Display', 'lighthouse' ); ?></h3>

    <table class="form-table">
        <tr>
                <th scope="row"><?php _e( 'Enable for login', 'lighthouse' ); ?></th>
                <td>
                    <select name="captcha_login">
                        <option value="yes" <?php selected( 'yes', (string) get_option( 'wpcaptcha_login' ) ); ?>><?php _e( 'Yes', 'lighthouse' ); ?></option>
                        <option value="no" <?php selected( 'no', (string) get_option( 'wpcaptcha_login' ) ); ?>><?php _e( 'No', 'lighthouse' ); ?></option>
                    </select>
                </td>
        </tr>
        <tr>
            <th scope="row"><?php _e( 'Enable for registration', 'lighthouse' ); ?></th>
            <td>
                <select name="captcha_register">
                    <option value="yes" <?php selected( 'yes', (string) get_option( 'wpcaptcha_register' ) ); ?>><?php _e( 'Yes', 'lighthouse' ); ?></option>
                    <option value="no" <?php selected( 'no', (string) get_option( 'wpcaptcha_register' ) ); ?>><?php _e( 'No', 'lighthouse' ); ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e( 'Enable for password recovery', 'lighthouse' ); ?></th>
            <td>
                <select name="captcha_lost">
                    <option value="yes" <?php selected( 'yes', (string) get_option( 'wpcaptcha_lost' ) ); ?>><?php _e( 'Yes', 'lighthouse' ); ?></option>
                    <option value="no" <?php selected( 'no', (string) get_option( 'wpcaptcha_lost' ) ); ?>><?php _e( 'No', 'lighthouse' ); ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e( 'Enable for comments', 'lighthouse' ); ?></th>
            <td>
                <select name="captcha_comments">
                    <option value="yes" <?php selected( 'yes', (string) get_option( 'wpcaptcha_comments' ) ); ?>><?php _e( 'Yes', 'lighthouse' ); ?></option>
                    <option value="no" <?php selected( 'no', (string) get_option( 'wpcaptcha_comments' ) ); ?>><?php _e( 'No', 'lighthouse' ); ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e( 'Hide for logged-in users', 'lighthouse' ); ?></th>
            <td>
                <select name="captcha_registered">
                    <option value="yes" <?php selected( 'yes', (string) get_option( 'wpcaptcha_registered' ) ); ?>><?php _e( 'Yes', 'lighthouse' ); ?></option>
                    <option value="no" <?php selected( 'no', (string) get_option( 'wpcaptcha_registered' ) ); ?>><?php _e( 'No', 'lighthouse' ); ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <td><?php submit_button(); ?></td>
            <td></td>
        </tr>
    </table>
</form>
