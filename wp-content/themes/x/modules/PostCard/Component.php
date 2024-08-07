<?php

namespace X_Modules\PostCard;

use X_UI\Modules\Image\Component as Image;
use X_UI\Modules\Buttons\Component as Button;
use X_UI\Core\AbstractComponent;
use X_UI\Core\Config;

class Component extends AbstractComponent
{
    protected static array $types = array('product', 'state', 'post');
    protected static array $post_layouts = array('default', 'banner', 'horizontal');
    protected static array $wrapper_html_tags = array('a', 'div', 'span');

    public static function frontend($data)
    {
        $html_tag = $data['html_tag'];

        $post_meta_spacing_classes = '';
        if (in_array($data['type'], ['product', 'state'])) {
            $post_meta_spacing_classes = 'mt-2';
        }

        // var_dump($data['card_image']);
        ?>
        <<?= $html_tag . ' ' ?><?php
            parent::render_attributes($data['attr']); ?>>
            <div class="ps-card-image">
                <?php Image::render($data['card_image']); ?>
            </div>
            <div class="ps-card-meta <?= $post_meta_spacing_classes ?>">
                <h2 class="ps-card-title ps-color-secondary-main"><?= $data['title'] ?></h2>
                <?php
                if (in_array($data['type'], array('product', 'post'))):
                    ?>
                    <div class="ps-card-description ps-color-other-black <?= $data['type'] === 'post' ? 'my-2' : 'mt-1 mb-3' ?>">
                        <?= $data['description']; ?>
                    </div>
                    <?php
                endif;
                ?>
                <?php
                if ($data['has_button']):
                    ?>
                    <span class="ps-card-action">
                        <?php
                        $button_attr = array_merge(
                            array(
                                'as' => 'button',
                                'title' => $data['type'] === 'post' ? 'Read more' : 'Explore',
                                'attr' => [
                                    'type' => 'button',
                                ]
                            ),
                            $data['button_attr']
                        );
                        Button::render($button_attr);
                        ?>
                    </span>
                    <?php
                endif;
                ?>
            </div>
        </<?= $html_tag ?>>

        <?php
    }

    public static function backend($args = [])
    {
        $default_breakpoints_attr = parent::get_default_breakpoints_attr();
        $placeholders = [
            // required
            'type' => 'post',
            'html_tag' => 'div',
            'title' => '',
            'description' => '',
            'card_image' => [
                'id' => null,
                'src' => ''
            ],
            'post_layout' => self::$post_layouts[0],
            'post_layout_breakpoints' => $default_breakpoints_attr,
            'button_attr' => [],
            'has_button' => true
        ];
        $args = wp_parse_args($args, $placeholders);
        if (!in_array($args['type'], self::$types)) {
            return parent::error('Missing card type ($args[\'type\'])');
        } elseif ($args['type'] === 'post' && !in_array($args['post_layout'], self::$post_layouts)) {
            return parent::error('Missing card post layout ($args[\'post_layout\'])');
        }
        if (!is_array($args['post_layout_breakpoints'])) {
            return parent::error('Wrong card post_layout_breakpoints format ($args[\'post_layout_breakpoints\']) should be an array');
        }
        foreach ($args['post_layout_breakpoints'] as $post_layout_breakpoint_key => $value) {
            if (!empty($value) && !in_array($post_layout_breakpoint_key, Config::get_grid_breakpoints_keys(), true)) {
                return parent::error(
                    'Wrong card post_layout_breakpoints format ($args[\'post_layout_breakpoints\']) should be an array with keys: ' . implode(
                        ', ',
                        Config::get_grid_breakpoints_keys()
                    )
                );
            } elseif (!empty($value) && !in_array($value, self::$post_layouts, true)) {
                return parent::error('Wrong card post_layout_breakpoints ($args[\'post_layout_breakpoints\'][\'' . $post_layout_breakpoint_key . '\'])');
            }
        }
        if (empty($args['card_image'] || (empty($args['card_image']['id']) && empty($args['card_image']['src'])))) {
            return parent::error('Missing card image id and src, id is primary and src is secondary ($args[\'card_image\'][\'id\'] or $args[\'card_image\'][\'src\'])');
        }
        if (empty($args['title'])) {
            return parent::error('Missing card title ($args[\'title\'])');
        }
        if (!in_array($args['html_tag'], self::$wrapper_html_tags, true)) {
            return parent::error('Wrong card wrapper html tag ($args[\'variant\'])');
        } elseif ($args['html_tag'] === 'a' && empty($args['attr']['href'])) {
            return parent::error('Missing href attribute for card with html_tag "a" ($args[\'attr\'][\'href\'])');
        }
        if (empty($args['description']) && in_array($args['type'], array('post', 'product'), true)) {
            return parent::error('Description attr is required while having a type of [post|product] ($args[\'description\'])');
        }


        if (!isset($args['attr']['class'])) {
            $args['attr']['class'] = [];
        }
        $args['attr']['class'][] = 'ps-card';
        $args['attr']['class'][] = 'ps-card-type-' . $args['type'];
        if ($args['type'] === 'post') {
            $args['attr']['class'][] = 'ps-card-post-layout-' . $args['post_layout'];
        }
        foreach ($args['post_layout_breakpoints'] as $breakpoint => $value) {
            if (!empty($value)) {
                $args['attr']['class'][] = 'ps-card-post-layout-' . $breakpoint . '-' . $value;
            }
        }

        return $args;
    }
}