<?php
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

class PS_Input extends PS_Component {
	protected static array $input_types    = array( 'text', 'number', 'textarea', 'email' );
	protected static array $sizes          = array( 'large', 'medium' );
	protected static array $icon_positions = array( 'left', 'right' );

	public static function frontend( $data ) {
		?>
	<div 
		<?php
		parent::render_attributes( $data['attr'] );
		?>
		>
		<?php
		if ( ! empty( $data['label_text'] ) ) :
			?>
	  <label class="ps-input-label-text mb-12 ps-typography-input_label" for="<?php echo $data['input_attr']['id']; ?>">
				<?php echo $data['label_text']; ?>
			</label>
			<?php
		endif;

		if ( $data['input_attr']['type'] === 'textarea' ) :
			?>
	  <div class="form-floating">
					<textarea 
					<?php
					parent::render_attributes( $data['input_attr'] );
					?>
						placeholder="<?php echo $data['input_attr']['placeholder']; ?>" class="ps-input-src"><?php echo ! empty( $data['input_attr']['value'] ) ? $data['input_attr']['value'] : ''; ?></textarea>
				</div>
		
			<?php
		else :
			?>
	  <span class="ps-input-wrapper">
			  <input 
			  <?php
				parent::render_attributes( $data['input_attr'] );
				?>
				placeholder="<?php echo $data['input_attr']['placeholder']; ?>" class="ps-input-src">
			<?php
			if ( $data['has_icon'] ) {
				?>
		  <span class="ps-input-icon-wrapper">
				<?php
				PS_Icon::render(
					array(
						'name' => $data['icon_name'],
						'size' => 'medium',
					)
				);
				?>
		  </span>
				<?php
			}
			?>
		   </span>
			<?php
		endif;
		?>
	  <span class="ps-input-message"></span>
			</div>
		<?php
	}

	public static function backend( $args = array() ) {
		$placeholders = array(
			// optional
			'attr'          => array(),
			'label_text'    => '',
			'is_required'   => false,
			'size'          => self::$sizes[0],
			'has_icon'      => false,
			'icon_position' => 'left',
			'icon_name'     => '',
			'input_attr'    => array(
				'type' => 'text',
			),
		);
		$args         = wp_parse_args( $args, $placeholders );

		if ( ! is_array( $args['input_attr'] ) ) {
			return parent::error( 'Wrong input_attr format ($args[\'input_attr\']) should be an array' );
		}
		if ( ! in_array( $args['input_attr']['type'], self::$input_types, true ) ) {
			return parent::error( 'Wrong input type ($args[\'input_attr\'][\'type\'])' );
		}
		if ( ! in_array( $args['size'], self::$sizes, true ) ) {
			return parent::error( 'Wrong input size ($args[\'size\'])' );
		}
		if ( $args['has_icon'] === true && empty( $args['icon_name'] ) ) {
			return parent::error( 'Icon name is required ($args[\'icon_name\'])' );
		}
		if ( $args['has_icon'] === true && ! in_array( $args['icon_position'], self::$icon_positions, true ) ) {
			return parent::error( 'Icon position is required ($args[\'icon_position\'])' );
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
			$args['attr']['class'] = array();
		} elseif ( is_string( $args['attr']['class'] ) ) {
			$args['attr']['class'] = array( $args['attr']['class'] );
		}

		if ( ! isset( $args['input_attr']['class'] ) ) {
			$args['input_attr']['class'] = array();
		} elseif ( is_string( $args['input_attr']['class'] ) ) {
			$args['attr']['class'] = array( $args['attr']['class'] );
		}

		$args['attr']['class'][]       = 'ps-input';
		$args['attr']['class'][]       = 'ps-input-size-' . $args['size'];
		$args['input_attr']['class'][] = 'ps-input-src';
		if ( $args['has_icon'] === true ) {
			$args['attr']['class'][] = 'ps-input-has-icon';
			$args['attr']['class'][] = 'ps-input-icon-position-' . $args['icon_position'];
		}

		return $args;
	}
}
