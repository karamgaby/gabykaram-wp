<?php
/**
 ** A base module for [textarea] and [textarea*]
 **/

/* form_tag handler */

use X_Modules\Inputs\InputComponent;

add_action( 'wpcf7_init', 'x_wpcf7_add_form_tag_textarea', 10, 0 );


/**
 * Returns a class names list for a form-tag of the specified type.
 *
 * @param string $type Form-tag type.
 * @param string $default_classes Optional default classes.
 * @return string Whitespace-separated list of class names.
 */
function x_wpcf7_form_textarea_controls_class( $type, $default_classes = '' ) {
  // @todo join x_wpcf7_form_textarea_controls_class and x_wpcf7_form_controls_class functions into the same (duplicate code) - move it up
  $type = trim( $type );

  if ( is_string( $default_classes ) ) {
    $default_classes = explode( ' ', $default_classes );
  }

  $classes = array(
    'x_inputs-wpcf7-form-control',
    sprintf( 'wpcf7-%s', rtrim( $type, '*' ) ),
  );

  if ( str_ends_with( $type, '*' ) ) {
    $classes[] = 'x_inputs-wpcf7-validates-as-required';
  }

  $classes = array_merge( $classes, $default_classes );
  $classes = array_filter( array_unique( $classes ) );

  return implode( ' ', $classes );
}

function x_wpcf7_add_form_tag_textarea() {
  wpcf7_add_form_tag( array( 'x_textarea', 'x_textarea*' ),
    'x_wpcf7_textarea_form_tag_handler', array( 'name-attr' => true )
  );
}


function x_wpcf7_textarea_form_tag_handler( $tag ) {
  if ( empty( $tag->name ) ) {
    return '';
  }

  $validation_error = wpcf7_get_validation_error( $tag->name );

  $class = x_wpcf7_form_textarea_controls_class( $tag->type );
  $label_text = null;
  if ( $validation_error ) {
    $class .= ' x_inputs-wpcf7-not-valid';
  }

  $atts = array();

  $atts['cols']      = $tag->get_cols_option( '40' );
  $atts['rows']      = $tag->get_rows_option( '10' );
  $atts['maxlength'] = $tag->get_maxlength_option();
  $atts['minlength'] = $tag->get_minlength_option();

  if ( $atts['maxlength'] and $atts['minlength']
                              and $atts['maxlength'] < $atts['minlength'] ) {
    unset( $atts['maxlength'], $atts['minlength'] );
  }

  $atts['class']    = $tag->get_class_option( $class );
  $atts['id']       = $tag->get_id_option();
  $atts['tabindex'] = $tag->get_option( 'tabindex', 'signed_int', true );
  $atts['readonly'] = $tag->has_option( 'readonly' );

  $atts['autocomplete'] = $tag->get_option(
    'autocomplete', '[-0-9a-zA-Z]+', true
  );

  if ( $tag->is_required() ) {
    $atts['aria-required'] = 'true';
  }

  if ( $validation_error ) {
    $atts['aria-invalid']     = 'true';
    $atts['aria-describedby'] = wpcf7_get_validation_error_reference(
      $tag->name
    );
  } else {
    $atts['aria-invalid'] = 'false';
  }

  $value = empty( $tag->content )
    ? (string) reset( $tag->values )
    : $tag->content;

  if ( $tag->has_option( 'placeholder' )
       or $tag->has_option( 'watermark' ) ) {
    $atts['placeholder'] = $value;
    $value               = '';
  }
  if ( $tag->has_option( 'jsonData' ) ) {
    try {
      $data  = json_decode( $value );
      $value = '';
      if ( ! empty( $data->placeholder ) ) {
        $atts['placeholder'] = $data->placeholder;
      }
      if ( ! empty( $data->label ) ) {
        $label_text = $data->label;
      }

      if ( ! empty( $data->value ) ) {
        $value = $data->value;
      }

    } catch ( Exception $exception ) {

    }
  }
  $value = $tag->get_default_option( $value );

  $value = wpcf7_get_hangover( $tag->name, $value );

  $atts['name'] = $tag->name;
  $atts['type'] = 'textarea';
  $atts['value'] = $value;

  $input_comp_attr =  array(
    'input_attr' => $atts,
    'attr'       => [
      'data-name' => $tag->name,
      'class' => 'x_inputs-wpcf7-form-control-wrap'
    ]
  );
  if ( ! empty( $label_text ) ):
    $input_comp_attr['label_text'] = $label_text;
  endif;
  return InputComponent::get($input_comp_attr);
}


add_action(
  'wpcf7_swv_create_schema',
  'x_wpcf7_swv_add_textarea_rules',
  10, 2
);

function x_wpcf7_swv_add_textarea_rules( $schema, $contact_form ) {
  $tags = $contact_form->scan_form_tags( array(
    'basetype' => array( 'x_textarea' ),
  ) );

  foreach ( $tags as $tag ) {
    if ( $tag->is_required() ) {
      $schema->add_rule(
        wpcf7_swv_create_rule( 'required', array(
          'field' => $tag->name,
          'error' => wpcf7_get_message( 'invalid_required' ),
        ) )
      );
    }

    if ( $minlength = $tag->get_minlength_option() ) {
      $schema->add_rule(
        wpcf7_swv_create_rule( 'minlength', array(
          'field'     => $tag->name,
          'threshold' => absint( $minlength ),
          'error'     => wpcf7_get_message( 'invalid_too_short' ),
        ) )
      );
    }

    if ( $maxlength = $tag->get_maxlength_option() ) {
      $schema->add_rule(
        wpcf7_swv_create_rule( 'maxlength', array(
          'field'     => $tag->name,
          'threshold' => absint( $maxlength ),
          'error'     => wpcf7_get_message( 'invalid_too_long' ),
        ) )
      );
    }
  }
}


/* Tag generator */

add_action( 'wpcf7_admin_init', 'x_wpcf7_add_tag_generator_textarea', 20, 0 );

function x_wpcf7_add_tag_generator_textarea() {
  $tag_generator = WPCF7_TagGenerator::get_instance();
  $tag_generator->add( 'x_textarea', __( 'X text area', 'contact-form-7' ),
    'x_wpcf7_tag_generator_textarea' );
}

function x_wpcf7_tag_generator_textarea( $contact_form, $args = '' ) {
  $args = wp_parse_args( $args, array() );
  $type = 'x_textarea';

  $description = __( "Generate a form-tag for a multi-line text input field.", 'contact-form-7' );


  ?>
  <div class="control-box">
    <fieldset>
      <legend><?php echo esc_html( $description ); ?></legend>

      <table class="form-table">
        <tbody>
        <tr>
          <th scope="row"><?php echo esc_html( __( 'Field type', 'contact-form-7' ) ); ?></th>
          <td>
            <fieldset>
              <legend
                class="screen-reader-text"><?php echo esc_html( __( 'Field type', 'contact-form-7' ) ); ?></legend>
              <label><input type="checkbox"
                            name="required"/> <?php echo esc_html( __( 'Required field', 'contact-form-7' ) ); ?>
              </label>
            </fieldset>
          </td>
        </tr>

        <tr>
          <th scope="row"><label
              for="<?php echo esc_attr( $args['content'] . '-name' ); ?>"><?php echo esc_html( __( 'Name', 'contact-form-7' ) ); ?></label>
          </th>
          <td><input type="text" name="name" class="tg-name oneline"
                     id="<?php echo esc_attr( $args['content'] . '-name' ); ?>"/></td>
        </tr>

        <tr>
          <th scope="row"><label
              for="<?php echo esc_attr( $args['content'] . '-values' ); ?>"><?php echo esc_html( __( 'Default value', 'contact-form-7' ) ); ?></label>
          </th>
          <td><input type="text" name="values" class="oneline"
                     id="<?php echo esc_attr( $args['content'] . '-values' ); ?>"/><br/>
            <label><input type="checkbox" name="placeholder"
                          class="option"/> <?php echo esc_html( __( 'Use this text as the placeholder of the field', 'contact-form-7' ) ); ?>
            </label></td>
        </tr>

        <tr>
          <th scope="row"><label
              for="<?php echo esc_attr( $args['content'] . '-id' ); ?>"><?php echo esc_html( __( 'Id attribute', 'contact-form-7' ) ); ?></label>
          </th>
          <td><input type="text" name="id" class="idvalue oneline option"
                     id="<?php echo esc_attr( $args['content'] . '-id' ); ?>"/></td>
        </tr>

        <tr>
          <th scope="row"><label
              for="<?php echo esc_attr( $args['content'] . '-class' ); ?>"><?php echo esc_html( __( 'Class attribute', 'contact-form-7' ) ); ?></label>
          </th>
          <td><input type="text" name="class" class="classvalue oneline option"
                     id="<?php echo esc_attr( $args['content'] . '-class' ); ?>"/></td>
        </tr>

        </tbody>
      </table>
    </fieldset>
  </div>

  <div class="insert-box">
    <input type="text" name="<?php echo $type; ?>" class="tag code" readonly="readonly" onfocus="this.select()"/>

    <div class="submitbox">
      <input type="button" class="button button-primary insert-tag"
             value="<?php echo esc_attr( __( 'Insert Tag', 'contact-form-7' ) ); ?>"/>
    </div>

    <br class="clear"/>

    <p class="description mail-tag"><label
        for="<?php echo esc_attr( $args['content'] . '-mailtag' ); ?>"><?php echo sprintf( esc_html( __( "To use the value input through this field in a mail field, you need to insert the corresponding mail-tag (%s) into the field on the Mail tab.", 'contact-form-7' ) ), '<strong><span class="mail-tag"></span></strong>' ); ?>
        <input type="text" class="mail-tag code hidden" readonly="readonly"
               id="<?php echo esc_attr( $args['content'] . '-mailtag' ); ?>"/></label></p>
  </div>
  <?php
}

?>
