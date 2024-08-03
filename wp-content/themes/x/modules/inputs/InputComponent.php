<?php

namespace X_Modules\Inputs;

use X_UI\Core\AbstractComponent;

/**
 * Component: Input
 *
 * @example
 * PS_Input::render( array(
 *   'input_attr'           => array(
 *      'type'                 => 'text',
 *      'placeholder'          => '$ Custom amount',
 *   ),
 *     'is_required'    => false,
 *   'label'   => 'Custom amount',
 *   'attr'              => array(
 *   'class'       => [ 'mt-24' ],
 *
 *   )) );
 */
class InputComponent extends AbstractComponent {
  protected static array $input_types = array( 'text', 'number', 'textarea', 'email', 'tel', 'url' );
  protected static array $sizes = array( 'large', 'medium' );
  protected static array $icon_positions = array( 'left', 'right' );

  public static function frontend( $data ) {
    ?>
    <div <?php
    parent::render_attributes( $data['attr'] ); ?>>
      <?php
      if ( ! empty( $data['label_text'] ) ) :
        ?>
        <label class="ps-input-label-text mb-1 x-typography-input-text x-color-mate-black-400" for="<?= $data['input_attr']['id'] ?>">
          <?= $data['label_text'] ?>
        </label>
      <?php
      endif;

      if ( $data['input_attr']['type'] === 'textarea' ) :
        ?>
        <div class="form-floating d-flex">
                    <textarea <?php
                    parent::render_attributes( $data['input_attr'] ); ?>
                        placeholder="<?= $data['input_attr']['placeholder']; ?>"
                        class="ps-input-src"><?= ! empty( $data['input_attr']['value'] ) ? $data['input_attr']['value'] : '' ?></textarea>
        </div>

      <?php
      else:
        ?>
        <span class="ps-input-wrapper">
              <input <?php
              parent::render_attributes( $data['input_attr'] ); ?>
                placeholder="<?= $data['input_attr']['placeholder']; ?>" class="ps-input-src">
           </span>
      <?php
      endif;
      ?>
      <span class="ps-input-message"></span>
    </div>
    <?php
  }

  public static function backend( $args = [] ) {
    $placeholders = [
      // optional
      'attr'          => [],
      'label_text'    => '',
      'is_required'   => false,
      'size'          => self::$sizes[0],
      'icon_position' => 'left',
      'icon_name'     => '',
      'input_attr'    => [
        'type' => 'text',
      ],
    ];
    $input_attr   = wp_parse_args( $args['input_attr'], array(
      'type'        => 'text',
      'placeholder' => ''
    ) );
    $args         = wp_parse_args( $args, $placeholders );

    $args['input_attr'] = $input_attr;
    if ( ! is_array( $args['input_attr'] ) ) {
      return parent::error( 'Wrong input_attr format ($args[\'input_attr\']) should be an array' );
    }
    if ( ! in_array( $args['input_attr']['type'], self::$input_types, true ) ) {
      return parent::error( 'Wrong input type ($args[\'input_attr\'][\'type\'])' );
    }
    if ( ! in_array( $args['size'], self::$sizes, true ) ) {
      return parent::error( 'Wrong input size ($args[\'size\'])' );
    }

    if ( ! empty( $args['input_attr']['placeholder'] ) ) {
      $args['input_attr']['aria-label'] = $args['input_attr']['placeholder'];
    } else {
      $args['input_attr']['aria-hidden'] = 'true';
    }


    if ( ! empty( $args['label_text'] ) && empty( $args['input_attr']['id'] ) ) {
      $args['input_attr']['id'] = uniqid( 'ps-input-src-', false ) . random_int( 1, 100 );
    }
    if ( $args['is_required'] ) {
      $args['input_attr']['required']      = 'required';
      $args['input_attr']['aria-required'] = 'true';
    }
    if ( ! isset( $args['attr']['class'] ) ) {
      $args['attr']['class'] = [];
    } elseif ( is_string( $args['attr']['class'] ) ) {
      $args['attr']['class'] = [ $args['attr']['class'] ];
    }

    if ( ! isset( $args['input_attr']['class'] ) ) {
      $args['input_attr']['class'] = [];
    } elseif ( is_string( $args['input_attr']['class'] ) ) {
      $args['input_attr']['class'] = [ $args['input_attr']['class'] ];
    }

    $args['attr']['class'][]       = 'ps-input';
    $args['attr']['class'][]       = 'ps-input-size-' . $args['size'];
    $args['input_attr']['class'][] = 'ps-input-src';

    return $args;
  }
}
