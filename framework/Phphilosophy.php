<?php

namespace Phphilosophy;

use Phphilosophy\Http\Request;
use Phphilosophy\Http\Response;

use Phphilosophy\Router\Route;
use Phphilosophy\Router\Router;

/**
 * Phphilosophy Micro PHP Framework for PHP 7.0
 *
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2015-2017 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @version     0.1.0
 * @package     Phphilosophy
 */
class Phphilosophy {
    
    /**
     * @const   string
     */
    const VERSION = '0.1.0';
    
    /**
     * @var \Phphilosophy\Router\Router
     */
    private static $router;
    
    /**
     * @var array|null
     */
    private static $guard = null;
    
    /**
     * @var string|null
     */
    private static $redirect = null;
    
    public static function register(Request $request)
    {
        self::$router = new Router($request);
        ob_start();
    }
    
    /**
     * @param   string          $pattern
     * @param   mixed           $action
     *
     * @return  void
     */
    public static function get(string $pattern, $action) {
        self::addRoute($pattern, $action, 'GET');
    }
    
    /**
     * @param   string          $pattern
     * @param   mixed           $action
     *
     * @return  void
     */
    public static function post(string $pattern, $action) {
        self::addRoute($pattern, $action, 'POST');
    }
    
    /**
     * @param   string          $pattern
     * @param   mixed           $action
     *
     * @return  void
     */
    public static function put(string $pattern, $action) {
        self::addRoute($pattern, $action, 'PUT');
    }
    
    /**
     * @param   string          $pattern
     * @param   mixed           $action
     *
     * @return  void
     */
    public static function patch(string $pattern, $action) {
        self::addRoute($pattern, $action, 'PATCH');
    }
    
    /**
     * @param   string          $pattern
     * @param   mixed           $action
     *
     * @return  void
     */
    public static function delete(string $pattern, $action) {
        self::addRoute($pattern, $action, 'DELETE');
    }
    
    /**
     * @param   string          $pattern
     * @param   mixed           $action
     *
     * @return  void
     */
    public static function head(string $pattern, $action) {
        self::addRoute($pattern, $action, 'HEAD');
    }
    
    /**
     * @param   string          $pattern
     * @param   mixed           $action
     *
     * @return  void
     */
    public static function options(string $pattern, $action) {
        self::addRoute($pattern, $action, 'OPTIONS');
    }
    
    /**
     * @param   string          $pattern
     * @param   mixed           $action
     *
     * @return  void
     */
    public static function any(string $pattern, $action)
    {
        $methods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'];
        self::addRoute($pattern, $action, $methods);
    }
    
    /**
     * @param   array           $methods
     * @param   string          $pattern
     * @param   mixed           $action
     *
     * @return  void
     */
    public static function add(array $methods, string $pattern, $action) {
        self::addRoute($pattern, $action, $methods);
    }
    
    /**
     * @param   string      $pattern
     * @param   callable    $routes
     *
     * @return  void
     */
    public static function group(string $pattern, callable $routes)
    {
        // Add the group prefix to the settings
        self::$group = $pattern;
        
        // Add the routes to the router
        call_user_func($routes);
        
        // Reset the settings and remove the group prefix
        self::$group = '';
    }
    
    /**
     * @param   array       $guard
     * @param   callable    $routes
     * @param   string      $redirect
     *
     * @return  void
     */
    public static function guard(array $guard, callable $routes, string $redirect)
    {
        // Add a guard to the settings
        self::$guard = $guard;
        self::$redirect = $redirect;
        
        // Add the routes to the router
        call_user_func($routes);
        
        // Reset the settings and remove the guards
        self::$guard = null;
        self::$redirect = null;
    }
    
    /**
     * @param   string          $pattern    The route pattern
     * @param   mixed           $action     The route action
     * @param   array|string    $methods    The route method(s)
     *
     * @retun   void
     */
    private static function addRoute(string $pattern, $action, $methods)
    {
        // Create new route entity
        $route = new Route($pattern, $action, $methods);
        
        // If a guard is present, add it to the route object
        if (!is_null(self::$guard) && !is_null(self::$redirect)) {
            $route->setGuard(self::$guard, self::$redirect);
        }
        
        // Add route entity to the internal route collection
        self::$router->addRoute($route);
    }

    /**
     * @param   callable    $action     The fallback callable
     *
     * @return  void
     */
    public static function notFound(callable $action) {
        self::$router->setNotFound($action);
    }
    
    /**
     * @return  void
     */
    private static function respond()
    {
        $content = ob_get_clean();
        $response = new Response($content);
        $response->send();
    }
    
    /**
     * @return  void
     */
    public static function run()
    {
        self::$router->dispatch();
        self::respond();
    }
}
