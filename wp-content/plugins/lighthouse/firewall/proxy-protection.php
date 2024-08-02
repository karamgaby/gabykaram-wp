<?php
if (!defined('ABSPATH')) {
    die('Page not found');
}

if (isset($_GET['api'])) {
    
    $apid = (int) $_GET['api'];
    
    if ($apid == 0 || $apid == 1 || $apid == 2 || $apid == 3) {

		update_option('wpg_proxy_protection', $apid);
		
		$files = glob(plugin_dir_path(__FILE__) . 'modules/cache/proxy/*'); // Get all cache file names
		foreach($files as $file){ // Iterate cache files
			if(is_file($file)) {
				unlink($file); // Delete cache file
			}
		}
    }
}

if (isset($_POST['psave2'])) {
    
    if (isset($_POST['protection2'])) {
        $protection2 = 1;
    } else {
        $protection2 = 0;
    }
    
    update_option('wpg_proxy_protection2', $protection2);
	
	if (get_option('wpg_proxy_protection') > 0) {
		$apiks   = 'wpg_proxy_api' . get_option('wpg_proxy_protection');

		$api_key = sanitize_text_field($_POST['apikey']);
		update_option($apiks, $api_key);
		
		$files = glob(plugin_dir_path(__FILE__) . 'modules/cache/proxy/*'); // Get all cache file names
		foreach($files as $file){ // Iterate cache files
			if(is_file($file)) {
				unlink($file); // Delete cache file
			}
		}
	}
}

if (isset($_POST['psave'])) {
    
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
    
    update_option('wpg_proxy_logging', $logging);
    update_option('wpg_proxy_mail', $mail);
}
?>

<div class="lhf--grid lhf--grid-2">
    <div class="lhf--grid-item">
        <h3><?php echo esc_html__("Proxy - Protection Module", 'lighthouse'); ?></h3>

        <?php
        if (get_option('wpg_proxy_protection') > 0 OR get_option('wpg_proxy_protection2') == 1) {
            echo '<h1 class="protmodg"><i class="fas fa-check-circle"></i> ' . esc_html__("Enabled", 'lighthouse') . '</h1>
            <p>' . esc_html__("The website is protected from", 'lighthouse') . ' <strong>' . esc_html__("Proxies", 'lighthouse') . '</strong></p>';
        } else {
            echo '<h1 class="protmodr"><i class="fas fa-times-circle"></i> ' . esc_html__("Disabled", 'lighthouse') . '</h1>
            <p>' . esc_html__("The website is not protected from", 'lighthouse') . ' <strong>' . esc_html__("Proxies", 'lighthouse') . '</strong></p>';
        }
        ?>

        <h3><?php echo esc_html__("Proxy Detection Methods", 'lighthouse'); ?></h3>

        <form action="" method="post">
            <h5><?php echo esc_html__("Detection Method #1", 'lighthouse'); ?></h5>

            <p>
                <select name="wpg_proxy_protection" id="wpg_proxy_protection">
                    <option value="0" <?php selected( 0, (int) get_option( 'wpg_proxy_protection' ) ); ?>>Disabled</option>
                    <option value="1" <?php selected( 1, (int) get_option( 'wpg_proxy_protection' ) ); ?>>IPHub</option>
                    <option value="2" <?php selected( 2, (int) get_option( 'wpg_proxy_protection' ) ); ?>>ProxyCheck</option>
                    <option value="3" <?php selected( 3, (int) get_option( 'wpg_proxy_protection' ) ); ?>>IPHunter</option>
                </select>

                <script>
                document.getElementById('wpg_proxy_protection').addEventListener('change', function () {
                    var selectedValue = this.value;

                    // Define the URLs for each option
                    var urlMap = {
                        '0': '<?php echo admin_url( 'admin.php?page=lighthouse-firewall&tab=modules&api=0' ); ?>',
                        '1': '<?php echo admin_url( 'admin.php?page=lighthouse-firewall&tab=modules&api=1' ); ?>',
                        '2': '<?php echo admin_url( 'admin.php?page=lighthouse-firewall&tab=modules&api=2' ); ?>',
                        '3': '<?php echo admin_url( 'admin.php?page=lighthouse-firewall&tab=modules&api=3' ); ?>'
                    };

                    // Redirect to the selected URL
                    window.location.href = urlMap[selectedValue];
                });
                </script>

                <hr>
                <small><?php echo esc_html__("Connects to Proxy Detection API and verifies whether the visitor is using a Proxy, VPN or TOR", 'lighthouse'); ?></small>
            </p>

            <?php
            if (get_option('wpg_proxy_protection') > 0 && get_option('wpg_proxy_protection') < 4) {
                $apik = 'wpg_proxy_api' . get_option('wpg_proxy_protection');
                $key  = get_option($apik);
                $proxy_check = 0;

                if (get_option('wpg_proxy_protection') == 1) {
                    //Invalid API Key ==> Offline
                    $ch  = curl_init();
                    $url = "http://v2.api.iphub.info/ip/8.8.8.8";
                    curl_setopt_array($ch, [
                        CURLOPT_URL => $url,
                        CURLOPT_CONNECTTIMEOUT => 30,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HTTPHEADER => [ "X-Key: {$key}" ]
                    ]);
                    $response = curl_exec($ch);
                    $httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
                    curl_close($ch);

                    if ($httpCode >= 200 && $httpCode < 300) {
                        $proxy_check = 1;
                    } else if ($httpCode == 429) {
                        $proxy_check = 429;
                    }
                } elseif (get_option('wpg_proxy_protection') == 2) {
                    $ch           = curl_init('http://proxycheck.io/v2/8.8.8.8?key=' . $key . '');
                    $curl_options = array(
                        CURLOPT_CONNECTTIMEOUT => 30,
                        CURLOPT_RETURNTRANSFER => true
                    );
                    curl_setopt_array($ch, $curl_options);
                    $response = curl_exec($ch);
                    curl_close($ch);

                    $jsonc = json_decode($response);

                    if (isset($jsonc->status) && $jsonc->status == "ok") {
                        $proxy_check = 1;
                    }
                } elseif (get_option('wpg_proxy_protection') == 3) {
                    //Invalid API Key ==> Offline
                    $headers = [
                        'X-Key: '.$key.'',
                    ];
                    $ch = curl_init("https://www.iphunter.info:8082/v1/ip/8.8.8.8");
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    $response = curl_exec($ch);
                    $httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
                    curl_close($ch);

                    if ($httpCode >= 200 && $httpCode < 300) {
                        $proxy_check = 1;
                    } else if ($httpCode == 429) {
                        $proxy_check = 429;
                    }
                }

                if ($proxy_check == 0) {
                    echo '<div class="callout callout-warning" role="callout">' . esc_html__("Invalid / missing API Key or API is Offline", 'lighthouse') . '</div>';
                } else if ($proxy_check == 429) {
                    echo '<div class="callout callout-warning" role="callout">' . esc_html__("Requests Limit exceeded", 'lighthouse') . '</div>';
                }

                if (get_option($apik) == NULL OR $proxy_check == 0) {
                    if (get_option('wpg_proxy_protection') == 1) {
                        $apik_url = 'https://iphub.info/pricing';
                    } else if (get_option('wpg_proxy_protection') == 2) {
                        $apik_url = 'https://proxycheck.io/pricing';
                    } else if (get_option('wpg_proxy_protection') == 3) {
                        $apik_url = 'https://www.iphunter.info/prices';
                    }
                    ?>
                    <a href="<?php echo $apik_url; ?>" class="btn btn-info btn-block text-white" target="_blank"><i class="fas fa-key"></i> <?php echo esc_html__("Get API Key", 'lighthouse'); ?></a><br />
                    <?php
                }
            }
            ?>

            <p><?php echo esc_html__("API Key", 'lighthouse'); ?></p>
            <input name="apikey" class="form-control" type="text" <?php
            if (get_option('wpg_proxy_protection') > 0) {
                echo 'value="' . get_option($apik) . '"';
            } else {
                echo 'disabled';
            }
            ?>>

            <h5><?php echo esc_html__("Detection Method #2", 'lighthouse'); ?></h5>

            <p>
                <input type="checkbox" name="protection2" <?php checked( 1, (int) get_option( 'wpg_proxy_protection2' ) ); ?>>
            <p>

            <p><?php echo esc_html__("Checks the visitor's HTTP connection headers for Proxy elements", 'lighthouse'); ?></p>

            <p>
                <button class="button button-primary" name="psave2" type="submit"><?php echo esc_html__("Save", 'lighthouse'); ?></button>
            </p>
        </form>
    </div>
    <div class="lhf--grid-item">
        <h3><?php echo esc_html__("What is - Proxy", 'lighthouse'); ?></h3>

        <p><?php echo __("<strong>Proxy</strong> or <strong>Proxy Server</strong> is basically another computer which serves as a hub through which internet requests are processed. By connecting through one of these servers, your computer sends your requests to the proxy server which then processes your request and returns what you were wanting.", 'lighthouse'); ?></p>

        <h3><?php echo esc_html__("Module Settings", 'lighthouse'); ?></h3>

        <form action="" method="post">
            <p>
                <label>
                    <input type="checkbox" name="logging" <?php checked( 1, (int) get_option( 'wpg_proxy_logging' ) ); ?>>
                    <?php echo esc_html__("Logging", 'lighthouse'); ?>
                </label>
            </p>
            <br><small><?php echo __("Logging every threat of this type", 'lighthouse'); ?></small>
            <p>
                <label>
                    <input type="checkbox" name="mail" <?php checked( 1, (int) get_option( 'wpg_proxy_mail' ) ); ?>>
                    <?php echo esc_html__("Mail Notifications", 'lighthouse'); ?>
                </label>
                <br><small><?php echo __("You will receive email notification when threat of this type is detected", 'lighthouse'); ?></small>
            </p>
            <p>
                <button class="button button-primary" name="psave" type="submit"><?php echo esc_html__("Save", 'lighthouse'); ?></button>
            </p>
        </form>
    </div>
</div>
