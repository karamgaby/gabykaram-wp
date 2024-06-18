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
        'image_desktop' => null,
        'image_mobile' => null,
        'open_positions' => [],
    )
);
$title = $args['title'];
$image_desktop = $args['image_desktop'];
$image_mobile = $args['image_mobile'];
$open_positions = $args['open_positions'];
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
<section class="open-positions-section <?= implode(' ', $class) ?>" <?php \X_UI\Core\AbstractComponent::render_attributes($attr); ?>>
    <div class="container">
        <div class="row">
            <div class="col-24 col-md-10">
                <div class="open-positions-section__content">
                    <?php if ($title): ?>
                        <h2 class="open-positions-section__title"><?= $title ?></h2>
                    <?php endif; ?>
                    <div class="open-positions-section__image">
                        <?php
                        if ($image_desktop):
                            Image::render([
                                'id' => $image_desktop['ID'],
                                'attr' => [
                                    'class' => 'd-none d-md-block',
                                ],
                            ]);
                        endif;
                        if ($image_mobile):
                            Image::render([
                                'id' => $image_mobile['ID'],
                                'attr' => [
                                    'class' => 'd-md-none',
                                ],
                            ]);
                        endif;
                        ?>
                    </div>
                </div>

            </div>
            <div class="col-24 col-md-14 justify-content-center d-flex flex-column mt-3 mt-md-0">
                <div class="open-positions-section__positions-types">
                    <?php
                    foreach ($open_positions as $open_positions_type):
                        $title = $open_positions_type['title'];
                        $positions = $open_positions_type['positions'];

                        ?>
                        <div class="open-positions-section__position-type">
                            <h3 class="open-positions-section__position-type__title"><?= $title ?></h3>
                            <div class="open-positions-section__positions">
                                <?php
                                foreach ($positions as $item):
                                    $title = $item['position'];
                                    $description = $item['description'];
                                    $image = $item['image'];
                                    $whatsapp_number = $item['whatsapp_number'];
                                    ?>
                                    <div class="open-positions-section__position">
                                        <div class="open-positions-section__position__image">
                                            <?php
                                            Image::render([
                                                'id' => $image['ID'],
                                            ]);
                                            ?>
                                        </div>
                                        <div class="open-positions-section__position__content">
                                            <h4 class="open-positions-section__position__title"><?= $title ?></h4>
                                            <div class="open-positions-section__position__description"><?= $description ?></div>
                                            <div class="open-positions-section__position__button">
                                                <?php
                                               Button::render(array(
                                                'title' => "Apply Here",
                                                'url' => $whatsapp_number,
                                                // 'target' => $cta_link_and_text['target'],
                                                'style' => 'icon-right',
                                                'as'=> 'a',
                                                'icon' => 'whatsapp',
                                                'has_icon' => true,
                                                'icon_position' => 'end',
                                                'attr' => [
                                                    'class' => 'w-100'
                                                ]
                                            ));
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                endforeach;
                                ?>


                            </div>
                        </div>
                        <?php
                    endforeach;
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>