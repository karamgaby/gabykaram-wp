<?php
/**
 * Component: RadioButton
 *
 * @example
 * PS_RadioButton::render( [
 *       'label_text'     => 'text',
 *      'input_name'  => 'text',
 *      'checkbox_value' => 'text',
 *      'size'           => 'medium',
 *      'color'          => 'primary',
 *      'is_checked'     => true,
 *    ] );;
 */
class PS_RadioButton extends PS_Component {

	protected static array $sizes  = array( 'medium', 'small' );
	protected static array $colors = array( 'primary', 'secondary' );

	public static function frontend( $data ) {
		?>
	<div>
	  <input type="radio" name="<?php echo esc_html( $data['input_name'] ); ?>"
			 class="<?php echo $data['input_class']; ?>"
		  <?php echo ! empty( $data['input_id'] ) ? 'id="' . $data['input_id'] . '"' : ''; ?>
		  <?php echo $data['is_checked'] ? ' checked="checked" ' : ''; ?>
		  <?php echo $data['is_required'] ? ' required ' : ''; ?>
		  <?php echo $data['is_disabled'] ? 'disabled="disabled"' : ''; ?>
			 value="<?php echo esc_html( $data['checkbox_value'] ); ?>">
		<label <?php parent::render_attributes( $data['attr'] ); ?>>
			<span class="ps-radio-button-visual">
				<span class="ps-radio-button-visual-filled">
				 <?php
					PS_Icon::render(
						array(
							'name' => 'filled-toggle-radio-button-checked',
							'size' => $data['size'],
						)
					);
					?>
				</span>
				<span class="ps-radio-button-visual-blank">
				 <?php
					PS_Icon::render(
						array(
							'name' => 'filled-toggle-radio-button-unchecked',
							'size' => $data['size'],

						)
					);
					?>
				</span>
			</span>
			<span class="ps-radio-button-label-text <?php echo ! $data['show_label'] ? 'visually-hidden' : ''; ?>">
				<?php echo $data['label_text']; ?>
			</span>
		</label>
	</div>
		<?php
	}

	public static function backend( $args = array() ) {
		$placeholders = array(
			// required
			'label_text'     => null,
			'input_name'     => null,
			'checkbox_value' => null,
			'size'           => self::$sizes[0],
			'color'          => self::$colors[0],
			// optional
			'attr'           => array(),
			'show_label'     => true,
			'is_checked'     => false,
			'is_disabled'    => false,
			'is_required'    => false,
			'input_class'    => '',
			'input_id'       => '',
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
		if ( ! isset( $args['input_class'] ) ) {
			$args['input_class'] = '';
		}
		if ( empty( $args['input_id'] ) ) {
			$args['input_id'] = uniqid( 'ps-input-radio-', false ) . random_int( 1, 100 );
		}

		$args['attr']['class'][] = 'ps-radio-button';
		$args['attr']['class'][] = 'ps-radio-button-size-' . $args['size'];
		$args['attr']['class'][] = 'ps-radio-button-color-' . $args['color'];
		$args['attr']['for']     = $args['input_id'];
		$args['input_class']    .= ' ps-input-radio';
		return $args;
	}
}
