<?php
namespace X_UI\Modules\Buttons;

use X_UI\Modules\Svg\Component as Svg;
use X_UI\Core\AbstractComponent;

/**
 * Component: Button
 *
 * @package axio
 */
class Component extends AbstractComponent {

  //@todo move $variants to file -< this would be automatically generated file based on json tokens buttons.json
  public static array $variants = array(
    'primary-standard',
    'primary-outlined',
    'primary-light',
    'secondary-outlined',
    'secondary-text'
  );
  public static array $button_types = array( 'button', 'submit', 'reset' );

  protected static function get_data_placeholders(): array {
    return  [
      // required
      'title'         => '',
      'style'         => self::$variants[0],
      'url'           => '#',

      // optional
      'icon'          => null,
      'has_icon'      => false,
      'icon_position' => false,
      'as'            => 'a',
      'target'        => '_self',
      'type'          => null,
      'attr'          => [],
    ];
  }
  public static function frontend( $data ) {
    $html_tag      = $data['as'];
    if(!isset($data['icon'])) {
//      'icon'          => isset( $args['icon_position'] ) && $args['icon_position'] === 'start' ? 'chevron-left' : 'chevron-right',
      $icon          =  isset( $data['icon_position'] ) && $data['icon_position'] === 'start' ? 'chevron-left' : 'chevron-right';
    } else {
      $icon          = $data['icon'];
    }
    $has_icon      = $icon && $data['has_icon'];
    $icon_position = $data['icon_position'];
    ?>
    <<?php echo $html_tag . ' '; ?><?php parent::render_attributes( $data['attr'] ); ?>>
    <span>
       <?php
       if ( ! ! $has_icon && $icon_position === 'start' ) {
         Svg::render( array(
           'name' => $icon
         ) );
       }
       ?>
    <span><?php echo $data['title']; ?></span>
    <?php
    if ( ! ! $has_icon && $icon_position === 'end' ) {
      Svg::render( array(
        'name' => $icon
      ) );
    }
    ?>
    </span>
    </<?php echo $html_tag . ' '; ?>>
    <?php
  }

  public static function backend( $args = [] ) {
    $args = self::manipulateAttrClass( $args );

    if ( $args['as'] === 'button' && ! isset( $args['type'] ) ) {
      $args['type'] = 'button';
    }
    if ( ! isset( $args['attr']['href'] ) ) {
      $args['attr']['href'] = $args['url'];
    }
    if ( ! isset( $args['attr']['target'] ) ) {
      $args['attr']['target'] = $args['target'];
    }


    return $args;

  }

  private static function manipulateAttrClass( $args ) {
    if ( ! isset( $args['attr']['class'] ) ) {
      $args['attr']['class'] = [];
    } elseif ( is_string( $args['attr']['class'] ) ) {
      $args['attr']['class'] = array( $args['attr']['class'] );
    }

    // use prefixed class to avoid styling clashes
    $args['attr']['class'][] = 'x-btn';
    $args['attr']['class'][] = 'x-btn-style-' . $args['style'];

    if ( ! empty( $args['attr']['disabled'] ) ) {
      $args['attr']['class'][] = 'x-btn-disabled';
    }

    return $args;
  }
}
