<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( 'Page not found' );
}

$table = $wpdb->prefix . 'lhf_loginhistory';
?>

<h2><?php echo __( 'Login History', 'lighthouse' ); ?></h2>

<form method="post">
    <table id="dt-basic" class="stripe hover order-column row-border" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th><?php echo __( 'Username', 'lighthouse' ); ?></th>
                <th><?php echo __( 'IP Address', 'lighthouse' ); ?></th>
                <th><?php echo __( 'Date', 'lighthouse' ); ?></th>
                <th><?php echo __( 'Time', 'lighthouse' ); ?></th>
                <th><?php echo __( 'Login Status', 'lighthouse' ); ?></th>
            </tr>
        </thead>
        <tbody>

        <?php
        $query = $wpdb->get_results( "SELECT id, username, ip, date, time, successful FROM `$table` ORDER by date DESC" );

        foreach ( $query as $row ) {
            echo '<tr>
                <td>' . esc_html( $row->username ) . '</td>
                <td><code>' . $row->ip . '</code></td>
                <td data-order="' . strtotime( $row->date ) . '">' . esc_html( $row->date ) . '</td>
                <td>' . esc_html( $row->time ) . '</td>
                <td>';

                if ( (int) $row->successful === 1 ) {
                    echo '<span class="badge badge-success">' . esc_html__( 'Success', 'lighthouse' ) . '</span>';
                } else {
                    echo '<span class="badge badge-danger">' . esc_html__( 'Fail', 'lighthouse' ) . '</span>';
                }

                echo '</td>
            </tr>';
        }
        ?>
        </tbody>
    </table>
</form>
