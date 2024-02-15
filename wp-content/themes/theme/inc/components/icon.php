<?php
/**
 * Component: ICON
 *
 * @example
 * PS_Icon::render(['name' => 'plus']);
 */

class PS_Icon extends PS_Component {
	protected static array $sizes = array( 'small', 'medium', 'large', 'larger', 'xlarge', 'xxlarge', 'xxxlarge' );

	public static function frontend( $data ) {
		if ( $data['output'] === 'sprite' ) {
			self::sprite_frontend( $data );
		} else {
			$icon_name = 'icon-' . esc_html( $data['name'] ) . '.svg';
			$svg_path  = get_template_directory() . '/build/icons/' . $icon_name;
			try {
				$svg_content = file_get_contents( $svg_path );
				$dom         = new DOMDocument();
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
			<use xlink:href="
			<?php
			echo esc_attr( get_template_directory_uri() . '/build/sprite/icons.svg?ver=' . STORKER_THEME_VERSION . '#icon-' . esc_html( $data['name'] ) );
			?>
			"></use>
		</svg>
		<?php
	}

	public static function backend( $args = array() ) {
		$default_breakpoints_attr = parent::get_default_breakpoints_attr();
		$placeholders             = array(
			// required
			'name'             => null,
			'output'           => 'svg',
			// optional
			'attr'             => array(),
			'title'            => '',
			'size'             => 'small',
			'size_breakpoints' => $default_breakpoints_attr,
			'is_masked'        => false,
		);
		$args                     = wp_parse_args( $args, $placeholders );
		if ( empty( $args['name'] ) ) {
			return parent::error( 'Missing icon name ($args[\'name\'])' );
		}
		if ( ! in_array( $args['size'], self::$sizes, true ) ) {
			return parent::error( 'Wrong icon size ($args[\'size\'])' );
		}
		if ( ! is_array( $args['size_breakpoints'] ) ) {
			return parent::error( 'Wrong icon size_breakpoints format ($args[\'size_breakpoints\']) should be an array' );
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

		$args['attr']['class'][] = 'ps-icon';
		$args['attr']['class'][] = 'ps-icon-' . esc_html( $args['name'] );
		$args['attr']['class'][] = 'ps-icon-size-' . $args['size'];

		foreach ( $args['size_breakpoints'] as $breakpoint => $value ) {
			if ( ! empty( $value ) ) {
				$args['attr']['class'][] = 'ps-icon-size-' . $breakpoint . '-' . $value;
			}
		}

		return $args;
	}
}
