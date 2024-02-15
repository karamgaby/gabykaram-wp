<?php

/**
 * Component: video
 *
 * @example
 * $placeholders = [
 *      // required
 *      'video_id'    => 'id',
 *      // optional
 *      'attr'        => [],
 *      'cover_image'   => [
 *              'id'=> null,
 *              'src'=> ''
 *          ],
 *  ];
 */


class PS_Video extends PS_Component {

	protected static array $sizes = array( 'medium', 'small' );

	public static function frontend( $data ) {
		$video_component_id = uniqid( 'ps-video-', false ) . random_int( 1, 100 );
		?>
		<div <?php parent::render_attributes( $data['attr'] ); ?>>
			<button class="ps-video-cover" data-type="inline" data-fancybox href="https://www.youtube.com/<?php echo $data['video_id']; ?>?autoplay=1" data-groupAll="false" >
				<?php PS_Image::render( $data['cover_image'] ); ?>
				<span class="ps-video-cover-filter"></span>
				<span class="ps-video-icon">
					<?php
					PS_Icon::render(
						array(
							'name' => 'play-arrow',
							'size' => 'xxlarge',
							'attr' => array(
								'class' => 'ps-fill-other-white',
							),
						)
					);
					?>
				</span>
			</button>
		</div>
		<div style="display: none;" class="fancybox__content" id="<?php echo $video_component_id; ?>_fancybox">
			<div class="container">
				<div class="plyr__video-embed" id="<?php echo $video_component_id; ?>_player"  data-plyr-provider="youtube" data-plyr-embed-id="<?php echo $data['video_id']; ?>"></div>
			</div>
		</div>
		<?php
	}

	public static function backend( $args = array() ) {
		$placeholders = array(
			// required
			'video_id'    => '',
			// optional
			'attr'        => array(),
			'cover_image' => array(
				'id'  => null,
				'src' => '',
			),
		);
		$args         = wp_parse_args( $args, $placeholders );
		if ( empty( $args['video_id'] ) ) {
			return parent::error( 'Missing youtube video id ($args[\'video_id\'])' );
		}
		if ( empty( $args['cover_image'] || ( empty( $args['cover_image']['id'] ) && empty( $args['cover_image']['src'] ) ) ) ) {
			return parent::error( 'Missing cover image id and src, id is primary and src is secondary ($args[\'cover_image\'][\'id\'] or $args[\'cover_image\'][\'src\'])' );
		}
		if ( ! isset( $args['attr']['class'] ) ) {
			$args['attr']['class'] = array();
		} elseif ( is_string( $args['attr']['class'] ) ) {
			$args['attr']['class'] = array( $args['attr']['class'] );
		}

		$args['attr']['class'][] = 'ps-video';
		return $args;
	}
}
