<?php
// only show the popup once
if(!isset($_COOKIE["subscribe_popup_went_visible"])) {
	$popup_subscribe_data = get_field('popup_subscribe_data', 'option');
	$popup_subscription_form_id = $popup_subscribe_data['form_id'];
	$description = $popup_subscribe_data['description'];
	$custom_logo_id = get_theme_mod( 'custom_logo' );
	$image = wp_get_attachment_image( $custom_logo_id, 'full', false, array(
		'class' => 'popup-logo height-100 mx-auto my-16'
	) );

	?>
    <div class="popup-subscribe-modal modal fade ps-color-primary" id="popup_subscribe_modal" tabindex="-1"
         aria-labelledby="<?= $popup_subscription_form_id . '_ModalLabel' ?>" aria-hidden="true">
        <div class="modal-dialog lg-m-0 md-s-auto modal-dialog-scrollable">
            <div class="modal-content position-relative">
				<?php
				PS_Icon::render( array(
					'name' => 'quote',
					'size' => 'xxxlarge',
					'attr' => array(
						'class' => [ 'subscribe-popup-quote-icon', 'ps-fill-purple-light' ]
					)
				) );
				?>
                <div class="modal-close-btn ">
					<?php
					PS_IconButton::render( array(
						'icon_name' => 'filled-navigation-close',
						'size'      => 'small',
						'color'     => 'secondary',
						'attr'      => [
							'class'           => '',
							'data-bs-dismiss' => 'modal',
							'aria-label'      => 'close',
							'type'            => 'button',
						]
					) );
					?>
                </div>
                <div class="modal-content-start">
                    <div class="d-flex popup-logo">
						<?php
						echo $image;
						?>
                    </div>
                    <div class="d-flex align-items-center justify-content-center my-16 mx-24 flex-column gap-8">
                        <div class="d-flex gap-8">
							<?php
							PS_Icon::render( array(
								'name' => 'love-letter',
								'size' => 'medium',
							) );
							?>
                            <span class="ps-typography-h3 subscribe-icon-text">Subscribe</span>
                        </div>
                        <p class="ps-typography-subtitle1 text-center "><?= $description ?></p>
                    </div>
                </div>
                <div class="modal-content-end">
                    <div class="popup-form">
						<?php
						echo do_shortcode( '[contact-form-7 id="' . $popup_subscription_form_id . '" title="Subscription form"]' );
						?>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php
}