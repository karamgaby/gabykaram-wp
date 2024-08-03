<?php
/**
 * MenuBar: Data structures
 *
 * @package axio
 */

use X_UI\Core\Modules\Buttons\Tokens as ButtonsTokens;

/**
 * Localization
 */
add_filter('axio_core_pll_register_strings', function ($strings) {

  return array_merge($strings, [
    'Button: Type Solid' => 'Solid',
    'Button: Type Outline' => 'Outline',
  ]);

}, 10, 1);

add_action('acf/include_fields', function () {
  if (!function_exists('acf_add_local_field_group')) {
    return;
  }
  $tokens = ButtonsTokens::getInstance();
  $btn_tokens = $tokens->getMeta('buttons');
  $buttons_options = [];
  foreach ($btn_tokens as $style => $btn_token) {
    $buttons_options[$style] = $btn_token['label'];
  }
  acf_add_local_field_group(
    array(
      'key' => 'group_66ae606e4cb43',
      'title' => 'Header Menu Item',
      'fields' => array(
        array(
          'key' => 'field_66ae62a534db1',
          'label' => 'Button Style',
          'name' => 'button_style',
          'aria-label' => '',
          'type' => 'select',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'choices' => $buttons_options,
          'default_value' => 'text-only',
          'return_format' => 'value',
          'multiple' => 0,
          'allow_null' => 0,
          'ui' => 0,
          'ajax' => 0,
          'placeholder' => '',
        ),
        array(
          'key' => 'field_66ae6315e54f7',
          'label' => 'Active Button Style',
          'name' => 'active_button_style',
          'aria-label' => '',
          'type' => 'select',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'choices' => $buttons_options,
          'default_value' => 'text-only-active',
          'return_format' => 'value',
          'multiple' => 0,
          'allow_null' => 0,
          'ui' => 0,
          'ajax' => 0,
          'placeholder' => '',
        ),
      ),
      'location' => array(
        array(
          array(
            'param' => 'nav_menu_item',
            'operator' => '==',
            'value' => 'location/primary',
          ),
          array(
            'param' => 'parent_menu_item',
            'operator' => '==',
            'value' => 'is_parent',
          ),
        ),
      ),
      'menu_order' => 0,
      'position' => 'normal',
      'style' => 'default',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'hide_on_screen' => '',
      'active' => true,
      'description' => '',
      'show_in_rest' => 0,
    )
  );
});


