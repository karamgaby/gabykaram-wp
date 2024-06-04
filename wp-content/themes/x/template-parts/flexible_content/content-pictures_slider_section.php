<?php
"use strict";
use X_Modules\PictureCards\Component as PictureCards;

if ( ! isset( $args ) ) {
  return;
}
$section_id = $args['section_id'] ?? null;
$title                         = $args['title'];
$content                       = $args['content'];
$pictures                      = $args['pictures'];
$has_button_on_mobile          = $args['has_button_on_mobile'] ?? false;
$button_link_plus_text         = $args['button_link_plus_text'] ?? null;
$switch_image_on_top_on_mobile = $args['switch_image_on_top_on_mobile'] ?? false;
$attr = [];

if ( ! empty( $section_id ) ) {
  $attr['id'] = $section_id;
}
?>

<section class="pictures-slider-section" <?php \X_UI\Core\AbstractComponent::render_attributes($attr); ?> >
  <div class="container">
    <div class="row">
      <div class="col-24">
        <div class="col-24 col-lg-22">
          <h2 class="x-typography-h4 x-typography-lg-h2 x-color-medium-turquoise-600"><?= $title ?></h2>
        </div>
        <?php
        if ( ! empty( $content ) ) :
          ?>
          <div class="row">
            <div class="col-24 col-lg-18">
              <div class="section-content x-typography-body-1 x-typography-lg-subtitle-1 mt-3">
                <?= $content ?>
              </div>
            </div>
          </div>
        <?php
        endif;
        ?>

      </div>
      <div class="col-24">
        <div class="pictures-slides swiper <?= ! $switch_image_on_top_on_mobile ? 'mt-3 mt-lg-6' : '' ?>">
          <div class="swiper-wrapper">
            <?php
            foreach ( $pictures as $picture ) :
              $image_id = $picture['picture']['ID'];
              $picture_title = $picture['picture_title'];
              ?>
              <div class="picture-slide swiper-slide">
            <?php
            PictureCards::render( array(
              'image_id'    => $image_id,
              'style'       => 'picture_only',
              'device'      => 'desktop',
              'image_title' => $picture_title,
              'attr'        => [
                'class' => 'd-none d-lg-flex'
              ]
            ) );

            PictureCards::render( array(
              'image_id'    => $image_id,
              'style'       => 'picture_only',
              'device'      => 'mobile',
              'image_title' => $picture_title,
              'attr'        => [
                'class' => 'd-flex d-lg-none'
              ]
            ) );
            ?>
              </div>

            <?php
            endforeach;
            ?>
            <div class="space-slide swiper-slide">
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>
