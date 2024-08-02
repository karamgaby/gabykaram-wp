<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( 'Page not found' );
}

if ( isset( $_POST['save'] ) ) {
    if ( isset( $_POST['mail_notifications'] ) ) {
        $mail_notifications = 1;
    } else {
        $mail_notifications = 0;
    }

    update_option( 'wpg_mail_notifications', $mail_notifications );
    update_option( 'wpg_admin_email', sanitize_email( $_POST['wpg_admin_email'] ) );
}
?>

<h3><?php echo __( 'Settings', 'lighthouse' ); ?></h3>

<form method="post">
    <table class="form-table">
        <tr>
            <th scope="row"><label>Email Notifications</label></th>
            <td>
                <p>
                    <input type="checkbox" name="mail_notifications" value="1" <?php checked( 1, (int) get_option( 'wpg_mail_notifications' ) ); ?>>
                    <label><?php echo __( 'Enable Email Notifications', 'lighthouse' ); ?></label>
                    <br><small><?php echo __( 'If this is enabled, you will receive notifications at the email address below.', 'lighthouse' ); ?></small>
                </p>
                <p>
                    <label><?php echo __( 'Email Address', 'lighthouse' ); ?></label><br>
                    <input type="email" class="regular-text" name="wpg_admin_email" value="<?php echo get_option( 'wpg_admin_email' ); ?>">
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button class="button button-primary" name="save" type="submit"><?php echo __( 'Save Changes', 'lighthouse' ); ?></button>
            </td>
        </tr>
    </table>
</form>
