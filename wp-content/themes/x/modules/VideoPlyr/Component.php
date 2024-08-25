<?php

namespace X_Modules\VideoPlyr;

use X_UI\Modules\Image\Component as Image;
use \X_UI\Core\AbstractComponent;

/**
 * Component: Footer
 *
 * @example
 * X_Footer::render();
 *
 * @package axio
 */
class Component extends AbstractComponent
{


    protected static function get_data_placeholders(): array
    {
        return [
            'video_src' => null,
            'cover_image' => null,
        ];
    }

    public static function frontend($data)
    {
        $video_component_id = uniqid('x-video-plyr', false) . random_int(1, 100);
        $video_cover_image = $data['cover_image'];
        $video_id = self::get_youtube_id($data['video_src']);
        ?>
        <div data-fancybox="x-video-plyr"
            aria-label="<?= __('Watch video', 'x') ?>" tabindex="0" data-type="inline"
            data-src="#<?= $video_component_id ?>_fancybox" data-groupAll="false"
            class="x-video-plyr m-auto p-0 x-background-transparent border-0">
            <div class="video-overlay">
                <?php
                $cover_image_args = [
                    'attr' => [
                        'class' => 'video-overlay-cover w-100 b-lazy',
                    ],
                ];
                if (!empty($video_cover_image['id'])) {
                    $cover_image_args['id'] = $video_cover_image['id'];
                }
                if (!empty($video_cover_image['src'])) {
                    $cover_image_args['src'] = $video_cover_image['src'];
                }
                Image::render($cover_image_args);
                ?>
            </div>
        </div>
        <div style="display: none;" class="fancybox__content" id="<?= $video_component_id ?>_fancybox">
            <div class="container">
                <div class="plyr__video-embed" id="<?= $video_component_id ?>_player" data-plyr-provider="youtube"
                    data-plyr-embed-id="<?= $video_id ?>"></div>
            </div>
        </div>
        <!-- <footer <?php parent::render_attributes($data['attr']); ?>>
    
    </footer> -->
        <?php
    }

    public static function backend($args = [])
    {

        $args = self::manipulateAttrClass($args);
        if (empty($args['video_src'])) {
            return parent::error('Missing youtube video src ($args[\'video_src\'])');
        }
        if (empty($args['cover_image'] || (empty($args['cover_image']['id']) && empty($args['cover_image']['src'])))) {
            return parent::error('Missing cover image id and src, id is primary and src is secondary ($args[\'cover_image\'][\'id\'] or $args[\'cover_image\'][\'src\'])');
        }
        if (empty($args['cover_image']['id']) && (empty($args['cover_image']['width']) || empty($args['cover_image']['height']))) {
            return parent::error('Missing cover image width and height ($args[\'cover_image\'][\'width\'] or $args[\'cover_image\'][\'height\'])');
        }
        return $args;

    }


    public static function get_youtube_id($url)
    {
        $regex = '/(?:youtube(?:-nocookie)?\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/|youtube\.com\/shorts\/)([a-zA-Z0-9_-]{11})/';
        preg_match($regex, $url, $matches);
        return isset($matches[1]) ? $matches[1] : null;
    }

    private static function manipulateAttrClass($args)
    {
        if (!isset($args['attr']['class'])) {
            $args['attr']['class'] = [];
        } elseif (is_string($args['attr']['class'])) {
            $args['attr']['class'] = array($args['attr']['class']);
        }

        // use prefixed class to avoid styling clashes
        $args['attr']['class'][] = 'x-video-plyr';

        return $args;
    }
}
