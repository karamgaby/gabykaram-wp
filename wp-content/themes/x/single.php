<?php
use X_UI\Modules\Image\Component as Image;

/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package x
 */

 get_header();
 ?>
     <main id="primary" class="single-blog" itemscope itemtype="https://schema.org/Article">
       <?php
       get_template_part( 'template-parts/single-post/content','page-hero-section');
       ?>
     <section class="container  pt-4 pb-3 py-lg-4">
            <div class="row justify-content-center">
              <div class="col-24 col-md-16 content-section">
                 <?php
                 while ( have_posts()):
                   the_post();
                   the_content();
                 endwhile;
                 ?>
              </div>
            </div>
     </section>
     </main>
     <!-- <aside>
         <?php
        //  get_template_part( 'template-parts/single-post/content', 'related-post' );
         ?>
     </aside> -->
 
 <?php
 get_footer();
 