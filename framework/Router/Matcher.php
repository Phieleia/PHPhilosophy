<?php

namespace Phphilosophy\Router;

use Phphilosophy\Http\Request;

/**
 * Phphilosophy Request Matcher
 *
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2015-2016 Lisa Saalfrank
 * @license	http://opensource.org/licenses/MIT MIT License
 * @since       0.1.0
 * @version     0.1.0
 * @package     Phphilosophy
 * @subpackage  Router
 */
class Matcher {
    
    /**
     * @var     \Phphilosophy\Http\Request  The current request
     */
    private $request;
    
    /**
     * @var     array   An array with regex shortcuts
     */
    private $tokens = [
        ':alpha' => '[A-Za-z]+',
        ':id' => '[0-9]+',
        ':int' => '[\-]?[0-9]+',
        ':alphanum' => '[A-Za-z0-9]+',
        ':string' => '[A-Za-z0-9\-_]+',
        '' => '[A-Za-z0-9]+'
    ];
    
    /**
     * @param   \Phphilosophy\Http\Request  $request
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }
    
    /**
     * @param   string  $token      The parameter type
     * @param   string  $pattern    The route pattern
     * @return  string  The route regex
     */
    private function translate($token, $pattern)
    {
        // Searches the route pattern for placeholders like {id:num}
        $search = '#[\{][a-z0-9]+'.$token.'[\}]#';
        
        // The regular expression to be exchanged with the token name
        $replacement = $this->tokens[$token];
        
        // Turns the route param into a regular expression
        $result = preg_replace($search, $replacement, $pattern);
        
        return $result;
    }
    
    /**
     * @param   \Phphilosophy\Router\Route  $route  A route instance
     * @return  string  The pattern as a regex
     */
    private function parse(Route $route)
    {
        // The parameter token namespace
        $tokens = array_keys($this->tokens);
        
        // The route pattern
        $pattern = $route->getPattern();
        
        // Search for all kinds of parameters and translate them
        foreach ($tokens as $token) {
            $pattern = $this->translate($token, $pattern);
        }
        
        // The parsed regular expression ready for matching
        return '#^'.$pattern.'$#D';
    }
    
    /**
     * @param   \Phphilosophy\Router\Route  $route  A route instance
     * @return  boolean     Was there any match?
     */
    public function match(Route $route)
    {
        // The pattern translated into a regex
        $regex = $this->parse($route);
        
        // The route methods
        $methods = $route->getMethods();
        
        // The current uri
        $uri = '/'.trim($this->request->getRequestTarget(), '/');
        
        // The current http method
        $method = $this->request->getMethod();
        
        return preg_match($regex, $uri) && in_array($method, $methods);
    }
}