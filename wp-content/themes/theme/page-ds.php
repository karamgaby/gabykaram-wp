<?php

/**
 * Template name: DS page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package polarstork
 */


get_header();
?>
  <main id="primary" class="site-main default-page">
	  <div class="container">
		<div class="row">
		  <div class="col-12">
			<h2>Typography</h2>
		  </div>
		  <div class="col-12">
			<p class="ps-typography-h1">H1</p>
			<p class="ps-typography-h3 ps-typography-lg-h2">H3 - H2 Desktop</p>
			<p class="ps-typography-h4 ps-typography-lg-h3">H4 - H3 Desktop</p>
			<div class="ps-free-text">
			  <p>This is a paragraph and this is a <a href="#">link</a></p>
			  <ul>
				<li>this</li>
				<li>is</li>
				<li>an</li>
				<li>un-ordered</li>
				<li>list</li>
			  </ul>
			  <ol>
				<li>this</li>
				<li>is</li>
				<li>an</li>
				<li>ordered</li>
				<li>list</li>
			  </ol>
			</div>
		  </div>
		</div>
	  </div>
	  <div class="container">
		<div class="row">
		  <div class="col-12">
			<h2>Button</h2>
		  </div>
		  <div class="col-12">
			<?php
			$colors = array( 'base', 'primary', 'secondary' );
			foreach ( $colors as $color ) :
				?>
			  <h3><?php echo $color; ?> Button</h3>
				<?php

				PS_Button::render(
					array(
						'variant'      => 'contained',
						'size'         => 'medium',
						'text'         => 'Base',
						'color'        => $color,
						'content_type' => 'text-only',
					)
				);
				PS_Button::render(
					array(
						'variant'      => 'contained',
						'size'         => 'medium',
						'text'         => 'Base Icon Right',
						'color'        => 'base',
						'icon_name'    => 'filled-facebook',
						'content_type' => 'icon-right',
					)
				);
				PS_Button::render(
					array(
						'variant'      => 'text',
						'size'         => 'medium',
						'text'         => 'Base variant text',
						'color'        => 'base',
						'icon_name'    => 'filled-twitter',
						'content_type' => 'text-only',
					)
				);
				PS_Button::render(
					array(
						'variant'      => 'navigation',
						'size'         => 'medium',
						'text'         => 'Base variant navigation',
						'color'        => 'base',
						'icon_name'    => 'filled-facebook',
						'content_type' => 'icon-left',
					)
				);
			endforeach;
			?>
		  </div>
		</div>
	  </div>
	  <div class="container">
		<h2>Icon Button</h2>
		  <?php
			PS_IconButton::render(
				array(
					'icon_name' => 'hamburger',
					'size'      => 'large',
					'title'     => 'Facebook icon button',
					'color'     => 'primary',
				)
			);
			PS_IconButton::render(
				array(
					'icon_name' => 'filled-facebook',
					'size'      => 'medium',
					'title'     => 'Facebook icon button',
					'color'     => 'secondary',
				)
			);
			PS_IconButton::render(
				array(
					'icon_name' => 'filled-twitter',
					'size'      => 'medium',
					'title'     => 'Facebook icon button',
					'color'     => 'secondary',
				)
			);
			PS_IconButton::render(
				array(
					'icon_name' => 'play-arrow',
					'size'      => 'large',
					'title'     => 'Facebook icon button',
					'color'     => 'secondary',
				)
			);
			?>
	  </div>
	  <div class="container">
		<h2>Checkbox</h2>
	
		  <?php
			PS_Checkbox::render(
				array(
					'label_text'  => 'unchecked checkbox',
					'input_name'  => 'text',
					'input_value' => 'text',
					'size'        => 'medium',
					'color'       => 'primary',
				)
			);
			PS_Checkbox::render(
				array(
					'label_text'  => 'checked checkbox',
					'input_name'  => 'text',
					'input_value' => 'text',
					'size'        => 'medium',
					'color'       => 'primary',
					'is_checked'  => true,
				)
			);
			PS_Checkbox::render(
				array(
					'label_text'  => 'checked checkbox',
					'input_name'  => 'text',
					'input_value' => 'text',
					'size'        => 'medium',
					'color'       => 'secondary',
					'is_checked'  => true,
				)
			);

			?>
	  </div>
	<div class="container">
	  <h2>Radio Button</h2>
		<?php
		PS_RadioButton::render(
			array(
				'label_text'  => 'unselected radio button',
				'input_name'  => 'something',
				'input_value' => 'text',
				'size'        => 'medium',
				'color'       => 'primary',
			)
		);
		PS_RadioButton::render(
			array(
				'label_text'  => 'selected radio button',
				'input_name'  => 'something',
				'input_value' => 'text',
				'size'        => 'small',
				'color'       => 'primary',
				'is_checked'  => true,
			)
		);
		PS_RadioButton::render(
			array(
				'label_text'  => 'selected radio button',
				'input_name'  => 'something2',
				'input_value' => 'text',
				'size'        => 'medium',
				'color'       => 'secondary',
			)
		);
		PS_RadioButton::render(
			array(
				'label_text'  => 'selected radio button',
				'input_name'  => 'something2',
				'input_value' => 'text',
				'size'        => 'small',
				'color'       => 'secondary',
				'is_checked'  => true,
			)
		);

		?>
	</div>
	<div class="container">
	  <h2>Icons</h2>
	  <?php
		$icon_sizes = array( 'small', 'medium', 'large', 'larger', 'xlarge', 'xxlarge', 'xxxlarge' );

		foreach ( $icon_sizes as  $icon_size ) :
			?>
	  <h3>IconSize: <?php echo $icon_size; ?></h3>
			<?php
			PS_Icon::render(
				array(
					'name' => 'hamburger',
					'size' => $icon_size,
				)
			);
	  endforeach;
		?>
	</div>
	<div class="container">
	  <h2>Inputs</h2>
	  
	  <?php

		PS_Input::render(
			array(
				'size'       => 'medium',
				'input_attr' => array(
					'type'        => 'text',
					'placeholder' => 'Honoree Name',
					'name'        => 'dedicate_my_donation_honoree_name',
					'class'       => array( 'w-100' ),
					'value'       => ! empty( $_POST ) && ! empty( $_POST['dedicate_my_donation_honoree_name'] ) ? $_POST['dedicate_my_donation_honoree_name'] : '',
				),
				'attr'       => array(
					'class' => array(
						'mt-24',
						! empty( $_POST ) && (string) $_POST['dedicate_my_donation_type'] === 'memory_of' ? 'd-none' : '',
					),
					'id'    => 'honoree_name',
				),
			)
		);
		PS_Input::render(
			array(
				'size'       => 'medium',
				'input_attr' => array(
					'type'        => 'text',
					'name'        => 'dedicate_my_donation_memory_of_name',
					'placeholder' => 'Memory of Name',
					'class'       => array( 'w-100' ),
					'value'       => ! empty( $_POST ) && ! empty( $_POST['dedicate_my_donation_memory_of_name'] ) ? $_POST['dedicate_my_donation_memory_of_name'] : '',
				),
				'attr'       => array(
					'class' => array(
						'mt-24',
						! empty( $_POST ) && (string) $_POST['dedicate_my_donation_type'] !== 'memory_of' ? 'd-none' : '',
					),
					'id'    => 'memory_of_name',
				),
			)
		);
		?>
		<?php
		PS_Input::render(
			array(
				'label_text' => 'Person to notify',
				'size'       => 'medium',
				'input_attr' => array(
					'type'        => 'text',
					'name'        => 'dedicate_my_donation_name',
					'placeholder' => 'Recipient Name',
					'class'       => array( 'w-100' ),
					'value'       => ! empty( $_POST ) && ! empty( $_POST['dedicate_my_donation_name'] ) ? $_POST['dedicate_my_donation_name'] : '',
				),
				'attr'       => array(
					'class'      => array( 'mt-24' ),
					'data-label' => 'Person to notify',
				),
			)
		);
		?>
		<?php
		PS_Input::render(
			array(
				'size'       => 'medium',
				'label_text' => 'Notify this person by',
				'input_attr' => array(
					'type'        => 'email',
					'name'        => 'dedicate_my_donation_email',
					'placeholder' => 'Recipient Email',
					'class'       => array( 'w-100' ),
					'value'       => ! empty( $_POST ) && ! empty( $_POST['dedicate_my_donation_email'] ) ? $_POST['dedicate_my_donation_email'] : '',
				),
				'attr'       => array(
					'class'      => array( 'mt-24' ),
					'data-label' => 'Notify this person by',
				),
			)
		);
		PS_Input::render(
			array(
				'size'       => 'medium',
				'input_attr' => array(
					'type'        => 'textarea',
					'name'        => 'dedicate_my_donation_message',
					'placeholder' => 'Message for the recipient (optional)',
					'class'       => array( 'w-100' ),
					'rows'        => 1,
					'value'       => ! empty( $_POST ) && ! empty( $_POST['dedicate_my_donation_message'] ) ? $_POST['dedicate_my_donation_message'] : '',
				),
				'attr'       => array(
					'class' => array( 'mt-24' ),
				),
			)
		);
		?>
	</div>
	<div class="container">
	  <h2>
		Video Component
	  </h2>
	  
	  <?php
		PS_Video::render(
			array(
				'video_id'    => 'VeigCZuxnfY',
				'cover_image' => array(
					'src'  => 'https://img.youtube.com/vi/VeigCZuxnfY/maxresdefault.jpg',
					'attr' => array(
						'width'  => '1280',
						'height' => '720',
					),
				),
			)
		);
		?>
	</div>
	</main><!-- #main -->
<?php
get_footer();
