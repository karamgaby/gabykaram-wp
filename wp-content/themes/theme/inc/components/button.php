<?php
/**
 * Component: Button
 *
 * @example
 * PS_Button::render( [
 *      'variant'      => 'contained',
 *      'size'         => 'large',
 *      'text'         => 'PolarStork',
 *      'color'        => 'primary',
 *      'content_type' => 'text-only',
 *  ] );
 */

class PS_Button extends PS_Component {

	public static array $variants      = array( 'contained', 'outlined', 'text', 'navigation' );
	public static array $sizes         = array( 'large', 'medium', 'none' );
	public static array $text_sizes    = array( 'large', 'medium', 'small' );
	public static array $content_types = array( 'text-only', 'icon-right', 'icon-left' );
	public static array $colors        = array( 'base', 'primary', 'secondary' );
	public static array $html_tags     = array( 'button', 'a' );
	public static array $button_types  = array( 'button', 'submit', 'reset' );

	public static function frontend( $data ) {
		$html_tag     = $data['html_tag'];
		$content_type = $data['content_type'];
		?>
	<<?php echo $html_tag . ' '; ?>
		 <?php
			parent::render_attributes( $data['attr'] );
			?>
		>
		<?php
		if ( $content_type === 'icon-left' ) :
			PS_Icon::render(
				array(
					'name' => $data['icon_name'],
				)
			);
		endif;
		if ( $content_type !== 'text-only' ) :
			?>
			<span>
			<?php
		endif;
		echo $data['text'];
		if ( $content_type !== 'text-only' ) :
			?>
	  </span>
			<?php
			if ( $content_type === 'icon-right' ) :
				PS_Icon::render(
					array(
						'name' => $data['icon_name'],
						'attr' => $data['icon_attr'],
					)
				);
			endif;
		endif;

		?>
	</<?php echo $html_tag; ?>>
		
		<?php
	}

	public static function backend( $args = array() ) {
		$default_breakpoints_attr = parent::get_default_breakpoints_attr();
		$placeholders             = array(
			// required
			'text'                  => null,
			'variant'               => self::$variants[0],
			'size'                  => self::$sizes[0],
			'text_size'             => self::$text_sizes[0],
			'content_type'          => self::$content_types[0],
			'color'                 => self::$colors[0],
			'html_tag'              => 'button',
			// optional
			'size_breakpoints'      => $default_breakpoints_attr,
			'text_size_breakpoints' => $default_breakpoints_attr,
			'attr'                  => array(),
			'icon_name'             => '',
			'icon_attr'             => array(),
		);
		$args                     = wp_parse_args( $args, $placeholders );
		if ( ! isset( $args['attr']['class'] ) ) {
			$args['attr']['class'] = array();
		} elseif ( is_string( $args['attr']['class'] ) ) {
			$args['attr']['class'] = array( $args['attr']['class'] );
		}
		if ( $args['content_type'] === 'icon-right' && empty( $args['icon_name'] ) ) {
			$args['icon_name'] = 'filled-navigation-arrow-forward';
		}
		if ( $args['content_type'] === 'icon-left' && empty( $args['icon_name'] ) ) {
			$args['icon_name'] = 'filled-navigation-arrow-back';
		}
		if ( empty( $args['text'] ) ) {
			return parent::error( 'Missing button text ($args[\'text\'])' );
		}
		if ( ! in_array( $args['variant'], self::$variants, true ) ) {
			return parent::error( 'Wrong button variant ($args[\'variant\'])' );
		}
		if ( ! in_array( $args['size'], self::$sizes, true ) ) {
			return parent::error( 'Wrong button size ($args[\'size\'])' );
		}
		if ( ! is_array( $args['size_breakpoints'] ) ) {
			return parent::error( 'Wrong button size_breakpoints format ($args[\'size_breakpoints\']) should be an array' );
		}
		foreach ( $args['size_breakpoints'] as $size_breakpoint_key => $value ) {
			if ( ! empty( $value ) && ! in_array( $size_breakpoint_key, ps_get_meta( 'media_breakpoints' ), true ) ) {
				return parent::error(
					'Wrong button size_breakpoints format ($args[\'size_breakpoints\']) should be an array with keys: ' . implode(
						', ',
						ps_get_meta( 'media_breakpoints' )
					)
				);
			} elseif ( ! empty( $value ) && ! in_array( $value, self::$sizes, true ) ) {
				return parent::error( 'Wrong button size_breakpoints ($args[\'size_breakpoints\'][\'' . $size_breakpoint_key . '\'])' );
			}
		}
		if ( ! in_array( $args['text_size'], self::$text_sizes, true ) ) {
			return parent::error( 'Wrong button text_sizes ($args[\'text_sizes\'])' );
		}
		if ( ! is_array( $args['text_size_breakpoints'] ) ) {
			return parent::error( 'Wrong button text_size_breakpoints format ($args[\'text_size_breakpoints\']) should be an array' );
		}
		foreach ( $args['text_size_breakpoints'] as $text_size_breakpoint_key => $value ) {
			if ( ! empty( $value ) && ! in_array( $text_size_breakpoint_key, ps_get_meta( 'media_breakpoints' ), true ) ) {
				return parent::error(
					'Wrong button text_size_breakpoints format ($args[\'text_size_breakpoints\']) should be an array with keys: ' . implode(
						', ',
						ps_get_meta( 'media_breakpoints' )
					)
				);
			} elseif ( ! empty( $value ) && ! in_array( $value, self::$sizes, true ) ) {
				return parent::error( 'Wrong button text_size ($args[\'text_size_breakpoints\'][\';' . $text_size_breakpoint_key . '\'])' );
			}
		}
		if ( ! in_array( $args['content_type'], self::$content_types, true ) ) {
			return parent::error( 'Wrong button content_type ($args[\'content_type\'])' );
		}
		if ( ! in_array( $args['color'], self::$colors, true ) ) {
			return parent::error( 'Wrong button color ($args[\'color\'])' );
		}

		if ( ! in_array( $args['html_tag'], self::$html_tags, true ) ) {
			return parent::error( 'Wrong button html_tag ($args[\'html_tag\'])' );
		} elseif ( $args['html_tag'] === 'a' && ! isset( $args['attr']['href'] ) ) {
			return parent::error( 'Missing href attribute for button with html_tag "a" ($args[\'attr\'][\'href\'])' );
		} elseif ( $args['html_tag'] === 'button' && ! isset( $args['attr']['type'] ) ) {
			$args['attr']['type'] = self::$button_types[0];
		} elseif ( $args['html_tag'] === 'button' && ! in_array( $args['attr']['type'], self::$button_types, true ) ) {
			return parent::error( 'Wrong button type ($args[\'attr\'][\'type\'])' );
		} elseif ( $args['html_tag'] === 'a' && ! isset( $args['attr']['type'] ) ) {
			unset( $args['attr']['type'] );
		}

		$args['attr']['class'][] = 'ps-btn';
		$args['attr']['class'][] = 'ps-btn-html-tag-' . $args['html_tag'];
		$args['attr']['class'][] = 'ps-btn-variant-' . $args['variant'];
		$args['attr']['class'][] = 'ps-btn-size-' . $args['size'];
		$args['attr']['class'][] = 'ps-btn-text-size-' . $args['text_size'];
		$args['attr']['class'][] = 'ps-btn-content-type-' . $args['content_type'];
		$args['attr']['class'][] = 'ps-btn-color-' . $args['color'];

		foreach ( $args['size_breakpoints'] as $breakpoint => $value ) {
			if ( ! empty( $value ) ) {
				$args['attr']['class'][] = 'ps-btn-size-' . $breakpoint . '-' . $value;
			}
		}
		foreach ( $args['text_size_breakpoints'] as $breakpoint => $value ) {
			if ( ! empty( $value ) ) {
				$args['attr']['class'][] = 'ps-btn-text-size-' . $breakpoint . '-' . $value;
			}
		}

		return $args;
	}

}
