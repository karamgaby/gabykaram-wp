<?php

namespace X_Modules\Products;

use X_UI\Core\AbstractComponent;

class RoomProductCard extends AbstractComponent
{

    private static TemplateLoader $templateLoader;

    protected static function get_data_placeholders(): array
    {
        return [
            'image_id' => '',
            'title' => '',
            'room_category' => '',
            'services' => [],
            'fit_for' => 0,
            'bed_type' => '',
            'bath_type' => '',
            // optional
            'attr' => array(),
        ];
    }

    public static function frontend($data = [])
    {
        self::$templateLoader = !empty(self::$templateLoader) ? self::$templateLoader : new TemplateLoader();
        self::$templateLoader->set_template_data($data)->get_template_part('room-card');
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
            return new \WP_Error('missing_image_id', 'Missing Product Room Card image_id ($args[\'image_id\'])');
        }
        if (empty($args['title'])) {
            return new \WP_Error('missing_title', 'Missing Product Room Card title ($args[\'title\'])');
        }
        if (empty($args['room_category'])) {
            return new \WP_Error('missing_room_category', 'Missing Product Room Card room_category ($args[\'room_category\'])');
        }
        if (empty($args['services'])) {
            return new \WP_Error('missing_services', 'Missing Product Room Card services ($args[\'services\'])');
        }
        if (empty($args['fit_for'])) {
            return new \WP_Error('missing_fit_for', 'Missing Product Room Card fit_for ($args[\'fit_for\'])');
        }
        if (empty($args['bed_type'])) {
            return new \WP_Error('missing_bed_type', 'Missing Product Room Card bed_type ($args[\'bed_type\'])');
        }
        if (empty($args['bath_type'])) {
            return new \WP_Error('missing_bath_type', 'Missing Product Room Card bath_type ($args[\'bath_type\'])');
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