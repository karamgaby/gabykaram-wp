<?php
use X_Modules\PostCard\Component as PostCard;
/**
 * Template part: Posts Archive listing part of Posts archive listing and pagination
 * args array:
 * 	- query_result
 */

$blogs = $args['query_result'];
?>
<div class="container pt-lg-5 pt-4 position-relative">
  <div class="row">
    <?php
    while ($blogs->have_posts()) :
      $blogs->the_post();
      $thumbnail_id = get_post_thumbnail_id();
      $thumbnail_url = get_the_post_thumbnail_url();
      if (!$thumbnail_id || !$thumbnail_url) {
        $card_image_args = [
          'src'    => get_template_directory_uri() . '/assets/images/placeholder.png',
          'attr' => [
            'width'  => '727',
            'height' => '373'
          ]
        ];
      } else {
        $card_image_args = [
          'id' => $thumbnail_id,
          'src' => $thumbnail_url
        ];
      }
    ?>
      <div class="col-lg-8 col-md-12 col-24 mb-4">
          <?php
          PostCard::render([
            'type' => 'post',
            'html_tag' => 'a',
            'title' => get_the_title(),
            'description' => truncate_words(strip_tags(get_the_content()), 30, ''),
            'card_image' => $card_image_args,
            'attr'        => [
              'href' => get_permalink()
            ],
            'button_attr' => array(
              'style' => 'icon-right-outlined',
              'has_icon'=> 'true',
              'icon'    => 'chevron-right',
            )
          ])
          ?>
      </div>
    <?php
    endwhile;
    ?>
  </div>
</div>
