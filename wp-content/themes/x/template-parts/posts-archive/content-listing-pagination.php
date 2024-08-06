<?php

/**
 * Template part: Posts archive listing and pagination
 * args array:
 * 	- page number
 * 	- search parameter  
 * 	- category filter
 */


$blogs = new WP_Query([
	'post_type'      	=> 'post',
	'posts_per_page' 	=> 9,
	'post_status'			=> 'publish',
]);
?>
<section id="blog-pagination-section">
	<?php
	if ($blogs->have_posts()) :
		$counter = 1;
		get_template_part('template-parts/posts-archive/parts/content', 'archive-listing', array(
			'query_result' => $blogs
		));
	else :
		get_template_part('template-parts/posts-archive/parts/content', 'no-posts');
	endif;
	wp_reset_query();
	?>
</section>
