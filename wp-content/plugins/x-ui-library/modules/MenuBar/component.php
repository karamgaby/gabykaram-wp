<?php

namespace X_UI\Modules\MenuBar;

use X_UI\Core\AbstractComponent;

/**
 * Component: Button
 *
 * @package axio
 */
class Component extends AbstractComponent {

  protected static function get_data_placeholders(): array {
    return [
      'image_id'      => '',
      'image_size'    => 'full',
      'attr'          => [],
      'menu_location' => null
    ];
  }

  private static TemplateLoader $templateLoader;

  public static function frontend( $data ): void {
    self::$templateLoader = ! empty( self::$templateLoader ) ? self::$templateLoader : new TemplateLoader();
    self::$templateLoader->set_template_data( $data )->get_template_part( 'header' );
  }

  public static function backend( $args = [] ): \WP_Error|array {
    self::validateArgs( $args );
    $args = self::manipulateAttrClass( $args );

    return $args;

  }

  private static function validateArgs( $args = [] ): void {
    if ( empty( $args['image_id'] ) ) {
      parent::error( 'Missing image src ($args[\'image_id\'])' );

      return;
    }
    if ( ! empty( $args['menu_location'] ) ) {
      parent::error( 'Missing menu_location ($args[\'menu_location\']' );
    }
  }

  private static function manipulateAttrClass( $args ) {
    if ( ! isset( $args['attr']['class'] ) ) {
      $args['attr']['class'] = [];
    } elseif ( is_string( $args['attr']['class'] ) ) {
      $args['attr']['class'] = array( $args['attr']['class'] );
    }

    // use prefixed class to avoid styling clashes
    $args['attr']['class'][] = 'x-menu-bar';

    return $args;
  }
}
