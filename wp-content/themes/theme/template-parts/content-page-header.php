<?php
/**
 * Template part for displaying page header with (background image, title and description)
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package polarstork
 */

is_home() ? $current_post_id = get_option( 'page_for_posts' ) : $current_post_id = false;
?>

<div class="page-header-image d-flex align-items-center" style="background-image: url(<?php echo the_field( 'page_header_background_image', $current_post_id ); ?>);">
	<div class="container">
		<div class="row">
			<div class="page-header-content">
				<h2><?php echo the_field( 'page_header_title', $current_post_id ); ?></h2>
				<p><?php echo the_field( 'page_header_description', $current_post_id ); ?></p>
				<?php
				if ( get_field( 'page_header_add_button', $current_post_id ) ) :
					?>
					<a class="btn orange-btn" href="<?php the_field( 'page_header_button_url', $current_post_id ); ?>" role="button"><?php the_field( 'page_header_button_text', $current_post_id ); ?></a>
					<?php
				endif;
				?>
			</div>
		</div>
	</div>
</div>
