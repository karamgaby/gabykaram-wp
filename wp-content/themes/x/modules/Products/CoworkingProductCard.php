<?php

namespace X_Modules\Products;

use X_UI\Core\AbstractComponent;

class CowokingProductCard extends AbstractComponent
{

    protected static $card_styles = ['business', 'outdoor'];
    private static TemplateLoader $templateLoader;

    protected static function get_data_placeholders(): array
    {
        return [
            'image_id' => '',
            'title' => '',
            'content' => '',
            'price' => '',
            'card_style' => 'business',
            // optional
            'attr' => array(),
        ];
    }

    public static function frontend($data = [])
    {
        self::$templateLoader = !empty(self::$templateLoader) ? self::$templateLoader : new TemplateLoader();
        self::$templateLoader->set_template_data($data)->get_template_part('coworking-card');
    }

    public static function backend($args = []): \WP_Error|array
    {
        $validation = self::validateArgs($args);
        if (is_wp_error($validation)) {
            return $validation;
        }
        $args = self::manipulateAttrClass($args);

        return $args;
    }
    private static function validateArgs($args = []): \WP_Error|array
    {
        if (empty($args['image_id'])) {
            return new \WP_Error('missing_image_id', 'Missing Product Cowoking Card image_id ($args[\'image_id\'])');
        }
        if (empty($args['title'])) {
            return new \WP_Error('missing_title', 'Missing Product Cowoking Card title ($args[\'title\'])');
        }
        if (empty($args['price'])) {
            return new \WP_Error('missing_price', 'Missing Product Cowoking Card price ($args[\'price\'])');
        }
        if (empty($args['content'])) {
            return new \WP_Error('missing_content', 'Missing Product Cowoking Card content ($args[\'price\'])');
        }
        if (empty($args['card_style'])) {
            return new \WP_Error('missing_card_style', 'Missing Product Cowoking Card style ($args[\'card_style\'])');
        }
       
       
        return $args;
    }

    private static function manipulateAttrClass($args)
    {
        if (!isset($args['attr']['class'])) {
            $args['attr']['class'] = [];
        } elseif (is_string($args['attr']['class'])) {
            $args['attr']['class'] = array($args['attr']['class']);
        }

        return $args;
    }
}