<?php

/**
 * Template name: Posts page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package polarstork
 */

get_header();
$blogs = new WP_Query([
    'post_type' => 'post',
    'posts_per_page' => -1,
]);
?>

<main class="blog-list pb-80 pb-lg-96">
    <?php
    get_template_part('template-parts/posts-archive/content', 'page-hero-section');
    get_template_part('template-parts/posts-archive/content', 'intro-section');
    get_template_part('template-parts/posts-archive/content', 'listing-pagination');
    ?>
</main>
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "ItemList",
        "url": "<?= get_permalink(get_option('page_for_posts')) ?>",
        "name": "Worlk Blogs",
        "description": "List of users review, Worlk benefits and how to Worlk",
        "itemListElement": [

            <?php
            $counter = 1;
            if ($blogs->have_posts()):
                while ($blogs->have_posts() && $counter < 11):
                    $blogs->the_post();
                    if ($counter !== 1):
                        ?>,
                                <?php
                    endif;
                    ?> {
                                "@type": "Article",
                                "image": "<?= get_the_post_thumbnail_url(); ?>",
                                "position": <?= $counter; ?>,
                                "url": "<?= get_permalink(); ?>",
                                "name": "<?= get_the_title(); ?>",
                                "headline": "<?= get_the_title(); ?>",
                                "author": {
                                    "@type": "Person",
                                    "@id": "<?= get_author_posts_url(get_the_author_meta('ID')); ?>",
                                    "name": "<?= get_the_author(); ?>",
                                    "url": "<?= get_author_posts_url(get_the_author_meta('ID')); ?>",
                                    "description": "<?= get_the_author_meta('description'); ?>",
                                    "image": {
                                        "@type": "ImageObject",
                                        "inLanguage": "en-US",
                                        "@id": "<?= get_avatar_url(get_the_author_meta('ID')); ?>",
                                        "url": "<?= get_avatar_url(get_the_author_meta('ID')); ?>",
                                        "contentUrl": "<?= get_avatar_url(get_the_author_meta('ID')); ?>",
                                        "caption": "<?= get_the_author(); ?>"
                                    }
                                }
                            }
                    <?php
                    $counter++;
                endwhile;
            endif;
            // Restore original post data.
            wp_reset_postdata();
            ?>
        ]
    }
</script>

<?php
get_footer();
?>