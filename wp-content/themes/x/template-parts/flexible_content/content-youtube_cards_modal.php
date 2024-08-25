<?php
"use strict";
use X_UI\Modules\Image\Component as Image;
use X_Modules\VideoPlyr\Component as VideoPlyrComponent;

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
        <div class="row row-gap-5">
            <?php
            $counter = 0;
            foreach ($cards as $card) {
                $counter++;
                $image_id = $card['image'];
                $description = $card['description'];
                $title = $card['title'];
                $youtube_video_url = $card['youtube_video_url'];
                preg_match('/src="(.+?)"|href="(.+?)"/i', $youtube_video_url, $matches);
                $video_src = $matches[1];
                $card_id = 'modal-card-' . $section_index . '-' . $counter;
                $video_component_id = uniqid('x-video-plyr', false) . random_int(1, 100);
                $video_id = VideoPlyrComponent::get_youtube_id($video_src);
                ?>
                <div class="col-24 col-md-8">
                    <div class="youtube-modal-card" data-fancybox="x-video-plyr" aria-label="<?= __('Watch video', 'x') ?>"
                        tabindex="0" data-type="inline" data-src="#<?= $video_component_id ?>_fancybox"
                        data-groupAll="false">

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
                    </div>
                    <div style="display: none;" class="fancybox__content" id="<?= $video_component_id ?>_fancybox">
                        <div class="container">
                            <div class="plyr__video-embed" id="<?= $video_component_id ?>_player"
                                data-plyr-provider="youtube" data-plyr-embed-id="<?= $video_id ?>"></div>
                        </div>
                    </div>
                </div>
                <?php
                $counter++;
            }
            ?>
        </div>
    </div>
</section>