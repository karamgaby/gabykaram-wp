<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package polarstork
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="mobile-web-app-capable" content="yes">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<meta itemprop="name" content="<?php echo get_bloginfo(); ?>" />
	<meta itemprop="url" content="<?php echo site_url(); ?>" />
	<meta itemprop="creator" content="pstheme" />
	<meta name="author" content="pstheme">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<?php
	wp_head();
	if ( function_exists( 'get_field' ) && get_field( 'google_tag_manager_id', 'option' ) ) :
		?>
		<!-- Google Tag Manager -->
		<script>
			(function(w, d, s, l, i) {
				w[l] = w[l] || [];
				w[l].push({
					'gtm.start': new Date().getTime(),
					event: 'gtm.js'
				});
				var f = d.getElementsByTagName(s)[0],
					j = d.createElement(s),
					dl = l != 'dataLayer' ? '&l=' + l : '';
				j.async = true;
				j.src =
					'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
				f.parentNode.insertBefore(j, f);
			})(window, document, 'script', 'dataLayer', '<?php the_field( 'google_tag_manager_id', 'option' ); ?>');
		</script>
		<!-- End Google Tag Manager -->
		<?php
	endif;

	if ( function_exists( 'get_field' ) && get_field( 'google_analytics_tracking_id', 'option' ) ) :
		$GA_api = get_field( 'google_analytics_tracking_id', 'option' );
		?>
		<!-- Global site tag (gtag.js) - Google Analytics -->
    <?php // phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedScript ?>
		<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $GA_api; ?>"></script>
		<script>
			window.dataLayer = window.dataLayer || [];

			function gtag() {
				dataLayer.push(arguments);
			}
			gtag('js', new Date());
			gtag('config', '<?php echo $GA_api; ?>');
		</script>
		<?php
	endif;
	?>
</head>

<body <?php body_class(); ?>>

	<?php
	if ( function_exists( 'get_field' ) && get_field( 'google_tag_manager_id', 'option' ) ) :
		?>
		<!-- Google Tag Manager (noscript) -->
		<noscript>
			<iframe src="https://www.googletagmanager.com/ns.html?id=<?php the_field( 'google_tag_manager_id', 'option' ); ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe>
		</noscript>
		<!-- End Google Tag Manager (noscript) -->
		<?php
	endif;
	?>
	<header>
		<div class="site-branding">
			<?php if ( is_front_page() ) : ?>
				<h1 class="site-title d-none"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<h1 class="site-title d-none"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php the_title(); ?></a></h1>
				<?php
			endif;
			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) :
				?>
				<p class="site-description d-none"><?php echo $description; /* phpcs:ignore Standard.Category.SniffName.ErrorCode */ ?></p>
				<?php
			endif;
			?>
		</div><!-- .site-branding -->
		<nav class="navbar fixed-top navbar-inverse navbar-expand" data-toggle="affix">
			<div class="container-fluid">
				<div class="navbar-brand wow fadeInLeft">
					<?php
					the_custom_logo();
					?>
				</div>
				<div id="main_menu" class="wow fadeInRight">
					<?php
					if ( function_exists( 'get_field' ) && get_field( 'showhide_language_switcher', 'option' ) && function_exists( 'pll_the_languages' ) ) :
						?>
						<div class="collapse navbar-collapse">
							<ul id="menu-languages" class="navbar-nav">
								<li class="dropdown">
									<a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link">
										<?php
										echo pll_current_language( 'name' );
										?>
										 </a>
									<ul class="dropdown-menu languages dropdown-menu-center">
										<?php
										pll_the_languages(
											array(
												'display_names_as' => 'name',
												'hide_current'     => true,
											)
										);
										?>
									</ul>
								</li>
							</ul>
						<?php
					endif;
					?>
						<button id="menu-btn" class="btn menu-btn" type="button">
							<span class="navbar-toggler-icon"></span>
						</button>
						</div>
				</div>
			</div>
		</nav>
	</header>
	<div id="menu-overlay" class="menu-btn"></div>
	<div id="menu-list" class="sidenav">
		<?php
		the_custom_logo();
		?>
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary-menu',
				'menu_id'        => 'primary-menu',
			)
		);
		?>
	</div>
