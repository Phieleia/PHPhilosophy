<?php

namespace Phphilosophy\Router;

use Phphilosophy\Http\Request;

/**
 * Phphilosophy Router for HTTP routing
 *
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2015-2016 Lisa Saalfrank
 * @license	http://opensource.org/licenses/MIT MIT License
 * @since       0.1.0
 * @version     0.1.0
 * @package     Phphilosophy
 * @subpackage  Router
 */
class Router {
    
    /**
     * @var     array   Collection of Route instances
     */
    private $routes = [];
    
    /**
     * @var     callable    An anonymous function
     */
    private $notFound;
    
    /**
     * @var     \Phphilosophy\Router\Parser
     */
    private $parser;
    
    /**
     * @var     \Phphilosophy\Router\Matcher
     */
    private $matcher;
    
    /**
     * @var     boolean     Was there any match?
     */
    private $match = false;

    public function __construct(Request $request)
    {
        $this->parser = new Parser($request);
        $this->matcher = new Matcher($request);
    }
    
    /**
     * @param   \Phphilosophy\Router\Route  A route instance
     */
    public function addRoute(Route $route) {
        $this->routes[] = $route;
    }
    
    /**
     * @param   array|callable  $action An anonymous function
     */
    public function setNotFound($action) {
        $this->notFound = $action;
    }
    
    /**
     * @param   callable    $guard
     * @param   string      $redirect
     *
     * @return  void
     */
    private function protect($guard, $redirect)
    {
        // Check if the guard went off
        $valid = call_user_func($guard);
        
        // if it did, redirect to the specified location
        if ($valid === false) {
            header('Location: '. $redirect);
            exit;
        }
    }
    
    /**
     * @param   \Equidea\Router\Route   $route
     *
     * @return  boolean
     */
    private function guard(Route $route)
    {
        if ($route->hasGuard()) {
            $this->protect($route->getGuard(), $route->getRedirect());
        }
        return true;
    }

    /**
     * @param   \Phphilosophy\Router\Route  $route  A route instance
     *
     * @return  void
     */
    private function match(Route $route)
    { 
        // The pattern given by the user
        $pattern = $route->getPattern();
        
        // Run the callable
        if ($this->matcher->match($route) && $this->guard($route)) {
            $params = $this->parser->parse($pattern);
            $this->match = true;
            call_user_func_array($route->getAction(), $params);
        }
    }
    
    /**
     * @return  void
     */
    public function dispatch()
    {
        // Searches the routes array for any matches
        foreach ($this->routes as $route) {
            $this->match($route);
        }
        
        if ($this->match === false) {
            call_user_func($this->notFound);
        }
    }
}