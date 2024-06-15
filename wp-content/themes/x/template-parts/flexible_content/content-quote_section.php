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
$quote = $args['quote'];
$author = $args['author'];
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
<section class="quote-section <?= implode(' ', $class) ?>" <?php \X_UI\Core\AbstractComponent::render_attributes($attr); ?>>
    <div class="container">
        <div class="row">
            <div class="col-24">
                <div class="quote-container">
                    <div class="quote-box">
                        <blockquote>
                            <?= $quote ?>
                        </blockquote>
                        <div class="quote-author">
                            <?= $author ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>