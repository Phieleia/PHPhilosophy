<?php

namespace Phphilosophy\Http;

/**
 * Phphilosophy Uri
 *
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2015-2016 Lisa Saalfrank
 * @license     http://opensource.org/licenses/MIT MIT License
 * @since       0.1.0
 * @version     0.1.0
 * @package     Phphilosophy
 * @subpackage  Http
 */
class Uri {
    
    /**
     * @var     string  The URI or the pattern
     */
    private $uri;
    
    /**
     * @var     array   Array of URI or pattern segments
     */
    private $segments = [];
    
    /**
     * @param   string  $uri    The URI or pattern
     */
    public function __construct($uri) {
        $this->setUri($uri);
        $this->findSegments();
    }
    
    /**
     * @param   string  $uri    The URI or pattern
     */
    public function setUri($uri) {
        $this->uri = $uri;
    }
    
    /**
     * @return  The URI or pattern of this instance
     */
    public function getUri() {
        return $this->uri;
    }
    
    /**
     * Splits the URI after each / and puts the segments into an array
     * @return  void
     */
    public function findSegments()
    {
        // Normalize the uri and pattern
        $uri = trim($this->uri, '/');
        
        // Split it into its segments
        $segments = explode('/', $uri);
        
        $this->segments = $segments;
    }
    
    /**
     * @return  array   Array of URI or pattern segments
     */
    public function getSegments() {
        return $this->segments;
    }
    
    /**
     * Retrieves a single URI segment by key
     * @param   int     $key    The key of the uri segment
     * @return  string  A single uri segment
     */
    public function getSegment($key) {
        return $this->segments[$key];
    }
}
