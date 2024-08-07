<?php
"use strict";
use X_Modules\PostCard\Component as PostCard;

if (!isset($args)) {
    return;
}
$args = wp_parse_args(
    $args,
    array(
        'projects' => [],
    )
);
$projects = $args['projects'];
if (!isset($args['attr']) || !is_array($args['attr'])) {
    $args['attr'] = [];
}
$attr = wp_parse_args(
    $args['attr'],
    array(
        'class' => [],
    )
);
$class = $attr['class'];
unset($attr['class']);
if (!function_exists('x_get_the_post_content_text')) {
    // @todo move it out
    function x_get_the_post_content_text($post_id = null)
    {
        $content = get_the_content(null, null, $post_id);
        $content = strip_tags($content);
        $content = strip_shortcodes($content);
        $content = trim(preg_replace('/\s+/', ' ', $content));
        $ret = $content; /* if the limit is more than the length, this will be returned */
        return $ret;
    }
}
?>
<section class="projects-section <?= implode(' ', $class) ?>" <?php \X_UI\Core\AbstractComponent::render_attributes($attr); ?>>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-24 col-md-20">
                <div class="projects-list d-flex row-gap-6 flex-column">
                    <?php foreach ($projects as $project_id):
                        $thumbnail_id = get_post_thumbnail_id($project_id);
                        $thumbnail_url = get_the_post_thumbnail_url($project_id);
                        $external_url = get_field('url', $project_id);
                        $title = get_the_title($project_id); 
                        // case-study-tag
                        $case_study_tags = get_the_terms($project_id, 'case-study-tag');
                        $description = truncate_words(x_get_the_post_content_text($project_id), 75, '');
                        if (empty($description)):
                            $description = ' ';
                        endif;
                        if (!empty($case_study_tags) && !is_wp_error($case_study_tags)) {
                            $tagsValues = array_map(function ($item) {
                                return $item->name;
                            }, $case_study_tags);

                            $description .= "<p class='" . (!empty($description) ? "mt-2" : '') . "'>" . implode(', ', $tagsValues) . "</p>";
                        }
                        if (!$thumbnail_id || !$thumbnail_url) {
                            $card_image_args = [
                                'src' => get_template_directory_uri() . '/assets/images/placeholder.png',
                                'attr' => [
                                    'width' => '727',
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
                        <div class="project-item">
                            <?php
                            PostCard::render([
                                'type' => 'post',
                                'post_layout' => 'banner',
                                'html_tag' => 'div',
                                'title' => $title,
                                'description' => $description,
                                'card_image' => $card_image_args,
                                'has_button' => !empty($external_url),
                                'button_attr' => array(
                                    'title' => 'Check it',
                                    'style' => 'icon-right-outlined',
                                    'has_icon' => 'true',
                                    'icon' => 'chevron-right',
                                    'href' => $external_url,
                                    'as' => 'a',
                                    'attr' => [
                                        'href' => $external_url,
                                    ]
                                )
                            ])
                                ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>