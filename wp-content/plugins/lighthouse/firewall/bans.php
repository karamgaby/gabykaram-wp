<?php
if (!defined('ABSPATH')) {
    die('Page not found');
}

$table = $wpdb->prefix . 'lhf_bans';

global $id, $date, $time, $reason;

if (isset($_GET['delete-all'])) {
    $wpdb->delete($table, array(
        'type' => 'ip'
    ));
}

if (isset($_GET['delete-id'])) {
    $id = (int) $_GET["delete-id"];
    
    $wpdb->delete($table, array(
        'id' => $id
    ));
}

function add_ban($btype, $bvalue, $date, $time, $reason)
{
    global $wpdb, $date, $time, $reason;
    
    $table = $wpdb->prefix . 'lhf_bans';
    
    $data   = array(
        'type' => $btype,
        'value' => $bvalue,
        'date' => $date,
        'time' => $time,
        'reason' => $reason
    );
    $format = array(
        '%s',
        '%s',
        '%s',
        '%s',
        '%s'
    );
    $wpdb->insert($table, $data, $format);
}

function update_ban($id, $bvalue, $reason)
{
    global $wpdb, $id, $reason;
    
    $table = $wpdb->prefix . 'lhf_bans';
    
    $data_update = array(
        'value' => $bvalue,
        'reason' => $reason
    );
    $data_where  = array(
        'id' => $id
    );
    $wpdb->update($table, $data_update, $data_where);
}
?>

<div class="lhf--grid lhf--grid-2">
    <div class="lhf--grid-item">
        <?php include_once 'bans-ip.php'; ?>
    </div>
    <div class="lhf--grid-item">
        <?php include_once 'bans-iprange.php'; ?>
    </div>
</div>
