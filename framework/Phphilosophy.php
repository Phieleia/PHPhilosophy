<?php

namespace Phphilosophy;

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
     * @var     \Phphilosophy\Router\Router
     */
    private $router;
    
    public function __construct()
    {
        $this->router = new Router();
    }
    
    /**
     * @param   string          $pattern
     * @param   mixed           $action
     * @return  void
     */
    public function get($pattern, $action) {
        $this->addRoute($pattern, $action, 'GET');
    }
    
    /**
     * @param   string          $pattern
     * @param   mixed           $action
     * @return  void
     */
    public function post($pattern, $action) {
        $this->addRoute($pattern, $action, 'POST');
    }
    
    /**
     * @param   string          $pattern
     * @param   mixed           $action
     * @return  void
     */
    public function put($pattern, $action) {
        $this->addRoute($pattern, $action, 'PUT');
    }
    
    /**
     * @param   string          $pattern
     * @param   mixed           $action
     * @return  void
     */
    public function patch($pattern, $action) {
        $this->addRoute($pattern, $action, 'PATCH');
    }
    
    /**
     * @param   string          $pattern
     * @param   mixed           $action
     * @return  void
     */
    public function delete($pattern, $action) {
        $this->addRoute($pattern, $action, 'DELETE');
    }
    
    /**
     * @param   string          $pattern
     * @param   mixed           $action
     * @return  void
     */
    public function any($pattern, $action)
    {
        $methods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];
        $this->addRoute($pattern, $action, $methods);
    }
    
    /**
     * @param   array           $methods
     * @param   string          $pattern
     * @param   mixed           $action
     * @return  void
     */
    public function add($methods, $pattern, $action) {
        $this->addRoute($pattern, $action, $methods);
    }
    
    /**
     * @param   string          $pattern    The route pattern
     * @param   mixed           $action     The route action
     * @param   array|string    $methods    The route method(s)
     * @retun   void
     */
    private function addRoute($pattern, $action, $methods)
    {
        $route = new Route($pattern, $action, $methods);
        $this->router->addRoute($route);
    }

    /**
     * @param   callable    $action     The fallback callable
     * @return  void
     */
    public function notFound($action) {
        $this->router->setNotFound($action);
    }
    
    /**
     * @return  void
     */
    public function run() {
        $this->router->dispatch();
    }
}