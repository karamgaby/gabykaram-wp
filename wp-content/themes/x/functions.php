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

function acf_modifify_flexible_content_global_spacing_options( $field ) {

  $grid_tokens = X_UI\Core\Tokens\Grid::getInstance();
  $spacing = $grid_tokens->getMeta('spacing');
  // Lock-in the value "Example".
  file_put_contents(__DIR__ . '/field_group.json', json_encode($spacing));
  // $field['choices'][] = '';
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