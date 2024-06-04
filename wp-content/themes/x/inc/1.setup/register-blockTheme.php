<?php
/**
 * Register: Blocks
 *
 * @package axio
 */

/**
 * Set explicitly allowed blocks (all others are disallowed)
 *
 * Notice that you need to manually add any custom block or plugins'
 * blocks here to appear on Gutenberg. This is to keep the control on what
 * is or is not allowed.
 *
 * Module specific blocks should be registered from the module.
 *
 * @param bool|array $allowed_block_types_all list of block names or true for all
 * @param WP_Post $post the current post object
 *
 * @return array $allowed_block_types_all list of block names
 */
add_filter('allowed_block_types_all', function ($allowed_block_types_all, $post) {

  // remove all existing blocks
  $blocks   = array();
  $blocks[] = 'core/post-title';
  $blocks[] = 'core/paragraph';
  $blocks[] = 'core/heading';
  $blocks[] = 'core/list';
  $blocks[] = 'core/list-item';
  $blocks[] = 'core/quote';
  $blocks[] = 'core/image';
  $blocks[] = 'core/freeform';
  $blocks[] = 'core/media-text';
  $blocks[] = 'core/columns';
  $blocks[] = 'core/group';
  $blocks[] = 'core/separator';
  $blocks[] = 'core/post-date';
  $blocks[] = 'core/post-excerpt';
  $blocks[] = 'core/post-featured-image';
  $blocks[] = 'acf/youtube-video';

  // $blocks[] = 'core/block';
  return $blocks;

  // other blocks added from modules
  return $blocks;

}, 10, 2);

/*
 * enable Gutenberg for post custom post type
 */
add_filter( 'use_block_editor_for_post', 'ps_handle_disable_gutenberg', 10, 2 );
function ps_handle_disable_gutenberg( $use_block_editor, $post ) {
  $allowed_post_types = apply_filters('ps_allowed_gutenberg_post_types', [ 'post' ], $post);
  if (in_array($post->post_type, $allowed_post_types)) {
    $use_block_editor =  true;
  } else {
    $use_block_editor = false;
  }

  return apply_filters('x_use_block_editor_for_post', $use_block_editor, $post);
}

/*
 * Filter block controls per component
 *
 * */
add_filter( 'block_type_metadata', 'bv_filter_gutenberg_metadata_registration' );
function bv_filter_gutenberg_metadata_registration( $metadata ) {
  $name          = $metadata['name'];
  $disabled_html = array(
    'core/paragraph',
    'core/heading',
    'core/list',
    'core/list-item',
    'core/image',
    'core/columns',
    'core/quote',
    'core/group',
    'core/media-text',
  );
  if ( $name === 'core/image' ) {
    $metadata['usesContext'] = array();
    if ( isset( $metadata['supports']['__experimentalBorder'] ) ) {
      $metadata['supports']['__experimentalBorder']['width']  = false;
      $metadata['supports']['__experimentalBorder']['radius'] = false;
      unset( $metadata['supports']['__experimentalBorder']['__experimentalDefaultControls']['width'] );
      unset( $metadata['supports']['__experimentalBorder']['__experimentalDefaultControls']['radius'] );
    }
    unset( $metadata['styles'] );
  }
  if ( in_array( $name, $disabled_html, true ) ) {
    $metadata['supports']['html'] = false;
    if ( isset( $metadata['supports']['color'] ) ) {
      $metadata['supports']['color']['gradient'] = false;
      $metadata['supports']['color']['link']     = false;
      if ( isset( $metadata['supports']['color']['__experimentalDefaultControls'] ) ) {
        $metadata['supports']['color']['__experimentalDefaultControls']['background'] = false;
        $metadata['supports']['color']['__experimentalDefaultControls']['text']       = false;
      }
    }
    if ( isset( $metadata['supports']['typography'] ) ) {
      $metadata['supports']['typography']['fontSize']                    = false;
      $metadata['supports']['typography']['lineHeight']                  = false;
      $metadata['supports']['typography']['__experimentalFontFamily']    = false;
      $metadata['supports']['typography']['__experimentalFontStyle']     = false;
      $metadata['supports']['typography']['__experimentalLetterSpacing'] = false;
      $metadata['supports']['typography']['__experimentalFontWeight']    = false;
      if ( isset( $metadata['supports']['typography']['__experimentalDefaultControls'] ) ) {
        $metadata['supports']['typography']['__experimentalDefaultControls']['fontSize']                     = false;
        $metadata['supports']['typography']['__experimentalDefaultControls']['lineHeight']                   = false;
        $metadata['supports']['typography']['__experimentalDefaultControls']['__experimentalTextTransform']  = true;
        $metadata['supports']['typography']['__experimentalDefaultControls']['__experimentalTextDecoration'] = true;
      }
    }
  }

  return $metadata;
}

/**
 * Filter global blocks controls
 * */

function ps_filter_gutenberg_global_editor_setting( $editor_settings ) {
  $editor_settings['codeEditingEnabled']                                      = false;
  $editor_settings['alignWide']                                               = false;
  $editor_settings['imageEditing']                                            = false;
  $editor_settings['enableCustomLineHeight']                                  = false;
  $editor_settings['disableCustomColors']                                     = true;
  $editor_settings['disableCustomFontSizes']                                  = true;
  $editor_settings['disableCustomGradients']                                  = true;
  $editor_settings['disableLayoutStyles']                                     = true;
  $editor_settings['colors']                                                  = array();
  $editor_settings['gradients']                                               = array();
  $editor_settings['fontSizes']                                               = array();
  $editor_settings['spacingSizes']                                            = array();
  $editor_settings['__experimentalFeatures']['color']['background']           = false;
  $editor_settings['__experimentalFeatures']['color']['customDuotone']        = false;
  $editor_settings['__experimentalFeatures']['color']['defaultDuotone']       = false;
  $editor_settings['__experimentalFeatures']['color']['defaultGradients']     = false;
  $editor_settings['__experimentalFeatures']['color']['defaultPalette']       = false;
  $editor_settings['__experimentalFeatures']['color']['duotone']['default']   = array();
  $editor_settings['__experimentalFeatures']['color']['gradients']['default'] = array();
  $editor_settings['titlePlaceholder']                                        = 'X post title';

  return $editor_settings;
}

add_filter( 'block_editor_settings_all', 'ps_filter_gutenberg_global_editor_setting' );




