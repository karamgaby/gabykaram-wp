<?php

use X_UI\Core\AbstractComponent;
use X_UI\Modules\Buttons\Component as Button;
use X_Theme\Modules\AccessibleSkipButton\Tokens;

/**
 * Component: AccessibilitySkipToContent
 *
 * @package x
 */
class AccessibilitySkipToContent extends AbstractComponent {

  protected static function get_data_placeholders(): array {
    return [
      'content_hashtag' => 'content',
      'attr'            => [],
    ];
  }

  public static function frontend( $data ) {
    $tokens       = Tokens::getInstance();
    $data2        = $tokens->getMeta( 'data' );
    $button_style = $data2['button_style'];
    Button::render(
      array(
        'style' => $button_style,
        'url'   => "#" . $data['content_hashtag'],
        'title' => ask__( 'Accessibility: Skip to content' ),
        'attr'  => $data['attr'],
      )
    );
    ?>

    <?php
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
    $args['attr']['class'][] = 'x-accessibility-skip-to-content';

    return $args;
  }
}
