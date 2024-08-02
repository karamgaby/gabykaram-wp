<?php
if (!defined('ABSPATH')) {
    die('Page not found');
}

if (isset($_POST['bsave2'])) {
    
    if (isset($_POST['protection'])) {
        $protection = 1;
    } else {
        $protection = 0;
    }
    
    if (isset($_POST['protection2'])) {
        $protection2 = 1;
    } else {
        $protection2 = 0;
    }
    
    if (isset($_POST['protection3'])) {
        $protection3 = 1;
    } else {
        $protection3 = 0;
    }
    
    update_option('wpg_badbot_protection', $protection);
    update_option('wpg_badbot_protection2', $protection2);
    update_option('wpg_badbot_protection3', $protection3);
}

if (isset($_POST['bsave'])) {
    
    if (isset($_POST['logging'])) {
        $logging = 1;
    } else {
        $logging = 0;
    }
    
    if (isset($_POST['autoban'])) {
        $autoban = 1;
    } else {
        $autoban = 0;
    }
    
    if (isset($_POST['mail'])) {
        $mail = 1;
    } else {
        $mail = 0;
    }
    
    update_option('wpg_badbot_logging', $logging);
    update_option('wpg_badbot_autoban', $autoban);
    update_option('wpg_badbot_mail', $mail);
}
?>

<div class="lhf--grid lhf--grid-2">
    <div class="lhf--grid-item">
        <h3><?php echo esc_html__("Bad Bots - Protection Module", 'lighthouse'); ?></h3>

        <?php
        if (get_option('wpg_badbot_protection') == 1 OR get_option('wpg_badbot_protection2') == 1 OR get_option('wpg_badbot_protection3') == 1) {
            echo '<h1 class="protmodg"><i class="fas fa-check-circle"></i> ' . esc_html__("Enabled", 'lighthouse') . '</h1>
            <p>' . esc_html__("The website is protected from", 'lighthouse') . ' <strong>Bad Bots</strong></p>';
        } else {
            echo '<h1 class="protmodr"><i class="fas fa-times-circle"></i> ' . esc_html__("Disabled", 'lighthouse') . '</h1>
            <p>' . esc_html__("The website is not protected from", 'lighthouse') . ' <strong>Bad Bots</strong></p>';
        }
        ?>

        <h3><?php echo esc_html__("Protection Modules", 'lighthouse'); ?></h3>

        <form action="" method="post">
            <p>
                <label>
                    <input type="checkbox" name="protection" <?php checked( 1, (int) get_option( 'wpg_badbot_protection' ) ); ?>>
                    <?php echo esc_html__("Bad Bots", 'lighthouse'); ?>
                </label>
                <br><small><?php echo __("Detects the <b>bad bots</b> and blocks their access to the website", 'lighthouse'); ?></small>
            </p>
            <p>
                <label>
                    <input type="checkbox" name="protection2" <?php checked( 1, (int) get_option( 'wpg_badbot_protection2' ) ); ?>>
                    <?php echo esc_html__("Fake Bots", 'lighthouse'); ?>
                </label>
                <br><small><?php echo __("Detects the <b>fake bots</b> and blocks their access to the website", 'lighthouse'); ?></small>
            </p>
            <p>
                <label>
                    <input type="checkbox" name="protection3" <?php checked( 1, (int) get_option( 'wpg_badbot_protection3' ) ); ?>>
                    <?php echo esc_html__("Anonymous Bots", 'lighthouse'); ?>
                </label>
                <br><small><?php echo __("Detects the <b>anonymous bots</b> and blocks their access to the website", 'lighthouse'); ?></small>
            </p>
            <p>
                <button class="button button-primary" name="bsave2" type="submit"><?php echo esc_html__("Save", 'lighthouse'); ?></button>
            </p>
        </form>
    </div>
    <div class="lhf--grid-item">
        <h3><?php echo esc_html__("What is Bad Bot", 'lighthouse'); ?></h3>

        <p><?php echo __("<strong>Bad</strong>, <strong>Fake</strong> and <strong>Anonymous Bots</strong> are bots that consume bandwidth, slow down your server, steal your content and look for vulnerability to compromise your server.", 'lighthouse'); ?></p>

        <h3><?php echo esc_html__("Module Settings", 'lighthouse'); ?></h3>

        <form action="" method="post">
            <p>
                <label>
                    <input type="checkbox" name="logging" <?php checked( 1, (int) get_option( 'wpg_badbot_logging' ) ); ?>>
                    <?php echo esc_html__("Logging", 'lighthouse'); ?>
                </label>
                <br><small><?php echo __("Logging every threat of this type", 'lighthouse'); ?></small>
            </p>
            <p>
                <label>
                    <input type="checkbox" name="autoban" <?php checked( 1, (int) get_option( 'wpg_badbot_autoban' ) ); ?>>
                    AutoBan
                </label>
                <br><small><?php echo __("Automatically ban anyone who is detected as this type of threat", 'lighthouse'); ?></small>
            </p>
            <p>
                <label>
                    <input type="checkbox" name="mail" <?php checked( 1, (int) get_option( 'wpg_badbot_mail' ) ); ?>>
                    Mail Notifications
                </label>
                <br><small><?php echo __("You will receive email notification when threat of this type is detected", 'lighthouse'); ?></small>
            </p>
            <p>
                <button class="button button-primary" name="bsave" type="submit"><?php echo esc_html__("Save", 'lighthouse'); ?></button>
            </p>
        </form>
    </div>
</div>
