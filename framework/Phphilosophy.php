<?php

namespace Phphilosophy;

use Phphilosophy\Http\Request;
use Phphilosophy\Http\Response;

use Phphilosophy\Router\Route;
use Phphilosophy\Router\Router;

/**
 * Phphilosophy Micro PHP Framework for PHP 5.5
 *
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2015-2016 Lisa Saalfrank
 * @license	http://opensource.org/licenses/MIT MIT License
 * @since       0.1.0
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
    private $router;
    
    /**
     * @var array
     */
    private $guard;
    
    public function __construct(Request $request)
    {
        $this->router = new Router($request);
        ob_start();
    }
    
    /**
     * @param   string          $pattern
     * @param   mixed           $action
     *
     * @return  void
     */
    public function get($pattern, $action) {
        $this->addRoute($pattern, $action, 'GET');
    }
    
    /**
     * @param   string          $pattern
     * @param   mixed           $action
     *
     * @return  void
     */
    public function post($pattern, $action) {
        $this->addRoute($pattern, $action, 'POST');
    }
    
    /**
     * @param   string          $pattern
     * @param   mixed           $action
     *
     * @return  void
     */
    public function put($pattern, $action) {
        $this->addRoute($pattern, $action, 'PUT');
    }
    
    /**
     * @param   string          $pattern
     * @param   mixed           $action
     *
     * @return  void
     */
    public function patch($pattern, $action) {
        $this->addRoute($pattern, $action, 'PATCH');
    }
    
    /**
     * @param   string          $pattern
     * @param   mixed           $action
     *
     * @return  void
     */
    public function delete($pattern, $action) {
        $this->addRoute($pattern, $action, 'DELETE');
    }
    
    /**
     * @param   string          $pattern
     * @param   mixed           $action
     *
     * @return  void
     */
    public function head($pattern, $action) {
        $this->addRoute($pattern, $action, 'HEAD');
    }
    
    /**
     * @param   string          $pattern
     * @param   mixed           $action
     *
     * @return  void
     */
    public function options($pattern, $action) {
        $this->addRoute($pattern, $action, 'OPTIONS');
    }
    
    /**
     * @param   string          $pattern
     * @param   mixed           $action
     *
     * @return  void
     */
    public function any($pattern, $action)
    {
        $methods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'];
        $this->addRoute($pattern, $action, $methods);
    }
    
    /**
     * @param   array           $methods
     * @param   string          $pattern
     * @param   mixed           $action
     *
     * @return  void
     */
    public function add($methods, $pattern, $action) {
        $this->addRoute($pattern, $action, $methods);
    }
    
    /**
     * @param   array       $guard
     * @param   callable    $routes
     * @param   string      $redirect
     *
     * @return  void
     */
    public function guard(array $guard, callable $routes, $redirect)
    {
        // Add a guard to the settings
        $this->guard = $guard;
        $this->redirect = $redirect;
        
        // Add the routes to the router
        call_user_func($routes);
        
        // Reset the settings and remove the guards
        $this->guard = null;
        $this->redirect = null;
    }
    
    /**
     * @param   string          $pattern    The route pattern
     * @param   mixed           $action     The route action
     * @param   array|string    $methods    The route method(s)
     *
     * @retun   void
     */
    private function addRoute($pattern, $action, $methods)
    {
        // Create new route entity
        $route = new Route($pattern, $action, $methods);
        
        // If a guard is present, add it to the route object
        if (!is_null($this->guard) && !is_null($this->redirect)) {
            $route->setGuard($this->guard, $this->redirect);
        }
        
        // Add route entity to the internal route collection
        $this->router->addRoute($route);
    }

    /**
     * @param   callable    $action     The fallback callable
     *
     * @return  void
     */
    public function notFound($action) {
        $this->router->setNotFound($action);
    }
    
    /**
     * @return  void
     */
    private function respond()
    {
        $content = ob_get_clean();
        $response = new Response($content);
        $response->send();
    }
    
    /**
     * @return  void
     */
    public function run()
    {
        $this->router->dispatch();
        $this->respond();
    }
}