<?php
"use strict";
use X_UI\Modules\Image\Component as Image;

if (!isset($args)) {
    return;
}
$args = wp_parse_args(
    $args,
    array(
        'cards' => [],
        'section_index' => uniqid(),
    )
);
$cards = $args['cards'];
$section_index = $args['section_index'];
if (!isset($args['attr']) || !is_array($args['attr'])) {
    $args['attr'] = [];
}
$attr = wp_parse_args(
    $args['attr'],
    array(
        'class' => [],
    )
);
$class = $attr['class'];
unset($attr['class']);
?>
<section class="youtube-cards-modal-section <?= implode(' ', $class) ?>" <?php \X_UI\Core\AbstractComponent::render_attributes($attr); ?>>
    <div class="container">
        <div class="row row-gap-4">
            <?php
            $counter = 0;
            foreach ($cards as $card) {
                $counter++;
                $image_id = $card['image'];
                $description = $card['description'];
                $title = $card['title'];
                $youtube_video_url = $card['youtube_video_url'];
                preg_match('/src="(.+?)"/', $youtube_video_url, $matches);
                $video_src = $matches[1];
                $card_id = 'modal-card-' . $section_index . '-' . $counter;
                ?>
                <div class="col-24 col-md-8">
                    <a class="youtube-modal-card" data-fancybox href="<?= $video_src; ?>&autoplay=1">

                        <div class="youtube-modal-card__title">
                            <?= $title ?>
                        </div>
                        <div class="youtube-modal-card__description">
                            <?= $description ?>
                        </div>
                        <div class="youtube-modal-card__image">
                            <?= Image::render([
                                'id' => $card['image']
                            ]) ?>
                        </div>
                    </a>
                </div>
                <?php
                $counter++;
            }
            ?>
        </div>
    </div>
</section>