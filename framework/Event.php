<?php

namespace Phphilosophy;

/**
 * Phphilosophy Event System
 *
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2015-2016 Lisa Saalfrank
 * @license	http://opensource.org/licenses/MIT MIT License
 * @since       0.1.0
 * @version     0.1.0
 * @package     Phphilosophy
 */
class Event {

    /**
     * @var array
     */
    public static $events = [];
    
    /**
     * @param   string      $name
     * @param   callable    $callback
     *
     * @return  void
     */
    public static function listen($name, $callback) {
        static::$events[$name] = $callback;
    }
    
    /**
     * @param   string      $name
     * @param   array       $params
     */
    public static function dispatch($name, array $params = [])
    {
        $callback = static::$events[$name];
        return call_user_func_array($callback, $params);
    }
}