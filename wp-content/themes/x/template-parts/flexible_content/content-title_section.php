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
$title = $args['title'];
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
                ?>
            </div>
        </div>
    </div>
</section>