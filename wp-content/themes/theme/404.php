<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package polarstork
 */

get_header();

$the_title   = 'Page Not Found';
$home_button = 'Back to Home';
?>

	<main id="main" class="site-main 404" role="main">
		<div class="container text-center">
			<h1>404</h1>
			<h3><?php echo $the_title; ?></h3>
			<div class=" back-home wow fadeInUp mt-5">
				<a href="<?php echo home_url( '/' ); ?>" class="btn btn-orange">
					<?php echo $home_button; ?>
				</a>
			</div>
		</div>
	</main><!-- #main -->
<?php
get_footer();




























