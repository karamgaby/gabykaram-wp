<?php
if (!defined('ABSPATH')) {
    die('Page not found');
}

if (isset($_POST['ssave2'])) {
    
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
    
    if (isset($_POST['protection4'])) {
        $protection4 = 1;
    } else {
        $protection4 = 0;
    }
    
    if (isset($_POST['protection5'])) {
        $protection5 = 1;
    } else {
        $protection5 = 0;
    }
    
    if (isset($_POST['protection6'])) {
        $protection6 = 1;
    } else {
        $protection6 = 0;
    }
    
    update_option('wpg_sqli_protection2', $protection2);
    update_option('wpg_sqli_protection3', $protection3);
    update_option('wpg_sqli_protection4', $protection4);
    update_option('wpg_sqli_protection5', $protection5);
    update_option('wpg_sqli_protection6', $protection6);
    
}

if (isset($_POST['ssave'])) {
    
    if (isset($_POST['protection'])) {
        $protection = 1;
    } else {
        $protection = 0;
    }
    
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
    
    update_option('wpg_sqli_protection', $protection);
    update_option('wpg_sqli_logging', $logging);
    update_option('wpg_sqli_autoban', $autoban);
    update_option('wpg_sqli_mail', $mail);
}
?>

<div class="lhf--grid lhf--grid-2">
    <div class="lhf--grid-item">
        <h3><?php echo esc_html__("SQL Injection - Protection Module", 'lighthouse'); ?></h3>

        <?php
        if (get_option('wpg_sqli_protection') == 1) {
            echo '<h1 class="protmodg"><i class="fas fa-check-circle"></i> ' . esc_html__("Enabled", 'lighthouse') . '</h1>
            <p>' . esc_html__("The website is protected from", 'lighthouse') . ' <strong>' . esc_html__("SQL Injection Attacks (SQLi)", 'lighthouse') . '</strong></p>';
        } else {
            echo '<h1 class="protmodr"><i class="fas fa-times-circle"></i> ' . esc_html__("Disabled", 'lighthouse') . '</h1>
            <p>' . esc_html__("The website is not protected from", 'lighthouse') . ' <strong>' . esc_html__("SQL Injection Attacks (SQLi)", 'lighthouse') . '</strong></p>';
        }
        ?>

        <h3><?php echo esc_html__("Additional Protection Modules", 'lighthouse'); ?></h3>

        <form action="" method="post">
            <p>
                <label>
                    <input type="checkbox" name="protection2" <?php checked( 1, (int) get_option( 'wpg_sqli_protection2' ) ); ?>>
                    <?php echo esc_html__("XSS Protection", 'lighthouse'); ?>
                </label>
                <br><small><?php echo esc_html__("Sanitizes infected requests", 'lighthouse'); ?></small>
            </p>
            <p>
                <label>
                    <input type="checkbox" name="protection3" <?php checked( 1, (int) get_option( 'wpg_sqli_protection3' ) ); ?>>
                    <?php echo esc_html__("Clickjacking Protection", 'lighthouse'); ?>
                </label>
                <br><small><?php echo esc_html__("Detecting and blocking clickjacking attempts", 'lighthouse'); ?></small>
            </p>
            <p>
                <label>
                    <input type="checkbox" name="protection6" <?php checked( 1, (int) get_option( 'wpg_sqli_protection6' ) ); ?>>
                    <?php echo esc_html__("Hide PHP Information", 'lighthouse'); ?>
                </label>
                <br><small><?php echo esc_html__("Hides the PHP version to remote requests", 'lighthouse'); ?></small>
            </p>
            <p>
                <label>
                    <input type="checkbox" name="protection4" <?php checked( 1, (int) get_option( 'wpg_sqli_protection4' ) ); ?>>
                    <?php echo esc_html__("MIME Mismatch Attacks Protection", 'lighthouse'); ?>
                </label>
                <br><small><?php echo esc_html__("Prevents attacks based on MIME-type mismatch", 'lighthouse'); ?></small>
            </p>
            <p>
                <label>
                    <input type="checkbox" name="protection5" <?php checked( 1, (int) get_option( 'wpg_sqli_protection5' ) ); ?>>
                    <?php echo esc_html__("Secure Connection", 'lighthouse'); ?>
                </label>
                <br><small><?php echo esc_html__("Forces the website to use secure connection (HTTPS)", 'lighthouse'); ?></small>
            </p>
            <p>
                <button class="button button-primary" name="ssave2" type="submit"><?php echo esc_html__("Save", 'lighthouse'); ?></button>
            </p>
        </form>
    </div>
    <div class="lhf--grid-item">
        <h3><?php echo esc_html__("What is SQL Injection", 'lighthouse'); ?></h3>

        <p><?php echo esc_html__("SQL Injection is a technique where malicious users can inject SQL commands into an SQL statement, via web page input. Injected SQL commands can alter SQL statement and compromise the security of a web application.", 'lighthouse'); ?></p>

        <h3><?php echo esc_html__("Module Settings", 'lighthouse'); ?></h3>

        <form action="" method="post">
            <p>
                <label>
                    <input type="checkbox" name="protection" <?php checked( 1, (int) get_option( 'wpg_sqli_protection' ) ); ?>>
                    <?php echo esc_html__("Protection", 'lighthouse'); ?>
                </label>
                <br><small><?php echo esc_html__("If this protection module is enabled all threats of this type will be blocked", 'lighthouse'); ?></small>
            </p>
            <p>
                <label>
                    <input type="checkbox" name="logging" <?php checked( 1, (int) get_option( 'wpg_sqli_logging' ) ); ?>>
                    <?php echo esc_html__("Logging", 'lighthouse'); ?>
                </label>
                <br><small><?php echo esc_html__("Logging every threat of this type", 'lighthouse'); ?></small>
            </p>
            <p>
                <label>
                    <input type="checkbox" name="autoban" <?php checked( 1, (int) get_option( 'wpg_sqli_autoban' ) ); ?>>
                    <?php echo esc_html__("AutoBan", 'lighthouse'); ?>
                </label>
                <br><small><?php echo esc_html__("Automatically ban anyone who is detected as this type of threat", 'lighthouse'); ?></small>
            </p>
            <p>
                <label>
                    <input type="checkbox" name="mail" <?php checked( 1, (int) get_option( 'wpg_sqli_mail' ) ); ?>>
                    <?php echo esc_html__("Mail Notifications", 'lighthouse'); ?>
                </label>
                <br><small><?php echo esc_html__("You will receive email notification when threat of this type is detected", 'lighthouse'); ?></small>
            </p>
            <p>
                <button class="button button-primary" name="ssave" type="submit"><?php echo esc_html__("Save", 'lighthouse'); ?></button>
            </p>
        </form>
    </div>
</div>
