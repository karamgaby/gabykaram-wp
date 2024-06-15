<?php
"use strict";
if (!isset($args)) {
    return;
}
$items = $args['items'];
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
<section class="icons-slider <?= implode(' ', $class) ?>" <?php \X_UI\Core\AbstractComponent::render_attributes($attr); ?>>
    <div class="container">
        <div class="row">
            <div class="col-24">
                <div class="icons-slides swiper">
                    <div class="swiper-wrapper">
                        <?php
                        foreach ($items as $item) {
                            $content = $item['content'];
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
                                <div class="icon-title x-typography-subtitle-1">
                                    <?php echo $content ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>