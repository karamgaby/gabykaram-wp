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
                ]
              );
              $section_id = get_sub_field('section_id');
              if(!empty( $section_id ) ) {
                $args['attr']['id'] = $section_id;
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
