<?php

namespace Phphilosophy\Application;

/**
 * Phphilosophy Configuration container
 *
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2015-2016 Lisa Saalfrank
 * @license	http://opensource.org/licenses/MIT MIT License
 * @since       0.1.0
 * @version     0.1.0
 * @package     Phphilosophy
 */
class Config {
    
    /**
     * @var array
     */
    private static $values = [];
    
    /**
     * @param   string  $key
     * @param   mixed   $value
     *
     * @return  void
     */
    public static function set($key, $value) {
        self::$values[$key] = $value;
    }
    
    /**
     * @param   string  $key
     * @param   mixed   $default
     *
     * @return  mixed
     */
    public static function get($key, $default = null)
    {
        if (self::has($key)) {
            return self::$values[$key];
        }
        
        if (!is_null($default)) {
            return $default;
        }
    }
    
    /**
     * @param   string  $key
     *
     * @return  boolean
     */
    public static function has($key) {
        return array_key_exists($key, self::$values);
    }
}