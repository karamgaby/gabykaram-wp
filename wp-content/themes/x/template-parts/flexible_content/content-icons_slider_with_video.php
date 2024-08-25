<?php
"use strict";
use X_Modules\VideoPlyr\Component as VideoPlyrComponent;
if (!isset($args)) {
    return;
}

$title_first_part = $args['title_first_part'];
$title_second_part = $args['title_second_part'];
$content = $args['content'];
$icons = $args['icons'];
$video_cover_image = $args['video_cover_image'];
$youtube_video_url = $args['youtube_video_url'];
$attr = wp_parse_args(
    $args['attr'],
    array(
        'class' => [],
    )
);
$class = $attr['class'];
unset($attr['class']);
?>

<section class="icons-slider-with-video-section <?= implode(' ', $class) ?>" <?php \X_UI\Core\AbstractComponent::render_attributes($attr); ?>>
    <div class="container">
        <div class="row icons-slider-with-video-section__row">
            <div class="col-24">
                <h2 class="icons-slider-with-video-section__title">
                    <span class="icons-slider-with-video-section__title__part-1">
                        <?= $title_first_part ?>
                    </span>
                    <span class="icons-slider-with-video-section__title__part-2">
                        <?= $title_second_part ?>
                    </span>
                </h2>
            </div>
            <div class="col-24">
                <div class="icons-slides swiper">
                    <div class="swiper-wrapper">
                        <?php
                        foreach ($icons as $item) {
                            $icon_content = $item['content'];
                            $icon = $item['icon'];
                            ?>
                            <div class="picture-slide swiper-slide">
                                <?php
                                X_UI\Modules\Image\Component::render(
                                    [
                                        'id' => $icon['value']['ID']
                                    ]
                                )
                                    ?>
                                <div class="icon-title x-typography-quote x-typography-lg-subtitle-2">
                                    <?php echo $icon_content ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-24">
                <div class="icons-slider-with-video-section__content">
                    <?= $content ?>
                </div>
            </div>
            <div class="col-24 d-none d-md-block">
                <hr class="icons-slider-with-video-section__separator">
            </div>
            <div class="col-24">
                <div class="video-section">
                    <?php
                    VideoPlyrComponent::render([
                        'video_src' => $youtube_video_url,
                        'cover_image' => $video_cover_image,
                    ]);
                    ?>
                </div>

            </div>
        </div>
    </div>
</section>