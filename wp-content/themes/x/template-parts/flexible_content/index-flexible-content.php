<?php

if (have_rows('flexible_content')):
  $counter = 0;
  // Loop through rows.
  while (have_rows('flexible_content')):
    the_row();
    $row_layout = get_row_layout();
    $args = array(
      'attr' => [
        'class' => []
      ]
    );
    $advanced_settings = get_sub_field('advanced_settings');
    $section_id = $advanced_settings ? $advanced_settings['section_id'] : null;
    $mobile_top_spacing = $advanced_settings ? $advanced_settings['mobile_top_spacing'] : null;
    $desktop_top_spacing = $advanced_settings ? $advanced_settings['desktop_top_spacing'] : null;
    if (!empty($section_id)) {
      $args['attr']['id'] = $section_id;
    }
    if (!empty($mobile_top_spacing) && $mobile_top_spacing !== 'default') {
      $args['attr']['class'][] = 'mt-' . $mobile_top_spacing;
      if (empty($desktop_top_spacing) || $desktop_top_spacing === 'default') {
        $args['attr']['class'][] = 'mt-md-0';
      }
    }
    if (!empty($desktop_top_spacing) && $desktop_top_spacing !== 'default') {
      $args['attr']['class'][] = 'mt-md-' . $desktop_top_spacing;
    }
    if ($row_layout === 'pictures_slider_section') {
      $args['title'] = get_sub_field('title');
      $args['content'] = get_sub_field('content');
      $args['pictures'] = get_sub_field('pictures');
      $args['has_button_on_mobile'] = get_sub_field('has_button_on_mobile');
      $args['button_link_plus_text'] = get_sub_field('button_link_plus_text');
      $args['switch_image_on_top_on_mobile'] = get_sub_field('switch_image_on_top_on_mobile');
    }
    if ($row_layout === 'text_gallery_section') {
      $args['title'] = get_sub_field('title');
      $args['content'] = get_sub_field('content');
      $args['pictures'] = get_sub_field('pictures');
    }
    if ($row_layout === 'calendar_booking') {
      $args['embed_type'] = get_sub_field('embed_type');
      $args['title'] = get_sub_field('title');
      $args['booking_id'] = get_sub_field('booking_id');
    }
    if ($row_layout === 'icons_slider') {
      $args['items'] = get_sub_field('icons');
    }
    if ($row_layout === 'quote_section') {
      $args['quote'] = get_sub_field('quote');
      $args['author'] = get_sub_field('author');
    }
    if ($row_layout === 'video_cta') {
      $args['show_video_on_top_on_mobile'] = get_sub_field('show_video_on_top_on_mobile');
      $args['video_cover_image'] = get_sub_field('video_cover_image');
      $args['youtube_video_url'] = get_sub_field('youtube_video_url');
      $args['content'] = get_sub_field('content');
      $args['content_color'] = get_sub_field('content_color');
      $args['bold_content_color'] = get_sub_field('bold_content_color');
      $args['title_typography_desktop'] = get_sub_field('title_typography_desktop');
      $args['title_typography_mobile'] = get_sub_field('title_typography_mobile');
      $args['cta_link_and_text'] = get_sub_field('cta_link_and_text');
    }
    if ($row_layout === 'title_section') {
      $args['title'] = get_sub_field('title');
    }
    if ($row_layout === 'background_cta_banner') {
      $args['title'] = get_sub_field('title');
      $args['cta'] = get_sub_field('cta');
    }
    if ($row_layout === 'products_type_room_listing') {
      $args['products'] = get_sub_field('products');
    }
    if ($row_layout === 'colored_title') {
      $args['title'] = get_sub_field('title');
    }
    if ($row_layout === 'google_reviews') {
      $args['google_review_shortcode_id'] = get_sub_field('google_review_shortcode_id');
    }
    if ($row_layout === 'products_type_coworking') {
      $args['title'] = get_sub_field('title');
      $args['content'] = get_sub_field('content');
      $args['call_to_action'] = get_sub_field('call_to_action');
      $args['coworking_products'] = get_sub_field('coworking_products');
    }
    if ($row_layout === 'navigation_cards') {
      $args['title'] = get_sub_field('title');
      $args['cards'] = get_sub_field('cards');
    }
    if ($row_layout === 'mobile_text_slider') {
      $args['sliding_words'] = get_sub_field('sliding_words');
    }
    if ($row_layout === 'open_positions') {
      $args['title'] = get_sub_field('title');
      $args['image_desktop'] = get_sub_field('image_desktop');
      $args['image_mobile'] = get_sub_field('image_mobile');
      $args['open_positions'] = get_sub_field('open_positions');
    }
    if ($row_layout === 'youtube_cards_modal') {
      $args['cards'] = get_sub_field('cards');
      $args['section_index'] = $counter;
    }
    if ($row_layout === 'icons_slider_with_video') {
      $args['title_first_part'] = get_sub_field('title_first_part');
      $args['title_second_part'] = get_sub_field('title_second_part');
      $args['content'] = get_sub_field('content');
      $args['youtube_video_url'] = get_sub_field('youtube_video_url');
      $args['video_cover_image'] = get_sub_field('video_cover_image');
      $args['icons'] = get_sub_field('icons');
    }
    if ($row_layout === 'text-image-link') {
      $args['title'] = get_sub_field('title');
      $args['content'] = get_sub_field('content');
      $args['title_color'] = get_sub_field('title_color');
      $args['title_typography_on_desktop'] = get_sub_field('title_typography_on_desktop');
      $args['title_typography_on_mobile'] = get_sub_field('title_typography_on_mobile');
      $args['call_to_action'] = get_sub_field('call_to_action');
      $args['has_image'] = get_sub_field('has_image');
      $args['image_desktop'] = get_sub_field('image_desktop');
      $args['image_mobile'] = get_sub_field('image_mobile');
      $args['image_desktop_width'] = get_sub_field('image_desktop_width');
      $args['is_image_direclty_below_title_mobile'] = get_sub_field('is_image_direclty_below_title_mobile');
    }
    ?>
    <?php
    get_template_part('template-parts/flexible_content/content', $row_layout, $args);
    $counter++;
    // End loop.
  endwhile;
endif;