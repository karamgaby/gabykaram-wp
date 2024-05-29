<?php
namespace X_Modules\ContactSection;

use X_UI\Core\AbstractComponent;

class Component extends AbstractComponent {

  protected static function get_data_placeholders(): array {
    return [
    ];
  }

  private static TemplateLoader $templateLoader;

  public static function frontend( $data ): void {
    self::$templateLoader = ! empty( self::$templateLoader ) ? self::$templateLoader : new TemplateLoader();
    self::$templateLoader->set_template_data( $data )->get_template_part( 'section' );
  }
  public static function backend( $args = [] ) {
    $args = self::manipulateAttrClass( $args );

    return $args;

  }

  private static function manipulateAttrClass( $args ) {
    if ( ! isset( $args['attr']['class'] ) ) {
      $args['attr']['class'] = [];
    } elseif ( is_string( $args['attr']['class'] ) ) {
      $args['attr']['class'] = array( $args['attr']['class'] );
    }

    // use prefixed class to avoid styling clashes
    $args['attr']['class'][] = '';

    return $args;
  }
}
