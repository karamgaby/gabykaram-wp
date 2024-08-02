<?php
if (!defined('ABSPATH')) {
    die('Page not found');
}

if (isset($_POST['add-database'])) {
    $table2   = $wpdb->prefix . 'lhf_dnsbl';
    $database = sanitize_text_field($_POST['database']);
    
    $validator = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM `$table2` WHERE `dnsbl_database` = %s LIMIT 1", $database));
    if ($validator > 0) {
    } else {
        $wpdb->insert($table2, array(
            'dnsbl_database' => $database
        ), array(
            '%s'
        ));
    }
}

if (isset($_POST['spsave'])) {
    
    if (isset($_POST['protection'])) {
        $protection = 1;
    } else {
        $protection = 0;
    }

    if (isset($_POST['protection_sfs'])) {
        $protection_sfs = 1;
    } else {
        $protection_sfs = 0;
    }

    if (isset($_POST['logging'])) {
        $logging = 1;
    } else {
        $logging = 0;
    }
    
    if (isset($_POST['mail'])) {
        $mail = 1;
    } else {
        $mail = 0;
    }
    
    update_option('wpg_spam_protection', $protection);
    update_option('wpg_spam_protection_sfs', $protection_sfs);
    update_option('wpg_spam_logging', $logging);
    update_option('wpg_spam_mail', $mail);
}

$tablesp = $wpdb->prefix . 'lhf_dnsbl';
$countsp = $wpdb->get_var("SELECT COUNT(*) FROM $tablesp");

?>

<div class="lhf--grid lhf--grid-2">
    <div class="lhf--grid-item">
        <h3><?php echo esc_html__("Spam - Protection Module", 'lighthouse'); ?></h3>

        <?php
        if (get_option('wpg_spam_protection') == 1 && $countsp > 0) {
            echo '<h1 class="protmodg"><i class="fas fa-check-circle"></i> ' . esc_html__("Enabled", 'lighthouse') . '</h1>
            <p>' . esc_html__("The website is protected from", 'lighthouse') . ' <strong>' . esc_html__("Spammers", 'lighthouse') . '</strong></p>';
        } else {
            echo '<h1 class="protmodr"><i class="fas fa-times-circle"></i> ' . esc_html__("Disabled", 'lighthouse') . '</h1>
            <p>' . esc_html__("The website is not protected from", 'lighthouse') . ' <strong>' . esc_html__("Spammers", 'lighthouse') . '</strong></p>';
        }
        ?>

        <h3><?php echo esc_html__("Spam Databases (DNSBL)", 'lighthouse'); ?></h3>

        <form method="post">
            <p>
                <label><?php echo esc_html__("Spam Database (DNSBL)", 'lighthouse'); ?></label><br>
                <input type="text" class="regular-text" name="database" required>
                <input class="button button-secondary" name="add-database" type="submit" value="Add Spam Database (DNSBL)">
            </p>
        </form>

        <?php
        if ($countsp > 3) {
            echo '<p>
                ' . esc_html__("It is NOT recommended to use more than ") . '<b>' . esc_html__("3 spam databases") . '</b>' . esc_html__(" because performance and accuracy could be affected in negative way.") . '
            </p>';
        }
        ?>

        <table cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th><?php echo esc_html__("DNSBL Database", 'lighthouse'); ?></th>
                    <th><?php echo esc_html__("Actions", 'lighthouse'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $table2   = $wpdb->prefix . 'lhf_dnsbl';
                $dnsbldbs = $wpdb->get_results("SELECT id, dnsbl_database FROM $table2");
                foreach ($dnsbldbs as $rowd) {
                    echo '<tr>
                        <td>' . esc_html($rowd->dnsbl_database) . '</td>
                        <td>
                        <a href="' . admin_url( 'admin.php?page=lighthouse-firewall&tab=modules' ) . '&delete-id=' . esc_html($rowd->id) . '" class="button button-secondary"><i class="fas fa-trash"></i> ' . esc_html__("Delete", 'lighthouse') . '</a>
                        </td>
                    </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="lhf--grid-item">
        <h3><?php echo esc_html__("What is", 'lighthouse'); ?> Spam & DNSBL</h3>

        <p><?php echo esc_html__("Electronic Spamming is the use of electronic messaging systems to send unsolicited messages (spam), especially advertising, as card card-body bg-light as sending messages repeatedly on the same site.", 'lighthouse'); ?></p>
        <p><?php echo __("A <strong>DNS-based Blackhole List (DNSBL)</strong> or <strong>Real-time Blackhole List (RBL)</strong> is a list of IP addresses which are most often used to publish the addresses of computers or networks linked to spamming.", 'lighthouse'); ?></p>

        <p><?php echo __("All <strong>Blacklists</strong> can be found here", 'lighthouse'); ?>: <strong><a href="https://www.dnsbl.info/dnsbl-list.php" target="_blank">https://www.dnsbl.info/dnsbl-list.php</a></strong></p>

        <h3><?php echo esc_html__("Module Settings", 'lighthouse'); ?></h3>

        <form action="" method="post">
            <p>
                <label>
                    <input type="checkbox" name="protection" <?php checked( 1, (int) get_option( 'wpg_spam_protection' ) ); ?>>
                    <?php echo __( 'Protection', 'lighthouse' ); ?>
                </label>
                <br><small><?php echo __( 'If this protection module is enabled all threats of this type will be blocked', 'lighthouse' ); ?></small>
            </p>
            <p>
                <label>
                    <input type="checkbox" name="protection_sfs" <?php checked( 1, (int) get_option( 'wpg_spam_protection_sfs' ) ); ?>>
                    <?php echo __( 'SFS Module', 'lighthouse' ); ?>
                </label>
                <br><small><?php echo __( 'If this protection module is enabled all user IPs will be checked against StopForumSpam database', 'lighthouse' ); ?></small>
            </p>
            <p>
                <label>
                    <input type="checkbox" name="logging" <?php checked( 1, (int) get_option( 'wpg_spam_logging' ) ); ?>>
                    <?php echo esc_html__("Logging", 'lighthouse'); ?>
                </label>
                <br><small><?php echo esc_html__("Logging every threat of this type", 'lighthouse'); ?></small>
            </p>
            <p>
                <label>
                    <input type="checkbox" name="mail" <?php checked( 1, (int) get_option( 'wpg_spam_mail' ) ); ?>>
                    <?php echo esc_html__("Mail Notifications", 'lighthouse'); ?>
                </label>
                <br><small><?php echo esc_html__("You will receive email notification when threat of this type is detected", 'lighthouse'); ?></small>
            </p>
            <p>
                <button class="button button-primary" name="spsave" type="submit"><?php echo esc_html__("Save", 'lighthouse'); ?></button>
            </p>
        </form>
    </div>
</div>
