<?php
class UserAgentFactoryPSec {
    public static function analyze( $string, $image_size = null, $image_path = null, $image_extension = null ) {
        $class = new UserAgentPSec();

        if ( $image_size !== null ) {
            $class->image_size = $image_size;
        }
        if ( $image_path !== null ) {
            $class->image_path = $image_path;
        }
        if ( $image_extension !== null ) {
            $class->image_extension = $image_extension;
        }
        $class->analyze( $string );

        return $class;
    }
}

class UserAgentPSec {
    private $_image_path      = '';
    private $_image_size      = 16;
    private $_image_extension = '.png';

    private $_data = [];

    public function __get( $param ) {
        $private_param = '_' . $param;

        switch ( $param ) {
            case 'image_path':
                return $this->_image_path . $this->_image_size . '/';
                break;
            default:
                if ( property_exists( $this, $private_param ) ) {
                    return $this->$private_param;
                } elseif ( array_key_exists( $param, $this->_data ) ) {
                    return $this->_data[ $param ];
                }
                break;
        }

        return null;
    }

    public function __set( $name, $value ) {
        $true_name = '_' . $name;
        if ( property_exists( $this, $true_name ) ) {
            $this->$true_name = $value;
        }
    }

    public function __construct() {
        $this->_image_path = 'img/';
    }

    private function _make_image( $dir, $code ) {
        return $this->image_path . $dir . '/' . $code . $this->_image_extension;
    }

    private function _make_platform() {
        $this->_data['platform'] = &$this->_data['device'];
        if ( ! empty( $this->_data['device']['title'] ) ) {
            $this->_data['platform'] = &$this->_data['device'];
        } elseif ( ! empty( $this->_data['os']['title'] ) ) {
            $this->_data['platform'] = &$this->_data['os'];
        } else {
            $this->_data['platform'] = [
                'link'  => '#',
                'title' => 'Unknown',
                'code'  => 'null',
                'dir'   => 'browser',
                'type'  => 'os',
                'image' => $this->_make_image( 'browser', 'null' ),
            ];
        }
    }

    public static function autoload( $class_name ) {
        $file_path = dirname( __FILE__ ) . '/' . $class_name . '.php';
        if ( is_file( $file_path ) ) {
            require_once $file_path;
        }
    }

    public function analyze( $string ) {
        $this->_data['useragent'] = $string;
        $class_list               = [ 'os', 'browser' ];
        foreach ( $class_list as $value ) {
            $class                          = 'useragent_detect_' . $value;
            $this->_data[ $value ]          = call_user_func( [ $class, 'analyze' ], $string );
            $this->_data[ $value ]['image'] = $this->_make_image( $value, $this->_data[ $value ]['code'] );
        }

        // Platform
        $this->_make_platform();
    }
}

spl_autoload_register( [ 'UserAgentPSec', 'autoload' ] );
