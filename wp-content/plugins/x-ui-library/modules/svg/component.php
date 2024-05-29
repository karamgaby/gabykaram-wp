<?php

namespace X_UI\Modules\Svg;

use X_UI\Core\AbstractComponent;

/**
 * Component: SVG
 *
 * @example
 * X_SVG::render(['name' => 'plus']);
 */
class Component extends AbstractComponent {
  protected static array $sizes = array( 'small', 'xlarge' );

  protected static function get_data_placeholders(): array {
    $default_breakpoints_attr = parent::get_default_breakpoints_attr();

    return [

      // required
      'name'             => null,

      // optional
      'output'           => 'sprite',
      'attr'             => [],
      'title'            => '',
      'size'             => 'small',
      'size_breakpoints' => $default_breakpoints_attr,
    ];
  }

  /**
   * Image markup
   */
  public static function frontend( $data ) {
    /**
     * @ sprite
     * & sprite_path
     *
     * @ svg
     * svg_path
     */
    if ( $data['output'] === 'sprite' ) {
      self::sprite_frontend( $data );
    } else {
      $icon_name = esc_html( $data['name'] ) . '.svg';
      $svg_path  = get_template_directory() . '/images/icons/' . $icon_name;
      try {
        $svg_content = file_get_contents( $svg_path );
        $dom         = new \DOMDocument();
        $dom->loadXML( $svg_content );
        // Get the root <svg> element
        $svgElement           = $dom->getElementsByTagName( 'svg' )->item( 0 );
        $formatted_attributes = self::format_attributes( $data['attr'] );
        foreach ( $formatted_attributes as $key => $value ) {
          $svgElement->setAttribute( $key, $value );
        }
        $modifiedSvgString = $dom->saveXML();
        echo $modifiedSvgString;
      } catch ( \Exception $e ) {
        trigger_error( $e->getMessage(), E_USER_WARNING );
      }
    }
  }

  public static function sprite_frontend( $data ) {
    $last_edited = apply_filters( 'x_ui_component_sprite_last_edited', '1.0.0' );
    ?>
    <svg
      <?php
      parent::render_attributes( $data['attr'] );
      ?>
    >
      <?php
      if ( $data['title'] ) :
        ?>
        <title>
          <?php
          echo esc_html( $data['title'] );
          ?>
        </title>
      <?php
      endif;
      ?>
      <use
        xlink:href="<?= esc_attr( get_stylesheet_directory_uri() . '/dist/sprite/sprite.svg?ver=' . $last_edited . '#icon-' . esc_html( $data['name'] ) ); ?>">
      </use>
    </svg>
    <?php
  }

  /**
   * Build html attributes from key-value array
   *
   * @param array $attr key-value array of attribute names and values
   *
   * @return array attributes of key:(string) value
   */
  public static function format_attributes( $attr = array() ) {
    $return = array();
    foreach ( $attr as $key => $value ) {
      if ( is_array( $value ) ) {
        $value = implode( ' ', $value );
      }
      if ( ! empty( $value ) || is_numeric( $value ) ) {
        $return[ $key ] = esc_attr( $value );
      } else {
        $return[ $key ] = '';
      }
    }

    return $return;
  }

  /**
   * Fetch and setup image data
   *
   * @param array $args
   */
  public static function backend( $args = [] ) {
    if ( empty( $args['name'] ) ) {
      return parent::error( 'Missing icon name ($args[\'name\'])' );
    }
    if ( ! is_array( $args['size_breakpoints'] ) ) {
      return parent::error( 'Wrong icon size_breakpoints format ($args[\'size_breakpoints\']) should be an array' );
    }

    if ( ! empty( $args['title'] ) ) {
      $args['attr']['aria-labelledby'] = 'title';
    } else {
      $args['attr']['aria-hidden'] = 'true';
    }

    if ( ! isset( $args['attr']['class'] ) ) {
      $args['attr']['class'] = [];
    } elseif (!is_array( $args['attr']['class'] ) ) {
      $args['attr']['class'] = [$args['attr']['class']];
    }
    $args['attr']['class'][] = 'x-icon';
    $args['attr']['class'][] = 'x-icon-' . esc_html( $args['name'] );
    $args['attr']['class'][] = 'x-icon-size-' . esc_html( $args['size'] );

    foreach ( $args['size_breakpoints'] as $breakpoint => $value ) {
      if ( ! empty( $value ) ) {
        $args['attr']['class'][] = 'x-icon-size-' . $breakpoint . '-' . $value;
      }
    }

    if ( defined( 'DOING_AJAX' ) && DOING_AJAX && WP_DEBUG ) {
      $args['output'] = 'svg';
    }

    return $args;

  }

}
