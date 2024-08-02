<?php
/* Hook to initialize sessions */
add_action( 'init', 'lighthouse_captcha_init_sessions' );

function lighthouse_captcha_init_sessions() {
    if ( ! session_id() ) {
        session_start();
    }
}

/* Captcha for login authentication starts here */ 
$login_captcha = get_option( 'wpcaptcha_login' );
if ( $login_captcha == 'yes' ) {
    add_action( 'login_form', 'lighthouse_captcha_for_login' );
    add_filter( 'login_errors', 'lighthouse_captcha_login_errors' );
    add_filter( 'login_redirect', 'lighthouse_captcha_login_redirect', 10, 3 );
}

/* Function to include captcha for login form */
function lighthouse_captcha_for_login() {
    echo '<p class="login-form-captcha">
        <label>' . __( 'Are you a bot?', 'lighthouse' ) . '</label>
        <div style="clear:both;"></div><div style="clear:both;"></div>';

        lighthouse_captcha_generate_code();

        /* Will retrieve the get varibale and prints a message from url if the captcha is wrong */
        if ( isset( $_GET['captcha'] ) && $_GET['captcha'] == 'confirm_error' ) {
            echo '<label style="color:#FF0000;" id="capt_err">' . esc_html( $_SESSION['captcha_error'] ) . '</label><div style="clear:both;"></div>';
            $_SESSION['captcha_error'] = '';
        }

        echo '<label>' . __( 'Type the text displayed above:', 'lighthouse' ) . '</label>
            <input id="captcha_code" name="captcha_code" size="15" type="text" tabindex="30">
    </p>';

    return true;
}

/* Hook to find out the errors while logging in */
function lighthouse_captcha_login_errors( $errors ) {
    if ( isset( $_REQUEST['action'] ) && 'register' == $_REQUEST['action'] ) {
        return $errors;
    }

    if ( esc_html( $_SESSION['captcha_code'] ) != $_REQUEST['captcha_code'] ) {
        return $errors . '<label id="capt_err" for="captcha_code_error">' . __( 'Captcha confirmation error!', 'lighthouse' ) . '</label>';
    }

    return $errors;
}

/* Hook to redirect after captcha confirmation */
function lighthouse_captcha_login_redirect( $url ) {
    /* Captcha mismatch */
    if ( isset( $_SESSION['captcha_code'] ) && isset( $_REQUEST['captcha_code'] ) && esc_html( $_SESSION['captcha_code'] ) != $_REQUEST['captcha_code'] ) {
        $_SESSION['captcha_error'] = __( 'Incorrect captcha confirmation!', 'lighthouse' );

        wp_clear_auth_cookie();

        return $_SERVER['REQUEST_URI'] . "/?captcha='confirm_error'";
    } else {
        /* Captcha match: take to the admin panel */
        return admin_url();
    }
}

/* <!-- Captcha for login authentication ends here --> */

/* Captcha for Comments ends here */
$comment_captcha = get_option('wpcaptcha_comments');
if($comment_captcha == 'yes')
{
	global $wp_version;
	if( version_compare($wp_version,'3','>=') ) { // wp 3.0 +
		add_action( 'comment_form_after_fields', 'lighthouse_captcha_comment_form_wp3', 1 );
		add_action( 'comment_form_logged_in_after', 'lighthouse_captcha_comment_form_wp3', 1 );
	}	
	// for WP before WP 3.0
	add_action( 'comment_form', 'lighthouse_captcha_comment_form' );
	add_filter( 'preprocess_comment', 'lighthouse_captcha_comment_post' );
}

/* Function to include captcha for comments form */
function lighthouse_captcha_comment_form()
{
	$c_registered = get_option('wpcaptcha_registered');
	if ( is_user_logged_in() && $c_registered == 'yes') {
		return true;
	}
	echo '<p class="comment-form-captcha">
		<label><b>'. __('Are you a bot?', 'lighthouse').' </b></label>
		<div style="clear:both;"></div><div style="clear:both;"></div>';
	lighthouse_captcha_generate_code();
	echo '<label>'.__('Type the text displayed above', 'lighthouse').':</label>
		<input id="captcha_code" name="captcha_code" size="15" type="text" />
		<div style="clear:both;"></div>
		</p>';
	return true;
}

/* Function to include captcha for comments form > wp3 */
function lighthouse_captcha_comment_form_wp3()
{
	$c_registered = get_option('wpcaptcha_registered');
	if ( is_user_logged_in() && $c_registered == 'yes') {
		return true;
	}
	
	echo '<p class="comment-form-captcha">
		<label><b>'. __('Are you a bot?', 'lighthouse').' </b></label>
		<div style="clear:both;"></div><div style="clear:both;"></div>';
	lighthouse_captcha_generate_code();
	echo '<label>'.__('Type the text displayed above', 'lighthouse').':</label>
		<input id="captcha_code" name="captcha_code" size="15" type="text" />
		<div style="clear:both;"></div>
		</p>';
		
	remove_action( 'comment_form', 'lighthouse_captcha_comment_form' );
	
	return true;
}

// this function checks captcha posted with the comment
function lighthouse_captcha_comment_post($comment)
{
	$c_registered = get_option('wpcaptcha_registered');
	if (is_user_logged_in() && $c_registered == 'yes') {
		return $comment;
	}

	// skip captcha for comment replies from the admin menu
	if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'replyto-comment' &&
	( check_ajax_referer( 'replyto-comment', '_ajax_nonce', false ) || check_ajax_referer( 'replyto-comment', '_ajax_nonce-replyto-comment', false ) ) ) {
		// skip capthca
		return $comment;
	}

	// Skip captcha for trackback or pingback
	if ( $comment['comment_type'] != '' && $comment['comment_type'] != 'comment' ) {
		 // skip captcha
		 return $comment;
	}
	
	// If captcha is empty
	if(empty($_REQUEST['captcha_code']))
		wp_die( __('CAPTCHA cannot be empty.', 'lighthouse' ) );

	// captcha was matched
	if($_SESSION['captcha_code'] == $_REQUEST['captcha_code']) return($comment);
	else wp_die( __('Error: Incorrect CAPTCHA. Press your browser\'s back button and try again.', 'lighthouse'));
} 

/* <!-- Captcha for Comments authentication ends here --> */

// Add captcha in the register form
$register_captcha = get_option('wpcaptcha_register');
if($register_captcha == 'yes')
{
	add_action('register_form', 'lighthouse_captcha_register');
	add_action( 'register_post', 'lighthouse_captcha_register_post', 10, 3 );
	add_action( 'signup_extra_fields', 'lighthouse_captcha_register' );
	add_filter( 'wpmu_validate_user_signup', 'lighthouse_captcha_register_validate' );
}

/* Function to include captcha for register form */
function lighthouse_captcha_register($default)
{
	echo '<p class="register-form-captcha">	
			<label><b>'. __('Are you a bot?', 'lighthouse').' </b></label>
			<div style="clear:both;"></div><div style="clear:both;"></div>';
	lighthouse_captcha_generate_code();
	echo '<label>'.__('Type the text displayed above', 'lighthouse').':</label>
			<input id="captcha_code" name="captcha_code" size="15" type="text" />
			</p>';
	return true;
}

/* This function checks captcha posted with registration */
function lighthouse_captcha_register_post($login,$email,$errors)
{
	// If captcha is blank - add error
	if ( isset( $_REQUEST['captcha_code'] ) && "" ==  $_REQUEST['captcha_code'] )
	{
		$errors->add('captcha_blank', '<strong>'.__('ERROR', 'lighthouse').'</strong>: '.__('Please complete the CAPTCHA.', 'lighthouse'));
		return $errors;
	}

	if ( isset( $_REQUEST['captcha_code'] ) && ($_SESSION['captcha_code'] == $_REQUEST['captcha_code'] )) {
					// captcha was matched						
	} else {
		$errors->add('captcha_wrong', '<strong>'.__('ERROR', 'lighthouse').'</strong>: '.__('That CAPTCHA was incorrect.', 'lighthouse'));
	}
  	return($errors);
} 
/* End of the function lighthouse_captcha_register_post */

function lighthouse_captcha_register_validate($results)
{
	if ( isset( $_REQUEST['captcha_code'] ) && "" ==  $_REQUEST['captcha_code'] ) {
		$results['errors']->add('captcha_blank', '<strong>'.__('ERROR', 'lighthouse').'</strong>: '.__('Please complete the CAPTCHA.', 'lighthouse'));
		return $results;
	}

	if ( isset( $_REQUEST['captcha_code'] ) && ($_SESSION['captcha_code'] == $_REQUEST['captcha_code'] )) {
					// captcha was matched						
	} else {
		$results['errors']->add('captcha_wrong', '<strong>'.__('ERROR', 'lighthouse').'</strong>: '.__('That CAPTCHA was incorrect.', 'lighthouse'));
	}
  return($results);
}
/* End of the function lighthouse_captcha_register_validate */

$lost_captcha = get_option('wpcaptcha_lost');
// Add captcha into lost password form
if($lost_captcha == 'yes'){
	add_action( 'lostpassword_form', 'lighthouse_captcha_lostpassword' );
	add_action( 'lostpassword_post', 'lighthouse_captcha_lostpassword_post', 10, 3 );
}

/* Function to include captcha for lost password form */
function lighthouse_captcha_lostpassword($default)
{
	echo '<p class="lost-form-captcha">
		<label><b>'. __('Are you a bot?', 'lighthouse').' </b></label>
		<div style="clear:both;"></div><div style="clear:both;"></div>';
	lighthouse_captcha_generate_code();
	echo '<label>'.__('Type the text displayed above', 'lighthouse').':</label>
		<input id="captcha_code" name="captcha_code" size="15" type="text" />
		</p>';	
}

function lighthouse_captcha_lostpassword_post() {
	if( isset( $_REQUEST['user_login'] ) && "" == $_REQUEST['user_login'] )
		return;

	// If captcha doesn't entered
	if ( isset( $_REQUEST['captcha_code'] ) && "" ==  $_REQUEST['captcha_code'] ) {
		wp_die( __( 'Please complete the CAPTCHA.', 'lighthouse' ) );
	}
	
	// Check entered captcha
	if ( isset( $_REQUEST['captcha_code'] ) && ($_SESSION['captcha_code'] == $_REQUEST['captcha_code'] )) {
		return;
	} else {
		wp_die( __( 'Error: Incorrect CAPTCHA. Press your browser\'s back button and try again.', 'lighthouse' ) );
	}
}

function lighthouse_captcha_generate_code() {
    $image_width = 120;
    $image_height = 40;

    $characters_on_image = (int) get_option('wpcaptcha_total_no_of_characters');

    if ( $characters_on_image < 3 || $characters_on_image > 6 ) {
        $characters_on_image = 6;
    }

    $wpcaptcha_type = get_option('wpcaptcha_type');
    $wpcaptcha_letters = get_option('wpcaptcha_letters');

    $font = LIGHTHOUSE_PLUGIN_PATH . '/assets/fonts/monofont.ttf';

    // The characters that can be used in the CAPTCHA code
    // Avoid confusing characters (l 1 and i for example)
    if ( ! empty( $wpcaptcha_type ) && $wpcaptcha_type == 'alphanumeric' ) {
        switch( $wpcaptcha_letters ) {
            case 'capital':
                $possible_letters = '23456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case 'small':
                $possible_letters = '23456789bcdfghjkmnpqrstvwxyz';
                break;
            case 'capitalsmall':
                $possible_letters = '23456789bcdfghjkmnpqrstvwxyzABCEFGHJKMNPRSTVWXYZ';
                break;
            default:
                $possible_letters = '23456789bcdfghjkmnpqrstvwxyz';
                break;
        }
    } elseif ( ! empty( $wpcaptcha_type ) && $wpcaptcha_type == 'alphabets' ) {
        switch( $wpcaptcha_letters ) {
            case 'capital':
                $possible_letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case 'small':
                $possible_letters = 'bcdfghjkmnpqrstvwxyz';
                break;
            case 'capitalsmall':
                $possible_letters = 'bcdfghjkmnpqrstvwxyzABCEFGHJKMNPRSTVWXYZ';
                break;
            default:
                $possible_letters = 'abcdefghijklmnopqrstuvwxyz';
                break;
        }
    } elseif ( ! empty( $wpcaptcha_type ) && $wpcaptcha_type == 'numbers' ) {
        $possible_letters = '0123456789';
    } else {
        $possible_letters = '0123456789';
    }

    $random_dots         = 0;
    $random_lines        = 20;
    $captcha_text_color  = "0x142864";
    $captcha_noise_color = "0x142864";

	$code = '';

	$i = 0;

    while ( $i < $characters_on_image ) {
		$code .= substr( $possible_letters, mt_rand( 0, strlen( $possible_letters ) - 1 ), 1 );
		$i++;
	}

    $font_size = $image_height * 0.75;
    $image     = imagecreate( $image_width, $image_height );

    // Set the background, text and noise colours here
    $background_color = imagecolorallocate( $image, 255, 255, 255 );

    $arr_text_color = lighthouse_captcha_hexrgb( $captcha_text_color );
    $text_color = imagecolorallocate( $image, $arr_text_color['red'], $arr_text_color['green'], $arr_text_color['blue'] );

    $arr_noise_color   = lighthouse_captcha_hexrgb( $captcha_noise_color );
    $image_noise_color = imagecolorallocate( $image, $arr_noise_color['red'], $arr_noise_color['green'], $arr_noise_color['blue'] );

    // Generate the dots randomly in background
    for ( $i = 0; $i < $random_dots; $i++ ) {
        imagefilledellipse( $image, mt_rand( 0, $image_width ), mt_rand( 0, $image_height ), 2, 3, $image_noise_color );
    }

    // Generate lines randomly in background of image
    for ( $i = 0; $i < $random_lines; $i++ ) {
        imageline( $image, mt_rand( 0, $image_width ), mt_rand( 0, $image_height ), mt_rand( 0, $image_width ), mt_rand( 0, $image_height ), $image_noise_color );
    }

    // Create a text box and add 6 letters code in it
    $textbox = imagettfbbox( $font_size, 0, $font, $code );
    $x = ( $image_width - $textbox[4] ) / 2;
    $y = ( $image_height - $textbox[5] ) / 2;
    imagettftext( $image, $font_size, 0, $x, $y, $text_color, $font, $code );

    ob_start();
    imagejpeg( $image ); // Show the image
    printf( '<img src="data:image/png;base64,%s"/ width="100">', base64_encode( ob_get_clean() ) );
    imagedestroy( $image ); // Destroy the image instance
    $_SESSION['captcha_code'] = $code;
}

function lighthouse_captcha_hexrgb ( $hexstr ) {
    $int = hexdec( $hexstr );

    return [
        "red"   => 0xFF & ( $int >> 0x10 ),
        "green" => 0xFF & ( $int >> 0x8 ),
        "blue"  => 0xFF & $int,
    ];
}
