<?php

use X_UI\Core\AbstractComponent;
use X_UI\Modules\Svg\Component as SVGComponent;

if ( ! isset( $data ) ) {
  return;
}

$image_id     = $data->image_id;
$title        = $data->title;
$subtitle     = $data->subtitle;
$contact_list = $data->contact_list;
$cf7_id = $data->cf7_id;
//var_dump($data);
$attr    = $data->attr;
$classes = $attr['class'];
unset( $attr['class'] );
$classes = implode( ' ', $classes );

?>

<section class="contact-section container <?= $classes ?>" <?php AbstractComponent::render_attributes( $attr ); ?>>
  <div class="row">
    <div class="col-lg-12 col-24">
      <h1 class="x-color-mate-black-900 x-typography-lg-h1 x-typography-h4 text-center text-lg-start"><?= $title ?></h1>
      <div class="contact-section__image mt-3 d-lg-none">
        <?php
        X_UI\Modules\Image\Component::render( array(
          'id'   => $image_id,
          'attr' => [
            'class' => ''
          ]
        ) );
        ?>
      </div>
      <?php
      if ( count( $contact_list ) > 0 ):
        ?>
        <div class="d-flex justify-content-between justify-content-lg-start mt-3">
          <div class="contact-section__contact-list x-color-mate-black-900 d-inline-flex mx-auto mx-lg-0  gap-1 flex-column">
            <?php
            foreach ( $contact_list as $contact ) :
              $icon_type = $contact['icon_type'];
              $has_link = $contact['has_link'];
              $text = $contact['text'];
              $link = $has_link && ! empty( $contact['link'] ) ? $contact['link'] : null;
              switch ( $icon_type ) {
                case 'email':
                  $icon_name = 'mail';
                  break;
                case 'location':
                  $icon_name = 'map-pin';
                  break;
                case 'phone':
                default:
                  $icon_name ='phone-call';
                  break;
              }
              ?>
              <div class="contact-list-item d-inline-flex gap-1 align-items-center">
                <div class="contact-list-item__icon d-inline-flex">
                  <?php
                  SVGComponent::render( array(
                    'name'             => $icon_name,
                    'size'             => 'small',
                    'size_breakpoints' => [
                      'md' => 'small',
                      'lg' => 'medium'
                    ],
                    'attr'             => [
                      'class' => 'contact-list-item__icon__icon',
                    ]
                  ) );
                  ?>
                </div>
                <?php
                if ( $has_link ) :
                  ?>
                  <a class="x-typography-link x-typography-lg-link-lg"
                     href="<?= $link['url'] ?>" <?php if ( ! empty( $link['target'] ) ): ?> target="<?= $link['target']; ?>" <?php endif; ?>><?= $link['title'] ?></a>
                <?php
                else:
                  ?>
                  <span class="x-typography-lg-subtitle-1 x-typography-subtitle-2 "><?= $text ?></span>
                <?php
                endif;
                ?>
              </div>
            <?php
            endforeach;
            ?>
          </div>
        </div>
      <?php
      endif;
      ?>
      <h2 class="x-typography-h4 x-color-mate-black-900 mt-4">
        <?= $subtitle ?>
      </h2>
      <div class="contact-section__contact-form mt-2">
        <?php
        echo do_shortcode('[contact-form-7 id="' . $cf7_id . '"]');
        ?>
      </div>
    </div>
    <div class="col-lg-12 col-24">
      <div class="contact-section__image contact-section__image--full-height d-none d-lg-block">
        <?php
        X_UI\Modules\Image\Component::render( array(
          'id'   => $image_id,
          'attr' => [
            'class' => ''
          ]
        ) );
        ?>
      </div>
    </div>
  </div>
</section>