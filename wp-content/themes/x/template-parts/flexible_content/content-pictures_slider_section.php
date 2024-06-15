<?php
"use strict";
use X_Modules\PictureCards\Component as PictureCards;

if ( ! isset( $args ) ) {
  return;
}

$title                         = $args['title'];
$content                       = $args['content'];
$pictures                      = $args['pictures'];
$has_button_on_mobile          = $args['has_button_on_mobile'] ?? false;
$button_link_plus_text         = $args['button_link_plus_text'] ?? null;
$switch_image_on_top_on_mobile = $args['switch_image_on_top_on_mobile'] ?? false;
$attr = wp_parse_args($args['attr'], array(
  'class' => [],
));
$class = $attr['class'];
unset($attr['class']);
?>

<section class="pictures-slider-section <?= implode(' ', $class) ?>" <?php \X_UI\Core\AbstractComponent::render_attributes($attr); ?> >
  <div class="container">
    <div class="row">
      <div class="col-24 <?= $switch_image_on_top_on_mobile ? 'order-2 order-md-1 mt-3 mt-md-0' : '' ?>">
        <div class="col-24 col-md-22">
          <h2 class="x-typography-h4 x-typography-md-h2 x-color-medium-turquoise-600"><?= $title ?></h2>
        </div>
        <?php
        if ( ! empty( $content ) ) :
          ?>
          <div class="row">
            <div class="col-24 col-md-18">
              <div class="section-content x-typography-body-1 x-typography-md-subtitle-1 mt-3">
                <?= $content ?>
              </div>
            </div>
          </div>
        <?php
        endif;
        ?>

      </div>
      <div class="col-24 <?= $switch_image_on_top_on_mobile ? 'order-1 order-md-2' : '' ?>">
        <div class="pictures-slides swiper <?= ! $switch_image_on_top_on_mobile ? 'mt-3 ' : 'mt-md-6' ?>">
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
                'class' => 'd-none d-md-flex'
              ]
            ) );

            PictureCards::render( array(
              'image_id'    => $image_id,
              'style'       => 'picture_only',
              'device'      => 'mobile',
              'image_title' => $picture_title,
              'attr'        => [
                'class' => 'd-flex d-md-none'
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
    <?php
    if($has_button_on_mobile) :
      ?>
      <div class="row justify-content-center mt-3 d-md-none">
        <div class="col-24">
          <?php
          X_UI\Modules\Buttons\Component::render(array(
            'title' => $button_link_plus_text['title'],
            'url' => $button_link_plus_text['url'],
            'as' => 'a',
            'attr' => [
              'class' => 'x-button x-button-primary w-100',
              'target' => $button_link_plus_text['target'] ?? '_self'
            ]
          ));
          ?>
        </div>
      </div>
      <?php
    endif; 
    ?>
  </div>
</section>
