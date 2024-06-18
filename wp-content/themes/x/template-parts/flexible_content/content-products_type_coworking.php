<?php
"use strict";
use X_Modules\Products\CowokingProductCard;

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
$content = $args['content'];
$products = $args['coworking_products'];
$call_to_action = $args['call_to_action'];
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
<section class="coworking-products-section <?= implode(' ', $class) ?>" <?php \X_UI\Core\AbstractComponent::render_attributes($attr); ?>>
    <div class="container">
        <div class="row">
            <div class="col-24 col-md-12">
                <div class="row">
                    <?php foreach ($products as $product_id): ?>
                        <div class="col-24 col-md-12">
                            <?php
                            $featured_image_id = get_post_thumbnail_id($product_id);
                            if (empty($featured_image_id)) {
                                $default_image_id = null;
                                $terms = wp_get_post_terms($product_id, 'product_type');
                                foreach ($terms as $term) {
                                    $term_slug = $term->slug;
                                    $term_default_image = get_field('default_product_image_tax_type_' . $term_slug, 'option');
                                    if (!empty($term_default_image)) {
                                        $default_image_id = $term_default_image;
                                    }
                                }
                                if (empty($default_image_id)) {
                                    $default_image_id = get_field('default_product_image', 'option');
                                }
                                if (!empty($default_image_id)) {
                                    $featured_image_id = $default_image_id;
                                }
                            }
                            $featured_image_id = $featured_image_id ?? null;
                            CowokingProductCard::render(
                                array(
                                    'image_id' => $featured_image_id,
                                    'title' => get_the_title($product_id),
                                    'content' => get_field('description', $product_id),
                                    'price' => get_field('price', $product_id),
                                    'card_style' => get_field('card_style', $product_id),
                                )
                            );
                            ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-24 col-md-10 offset-md-2">
                <div class="d-flex flex-column justify-content-center gap-3">
                    <h2 class="x-typography-h4 x-typography-md-h2 "><?= $title ?></h2>
                    <div class="x-typography-body-1 x-typography-md-subtitle-1 "><?= $content ?></div>
                    <div class="coworking-products-section__cta">
                        <?php
                        X_UI\Modules\Buttons\Component::render(
                            array(
                                'title' => $call_to_action['title'],
                                'url' => $call_to_action['url'],
                                'target' => $call_to_action['target'],
                                'style' => 'primary-standard',
                                'as' => 'a',
                                'attr' => [
                                    'class' => ''
                                ]
                            )
                        );
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>