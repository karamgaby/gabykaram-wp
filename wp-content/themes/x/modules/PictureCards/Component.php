<?php

namespace X_Modules\PictureCards;

use X_UI\Core\AbstractComponent;

class Component extends AbstractComponent {
  private static TemplateLoader $templateLoader;

  private static array $styles = array( "mobile_cta", "picture_only" );
  private static array $devices = array( "mobile", "desktop" );

  protected static function get_data_placeholders(): array {
    return [
      'image_id' => '',
      'style'    => self::$styles[0],
      "device"   => self::$devices[0],
      'attr'     => array(),
      // optional
      'image_title' => '',
      'button_props' => array(

      ),
    ];
  }

  public static function frontend( $data = [] ) {
    $style                = $data['style'];
    self::$templateLoader = ! empty( self::$templateLoader ) ? self::$templateLoader : new TemplateLoader();
    if ( $style === 'mobile_cta' ) {
      self::$templateLoader->set_template_data( $data )->get_template_part( 'button-action' );
    } else {
      self::$templateLoader->set_template_data( $data )->get_template_part( 'picture-only' );
    }
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
    if ( empty( $args['style'] ) ) {
      parent::error( 'Missing style ($args[\'style\'])' );

      return;
    }
  }

  private static function manipulateAttrClass( $args ) {
    if ( ! isset( $args['attr']['class'] ) ) {
      $args['attr']['class'] = [];
    } elseif ( is_string( $args['attr']['class'] ) ) {
      $args['attr']['class'] = array( $args['attr']['class'] );
    }

    return $args;
  }
}
