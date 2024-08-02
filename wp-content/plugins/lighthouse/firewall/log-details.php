<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( 'Page not found' );
}

if ( isset( $_GET['id'] ) ) {
    $table  = $wpdb->prefix . 'lhf_logs';
    $id     = (int) sanitize_text_field( $_GET['id'] );
    $result = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(id) FROM `$table` WHERE `id` = %d LIMIT 1", $id ) );

    if ( empty( $id ) ) {
        echo '<meta http-equiv="refresh" content="0; url=' . admin_url( 'admin.php?page=lighthouse-firewall&tab=logs' ) . '">';
        exit();
    }
    if ( (int) $result === 0 ) {
        echo '<meta http-equiv="refresh" content="0; url=' . admin_url( 'admin.php?page=lighthouse-firewall&tab=logs' ) . '">';
        exit();
    }
    $row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table WHERE id = %d LIMIT 1", $id ) );
    ?>

    <h3><?php echo __( 'Log', 'lighthouse' ); ?> #<?php echo esc_html( $row->id ) . __( ' - Details', 'lighthouse' ); ?></h3>

    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row"><label><?php echo __( 'IP Address', 'lighthouse' ); ?></label></th>
                <td>
                    <input type="text" class="regular-text code" value="<?php echo esc_html( $row->ip ); ?>" readonly>

                    <?php
                    if ( (int) lighthouse_fw_get_banned( $row->ip ) === 1 ) {
                        echo '<a href="' . admin_url( 'admin.php?page=lighthouse-firewall&tab=bans' ) . '&delete-id=' . lighthouse_fw_get_banned_id( $row->ip ) . '" class="button button-secondary">' . esc_html__( 'Unban', 'lighthouse' ) . '</a>';
                    } else {
                        echo '<a href="' . admin_url( 'admin.php?page=lighthouse-firewall&tab=bans' ) . '&ip=' . esc_html( $row->ip ) . '&reason=' . esc_html( $row->type ) . '" class="button button-secondary">' . __( 'Ban', 'lighthouse' ) . '</a>';
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><label><?php echo __( 'Date & Time', 'lighthouse' ); ?></label></th>
                <td><input type="text" class="regular-text code" value="<?php echo esc_html( $row->date ) . ', ' . esc_html( $row->time ); ?>" readonly></td>
            </tr>
            <tr>
                <th scope="row"><label><?php echo __( 'Browser', 'lighthouse' ); ?></label></th>
                <td><input type="text" class="regular-text" value="<?php echo esc_html( $row->browser ); ?>" readonly></td>
            </tr>
            <tr>
                <th scope="row"><label><?php echo __( 'Operating System', 'lighthouse' ); ?></label></th>
                <td><input type="text" class="regular-text" value="<?php echo esc_html( $row->os ); ?>" readonly></td>
            </tr>
            <tr>
                <th scope="row"><label><?php echo __( 'Country', 'lighthouse' ); ?></label></th>
                <td><input type="text" class="regular-text" value="<?php echo esc_html( $row->country ); ?>" readonly></td>
            </tr>
            <tr>
                <th scope="row"><label><?php echo __( 'Region', 'lighthouse' ); ?></label></th>
                <td><input type="text" class="regular-text" value="<?php echo esc_html( $row->region ); ?>" readonly></td>
            </tr>
            <tr>
                <th scope="row"><label><?php echo __( 'City', 'lighthouse' ); ?></label></th>
                <td><input type="text" class="regular-text" value="<?php echo esc_html( $row->city ); ?>" readonly></td>
            </tr>
            <tr>
                <th scope="row"><label><?php echo __( 'Internet Service Provider', 'lighthouse' ); ?></label></th>
                <td><input type="text" class="regular-text" value="<?php echo esc_html( $row->isp ); ?>" readonly></td>
            </tr>
            <tr>
                <th scope="row"><label><?php echo __( 'Potential Threat Type', 'lighthouse' ); ?></label></th>
                <td><input type="text" class="regular-text" value="<?php echo esc_html( $row->type ); ?>" readonly></td>
            </tr>
            <tr>
                <th scope="row"><label><?php echo __( 'Banned', 'lighthouse' ); ?></label></th>
                <td><input type="text" class="regular-text" value="<?php echo ( (int) lighthouse_fw_get_banned( $row->ip ) === 0 ) ? 'No' : 'Yes'; ?>" readonly></td>
            </tr>
            <tr>
                <th scope="row"><label><?php echo __( 'Referer URL', 'lighthouse' ); ?></label></th>
                <td><input type="text" class="regular-text" value="<?php echo esc_html( $row->referer_url ); ?>" readonly></td>
            </tr>
            <tr>
                <th scope="row"><label><?php echo __( 'User Agent', 'lighthouse' ); ?></label></th>
                <td><input type="text" class="regular-text" value="<?php echo esc_html( $row->useragent ); ?>" readonly></td>
            </tr>
            <tr>
                <th scope="row"><label><?php echo __( 'Accessed Page/URL', 'lighthouse' ); ?></label></th>
                <td><input type="text" class="regular-text" value="<?php echo esc_html( $row->page ); ?>" readonly></td>
            </tr>
            <tr>
                <th scope="row"><label><?php echo __( 'Query', 'lighthouse' ); ?></label></th>
                <td><input type="text" class="regular-text" value="<?php echo esc_html( $row->query ); ?>" readonly></td>
            </tr>
        </tbody>
    </table>
    <?php
} else {
    echo '<meta http-equiv="refresh" content="0; url=' . admin_url( 'admin.php?page=lighthouse-firewall&tab=logs' ) . '">';
    exit();
}
