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
        'title' => '',
        'cards' => [],
    )
);
$title = $args['title'];
$cards = $args['cards'];
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
<section class="navigation-cards-section <?= implode(' ', $class) ?>" <?php \X_UI\Core\AbstractComponent::render_attributes($attr); ?>>
    <div class="container">
        <div class="row gap-3 gap-md-5">
            <div class="col-24 col-lg-14">
                <h2 class="navigation-cards-section__title"><?= $title ?></h2>
            </div>
            <div class="col-24">
                <div class="row navigation-cards-section__cards-row">
                    <?php
                    $index = 0;
                    foreach ($cards as $card) {
                        $image = $card['image'];
                        $link = $card['link'];
                        ?>
                        <div class="col-24 col-md-12">
                            <div>
                                <div class="navigation-cards-section__card">
                                    <?php
                                    Image::render([
                                        'id' => $image['ID'],
                                        'attr' => [
                                            'class' => 'navigation-cards-section__card__image'
                                        ]
                                    ]);
                                    ?>
                                    <div class="navigation-cards-section__card__btn">
                                        <?php
                                        Button::render(
                                            array(
                                                'title' => $link['title'],
                                                'url' => $link['url'],
                                                'target' => $link['target'],
                                                'style' => $index % 2 === 0 ? 'icon-left' : 'icon-right',
                                                'as' => 'a',
                                                'icon' => $index % 2 === 0 ? 'chevron-left' : 'chevron-right',
                                                'has_icon' => true,
                                                'icon_position' => $index % 2 === 0 ? 'start' : 'end',
                                                'attr' => [
                                                    'class' => 'd-none d-md-inline-flex'
                                                ]
                                            )
                                        );
                                        Button::render(
                                            array(
                                                'title' => $link['title'],
                                                'url' => $link['url'],
                                                'target' => $link['target'],
                                                'style' => 'icon-right',
                                                'as' => 'a',
                                                'icon' => 'chevron-right',
                                                'has_icon' => true,
                                                'icon_position' => 'end',
                                                'attr' => [
                                                    'class' => 'd-md-none'
                                                ]
                                            )
                                        );
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $index++;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>