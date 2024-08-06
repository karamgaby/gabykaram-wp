<?php
/**
 * Created by PhpStorm.
 * User: gabykaram
 * Date: 1/4/23
 * Time: 3:06 PM
 * File: content-related-post.php
 */

global $post;

$related_posts = get_post_related_posts( $post->id );

?>
<section class="section-related-articles-separator">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <hr class="ps-color-secondary-light m-0">
      </div>
    </div>
  </div>
</section>
<section class="section-related-articles pb-80 pt-40 pt-lg-64 pb-lg-48">
	<div class="container">
		<div class="row">
      <div class="col-12">
        <h2 class="ps-typography-h3 ps-typography-lg-h2 ps-color-secondary-main text-center">Related stories</h2>
      </div>
    </div>
    <div class="row gy-32 mt-0 pt-8 pt-lg-16">
			<?php
			foreach ( $related_posts as $related_post ) :
				$post_id = $related_post->ID;
				$content = truncate_words( bv_get_the_post_content_text( $post_id ), 75, '' );
				$featured_image_id = get_post_thumbnail_id( $post_id );
				$url = get_the_permalink( $post_id );
				$featured_image_id = get_post_thumbnail_id( $post_id );
				$card_image_args = [];
				if(empty( $content)) {
					$content = '&nbsp';
				}
				if ( empty( $featured_image_id ) || $featured_image_id === 0 ) {
					$card_image_args = [
						'src'  => get_template_directory_uri() . '/images/placeholder.png',
						'attr' => [
							'width'  => '800',
							'height' => '800'
						]
					];
				} else {
					$card_image_args = [
						'id' => $featured_image_id,
					];
				}
				?>
        <div class="col-12 col-lg-4">
        <?php
        PS_Card::render( array(
	        'type'        => 'post',
	        'title'       => ! empty( $related_post->post_title ) ? $related_post->post_title : '&nbsp;',
	        'description' => $content,
	        'html_tag'    => 'a',
	        'card_image'  => $card_image_args,
	        'attr'        => [
		        'href' => $url
	        ],
	        'button_attr' => array(
		        'content_type' => 'icon-right',
		        'icon_name'    => 'filled-navigation-arrow-forward',
		        'variant'      => 'outlined',
            'size' => 'medium',
	        )
        ) );
        ?>
      </div>
			
			<?php
			endforeach;
			?>
		</div>
	</div>
</section>
