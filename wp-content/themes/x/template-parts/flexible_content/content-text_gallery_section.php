<?php
"use strict";
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
<section class="text-gallery-section" <?php \X_UI\Core\AbstractComponent::render_attributes($attr);?>>
  <div class="container">
    <div class="row">
      <div class="col-24 col-md-12">
        <div class="h-100 d-flex align-items-center">
          <div>
            <h2 class="x-typography-h4 x-typography-md-h2"><?= $title ?></h2>
            <div class="x-typography-body-1 x-typography-md-subtitle-1 mt-3 mt-5">
              <?= $content ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-24 col-md-12">
        <div class="pictures-gallery mt-3 mt-md-0">
          <?php
          $pictures_count     = count( $pictures );
          foreach ( $pictures as $index => $picture ) :
            $image_id = $picture['picture']['ID'];
            $image_src = wp_get_attachment_image_url($image_id, 'full');
            $has_extra_images = $index === 3 && $pictures_count > 4;
            ?>
            <div class="picture <?= $has_extra_images ? 'has-text-overlay' : '' ?>" data-fancybox="gallery" data-src="<?= $image_src ?>">
            <?php
            X_UI\Modules\Image\Component::render( array(
              'id' => $image_id,
              'attr' => [
                // 'data-fancybox' => 'gallery',
                // 'data-src' => 'https://lipsum.app/id/2/1024x768'
              ]
            ) );
            if ( $has_extra_images ) :
              ?>
              <div class="picture__text-overlay">
              <div>+<?= $pictures_count - 4 ?></div>
            </div>
            <?php
            endif;
            ?>

          </div>
          <?php
          endforeach;
          ?>
        </div>
      </div>
    </div>
  </div>
</section>
