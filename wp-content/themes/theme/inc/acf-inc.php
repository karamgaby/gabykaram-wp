<?php

/**
 * include ACF assets
 *
 * @package polarstork
 */

if ( function_exists( 'get_field' ) ) {

	// add options page for the theme
	$options_page_name = 'Theme Settings';

	acf_add_options_page(
		array(
			'page_title' => $options_page_name,
			'menu_title' => $options_page_name,
			'menu_slug'  => 'theme-settings',
			'capability' => 'manage_options',
			'redirect'   => false,
		)
	);
}

/**
 * add fields for Third Party Integration
 *
 * for editing check backup-third-party-integration.json
 */

if ( function_exists( 'acf_add_local_field_group' ) ) :

	acf_add_local_field_group(
		array(
			'key'                   => 'group_6113fb706dcc5',
			'title'                 => 'Third Party Integration',
			'fields'                => array(
				array(
					'key' => 'field_65d9d04509b57',
					'label' => 'Note: Analytics',
					'name' => '',
					'aria-label' => '',
					'type' => 'message',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'message' => '',
					'esc_html' => 0,
					'new_lines' => 'wpautop',
				),
				array(
					'key'               => 'field_6113fbffb9940',
					'label'             => 'Google tag manager ID',
					'name'              => 'google_tag_manager_id',
					'type'              => 'text',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'default_value'     => '',
					'placeholder'       => '',
					'prepend'           => '',
					'append'            => '',
					'maxlength'         => '',
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'theme-settings',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'active'                => true,
			'description'           => '',
		)
	);

endif;
