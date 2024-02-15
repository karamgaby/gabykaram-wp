<?php
if ( is_home() && get_option( 'page_for_posts' ) ) {
	$page_ID = get_option( 'page_for_posts' );
} else {
	$page_ID = get_the_ID();
}
$custom_schema = get_field( 'custom_schema', $page_ID );

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package polarstork
 */
?>
<footer id="colophon" class="site-footer" role="contentinfo">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<p class="copy-rights"> © <?php echo date( 'Y' ); ?>
					, <?php _e( 'Cop Name', 'polarstork' ); ?> <?php _e( 'Powered by', 'polarstork' ); ?> <a href="https://polarstork.com">Polar
						Stork</a></p>
				<nav class="navbar navbar-expand">
					<?php
					if ( has_nav_menu( 'footer-menu' ) ) :
						wp_nav_menu(
							array(
								'theme_location'  => 'footer-menu',
								'container'       => 'div',
								'container_class' => 'collapse navbar-collapse footer-menu',
								'menu_class'      => 'navbar-nav',
							)
						);
					endif;
					?>
				</nav>
			</div>

		</div>
	</div>
</footer>
<?php
wp_footer();
/**
 * custom schema section - as ACF field
 */

if ( $custom_schema && ! is_author() ) {
	echo $custom_schema;
}
?>

</body>

</html>
