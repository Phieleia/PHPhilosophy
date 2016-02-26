<?php

namespace Phphilosophy\Router;

use Phphilosophy\Http\Uri;
use Phphilosophy\Http\Request;

/**
 * Phphilosophy Uri parser
 *
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2015-2016 Lisa Saalfrank
 * @license	http://opensource.org/licenses/MIT MIT License
 * @since       0.1.0
 * @version     0.1.0
 * @package     Phphilosophy
 * @subpackage  Router
 */
class Parser {

    /**
     * @var     \Phphilosophy\Http\Request  The current request
     */
    private $request;
    
    /**
     * @param   \Phphilosophy\Http\Request  $request
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }
    
    /**
     * @param   mixed   $segment    A segment of the route pattern
     * @return  bool    True for param, else false
     */
    private function isParam($segment) {
        return strpos($segment, '{') !== false;
    }
    
    /**
     * @param   array   $uriSegments
     * @param   array   $patternSegments
     */
    private function getParams(array $uriSegments, array $patternSegments)
    {
        $params = [];
        
        // Determine the number of segments
        $segments = count($patternSegments);
        
        // Loop through the pattern segments and find the params
        for ($i = 0; $i < $segments; $i++)
        {   
            // Determines whether a segment is a param
            if ($this->isParam($patternSegments[$i])) {
                $params[] = $uriSegments[$i];
            }
        }
        return $params;
    }
    
    /**
     * @param   string  $pattern    The route pattern
     * @return  array   Route parameters
     */
    public function parse($pattern)
    {
        // The Segments of the HTTP URI
        $uriSegments = $this->request->uriSegments();
        
        // The segments of the route pattern
        $pattern = new Uri($pattern);
        $patternSegments = $pattern->getSegments();
        
        // Find the route parameters and return them
        return $this->getParams($uriSegments, $patternSegments);
    }
}