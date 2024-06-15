<?php
"use strict";
if (!isset($args)) {
    return;
}
$args = wp_parse_args(
    $args,
    array(
        'quote' => '',
        'author' => '',
    )
);
$video_cover_image = $args['video_cover_image'];
$youtube_video_url = $args['youtube_video_url'];
preg_match('/src="(.+?)"/', $youtube_video_url, $matches);
$video_src = $matches[1];
$content = $args['content'];
$cta_link_and_text = $args['cta_link_and_text'];
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
<section class="video-cta-section <?= implode(' ', $class) ?>" <?php \X_UI\Core\AbstractComponent::render_attributes($attr); ?>>
    <div class="container">
        <div class="row gy-3 ">
            <div class="col-24 col-md-14">
                <div class="video-section">
                    <a data-fancybox href="<?= $video_src; ?>" class="m-auto">
                        <div class="video-overlay">
                            <img class="video-overlay-cover b-lazy" src="<?= $video_cover_image['url'] ?>"
                                alt="<?= $video_cover_image['alt'] ?>" title="<?= $video_cover_image['title'] ?>">
                        </div>
                    </a>
                    <!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/6yJ4pohu8E8" frameborder="0"
                allowfullscreen></iframe> -->
                </div>
            </div>
            <div class="col-24 col-md-10">
                <div class="text-section">
                    <div class="text-section-wrapper">
                        <?php
                        if(!empty($cta_link_and_text)) :
                            X_UI\Modules\Buttons\Component::render(array(
                                'title' => $cta_link_and_text['title'],
                                'url' => $cta_link_and_text['url'],
                                'target' => $cta_link_and_text['target'],
                                'style' => 'icon-right',
                                'as'=> 'a',
                                'icon' => 'play',
                                'has_icon' => true,
                                'icon_position' => 'end',
                                'attr' => [
                                    'class' => 'd-md-none'
                                ]
                            ));
                        endif;
                        ?>
                        <p class="x-typography-body-1 x-typography-md-subtitle-1"><?= $content; ?></p>
                        <?php
                        if (!empty($cta_link_and_text)):
                            X_UI\Modules\Buttons\Component::render(
                                array(
                                    'title' => $cta_link_and_text['title'],
                                    'url' => $cta_link_and_text['url'],
                                    'target' => $cta_link_and_text['target'],
                                    'style' => 'icon-right',
                                    'as' => 'a',
                                    'icon' => 'play-circle',
                                    'has_icon' => true,
                                    'icon_position' => 'end',
                                    'attr' => [
                                        'class' => 'd-none d-md-inline-flex'
                                    ]
                                )
                            );
                            ?>
                            <?php
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>