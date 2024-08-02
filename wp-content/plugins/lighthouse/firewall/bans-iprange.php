<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( 'Page not found' );
}

$table = $wpdb->prefix . 'lhf_bans';

if ( isset( $_POST['ban-iprange'] ) ) {
    $iprange = sanitize_text_field( $_POST['ip_range'] );
    $date    = date_i18n( get_option( 'date_format' ) );
    $time    = date_i18n( get_option( 'time_format' ) );
    $reason  = '';

    $validator = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $table WHERE type = %s AND value = %s LIMIT 1", 'ip_range', $iprange ) );

    if ( $validator > 0 ) {
        echo '<p>' . __( 'This IP range is already banned.', 'lighthouse' ) . '</p>';
    } else {
        add_ban( 'ip_range', $iprange, $date, $time, $reason );
    }
}

if ( isset( $_GET['editiprange-id'] ) ) {
    $id = (int) $_GET['editiprange-id'];

    $row      = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table WHERE id = %d AND type = %s LIMIT 1", $id, 'ip_range' ) );
    $ipranges = $row->value;
    $result   = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $table WHERE type = %s AND value = %s LIMIT 1", 'ip_range', $ipranges ) );

    if ( empty( $id ) || (int) $result === 0 ) {
        echo '<meta http-equiv="refresh" content="0; url=' . admin_url( 'admin.php?page=lighthouse-firewall&tab=bans' ) . '&a=3">';
        exit();
    }

    if ( isset( $_POST['edit-ban'] ) ) {
        $iprange = sanitize_text_field( $_POST['ip_range'] );
        $reason  = '';

        update_ban( $id, $iprange, $reason );
    }
    ?>

    <form action="" method="post">
        <h3><?php echo __( 'Edit - IP Range Ban', 'lighthouse' ); ?></h3>

        <p>
            <label><?php echo __( 'IP Range', 'lighthouse' ); ?></label><br>
            <input name="ip_range" class="regular-text" type="text" maxlength="19" value="<?php echo esc_html( $row->value ); ?>" required>
        </p>
        <p>
            <button class="button button-primary" name="edit-ban" type="submit"><?php echo __( 'Save', 'lighthouse' ); ?></button>
        </p>
    </form>
    <?php
}
?>

<h3><?php echo __( 'IP Range Bans', 'lighthouse' ); ?></h3>

<table id="dt-basic2" class="stripe hover order-column row-border" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th><?php echo __( 'IP Range', 'lighthouse' ); ?></th>
            <th><?php echo __( 'Actions', 'lighthouse' ); ?></th>
        </tr>
    </thead>
    <tbody>

    <?php
    $query = $wpdb->get_results( "SELECT * FROM `$table` WHERE type='ip_range'" );

    foreach ( $query as $row ) {
        echo '<tr>
            <td>' . esc_html( $row->value ) . '</td>
            <td>
                <a href="' . admin_url( 'admin.php?page=lighthouse-firewall&tab=bans' ) . '&a=3&editiprange-id=' . esc_html( $row->id ) . '" class="button button-secondary">' . __( 'Edit', 'lighthouse' ) . '</a>
                <a href="' . admin_url( 'admin.php?page=lighthouse-firewall&tab=bans' ) . '&a=3&delete-id=' . esc_html( $row->id ) . '" class="button button-secondary">' . __( 'Unban', 'lighthouse' ) . '</a>
            </td>
        </tr>';
    }
    ?>

    </tbody>
</table>

<hr>

<h3><?php echo __( 'Ban IP Range', 'lighthouse' ); ?></h3>

<form action="" method="post">
    <p>
        <label><?php echo __( 'IP Range', 'lighthouse' ); ?></label><br>
        <input name="ip_range" class="regular-text" type="text" placeholder="Format: 12.34.56 or 1111:db8:3333:4444" maxlength="19" value="" required>
    </p>
    <p>
        <button class="button button-primary" name="ban-iprange" type="submit"><?php echo __( 'Ban', 'lighthouse' ); ?></button>
    </p>
</form>
