<?php
/**
 * Template part: Video Slider section common part in multiple pages
 */

$arrows_color = 'white';
$owl_is_rtl = ! empty( $args['owl_is_rtl'] );
if ( ! empty( $args['arrows_color'] ) ) {
	$arrows_color = $args['arrows_color'];
}
$total_videos = count( get_field( 'videos_slider'));
?>
<div class="text-video-slider row justify-content-center position-relative">
    <div class="col-12 <?= $total_videos > 2 ? 'col-lg-11': ''?>">
      <?php
      ob_start();
      echo '<button class="carousel-slider-arrow-button">';
      PS_IconButton::render( array(
	      'icon_name'        => 'filled-navigation-chevron-left',
	      'html_tag'         => 'span',
	      'color'            => 'base',
	      'size'             => 'medium',
	      'title'            => 'next-slide',
	      'size_breakpoints' => [
		      'xxxl' => 'large',
	      ],
	      'attr'             => [
		      'class' => array(
			      'carousel-slider-arrow',
			      'carousel-slider-arrow-' . $arrows_color,
		      )
	      ]
      ) );
      echo '</button>';
      $icon_left = ob_get_clean();
      ob_start();
      echo '<button class="carousel-slider-arrow-button">';
      PS_IconButton::render( array(
	      'icon_name'        => 'filled-navigation-chevron-right',
	      'html_tag'         => 'span',
	      'color'            => 'base',
	      'size'             => 'medium',
	      'title'            => 'next-slide',
	      'size_breakpoints' => [
		      'xxxl' => 'large',
	      ],
	      'attr'             => [
		      'class' => array(
			      'carousel-slider-arrow',
			      'carousel-slider-arrow-' . $arrows_color,
		      )
	      ]
      ) );
      echo '</button>';
      $icon_right = ob_get_clean();

      if ( have_rows( 'videos_slider' ) ) :
	      ?>
          <div class="video-slider carousel-slider owl-carousel"
               data-rtl="<?= $owl_is_rtl ? 'true':'false' ?>"
               data-arrow-left="<?= htmlspecialchars( $icon_left ) ?>"
               data-arrow-right="<?= htmlspecialchars( $icon_right ) ?>"
          >
            <?php
            while ( have_rows( 'videos_slider' ) ) :
	            the_row();
	            $activate                	= get_sub_field( 'activate' );
	            $testimonial_type           = get_sub_field( 'testimonial_type' );
	            $read_more_link             = get_sub_field( 'read_more_link' );
				$video_title                = get_sub_field( 'video_title' );
				if (!$activate) continue;
				if ($testimonial_type === 'video'):
					$video_cover_image          = get_sub_field( 'video_cover_image' );
					$youtube_video_o_ebmbed_url = get_sub_field( 'youtube_video_url', false, false );
					$video_id                   = get_youtube_video_id_from_url( $youtube_video_o_ebmbed_url );
				?>
					<div class="video-slide">
						<?php
						PS_Video::render( [
							'video_id'    => $video_id,
							'cover_image' => [
								'id' => $video_cover_image,
							]
						] ); ?>
						<h3 class="ps-typography-h5 ps-typography-lg-h3 ps-color-secondary-main text-center mt-32 pb-12 pb-lg-0 mt-lg-32 px-64 px-lg-0"><?= $video_title ?></h3>
					</div>
				<?php
				elseif($testimonial_type === 'text'):
					$testimonial_content 	= get_sub_field( 'testimonial_content' );
					$read_more_link			= get_sub_field( 'read_more_link' );
				?>
					<div class="text-testimonial">
						<div class="testimonial-content-container ps-background-text-background position-relative d-flex align-items-center">
							<div class="testimonial-content-wrapper px-24 py-32 d-flex flex-column overflow-auto mb-auto">
                <div class="quote-wrapper position-relative mb-12 d-flex">
                <?php
                PS_Icon::render(array('name'=> 'quote', 'size' => 'large', 'attr' => array('class' => ['ps-fill-primary-main'])));
                PS_Icon::render(array('name'=> 'quote', 'size' => 'large', 'attr' => array('class' => ['ps-fill-primary-main ms-n4'])));
                ?>
                </div>
								<div class="ps-lg-16">
									<div class="testimonial-content ps-free-text ps-color-text-primary ps-typography-body2 ps-typography-xl-body1">
                    <?= $testimonial_content ?>
				</div>
				<p class="d-inline ps-free-text ps-color-text-primary">
				  <?php
				  if ($read_more_link):
					  PS_Button::render( array(
						  'text'      => 'Read more',
						  'variant'   => 'text',
						  'size'      => 'none',
						  'text_size' => 'small',
						  'html_tag' => 'a',
						  'attr'      => array(
							  'href'			 => $read_more_link['url'],
							  'target'		 => $read_more_link['target'],
							  'aria-expanded'  => 'false',
							  'aria-label'  => 'Read more about ' . $read_more_link['title'],
							  'class'          => [ 'text-decoration-underline' ]
						  )
					  ) );
				  endif;
				  ?>
				</p>
									
                  
								</div>
							</div>
						</div>
						<h3 class="ps-typography-h5 ps-typography-lg-h3 ps-color-secondary-main text-center mt-32 pb-12 pb-lg-0 mt-lg-32 px-64 px-lg-0"><?= $video_title ?></h3>
					</div>
				<?php endif; ?>
            <?php
            endwhile;
            ?>
          </div>
      <?php
      endif;
      ?>
    
    </div>
</div>
