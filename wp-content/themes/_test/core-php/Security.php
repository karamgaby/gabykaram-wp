<?php

namespace php;


class Security {
	private static $instance;

	public static function getInstance(): Security {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		add_filter( 'login_errors', [ $this, 'harden_login_messages' ] );
		add_filter( 'wp_login_errors', [ $this, 'reset_password_harden_errors' ] );
		add_filter( 'lostpassword_user_data', [ $this, 'reset_password_harden_flow' ], 1, 2 );
		add_filter( 'rest_namespace_index', [ $this, 'disable_index_for_rest_api' ] );
		add_filter( 'rest_index', [ $this, 'disable_rest_api_endpoint_listing' ], 111 );
		remove_action( 'wp_head', 'wp_generator' );
		// Feed generator tags.
		foreach ( array( 'rss2_head', 'commentsrss2_head', 'rss_head', 'rdf_header', 'atom_head', 'comments_atom_head', 'opml_head', 'app_head' ) as $action ) {
			remove_action( $action, 'the_generator' );
		}
	}

	public function harden_login_messages( $error ) {
		global $errors;
		$err_codes = $errors->get_error_codes();

		// Invalid username.
		if ( in_array( 'invalid_username', $err_codes, true ) || in_array( 'incorrect_password', $err_codes, true ) ) {
			$errorMsg = '<strong>' . _x( 'Error', 'login_page', 'admin-block-theme' ) . '</strong>:';
			// @todo test if this way of doing translations would allow for the language to be picked up by the tool that generate the po file.
			$error = sprintf( _x( '%s The credentials you entered are not valid.', 'login_page', 'admin-block-theme' ), array( $errorMsg ) );
		}

		return $error;
	}

	public function reset_password_harden_errors( $errors ) {
		$err_codes = $errors->get_error_codes();
		if ( in_array( 'confirm', $err_codes, true ) ) {
			$errors->remove( 'confirm' );
			$loginPageUrl  = wp_login_url();
			$loginPageText = sprintf( '<a href="%s">%s</a>', $loginPageUrl, _x( 'login page', 'login_page', 'admin-block-theme' ) );
			$errors->add(
				'confirm',
				sprintf( 'Check your email for the confirmation link, then visit the %s.', $loginPageText ),
				'message'
			);
		}

		return $errors;
	}

	public function reset_password_harden_flow( $user_data, $errors ) {
		$err_codes = $errors->get_error_codes();

		if ( ! $user_data && ! in_array( 'empty_username', $err_codes, true ) ) {
			$redirect_to = ! empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : 'wp-login.php?checkemail=confirm';
			wp_safe_redirect( $redirect_to );
			exit;
		}

		return $user_data;
	}

	public function disable_index_for_rest_api( $response ) {
		$data               = $response->get_data();
		$data['namespaces'] = [];
		$data['routes']     = [];
		$response->set_data( $data );

		return $response;
	}

	public function disable_rest_api_endpoint_listing( $response ): array {
		// If the request is for the root of the REST API, return an empty response
		return array();
	}
}
