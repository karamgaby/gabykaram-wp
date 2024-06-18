<?php
/* Template Name: Flexible Content Template */


get_header(); ?>

<div id="primary" class="primary primary--page">

  <?php
  while (have_posts()):
    the_post(); ?>
    <article id="post-<?php
    the_ID(); ?>" <?php
     post_class('entry entry--page'); ?>>
      <?php
      // Check value exists.
      get_template_part('template-parts/flexible_content/index','flexible-content');
      ?>
    </article>

    <?php
  endwhile; ?>

</div><!-- #primary -->

<?php
get_footer();
