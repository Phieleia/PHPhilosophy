<?php

namespace Phphilosophy\Router;

/**
 * Phphilosophy Router for HTTP routing
 *
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2015-2016 Lisa Saalfrank
 * @license	    http://opensource.org/licenses/MIT MIT License
 * @since       0.1.0
 * @version     0.1.0
 * @package     Phphilosophy
 * @subpackage  Router
 */
class Router {
    
    /**
     * @access  private
     * @var     array   Collection of Route instances
     */
    private $routes = [];
    
    /**
     * @access  private
     * @var     callable    An anonymous function
     */
    private $notFound;
    
    /**
     * @access  private
     * @var     \Phphilosophy\Router\Parser
     */
    private $parser;
    
    /**
     * @access  private
     * @var     \Phphilosophy\Router\Matcher
     */
    private $matcher;
    
    /**
     * @access  private
     * @var     boolean     Was there any match?
     */
    private $match = false;

    /**
     * @access  public
     */
    public function __construct() {
        $this->parser = new Parser();
        $this->matcher = new Matcher();
    }
    
    /**
     * @access  public
     * @param   \Phphilosophy\Router\Route  A route instance
     */
    public function addRoute(Route $route) {
        $this->routes[] = $route;
    }
    
    /**
     * @access  public
     * @param   callable    $action     An anonymous function
     */
    public function setNotFound($action) {
        $this->notFound = $action;
    }

    /**
     * @access  private
     * @param   \Phphilosophy\Router\Route  $route  A route instance
     * @return  void
     */
    private function match(Route $route) {
            
        // The pattern given by the user
        $pattern = $route->getPattern();
        
        // Run the callable
        if ($this->matcher->match($route)) {
            $params = $this->parser->parse($pattern);
            $this->match = true;
            call_user_func_array($route->getAction(), $params);
        }
    }
    
    /**
     * @access  public
     * @return  void
     */
    public function dispatch() {
        
        // Searches the routes array for any matches
        foreach ($this->routes as $route) {
            $this->match($route);
        }
        
        if ($this->match === false) {
            call_user_func($this->notFound);
        }
    }
}