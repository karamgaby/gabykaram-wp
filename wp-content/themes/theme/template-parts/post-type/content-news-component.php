<div class="news-item">
	<div class="row">
		<div class="col-md-4 col-12">
			<?php
			if ( get_the_post_thumbnail_url() ) :
				the_post_thumbnail( 'large', array( 'class' => 'news-img' ) );
			else :
				?>
			<a href="<?php the_permalink(); ?>">
				<img class="news-img" src="<?php echo get_template_directory_uri(); ?>/images/base-image.jpg" alt="<?php the_title(); ?>">
		 </a>
				<?php
			endif;
			?>

		</div>
		<div class="col-md-8 col-12">
			<div class="news-content">
				<h2 class="news-title">
				<a href="<?php the_permalink(); ?>">
				<?php the_title(); ?>
				</a>
				</h2>
				<h5 class="news-date"><?php the_time( 'l j F Y' ); ?>, <?php the_time( 'G:i' ); ?></h5>
				<div class="news-description"><?php the_excerpt(); ?></div>
			</div>
		</div>
	</div>
</div>
