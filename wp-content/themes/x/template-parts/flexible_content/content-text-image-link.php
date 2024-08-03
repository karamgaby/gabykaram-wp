<?php
"use strict";
use X_UI\Modules\Image\Component as Image;
use X_UI\Modules\Buttons\Component as Button;

if (!isset($args)) {
    return;
}
// $args['title'] = get_sub_field('title');
// $args['content'] = get_sub_field('content');
// $args['title_color'] = get_sub_field('title_color');
// $args['title_typography_on_desktop'] = get_sub_field('title_typography_on_desktop');
// $args['title_typography_on_mobile'] = get_sub_field('title_typography_on_mobile');
// $args['call_to_action'] = get_sub_field('call_to_action');
// $args['has_image'] = get_sub_field('has_image');
// $args['image_desktop'] = get_sub_field('image_desktop');
// $args['image_mobile'] = get_sub_field('image_mobile');
// $args['image_desktop_width'] = get_sub_field('image_desktop_width');
// $args['is_image_direclty_below_title_mobile'] = get_sub_field('is_image_direclty_below_title_mobile');
$args = wp_parse_args(
    $args,
    array(
        'title' => '',
        'content' => '',
        'title_color' => null,
        'title_typography_on_desktop' => null,
        'title_typography_on_mobile' => null,
        'call_to_action' => '',
        'has_image' => false,
        'image_desktop' => null,
        'image_mobile' => null,
        'image_desktop_width' => 6,
        'is_image_direclty_below_title_mobile' => false,
    )
);
$title = $args['title'];
$content = $args['content'];
$title_color = $args['title_color'];
$title_typography_on_desktop = $args['title_typography_on_desktop'];
$title_typography_on_mobile = $args['title_typography_on_mobile'];
$call_to_action = $args['call_to_action'];
$has_image = $args['has_image'];
$image_desktop = $args['image_desktop'];
$image_mobile = $args['image_mobile'];
$image_desktop_width = $args['image_desktop_width'];
$is_image_directly_below_title_mobile = $args['is_image_direclty_below_title_mobile'];



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
$text_columns = 24;
if ($has_image && !empty($image_desktop_width)) {
    $text_columns = $text_columns - ($image_desktop_width * 2);
}
?>
<section class="text-image-link-section <?= implode(' ', $class) ?>" <?php \X_UI\Core\AbstractComponent::render_attributes($attr); ?>>
    <div class="container">
        <div class="row">
            <div
                class="col-24 justify-content-center align-items-center d-flex flex-column <?= 'col-md-' . $text_columns ?>">
                <div class="d-inline-flex flex-column gap gap-3 gap-md-5">
                    <h2
                        class="<?= 'x-typography-' . $title_typography_on_mobile ?> <?= 'x-typography-md-' . $title_typography_on_desktop ?> <?= 'x-color-' . $title_color ?>">
                        <?= $title ?>
                    </h2>
                    <?php
                    if ($has_image && $is_image_directly_below_title_mobile):
                        ?>
                        <div class="text-image-link-section__image d-md-none">
                            <?php
                            Image::render([
                                'id' => $image_mobile['ID'],
                            ]);
                            ?>
                        </div>
                        <?php
                    endif;
                    ?>
                    <div class="text-image-link-section__content x-typography-body-1 x-typography-md-quote">
                        <?= $content ?>
                    </div>
                    <?php
                    if ($has_image && !$is_image_directly_below_title_mobile):
                        ?>
                        <div class="text-image-link-section__image d-md-none">
                            <?php
                            Image::render([
                                'id' => $image_mobile['ID'],
                            ]);
                            ?>
                        </div>
                        <?php
                    endif;
                    ?>
                    <?php
                    if (!empty($call_to_action)):
                        ?>
                        <div class="d-inline-flex">
                            <?php
                            Button::render(
                                array(
                                    'title' => $call_to_action['title'],
                                    'url' => $call_to_action['url'],
                                    'target' => $call_to_action['target'],
                                    'style' => 'primary-standard',
                                    'as' => 'a',
                                    'attr' => [
                                       'class' =>  'w-100 w-md-auto'
                                    ]
                                )
                            );
                            ?>
                        </div>
                        <?php
                    endif;
                    ?>
                </div>
            </div>
            <?php
            if ($has_image) {
                ?>
                <div class="col-24 d-none d-md-flex justify-content-center align-items-center flex-column <?= 'col-md-' . ($image_desktop_width * 2) ?> ">
                    <div class="text-image-link-section__image">
                        <?php
                        Image::render([
                            'id' => $image_desktop['ID'],
                        ]);
                        ?>
                    </div>
                </div>
                <?php
                // echo '<div class="col-24 ' . 'col-md-' . $image_desktop_width . '">';
                // echo '</div>';
            }
            ?>
        </div>
    </div>
</section>