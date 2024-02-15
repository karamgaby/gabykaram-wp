<?php
/**
 * Component: ICON
 *
 * @example
 * PS_IconButton::render(['icon_name' => 'plus', 'size' => 'small', 'color' => 'primary']);
 */

class PS_IconButton extends PS_Component {
	protected static array $html_tags    = array( 'button', 'span', 'a' );
	protected static array $sizes        = array( 'large', 'medium', 'small' );
	protected static array $colors       = array( 'primary', 'secondary', 'base' );
	protected static array $button_types = array( 'button', 'submit', 'reset' );


	public static function frontend( $data ) {
		$html_tag = $data['html_tag'];
		?>
		<<?php echo $html_tag . ' '; ?>
			 <?php
				parent::render_attributes( $data['attr'] );
				?>
		>
		<?php
		PS_Icon::render(
			array(
				'name'             => $data['icon_name'],
				'size'             => $data['size'] === 'large' ? 'large' : 'small',
				'size_breakpoints' => $data['icon_size_breakpoints'],
			)
		);
		?>

		</<?php echo $html_tag; ?>>
		<?php
	}

	public static function backend( $args = array() ) {
		$default_breakpoints_attr = parent::get_default_breakpoints_attr();
		$placeholders             = array(
			// required
			'icon_name'        => null,
			'html_tag'         => 'button',
			// optional
			'size'             => 'small',
			'title'            => '',
			'size_breakpoints' => $default_breakpoints_attr,
			'attr'             => array(),
		);
		$args                     = wp_parse_args( $args, $placeholders );
		if ( empty( $args['icon_name'] ) ) {
			return parent::error( 'Missing icon name ($args[\'icon_name\'])' );
		}
		if ( ! in_array( $args['size'], self::$sizes, true ) ) {
			return parent::error( 'Wrong icon button size ($args[\'size\'])' );
		}
		if ( ! in_array( $args['html_tag'], self::$html_tags, true ) ) {
			return parent::error( 'Wrong icon button size ($args[\'size\'])' );
		} elseif ( $args['html_tag'] === 'a' && ! isset( $args['attr']['href'] ) ) {
			return parent::error( 'Missing href attribute for button with html_tag "a" ($args[\'attr\'][\'href\'])' );
		} elseif ( $args['html_tag'] === 'button' && ! isset( $args['attr']['type'] ) ) {
			$args['attr']['type'] = self::$button_types[0];
		} elseif ( $args['html_tag'] === 'button' && ! in_array( $args['attr']['type'], self::$button_types, true ) ) {
			return parent::error( 'Wrong button type ($args[\'attr\'][\'type\'])' );
		} elseif ( $args['html_tag'] === 'a' && ! isset( $args['attr']['type'] ) ) {
			unset( $args['attr']['type'] );
		}
		if ( ! in_array( $args['color'], self::$colors, true ) ) {
			return parent::error( 'Wrong icon button color ($args[\'color\'])' );
		}
		if ( ! is_array( $args['size_breakpoints'] ) ) {
			return parent::error( 'Wrong icon button size_breakpoints format ($args[\'size_breakpoints\']) should be an array' );
		}
		foreach ( $args['size_breakpoints'] as $size_breakpoint_key => $value ) {
			if ( ! empty( $value ) && ! in_array( $size_breakpoint_key, ps_get_meta( 'media_breakpoints' ), true ) ) {
				return parent::error(
					$size_breakpoint_key . $value . 'Wrong icon size_breakpoints format ($args[\'size_breakpoints\']) should be an array with keys: ' . implode(
						', ',
						ps_get_meta( 'media_breakpoints' )
					)
				);
			} elseif ( ! empty( $value ) && ! in_array( $value, self::$sizes, true ) ) {
				return parent::error( 'Wrong icon size_breakpoints ($args[\'size_breakpoints\'][\';' . $size_breakpoint_key . '\'])' );
			}
		}

		if ( ! empty( $args['title'] ) ) {
			$args['attr']['aria-labelledby'] = $args['title'];
		} else {
			$args['attr']['aria-hidden'] = 'true';
		}
		if ( ! isset( $args['attr']['class'] ) ) {
			$args['attr']['class'] = array();
		} elseif ( is_string( $args['attr']['class'] ) ) {
			$args['attr']['class'] = array( $args['attr']['class'] );
		}

		$args['attr']['class'][]       = 'ps-btn-icon';
		$args['attr']['class'][]       = 'p-12';
		$args['attr']['class'][]       = 'ps-btn-icon-size-' . $args['size'];
		$args['attr']['class'][]       = 'ps-btn-icon-color-' . $args['color'];
		$args['icon_size_breakpoints'] = array();
		foreach ( $args['size_breakpoints'] as $breakpoint => $value ) {
			if ( ! empty( $value ) ) {
				$icon_size = 'small';
				if ( $value === 'large' ) {
					 $icon_size = 'large';
				}
				$args['icon_size_breakpoints'][ $breakpoint ] = $icon_size;
				$args['attr']['class'][]                      = 'ps-btn-icon-size-' . $breakpoint . '-' . $value;
			}
		}

		if ( $args['html_tag'] === 'span' ) {
			$args['attr']['tabindex'] = '0';
			$args['attr']['role']     = 'button';
		} else {
			$args['attr']['type'] = 'button';
		}

		return $args;
	}
}
