<?php

/**
 * Template part: Page CTA Banner section common part in multiple pages
 */
if ( ! isset( $args ) ) {
	return;
}
$placeholders     = array(
	'description'                => '',
	'background_color'           => '',
	'secondary_background_color' => '',
	'button_color'               => 'secondary',
	'is_hero'                    => false,
);
$args             = wp_parse_args( $args, $placeholders );
$background_color           = $args['background_color'];
$secondary_background_color = $args['secondary_background_color'];
$title                      = $args['title'];
$description                = $args['description'];
$image_id                   = $args['image_id'];
$button_text                = $args['button_text'];
$button_url                 = $args['button_url'];

$title_spacing    = '';
$button_class    = 'mt-32';
$button_size = 'large';
$button_size_breakpoints = [];
$text_class    = 'ps-color-secondary-main';
$section_spacing    = 'py-64 py-lg-96';
$title_typography = 'ps-typography-h3 ps-typography-lg-h2';

if ( ! empty( $args['description'] ) ) {
	$title_spacing = 'mb-24';
}
if(empty( $description)) {
  $section_spacing = 'py-96';
	$button_class = 'mt-48';
}
if ( $args['is_hero'] ) {
	$title_typography = 'ps-typography-h3 ps-typography-lg-h1 text-center text-lg-start';
	$title_spacing = 'mb-32';
	$button_class = 'mt-32 mx-auto ms-lg-0';
	$section_spacing = 'pb-80 pt-64 pt-lg-96 pb-lg-128';
	$text_class = 'ps-color-text-secondary text-center text-lg-start';
  $button_size = 'medium';
	$button_size_breakpoints['lg'] = 'large';
}



if ( ! empty( $args['button_color'] ) && in_array( $args['button_color'], PS_Button::$colors, true ) ) {
	$button_color = $args['button_color'];
} else {
	$button_color = $placeholders['button_color'];
}

$button_args = array(
	'text'     => $button_text,
	'variant'  => 'contained',
	'color'    => $button_color,
	'html_tag' => 'a',
	'size'     => $button_size,
  'size_breakpoints' => $button_size_breakpoints,
	'attr'     => [
		'class' => [ $button_class ],
		'href'  => $button_url,
	]
);
?>

<section class="horizontal-content-image position-relative overflow-hidden <?= $section_spacing ?> <?= $background_color ?>">
    <div class="container position-relative z-index-2">
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="h-100 d-flex flex-column justify-content-center">
                    <h2 class="ps-color-secondary-main <?= $title_typography ?> <?= $title_spacing ?>"><?= $title ?></h2>
	                <?php
	                if ( ! empty( $description ) ) :
		                ?>
                      <div class="ps-typography-h5 <?= $text_class ?>">
                        <?= $description ?>
                      </div>
	                <?php
	                endif;
	                ?>
	                <?php
	                PS_Button::render( $button_args );
	                ?>
                </div>
            </div>
            <div class="col-12 col-lg-6 mt-64 mt-lg-0">
                <div class="horizontal-content-image-cover">
                  <?php
                  PS_Image::render( array(
	                  'id'   => $image_id,
	                  'attr' => [
		                  'class' => [ 'horizontal-content-image-cover-src' ]
	                  ]
                  ) );
                  ?>
                </div>
	            <?php
	            if ( ! empty( $secondary_background_color ) ) :
		            ?>
                <div class="horizontal-content-secondary-background d-none d-lg-block <?= $secondary_background_color ?>"></div>
	            <?php
	            endif;
	            ?>
            </div>
        </div>
    </div>
</section>
