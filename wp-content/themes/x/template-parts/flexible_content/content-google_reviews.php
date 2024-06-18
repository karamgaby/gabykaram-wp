<?php
"use strict";
use WP_Rplg_Google_Reviews\Includes\Feed_Deserializer;
use WP_Rplg_Google_Reviews\Includes\Feed_Old;
use WP_Rplg_Google_Reviews\Includes\Core\Core;

if (!isset($args)) {
    return;
}

$shortcode_id = $args['google_review_shortcode_id'];

$feed_deserializer = new Feed_Deserializer(new \WP_Query());
$core = new Core();
$feed_old = new Feed_Old();

if (get_option('grw_active') === '0') {
    return '';
}


$feed = $feed_deserializer->get_feed($shortcode_id);

if (!$feed) {
    return;
}

$data = $core->get_reviews($feed);
$business = $data['businesses'];
$reviews = $data['reviews'];
// file_put_contents(__DIR__ . '/data.json', json_encode($data));


$args = wp_parse_args(
    $args,
    array(
        'quote' => '',
        'author' => '',
    )
);
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
<section>
    <div class="container">
        <div class="row">
            <div class="col-24">
                <?php echo do_shortcode('[grw id='.$shortcode_id.']'); ?>
            </div>
        </div>
    </div>
</section>