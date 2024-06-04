<?php

"use strict";
if ( ! isset( $args ) ) {
  return;
}
$section_id = $args['section_id'] ?? null;
$embed_type = $args['embed_type'];
$title      = $args['title'];
$booking_id = isset( $args['booking_id'] ) ? sanitize_text_field( $args['booking_id'] ) : '';

$attr = [
  'class' => [
    'calendar-booking x-background-white-grey-300',
  ]
];
if ( ! empty( $section_id ) ) {
  $attr['id'] = $section_id;
}
if($embed_type === 'calendly') {
  $attr['class'][] = 'pt-lg-7 py-5 calendar-booking--calendly';
} else {
  $attr['class'][] = 'py-lg-7 py-5';
}
?>
<section <?php
\X_UI\Core\AbstractComponent::render_attributes( $attr ); ?> >
  <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="col-24 col-lg-20">
        <?php
        if ( ! empty( $title ) ):
          ?>
          <h2 class="x-typography-h4 x-typography-lg-h2 mb-lg-5 mb-3"><?= $title ?></h2>
        <?php
        endif;
        ?>
      </div>
      <div class="col-24   <?= $embed_type !== 'calendly'? 'col-lg-20': 'col-lg-22'?>">

        <?php
        if ( $embed_type === 'calendly' ):
          ?>
          <div class="calendar-booking__calendly-embed">
            <!-- Calendly inline widget begin -->
            <div class="calendly-inline-widget" data-url="https://calendly.com/gabykaram/30min?hide_gdpr_banner=1" style="min-width:320px;height:660px;"></div>
            <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>
            <!-- Calendly inline widget end -->
          </div>

        <?php
        else:
          echo do_shortcode( '[wpcal id=2]' );
        endif;
        ?>
      </div>
    </div>
  </div>
</section>
