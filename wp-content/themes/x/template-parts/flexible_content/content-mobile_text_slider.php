<!-- sliding_words -->
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
$sliding_words = $args['sliding_words'];

if (empty($sliding_words)) {
    return;
}

$words = explode(',', $sliding_words);
$sliding_words = array_map('trim', $words);
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
<section class="mobile-text-slider-section <?= implode(' ', $class) ?>" <?php \X_UI\Core\AbstractComponent::render_attributes($attr); ?>>
    <div class="sliding-words-slider swiper">
        <div class="swiper-wrapper">
            <?php
            // var_dump($sliding_words);
            foreach ($sliding_words as $word) {
                ?>
                <div class="word-slide swiper-slide">
                    <?= $word; ?>
                </div>
                <div class="swiper-slide dot-slide"><span class="dot"></span></div>
                <?php
            }
            ?>
        </div>
    </div>
</section>