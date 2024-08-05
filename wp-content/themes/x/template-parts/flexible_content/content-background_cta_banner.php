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
$cta = $args['cta'];
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
<section class="background-cta-banner-section py-3 py-md-7 <?= implode(' ', $class) ?>" <?php \X_UI\Core\AbstractComponent::render_attributes($attr); ?>>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-24 col-md-16 d-flex flex-column gap-3  align-items-center justify-content-center">
                <h2 class="background-cta-banner-section__title"><?= $title ?></h2>
                <?php
                if (!empty($cta)):
                    X_UI\Modules\Buttons\Component::render(
                        array(
                            'style' => 'icon-right',
                            'title' => $cta['title'],
                            'url' => $cta['url'],
                            'target' => $cta['target'],
                            'icon' => 'pencil',
                            'has_icon' => 'true',
                            'icon_position' => 'end',
                            'attr' => array(
                                'class' => 'w-100 w-md-auto'
                            )
                        )
                    );
                    ?>
                    <?php
                endif;
                ?>
            </div>
        </div>
    </div>
</section>