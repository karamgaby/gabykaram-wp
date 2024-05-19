<?php

namespace X_UI\Modules\Image;

use X_UI\Core\AbstractComponent;

/**
 * Component: Image
 *
 * @example
 * Component::render([
 *  'id'   => get_post_thumbnail_id(),
 *  'size' => 'hero',
 * 'src' => 'path to image'
 * ]);
 */
class Component extends AbstractComponent {

  protected static function get_data_placeholders(): array {
    return array(
      // required
      'id'       => null,
      'size'     => 'large',
      'src'      => '',
      // optional
      'attr'     => array(),
      'alt'      => '',
      'decoding' => 'async',

    );
  }

  /**
   * Image markup
   */
  public static function frontend( $data ) {
    $attr = $data['attr'];
    $alt  = $attr['alt'];
    $src  = $attr['src'];
    unset( $attr['src'] );
    unset( $attr['alt'] );
    ?>
    <img alt="<?= $alt ?>" src="<?= $src ?>" <?php parent::render_attributes( $data['attr'] ); ?> />
    <?php
  }

  /**
   * Fetch and setup image data
   *
   * @param array $args
   */
  public static function backend( $args = array() ) {
    if ( empty( $args['id'] ) && empty( $args['src'] ) ) {
      return parent::error( 'Missing image id and src, id is primary and src is secondary ($args[\'id\'] or $args[\'src\'])' );
    }
    if ( empty( $args['id'] ) && ( empty( $args['attr']['width'] ) || empty( $args['attr']['height'] ) ) ) {
      return parent::error( 'Missing image width and height, width and height are required when src is used ($args[\'attr\'][\'width\'] and $args[\'attr\'][\'height\'])' );
    }
    if ( ! empty( $args['id'] ) ) {
      $image = wp_get_attachment_metadata( $args['id'] );
      if ( empty( $image ) || is_wp_error( $image ) ) {
        $file = get_attached_file( $args['id'] );
        if ( empty( $file ) || ! strstr( $file, '.svg' ) ) {
          return parent::error( 'Invalid attachment for PS_Image' );
        }
      }
      if ( ! empty( $image ) ) {
        $generated_sizes         = $image['sizes'];
        $generated_sizes['full'] = array(
          'width'  => $image['width'],
          'height' => $image['height'],
        );
//        @todo check original code on how it is done and validate that the new code is working
        if ( isset( $generated_sizes[ $args['size'] ] ) ) {
          $desired_sizes = $generated_sizes[ $args['size'] ];
        } else {
          $desired_sizes = $generated_sizes['full'];
          $args['size']  = 'full';
        }

        $args['attr']['data-src'] = self::get_image_url( $args['id'], $args['size'] );
        $args['attr']['src']      = self::get_image_url( $args['id'], 'image-placeholder' );
        $args['attr']['width']    = $desired_sizes['width'];
        $args['attr']['height']   = $desired_sizes['height'];
        if ( empty( $args['alt'] ) ) {
          $args['alt'] = get_post_meta( $args['id'], '_wp_attachment_image_alt', true );
        }
        if ( ! isset( $args['attr']['alt'] ) ) {
          $args['attr']['alt'] = $args['alt'];
        }
        if ( ! isset( $args['attr']['decoding'] ) ) {
          $args['attr']['decoding'] = $args['decoding'];
        }
      } else {
        $args['attr']['src'] = wp_get_attachment_url( $args['id'] );
      }
    } else {
      $args['attr']['src'] = $args['src'];
    }
    if ( ! isset( $args['attr']['class'] ) ) {
      $args['attr']['class'] = array();
    } elseif ( is_string( $args['attr']['class'] ) ) {
      $args['attr']['class'] = array( $args['attr']['class'] );
    }

    $args['attr']['class'][] = 'lazy';

    return $args;
  }

  /**
   * Get URL for WP image
   *
   * @param int $attachment_id the ID of image
   * @param string $size the WP image size
   *
   * @return string URL
   */
  public static function get_image_url( $attachment_id, $size ) {

    $image_url = '';
    $image_src = wp_get_attachment_image_src( $attachment_id, $size );
    if ( ! empty( $image_src ) && ! is_wp_error( $image_src ) ) {
      $image_url = $image_src[0];
    }

    return $image_url;

  }
}
