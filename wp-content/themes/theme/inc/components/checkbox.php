<?php
/**
 * Component: Checkbox
 *
 * @example
 * PS_Checkbox::render( [
 *       'label_text'     => 'text',
 *      'input_name'  => 'text',
 *      'input_value' => 'text',
 *      'size'           => 'medium',
 *      'color'          => 'primary',
 *      'is_checked'     => true,
 *    ] );;
 */

class PS_Checkbox extends PS_Component {

	protected static array $sizes  = array( 'medium', 'small' );
	protected static array $colors = array( 'primary', 'secondary' );

	public static function frontend( $data ) {
		?>
		<label <?php parent::render_attributes( $data['attr'] ); ?>>
			<input type="checkbox" name="<?php echo esc_html( $data['input_name'] ); ?>"
				   class="<?php echo $data['input_class']; ?>"
				   <?php echo ! empty( $data['input_id'] ) ? ( ' id="' . $data['input_id'] . '"' ) : ''; ?>
				   <?php echo $data['is_checked'] ? 'checked="checked"' : ''; ?>
				   <?php echo $data['is_disabled'] ? 'disabled="disabled"' : ''; ?>
				   <?php echo $data['is_required'] ? ' required ' : ''; ?>
				   value="<?php echo esc_html( $data['input_value'] ); ?>"
			>
			<span class="ps-checkbox-visual">
				<span class="ps-checkbox-visual-filled">
				 <?php
					PS_Icon::render(
						array(
							'name' => 'filled-toggle-check-box',
							'size' => $data['size'],
						)
					);
					?>
				</span>
				<span class="ps-checkbox-visual-blank">
				 <?php
					PS_Icon::render(
						array(
							'name' => 'filled-toggle-check-box-outline-blank',
							'size' => $data['size'],

						)
					);
					?>
				</span>
			</span>
			<span class="ps-checkbox-label-text <?php echo ! $data['show_label'] ? 'visually-hidden' : ''; ?>">
				<?php echo $data['label_text']; ?>
			</span>
		</label>
		<?php
	}

	public static function backend( $args = array() ) {
		$placeholders = array(
			// required
			'label_text'  => null,
			'input_name'  => null,
			'input_value' => null,
			'size'        => self::$sizes[0],
			'color'       => self::$colors[0],
			// optional
			'attr'        => array(),
			'show_label'  => true,
			'icon_name'   => '',
			'is_checked'  => false,
			'is_disabled' => false,
			'is_required' => false,
			'input_class' => '',
			'input_id'    => '',
		);
		$args         = wp_parse_args( $args, $placeholders );
		if ( empty( $args['label_text'] ) ) {
			return parent::error( 'Missing checkbox label text ($args[\'label_text\'])' );
		}
		if ( empty( $args['input_name'] ) ) {
			return parent::error( 'Missing checkbox name ($args[\'input_name\'])' );
		}
		if ( empty( $args['input_value'] ) ) {
			return parent::error( 'Missing checkbox value ($args[\'input_value\'])' );
		}
		if ( ! in_array( $args['size'], self::$sizes, true ) ) {
			return parent::error( 'Wrong checkbox size ($args[\'size\'])' );
		}
		if ( ! in_array( $args['color'], self::$colors, true ) ) {
			return parent::error( 'Wrong checkbox color ($args[\'color\'])' );
		}
		if ( ! is_bool( $args['is_checked'] ) ) {
			return parent::error( 'Wrong checkbox checked state ($args[\'is_checked\']) only boolean is acceptable' );
		}
		if ( ! is_bool( $args['is_disabled'] ) ) {
			return parent::error( 'Wrong checkbox disabled state ($args[\'is_disabled\']) only boolean is acceptable' );
		}
		if ( ! is_bool( $args['show_label'] ) ) {
			return parent::error( 'Wrong checkbox label display status ($args[\'show_label\']) only boolean is acceptable' );
		}

		if ( ! isset( $args['attr']['class'] ) ) {
			$args['attr']['class'] = array();
		}
		$args['attr']['class'][] = 'ps-checkbox';
		$args['attr']['class'][] = 'ps-checkbox-size-' . $args['size'];
		$args['attr']['class'][] = 'ps-checkbox-color-' . $args['color'];

		return $args;
	}
}
