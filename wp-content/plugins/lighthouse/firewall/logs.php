<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( 'Page not found' );
}

$table = $wpdb->prefix . 'lhf_logs';

if ( isset( $_GET['delete-id'] ) ) {
    $id = (int) sanitize_text_field( $_GET['delete-id'] );

    $wpdb->delete(
        $table,
        [
            'id' => $id,
        ]
    );
}

if ( isset( $_GET['delete-all'] ) ) {
    $wpdb->query( "TRUNCATE TABLE `$table`" );
}
?>

<h3><?php echo esc_html__( 'Logs', 'lighthouse' ); ?></h3>

<p>
    <a href="<?php echo admin_url( 'admin.php?page=lighthouse-firewall&tab=logs' ); ?>&delete-all" class="button button-secondary"><?php echo __( 'Delete All Logs', 'lighthouse' ); ?></a>
</p>

<table id="dt-basic" class="stripe hover order-column row-border" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th><?php echo __( "IP Address", 'lighthouse' ); ?></th>
            <th><?php echo __( "Type", 'lighthouse' ); ?></th>
            <th><?php echo __( "Date", 'lighthouse' ); ?></th>
            <th><?php echo __( "Browser", 'lighthouse' ); ?></th>
            <th><?php echo __( "OS", 'lighthouse' ); ?></th>
            <th><?php echo __( "Country", 'lighthouse' ); ?></th>
            <th><?php echo __( "Actions", 'lighthouse' ); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = $wpdb->get_results( "SELECT id, ip, date, time, browser, browser_code, os, os_code, country, country_code, type FROM `$table` ORDER by id DESC" );

        foreach ( $query as $row ) {
            echo '<tr>
                <td><code>' . esc_html( $row->ip ) . '</code></td>
                <td>';

                    if ( $row->type === 'SQLi' ) {
                        echo '<i class="fas fa-code"></i> ' . esc_html( $row->type );
                    } elseif ( $row->type === 'Proxy' ) {
                        echo '<i class="fas fa-globe"></i> ' . esc_html( $row->type );
                    } elseif ( $row->type === 'Spammer' ) {
                        echo '<i class="fas fa-keyboard"></i> ' . esc_html( $row->type );
                    } else {
                        echo '<i class="fas fa-user-secret"></i> ' . esc_html( $row->type );
                    }

                echo '</td>
                <td data-sort="' . esc_html( $row->date ) . ', ' . $row->time . '">' . $row->date . ', ' . $row->time . '</td>
                <td>' . esc_html( $row->browser ) . '</td>
                <td>' . esc_html( $row->os ) . '</td>
                <td>' . esc_html( $row->country ) . '</td>
                <td>
                    <a href="' . admin_url( 'admin.php?page=lighthouse-firewall&tab=log' ) . '&id=' . esc_html( $row->id ) . '">Details</a>
                </td>
            </tr>';
        }
        ?>
    </tbody>
</table>
