<?php
"use strict";
if (!isset($args)) {
    return;
}
$args = wp_parse_args(
    $args,
    array(
        'title' => '',
        'scroll_to_id' => '',
    )
);
$title = $args['title'];
$scroll_to_id = $args['scroll_to_id'];
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
<section class="title-section <?= implode(' ', $class) ?>" <?php \X_UI\Core\AbstractComponent::render_attributes($attr); ?>>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-24 col-md-16 d-flex flex-column gap-2  align-items-center justify-content-center">
                <h2 class="title-section__title"><?= $title ?></h2>
                <?php
                if (!empty($scroll_to_id)):
                    ?>
                    <a href="#<?= $scroll_to_id ?>" class="title-section__scroll-to-link">
                        <span class="visually-hidden">Scroll to</span>
                        <?php
                endif;
                X_UI\Modules\Svg\Component::render(
                    array(
                        'name' => 'chevrons-down',
                        'size' => 'auto',
                        'size_breakpoints' => [
                            'sm' => 'small',
                            'md' => 'auto'
                        ],
                        'attr' => [
                            'class' => 'title-section__icon'
                        ]
                    )
                );
                if (!empty($scroll_to_id)):
                    ?>
                    </a>
                    <?php
                endif;
                ?>
            </div>
        </div>
    </div>
</section>