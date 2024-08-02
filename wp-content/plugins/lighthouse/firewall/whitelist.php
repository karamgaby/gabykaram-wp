<?php
if (!defined('ABSPATH')) {
    die('Page not found');
}

$table = $wpdb->prefix . 'lhf_ipwhitelist';

if (isset($_GET['delete-id'])) {
    $id = (int) $_GET["delete-id"];
    
    $wpdb->delete($table, array(
        'id' => $id
    ));
}

if (isset($_POST['add-ip'])) {
    $ip    = sanitize_text_field($_POST['ip']);
    $notes = sanitize_text_field($_POST['notes']);
    
    $validator = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM `$table` WHERE `ip` = %s LIMIT 1", $ip));
    if ($validator > 0) {
        echo '<br />
		<div class="callout callout-info">
                <p><i class="fas fa-info-circle"></i> ' . balanceTags("This <strong>IP Address</strong> is already whitelisted.", 'lighthouse') . '</p>
        </div>';
    } else {
        $wpdb->insert($table, array(
            'ip' => $ip,
            'notes' => $notes
        ), array(
            '%s',
            '%s'
        ));
    }
}
?>

<?php
if ( isset( $_GET['edit-id'] ) ) {
    $id = (int) $_GET['edit-id'];

    $result = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(id) FROM `$table` WHERE `id` = %d LIMIT 1", $id ) );

    if ( empty( $id ) || (int) $result === 0 ) {
        echo '<meta http-equiv="refresh" content="0; url=' . admin_url( 'admin.php?page=lighthouse-firewall&tab=whitelist' ) . '">';
        exit();
    }

    $srow = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table WHERE id = %d LIMIT 1", $id ) );

    if ( isset( $_POST['edit-ip'] ) ) {
        $ip    = sanitize_text_field( $_POST['ip'] );
        $notes = sanitize_text_field( $_POST['notes'] );

        $data_update = [
            'ip'    => $ip,
            'notes' => $notes,
        ];
        $data_where  = [
            'id' => $id,
        ];
        $wpdb->update( $table, $data_update, $data_where );

        echo '<meta http-equiv="refresh" content="0; url=' . admin_url( 'admin.php?page=lighthouse-firewall&tab=whitelist' ) . '">';
    }
    ?>
    <form action="" method="post">
        <h3><?php echo esc_html__("Edit IP Address", 'lighthouse'); ?></h3>

        <p>
            <label><?php echo esc_html__("IP Address", 'lighthouse'); ?></label><br>
            <input type="text" name="ip" class="regular-text" value="<?php echo esc_html($srow->ip); ?>" required>
        </p>
        <p>
            <label><?php echo esc_html__("Notes", 'lighthouse'); ?></label><br>
            <textarea rows="4" name="notes" class="large-text" placeholder="<?php echo esc_html__("Additional (descriptive) information can be added here", 'lighthouse'); ?>"><?php echo esc_html($srow->notes); ?></textarea>
        </p>
        <p>
            <button class="button button-primary" name="edit-ip" type="submit"><?php echo esc_html__("Save", 'lighthouse'); ?></button>
        </p>
    </form>
    <?php
}
?>

<h3><?php echo esc_html__("IP Whitelist", 'lighthouse'); ?></h3>

<table id="dt-basic" class="stripe hover order-column row-border" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th><i class="fas fa-user"></i> <?php echo esc_html__("IP Address", 'lighthouse'); ?></th>
            <th><i class="fas fa-clipboard"></i> <?php echo esc_html__("Notes", 'lighthouse'); ?></th>
            <th><i class="fas fa-cog"></i> <?php echo esc_html__("Actions", 'lighthouse'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = $wpdb->get_results("SELECT * FROM `$table`");
        foreach ($query as $row) {
            echo '<tr>
				<td><code>' . $row->ip . '</code></td>
				<td>' . esc_html( $row->notes ) . '</td>
				<td>
                    <a href="' . admin_url( 'admin.php?page=lighthouse-firewall&tab=whitelist' ) . '&edit-id=' . $row->id . '">' . __( 'Edit', 'lighthouse' ) . '</a> | 
                    <a href="' . admin_url( 'admin.php?page=lighthouse-firewall&tab=whitelist' ) . '&delete-id=' . $row->id . '">' . __( 'Delete', 'lighthouse' ) . '</a>
				</td>
			</tr>';
        }
        ?>
    </tbody>
</table>

<h3><?php echo esc_html__("Add IP Adress", 'lighthouse'); ?></h3>

<form action="" method="post">
    <p>
        <label><?php echo esc_html__("IP Address", 'lighthouse'); ?></label><br>
        <input type="text" name="ip" class="regular-text" required>
    </p>
    <p>
        <label><?php echo esc_html__("Notes", 'lighthouse'); ?></label><br>
        <textarea rows="5" name="notes" class="large-text" placeholder="<?php echo esc_html__("Additional (descriptive) information can be added here", 'lighthouse'); ?>"></textarea>
    </p>
    <p>
        <button class="button button-primary" name="add-ip" type="submit"><?php echo esc_html__("Add", 'lighthouse'); ?></button>
    </p>
</form>            
