<?php

namespace Phphilosophy;

use Phphilosophy\Router\Route;
use Phphilosophy\Router\Router;

/**
 * Phphilosophy Micro PHP Framework for PHP 5.5
 *
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2015-2016 Lisa Saalfrank
 * @license	    http://opensource.org/licenses/MIT MIT License
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
     * @access  private
     * @var     \Phphilosophy\Router\Router
     */
    private $router;
    
    /**
     * @access  public
     */
    public function __construct()
    {
        $this->router = new Router();
    }
    
    /**
     * @access  public
     * @param   string          $pattern
     * @param   mixed           $action
     * @return  void
     */
    public function get($pattern, $action) {
        $this->addRoute($pattern, $action, 'GET');
    }
    
    /**
     * @access  public
     * @param   string          $pattern
     * @param   mixed           $action
     * @return  void
     */
    public function post($pattern, $action) {
        $this->addRoute($pattern, $action, 'POST');
    }
    
    /**
     * @access  public
     * @param   string          $pattern
     * @param   mixed           $action
     * @return  void
     */
    public function put($pattern, $action) {
        $this->addRoute($pattern, $action, 'PUT');
    }
    
    /**
     * @access  public
     * @param   string          $pattern
     * @param   mixed           $action
     * @return  void
     */
    public function patch($pattern, $action) {
        $this->addRoute($pattern, $action, 'PATCH');
    }
    
    /**
     * @access  public
     * @param   string          $pattern
     * @param   mixed           $action
     * @return  void
     */
    public function delete($pattern, $action) {
        $this->addRoute($pattern, $action, 'DELETE');
    }
    
    /**
     * @access  public
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
     * @access  public
     * @param   array           $methods
     * @param   string          $pattern
     * @param   mixed           $action
     * @return  void
     */
    public function add($methods, $pattern, $action) {
        $this->addRoute($pattern, $action, $methods);
    }
    
    /**
     * @access  private
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
     * @access  public
     * @param   callable    $action     The fallback callable
     * @return  void
     */
    public function notFound($action) {
        $this->router->setNotFound($action);
    }
    
    /**
     * @access  public
     * @return  void
     */
    public function run() {
        $this->router->dispatch();
    }
}