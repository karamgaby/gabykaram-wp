<?php
/* Template Name: Flexible Content Template */


get_header(); ?>

  <div id="primary" class="primary primary--page">

      <?php
      while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php
        the_ID(); ?>" <?php
        post_class( 'entry entry--page' ); ?>>
          <?php
          // Check value exists.
          if ( have_rows( 'flexible_content' ) ):

            // Loop through rows.
            while ( have_rows( 'flexible_content' ) ) : the_row();
              $row_layout = get_row_layout();
              $args = array(
                'attr' => [
                  'class' => []
                ]
              );
              $advanced_settings = get_sub_field('advanced_settings');
              $section_id = $advanced_settings ? $advanced_settings['section_id'] : null;
              $mobile_top_spacing = $advanced_settings ? $advanced_settings['mobile_top_spacing'] : null;
              $desktop_top_spacing = $advanced_settings ? $advanced_settings['desktop_top_spacing'] : null;
              if(!empty( $section_id ) ) {
                $args['attr']['id'] = $section_id;
              }
              if(!empty($mobile_top_spacing)) {
                $args['attr']['class'][] = 'mt-' . $mobile_top_spacing;
                if(empty($desktop_top_spacing)) {
                  $args['attr']['class'][] = 'mt-md-0';
                }
              }
              if(!empty($desktop_top_spacing)) {
                $args['attr']['class'][] = 'mt-md-' . $desktop_top_spacing;
              }
              if($row_layout === 'pictures_slider_section') {
                $args['title'] = get_sub_field( 'title');
                $args['content'] = get_sub_field( 'content');
                $args['pictures'] = get_sub_field( 'pictures');
                $args['has_button_on_mobile'] = get_sub_field( 'has_button_on_mobile');
                $args['button_link_plus_text'] = get_sub_field( 'button_link_plus_text');
                $args['switch_image_on_top_on_mobile'] = get_sub_field( 'switch_image_on_top_on_mobile');
              }
              if($row_layout === 'text_gallery_section') {
                $args['title'] = get_sub_field( 'title');
                $args['content'] = get_sub_field( 'content');
                $args['pictures'] = get_sub_field( 'pictures');
              }
              if($row_layout === 'calendar_booking') {
                $args['embed_type'] = get_sub_field( 'embed_type');
                $args['title'] = get_sub_field( 'title');
                $args['booking_id'] = get_sub_field( 'booking_id');
              }
              if($row_layout === 'icons_slider') {
                $args['items'] = get_sub_field( 'icons');
              }
              if($row_layout === 'quote_section') {
                $args['quote'] = get_sub_field( 'quote');
                $args['author'] = get_sub_field( 'author');
              }
              if($row_layout === 'video_cta') {
                $args['video_cover_image'] = get_sub_field( 'video_cover_image');
                $args['youtube_video_url'] = get_sub_field( 'youtube_video_url');
                $args['content'] = get_sub_field( 'content');
                $args['cta_link_and_text'] = get_sub_field( 'cta_link_and_text');
              }
              if($row_layout === 'title_section') {
                $args['title'] = get_sub_field( 'title');
              }
              if($row_layout === 'background_cta_banner') {
                $args['title'] = get_sub_field( 'title');
                $args['cta'] = get_sub_field( 'cta');
              }
              if($row_layout === 'products_type_room_listing') {
                $args['products'] = get_sub_field( 'products');
              }
              ?>
              <?php
              get_template_part('template-parts/flexible_content/content', $row_layout, $args);
              // End loop.
            endwhile;
          endif;
          ?>
        </article>

      <?php
      endwhile; ?>

  </div><!-- #primary -->

<?php
get_footer();
