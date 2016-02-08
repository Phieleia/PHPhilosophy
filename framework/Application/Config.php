<?php

namespace Phphilosophy\Application;

/**
 * Phphilosophy configuration container
 *
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2015-2016 Lisa Saalfrank
 * @license	    http://opensource.org/licenses/MIT MIT License
 * @since       0.1.0
 * @version     0.1.0
 * @package     Phphilosophy
 * @subpackage  Application
 */
class Config {
    
    /**
     * @var     array   Array with configuration values
     */
    private static $config = [];
    
    /**
     * @param   string  $key    The configuration name
     * @param   mixed   $value  The configuration item
     * @return  void
     */
    public static function set($key, $value) {
        self::$config[$key] = $value;
    }
    
    /**
     * @param   string  $key    The configuration name
     * @return  mixed   The configuration value
     */
    public static function get($key) {
        self::$config[$key];
    }
}