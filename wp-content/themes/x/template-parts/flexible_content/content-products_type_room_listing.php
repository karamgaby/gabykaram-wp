<?php
"use strict";
use X_Modules\Products\RoomProductCard;
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
$products = $args['products'];
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
<section class="rooms-products-section <?= implode(' ', $class) ?>" <?php \X_UI\Core\AbstractComponent::render_attributes($attr); ?>>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-24 col-md-20">
            <div class="products-list">
                <?php foreach($products as $product_id): ?>
                    <div class="product-item">
                        <?php 
                        $featured_image_id = get_post_thumbnail_id($product_id);
                        if(empty($featured_image_id)) {
                            $default_image_id = null;
                            $terms = wp_get_post_terms($product_id, 'product_type');
                            foreach($terms as $term) {
                                $term_slug = $term->slug;
                                $term_default_image = get_field('default_product_image_tax_type_'.$term_slug, 'option');
                                if(!empty($term_default_image)) {
                                    $default_image_id = $term_default_image;
                                }
                            }
                            if(empty($default_image_id)) {
                                $default_image_id = get_field('default_product_image', 'option');
                            }
                            if(!empty($default_image_id)) {
                                $featured_image_id = $default_image_id;
                            }
                        }
                        $featured_image_id = $featured_image_id ?? null;
                        RoomProductCard::render(array(
                            'image_id' => $featured_image_id,
                            'title' => get_the_title($product_id),
                            'room_category' => get_field('room_category', $product_id),
                            'services' => get_field('services', $product_id),
                            'fit_for'=> get_field('fit_for', $product_id),
                            'bed_type' => get_field('bed_type', $product_id),
                            'bath_type' => get_field('bath_type', $product_id),
                        ));
                        ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
</section>