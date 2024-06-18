<?php
"use strict";
use X_UI\Modules\Image\Component as Image;
use X_UI\Modules\Buttons\Component as Button;

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
                    <div class="youtube-modal-card" tabindex="0" data-bs-toggle="modal" data-bs-target="#<?= $card_id ?>">

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

                    <!-- Modal -->
                    <div class="youtube-card-modal modal fade" id="<?= $card_id ?>" tabindex="-1"
                        aria-labelledby="<?= $card_id ?>Label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="youtube-modal-card">

                                    <div class="youtube-modal-card__title" id="<?= $card_id ?>Label">
                                        <?= $title ?>
                                    </div>
                                    <div class="youtube-modal-card__description">
                                        <?= $description ?>
                                    </div>
                                    <iframe data-src="<?= $video_src; ?>&autoplay=1" allow="autoplay"></iframe>
                                </div>
                            </div>
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