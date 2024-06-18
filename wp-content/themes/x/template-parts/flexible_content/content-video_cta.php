<?php
"use strict";
use X_UI\Core\Tokens\Colors;

$colorsTokens = Colors::getInstance();
$colors = $colorsTokens->getMeta('colors');
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
$show_video_on_top_on_mobile = isset($args['show_video_on_top_on_mobile']) ? $args['show_video_on_top_on_mobile']: false;
$video_cover_image = $args['video_cover_image'];
$youtube_video_url = $args['youtube_video_url'];
preg_match('/src="(.+?)"/', $youtube_video_url, $matches);
$video_src = $matches[1];
$content = $args['content'];
$content_color = $args['content_color'];
$bold_content_color = $args['bold_content_color'];
$title_typography_desktop = $args['title_typography_desktop'];
$title_typography_mobile = $args['title_typography_mobile'];
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
            <div class="col-24 col-md-14 <?= $show_video_on_top_on_mobile ? '' : 'order-1 order-md-0'; ?>">
                <div class="video-section">
                    <a data-fancybox href="<?= $video_src; ?>" class="m-auto">
                        <div class="video-overlay">
                            <img class="video-overlay-cover b-lazy" src="<?= $video_cover_image['url'] ?>"
                                alt="<?= $video_cover_image['alt'] ?>" title="<?= $video_cover_image['title'] ?>">
                        </div>
                    </a>
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
                         <div
                        class="video-cta-section__content <?= 'x-typography-' . $title_typography_mobile ?> <?= 'x-typography-md-' . $title_typography_desktop ?> "
                        style="--content-color: <?= $colors[$content_color] ?>; --bold-content-color: <?= $colors[$bold_content_color] ?>;"
                        ><?= $content; ?></div>
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