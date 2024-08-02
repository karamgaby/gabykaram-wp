<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( 'Page not found' );
}

$table = $wpdb->prefix . 'lhf_bans';

if ( isset( $_POST['ban-ip'] ) ) {
    $ip     = sanitize_text_field( $_POST['ip'] );
    $date   = date_i18n( get_option( 'date_format' ) );
    $time   = date_i18n( get_option( 'time_format' ) );
    $reason = sanitize_text_field( $_POST['reason'] );

    if ( ! filter_var( $ip, FILTER_VALIDATE_IP ) ) {
        echo '<p>' . __( 'The entered IP address is invalid.', 'lighthouse' ) . '</p>';
    } else {
        $validator = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $table WHERE type = %s AND value = %s LIMIT 1", 'ip', $ip ) );

        if ( $validator > 0 ) {
            echo '<p>' . __( 'This IP address is already banned.', 'lighthouse' ) . '</p>';
        } else {
            add_ban( 'ip', $ip, $date, $time, $reason );
        }
    }
}
?>

<?php
if ( isset( $_GET['editip-id'] ) ) {
    $id = (int) $_GET['editip-id'];

    $row    = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table WHERE id = %d AND type = %s LIMIT 1", $id, 'ip' ) );
    $ips    = $row->value;
    $result = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $table WHERE type = %s AND value = %s LIMIT 1", 'ip', $ips ) );

    if ( empty( $id ) || (int) $result === 0 ) {
        echo '<meta http-equiv="refresh" content="0; url=' . admin_url( 'admin.php?page=lighthouse-firewall&tab=bans' ) . '">';
        exit();
    }

    if ( isset( $_POST['edit-ban'] ) ) {
        $ip     = sanitize_text_field( $_POST['ip'] );
        $reason = sanitize_text_field( $_POST['reason'] );

        if ( ! filter_var( $ip, FILTER_VALIDATE_IP ) ) {
            echo '<p>' . __( 'The entered IP address is invalid.', 'lighthouse' ) . '</p>';
        } else {
            update_ban( $id, $ip, $reason );
        }
    }
    ?>

    <form action="" method="post">
                        <div class="card col-md-12 card-dark">
                            <div class="card-header">
                                <h3 class="card-title"><?php
        echo esc_html__("Edit - IP Address Ban", 'lighthouse');
    ?></h3>
                            </div>
                            <div class="card-body">
                                            <div class="form-group">
                                                <label class="control-label"><?php
        echo esc_html__("IP Address:", 'lighthouse');
    ?> </label>
                                                <div class="col-sm-12">
                                                    <input name="ip" class="form-control" type="text" value="<?php
        echo esc_html($row->value);
    ?>" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label"><?php
        echo esc_html__("Reason:", 'lighthouse');
    ?> </label>
                                                <div class="col-sm-12">
                                                    <input name="reason" class="form-control" type="text" value="<?php
        echo esc_html($row->reason);
    ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label"><?php
        echo esc_html__("Ban Date:", 'lighthouse');
    ?> </label>
                                                <div class="col-sm-12">
                                                    <input name="date" class="form-control" type="text" value="<?php
        echo esc_html($row->date) . ' at ' . esc_html($row->time);
    ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label"><?php
        echo esc_html__("AutoBanned:", 'lighthouse');
    ?> </label>
                                                <div class="col-sm-12">
                                                    <input name="autoban" class="form-control" type="text" value="<?php
        if ($row->autoban == 1) {
            echo 'Yes';
        } else {
            echo 'No';
        }
    ?>" readonly>
                                                </div>
                                            </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-flat btn-success" name="edit-ban" type="submit"><?php
        echo esc_html__("Save", 'lighthouse');
    ?></button>
                            </div>
                        </div>
    </form>
    <?php
}
?>

<h3><?php echo __( 'IP Bans', 'lighthouse' ); ?></h3>

<p>
    <a href="<?php echo admin_url( 'admin.php?page=lighthouse-firewall&tab=bans' ); ?>&delete-all" title="Delete all IP Bans"><?php echo __( 'Delete All', 'lighthouse' ); ?></a>
</p>

<table id="dt-basic3" class="stripe hover order-column row-border" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th><?php echo __( 'IP Address', 'lighthouse' ); ?></th>
            <th><?php echo __( 'Banned On', 'lighthouse' ); ?></th>
            <th><?php echo __( 'Autobanned', 'lighthouse' ); ?></th>
            <th><?php echo __( 'Actions', 'lighthouse' ); ?></th>
        </tr>
    </thead>
    <tbody>

    <?php
    $query = $wpdb->get_results( "SELECT * FROM `$table` WHERE type='ip'" );

    foreach ( $query as $row ) {
        echo '<tr>
            <td>' . $row->value . '</td>
            <td>' . $row->date . '</td>
            <td>';

                if ( (int) $row->autoban === 1 ) {
                    echo 'Yes';
                } else {
                    echo 'No';
                }

            echo '</td>
            <td>
                <a href="' . admin_url( 'admin.php?page=lighthouse-firewall&tab=bans' ) . '&editip-id=' . $row->id . '" class="button button-secondary">' . __( 'Edit', 'lighthouse' ) . '</a>
                <a href="' . admin_url( 'admin.php?page=lighthouse-firewall&tab=bans' ) . '&delete-id=' . $row->id . '" class="button button-secondary">' . __( 'Unban', 'lighthouse' ) . '</a>
            </td>
        </tr>';
    }
    ?>

    </tbody>
</table>

<?php
if ( ! isset( $_GET['ip'] ) ) {
    $ip = '';
} else {
    $ip = sanitize_text_field( $_GET['ip'] );
}
if ( ! isset( $_GET['reason'] ) ) {
    $reason = '';
} else {
    $reason = sanitize_text_field( $_GET['reason'] );
}
?>

<hr>

<h3><?php echo __( 'Ban IP Address', 'lighthouse' ); ?></h3>

<form action="" method="post">
    <p>
        <label><?php echo __( 'IP Address', 'lighthouse' ); ?></label><br>
        <input name="ip" class="regular-text" type="text" value="<?php echo esc_html( $ip ); ?>" required>
    </p>
    <p>
        <label><?php echo __( 'Reason', 'lighthouse' ); ?></label><br>
        <input name="reason" class="regular-text" type="text" value="<?php echo esc_html( $reason ); ?>">
    </p>
    <p>
        <button class="button button-primary" name="ban-ip" type="submit"><?php echo __( 'Ban', 'lighthouse' ); ?></button>
    </p>
</form>
