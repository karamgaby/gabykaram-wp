<?php
namespace X_UI\Core;
/**
 * Abstract Class Component
 *
 * Structure and required functionality for each component.
 * Every component should inherit this class.
 */
abstract class AbstractComponent {

    /**
     * Render component (echo HTML)
     *
     * @param array $args
     */
    public static function render($args = []) {

        $data = static::backend($args);

        // bail if errors on backend
        if ($data instanceof \WP_Error) {

            // display error
            if (defined('WP_DEBUG') && WP_DEBUG === true) {
//              @todo recheck it should be x_core_debug_msg or x_ui_debug_msg
                if (function_exists('\axio_core_debug_msg')) {
                    \axio_core_debug_msg($data->get_error_message(), ['backend', 'frontend', 'render', 'get']);
                } else {
                    trigger_error($data->get_error_message(), E_USER_WARNING);
                }

            }

            return;

        }

        static::frontend($data);

    }

    /**
     * Return component HTML
     *
     * @param array $args
     */
    public static function get($args = []) {

        ob_start();
        static::render($args);
        return ob_get_clean();

    }

    /**
     * Build html attributes from key-value array
     *
     * @param array $attr key-value array of attribute names and values
     *
     * @return string attributes for html element
     */
    public static function render_attributes($attr = array()) {

        $return = array();
        foreach ($attr as $key => $value) {

            if (is_array($value)) {
                $value = implode(' ', $value);
            }
            if($key === 'disabled') {
              $return[] = 'disabled';
            } else if (!empty($value) || is_numeric($value)) {
                $return[] = esc_attr($key) . '="' . esc_attr($value) . '"';
            } else {
                if ($key === 'alt') {
                    $return[] = esc_attr($key) . '=""';
                } else {
                    $return[] = esc_attr($key);
                }
            }
        }
        echo implode(' ', $return);

    }

    /**
     * Make error message
     *
     * @param string message
     */
    public static function error($message) {

        return new \WP_Error('error', $message);

    }

    protected static function get_default_breakpoints_attr(): array {
        $media_breakpoints = Config::get_grid_breakpoints_keys(  );
        $breakpoints_attr  = array();
        foreach ( $media_breakpoints as $breakpoint ) {
            $breakpoints_attr[ $breakpoint ] = '';
        }
        return $breakpoints_attr;
    }
}
