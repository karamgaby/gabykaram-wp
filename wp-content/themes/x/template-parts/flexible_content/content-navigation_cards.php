<?php
"use strict";
use X_UI\Modules\Image\Component as Image;
use X_UI\Modules\Buttons\Component as Button;
use X_UI\Core\Tokens\Colors as ColorsTokens;
use \X_UI\Core\AbstractComponent;
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
$colorTokensInstance = ColorsTokens::getInstance();
$colors = $colorTokensInstance->getMeta('colors');
$typeMap = [
    'primary' => [
        'hover' => [
            'bg-color' => $colors['orange-700'],
        ],
        'default' => [
            'text-color' => $colors['orange-700'],
        ]
    ],
    'secondary' => [
        'hover' => [
            'bg-color' => $colors['yellow-gold-500'],
        ],
        'default' => [
            'text-color' => $colors['yellow-gold-500'],
        ]
    ]
];

?>
<section class="navigation-cards-section <?= implode(' ', $class) ?>" <?php AbstractComponent::render_attributes($attr); ?>>
    <div class="container">
        <div class="row gap-3 gap-md-5 justify-content-center">
            <div class="col-24 col-lg-14">
                <h2 class="navigation-cards-section__title"><?= $title ?></h2>
            </div>
            <div class="col-24">
                <div class="row navigation-cards-row row-gap-3">
                    <?php
                    $index = 0;

                    foreach ($cards as $card) {
                        $type = $card['type'];
                        $image = $card['image'];
                        $link = $card['link'];
                        $flip_content = $card['flip_content'];
                        $card_attr = [];
                        $typeStyleObj = isset($typeMap[$type]) ? $typeMap[$type] : null;
                        $styles = [];
                        if ($typeStyleObj) {
                            $styles['--navigation-card-hover-bg-color'] = $typeStyleObj['hover']['bg-color'];
                            $styles['--navigation-card-text-color'] = $typeStyleObj['default']['text-color'];
                        }
                        $card_attr['style'] = $styles;
                        ?>
                        <div class="col-24 col-md-12">
                            <a href="<?= $link['url'] ?>" target="<?= $link['target'] ?>"
                                class="navigation-card navigation-card--<?= $index % 2 === 0 ? 'even' : 'odd' ?>" <?php AbstractComponent::render_attributes($card_attr); ?>>
                                <div class="navigation-card__front">
                                    <?php
                                    Image::render([
                                        'id' => $image['ID'],
                                        'attr' => [
                                            'class' => 'navigation-card__front__image'
                                        ]
                                    ]);
                                    ?>
                                    <div class="navigation-card__front__btn">
                                        <?php
                                        Button::render(
                                            array(
                                                'title' => $link['title'],
                                                'style' => 'icon-only',
                                                'as' => 'div',
                                                'icon' => $index % 2 === 0 ? 'arrow-left' : 'arrow-right',
                                                'has_icon' => 'only',
                                            )
                                        );
                                        ?>
                                        <span
                                            class="navigation-card__front__btn__title x-typography-h3"><?= $link['title'] ?></span>
                                    </div>
                                </div>
                                <div class="navigation-card__back">
                                    <div class="navigation-card__back__content x-color-mate-black-800">
                                        <div class="navigation-card__back__subtitle x-typography-subtitle-2">
                                            <?= $flip_content['subtitle'] ?>
                                        </div>
                                        <h3 class="navigation-card__back__title x-typography-h3"><?= $flip_content['title'] ?></h3>
                                    </div>
                                    <div class="navigation-card__back__btn">
                                        <?php
                                        Button::render(
                                            array(
                                                'title' => $link['title'],
                                                'style' => 'icon-only',
                                                'as' => 'div',
                                                'icon' => $index % 2 === 0 ? 'arrow-left' : 'arrow-right',
                                                'has_icon' => 'only',
                                            )
                                        );
                                        ?>
                                    </div>
                                </div>
                            </a>
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