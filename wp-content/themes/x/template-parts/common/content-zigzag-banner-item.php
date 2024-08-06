<?php
/**
 * Template part: Innovation Page hero banner section, extending the common zigzag-banner-item
 */
if ( ! isset( $args ) ) {
	return;
}
$placeholders      = array(
	'title'       => '',
	'description' => '',
);
$args              = wp_parse_args( $args, $placeholders );
$direction         = $args['direction'];
$title_class       = $args['title_class'];
$description_class = $args['description_class'];
$title             = $args['title'];
$description       = $args['description'];
$img_attr          = $args['img_attr'];

if ( ! isset( $img_attr['attr'] ) ) {
	$img_attr['attr'] = [];
}
if ( ! isset( $img_attr['attr']['class'] ) ) {
	$img_attr['attr']['class'] = [];
}
$img_attr['attr']['class'][] = 'zigzag-banner-item-img-cover-src';
?>

<div class="zigzag-banner-item">
    <div class="row <?= $direction === 'rtl' ? 'flex-row-reverse' : '' ?>">
      <div class="col-12 col-lg-6 d-flex align-items-center pb-48 pb-lg-0 ">
        <div class="<?= $direction === 'rtl' ? 'ms-lg-32' : 'me-lg-32' ?>">
          <h2 class="<?= $title_class; ?>"><?= $title; ?></h2>
          <div class="<?= $description_class ?>">
            <?= $description; ?>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-6">
        <div class="zigzag-banner-item-img-cover">
          <?php
          PS_Image::render( $img_attr );
          ?>
        </div>
      </div>
    </div>
</div>
