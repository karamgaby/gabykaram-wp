<?php
/**
 * add custom admin role.
 */

add_action( 'init', 'create_client_admin_role' );

function create_client_admin_role() {
	global $wp_roles;
	if ( ! isset( $wp_roles ) ) {
		// phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		$wp_roles = new WP_Roles();
	}

	$capabilities = array(
		'edit_theme_options'       => true,
		'vx_crmperks_view_plugins' => true,
		'vx_crmperks_view_addons'  => true,
		'vx_crmperks_edit_addons'  => true,
		'vxcf_leads_read_entries'  => true,
		'vxcf_leads_read_license'  => true,
		'vxcf_leads_read_settings' => true,
		'vxcf_leads_edit_entries'  => true,
		'vxcf_leads_edit_settings' => true,
		'delete_others_pages'      => true,
		'delete_others_posts'      => true,
		'edit_others_pages'        => true,
		'edit_others_posts'        => true,
		'manage_categories'        => true,
	);
	// get editor capability
	if ( wp_roles()->is_role( 'editor' ) ) {
		$etr_editor   = $wp_roles->get_role( 'editor' );
		$capabilities = array_merge( $etr_editor->capabilities, $capabilities );
	}

	// add Mailchimp plugin capabilty to edit_pages
	add_filter(
		'mc4wp_admin_required_capability',
		function( $capability ) {
			return 'edit_pages';
		}
	);

	// get yoast manager capability
	if ( wp_roles()->is_role( 'wpseo_manager' ) ) {
		$etr_seo      = $wp_roles->get_role( 'wpseo_manager' );
		$capabilities = array_merge( $etr_seo->capabilities, $capabilities );
	}

	// get give manager capability
	if ( wp_roles()->is_role( 'give_manager' ) ) {
		$etr_give     = $wp_roles->get_role( 'give_manager' );
		$capabilities = array_merge( $etr_give->capabilities, $capabilities );
	}

	// add w3 total cache plugin capability
	function allow_users_to_flush( $capability ) {
		return 'publish_posts';
	}
	add_filter( 'w3tc_capability_row_action_w3tc_flush_post', 'allow_users_to_flush', 10, 10 );
	add_filter( 'w3tc_capability_w3tc_flush', 'allow_users_to_flush', 10, 10 );
	add_filter( 'w3tc_capability_w3tc_flush_all', 'allow_users_to_flush', 10, 10 );
	add_filter( 'w3tc_capability_admin_bar', 'allow_users_to_flush', 10, 10 );
	add_filter( 'w3tc_capability_admin_bar_flush_all', 'allow_users_to_flush', 10, 10 );
	add_filter( 'w3tc_capability_admin_bar_w3tc', 'allow_users_to_flush', 10, 10 );
	add_filter( 'w3tc_capability_admin_bar_flush', 'allow_users_to_flush', 10, 10 );
	add_filter( 'w3tc_capability_w3tc', 'allow_users_to_flush', 10, 10 );
	add_filter( 'w3tc_capability_admin_notices', 'allow_users_to_flush', 10, 10 );
	add_filter( 'w3tc_capability_menu_w3tc_dashboard', 'allow_users_to_flush', 10, 10 );
	add_filter( 'w3tc_capability_menu', 'allow_users_to_flush', 10, 10 );
	add_filter( 'w3tc_capability_admin_bar', 'allow_users_to_flush', 10, 10 );
	function w3tc_cap_filter( $allcaps, $cap, $args ) {
		if ( preg_match( '/w3tc_dashboard/', $_SERVER['REQUEST_URI'] ) ) {
			$allcaps[ $cap[0] ] = true;
		}
		return $allcaps;
	}

	add_filter( 'user_has_cap', 'w3tc_cap_filter', 10, 3 );

	$wp_roles->remove_role( 'mini-admin' );
	$wp_roles->add_role( 'mini-admin', 'X Admin', $capabilities );
}
add_action('admin_menu', 'change_menus_position');
function change_menus_position() {

  // Remove old menu
  remove_submenu_page( 'themes.php', 'nav-menus.php' );

  //Add new menu page
  add_menu_page(
    'Menus',
    'Menus',
    'edit_theme_options',
    'nav-menus.php',
    '',
    'dashicons-list-view',
    68
  );
  function remove_appearance_menu() {
    // Check if the current user is not an administrator.
    if ( ! current_user_can( 'administrator' ) ) {
      // Remove the "Appearance" menu.
      remove_menu_page( 'themes.php' );
      remove_menu_page( 'tools.php' );
    }
  }
  add_action( 'admin_menu', 'remove_appearance_menu' );

}
