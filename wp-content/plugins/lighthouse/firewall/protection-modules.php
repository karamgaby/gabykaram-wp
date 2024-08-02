<?php
if (!defined('ABSPATH')) {
    die('Page not found');
}

if (isset($_GET['delete-id'])) {
    $id = (int) $_GET["delete-id"];
    
    $table2 = $wpdb->prefix . 'lhf_dnsbl';
    $wpdb->delete($table2, array(
        'id' => $id
    ));
}

include_once 'sqli-protection.php';
include_once 'badbots-protection.php';
include_once 'proxy-protection.php';
include_once 'spam-protection.php';
