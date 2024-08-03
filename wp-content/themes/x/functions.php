<?php

if (!defined('STAGE_ZERO_VERSION')) {
  $theme = wp_get_theme();
  $theme_version = $theme->get('Version');
  define('STAGE_ZERO_VERSION', $theme_version);
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * polarstork_theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package polarstork
 */
if (!defined('STORKER_THEME_VERSION')) {
  $theme = wp_get_theme();
  $theme_version = $theme->get('Version');
  define('STORKER_THEME_VERSION', $theme_version);
}

define('STORKER_DATE_FORMAT', 'd.m.Y');

/**
 * Core setup.
 */
require get_template_directory() . '/inc/0.core/reset.php';
require get_template_directory() . '/inc/0.core/security.php';
require get_template_directory() . '/inc/0.core/user-roles.php';

/**
 * Theme setup.
 */
require get_template_directory() . '/inc/1.setup/register-assets.php';
require get_template_directory() . '/inc/1.setup/register-blockTheme.php';
require get_template_directory() . '/inc/1.setup/register-localization.php';
require get_template_directory() . '/inc/1.setup/register-theme.php';
require get_template_directory() . '/inc/1.setup/setup-acf.php';
require get_template_directory() . '/inc/1.setup/setup-classic-editor.php';
require get_template_directory() . '/inc/1.setup/setup-fallbacks.php';
require get_template_directory() . '/inc/1.setup/setup-gutenberg.php';
require get_template_directory() . '/inc/1.setup/setup-theme-support.php';

/**
 * Plugins specific logic.
 */
require get_template_directory() . '/inc/2.plugins/acf-hooks.php';
require get_template_directory() . '/inc/2.plugins/yoast.php';
require get_template_directory() . '/inc/2.plugins/cf7.php';

require get_template_directory() . '/inc/3.views/ThemeSetting.php';

/**
 * helper functions - should be pure functions.
 */
require get_template_directory() . '/inc/9.helpers/apache-htaccess.php';
require get_template_directory() . '/inc/9.helpers/function-dates.php';
require get_template_directory() . '/inc/9.helpers/function-last-edited.php';
require get_template_directory() . '/inc/9.helpers/utils.php';


// import TGM Plugin Activation library
require_once get_template_directory() . '/inc/4.libraries/tgm/class-tgm-plugin-activation.php';
// import TGM Plugin Activation library setup
require_once get_template_directory() . '/inc/4.libraries/tgm/function-required-plugins.php';

add_filter('x_ui_component_sprite_last_edited', function () {
  return x_last_edited('svg');
});

function acf_modifify_flexible_content_global_spacing_options($field)
{

  $grid_tokens = X_UI\Core\Tokens\Grid::getInstance();
  $spacing = $grid_tokens->getMeta('spacing');
  $choices = $field['choices'];
  foreach ($spacing as $key => $value) {
    $choices[$key] = sprintf('%s => (%s) 1 rem = 16px', $key, $value);
  }
  foreach ($spacing as $key => $value) {
    $choices['n' . $key] = sprintf('Negative spacce %s => (%s) 1 rem = 16px', $key, $value);
  }
  $field['choices'] = $choices;
  return $field;
}

add_filter('acf/prepare_field/name=desktop_top_spacing', 'acf_modifify_flexible_content_global_spacing_options');
add_filter('acf/prepare_field/name=mobile_top_spacing', 'acf_modifify_flexible_content_global_spacing_options');


function acf_modifify_flexible_color_options($field)
{
  $colors_tokens = X_UI\Core\Tokens\Colors::getInstance();
  $colors = $colors_tokens->getMeta('colors');
  $choices = [];

  foreach ($colors as $key => $colorHex) {
    ob_start();

    ?>
    <div class="d-inline-flex"
      style="display: inline-flex !important; gap: 8px; align-items: center; justify-content: center;">
      <span>Color: <?= $key ?></span>
      <div style="width: 32px; height: 32px; display: block; background-color: <?= $colorHex ?>"></div>
    </div>
    <?php
    $choice_label = ob_get_clean();
    $choices[$key] = $choice_label;
  }
  $field['choices'] = $choices;

  return $field;
}
add_filter('acf/prepare_field/name=title_color', 'acf_modifify_flexible_color_options');
add_filter('acf/prepare_field/name=content_color', 'acf_modifify_flexible_color_options');
add_filter('acf/prepare_field/name=bold_content_color', 'acf_modifify_flexible_color_options');

function acf_modifify_flexible_content_typography_options($field)
{
  $typographies_tokens = X_UI\Core\Tokens\Typographies::getInstance();
  $typographies = $typographies_tokens->getMeta('typographies');
  // Lock-in the value "Example".
  $choices = [];

  foreach ($typographies as $key => $typography) {
    ob_start();

    ?>
    <div class="d-inline-flex"
      style="display: inline-flex !important; gap: 8px; align-items: center; justify-content: center;">
      <span>Typographies: <?= $key ?></span>
    </div>
    <?php
    $choice_label = ob_get_clean();
    $choices[$key] = $choice_label;
  }
  $field['choices'] = $choices;

  return $field;
}
add_filter('acf/prepare_field/name=title_typography_on_desktop', 'acf_modifify_flexible_content_typography_options');
add_filter('acf/prepare_field/name=title_typography_on_mobile', 'acf_modifify_flexible_content_typography_options');
add_filter('acf/prepare_field/name=title_typography_desktop', 'acf_modifify_flexible_content_typography_options');
add_filter('acf/prepare_field/name=title_typography_mobile', 'acf_modifify_flexible_content_typography_options');

function customize_acf_wysiwyg_toolbars($toolbars)
{

  $toolbars['Simple'] = array();
  $toolbars['Simple'][1] = array('bold', 'italic', 'underline', 'strikethrough', "bullist", "numlist", "undo", "redo", "link", "fullscreen");

  $toolbars['Text'] = array();
  $toolbars['Text'][1] = array('bold', 'italic', 'underline', 'strikethrough', "undo", "redo", "fullscreen");

  return $toolbars;
}
add_filter('acf/fields/wysiwyg/toolbars', 'customize_acf_wysiwyg_toolbars');



// ACF Location Rules
add_filter('acf/location/rule_types', 'add_parent_menu_item_location_rule');
function add_parent_menu_item_location_rule($choices)
{
  $choices['Menu']['parent_menu_item'] = 'Parent Menu Item';
  return $choices;
}

add_filter('acf/location/rule_values/parent_menu_item', 'parent_menu_item_rule_values');
function parent_menu_item_rule_values($choices)
{
  $choices['is_parent'] = 'Is Parent';
  $choices['is_child'] = 'Is Child';
  return $choices;
}

add_filter('acf/location/rule_match/parent_menu_item', 'parent_menu_item_rule_match', 10, 3);
function parent_menu_item_rule_match($match, $rule, $options)
{
  if (!isset($options['nav_menu_item'])) {
    return false;
  }

  $nav_menu_item_id = $options['nav_menu_item_id'];

  // var_dump($options);
  // If $nav_menu_item_id is not a number, return false
  if (!is_numeric($nav_menu_item_id)) {
    return false;
  }

  // Get the menu item's parent ID
  $menu_item_parent = get_post_meta($nav_menu_item_id, '_menu_item_menu_item_parent', true);

  // Check if it's a parent (no parent ID) or child
  $is_parent = empty($menu_item_parent);

  if ($rule['value'] == 'is_parent') {
    $match = $is_parent;
  } elseif ($rule['value'] == 'is_child') {
    $match = !$is_parent;
  }

  return $match;
}