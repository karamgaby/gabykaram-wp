<?php

/**
 * Template part: States initiatives section, common part used on the landing page and the donation page
 */

if ( ! isset( $args ) ) {
	return;
}
$placeholders  = array(
	'title'       => '',
	'description' => '',
	'class'       => 'pt-48 pb-64 pt-lg-96 pb-lg-128',
	'section_id' => '',
);
$args          = wp_parse_args( $args, $placeholders );
$title         = $args['title'];
$description   = $args['description'];
$section_class = $args['section_class'];
$section_id = $args['section_id'];
?>
<section class="states-initiative <?= $section_class ?>" id="<?= $section_id ?>">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <h2 class="text-center ps-color-secondary-main ps-typography-h3 ps-typography-lg-h2"><?= $title; ?></h2>
                <div class="text-center ps-color-text-secondary ps-typography-h5 mt-24 mt-lg-32">
                  <?= $description; ?>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-0 mt-lg-24 gy-48 gy-lg-24">
          <?php
          while ( have_rows( 'states_initiatives', 'option' ) ) :
	          the_row();
	          $state    = get_sub_field( 'state' );
	          $image_id = get_sub_field( 'image' );
	          $url      = get_sub_field( 'link' );
	          ?>
            <div class="col-12 col-lg-4">
                <?php
                PS_Card::render( array(
	                'type'       => 'state',
	                'title'      => $state,
	                'html_tag'   => 'a',
	                'card_image' => array(
		                'id' => $image_id,
	                ),
	                'attr'       => array(
		                'href' => $url
	                )
                ) );
                ?>
              </div>
          <?php
          endwhile;
          ?>
        </div>
    </div>
</section>
