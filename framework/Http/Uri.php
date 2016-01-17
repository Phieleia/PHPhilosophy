<?php

namespace Phphilosophy\Http;

/**
 * Phphilosophy Uri
 *
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2015-2016 Lisa Saalfrank
 * @since       1.0.0
 * @version     1.0.0
 * @package     Phphilosophy
 * @subpackage  Http
 */
class Uri {
    
    /**
     * @access  private
     * @var     string  The URI or the pattern
     */
    private $uri;
    
    /**
     * @access  private
     * @var     array   Array of URI or pattern segments
     */
    private $segments = [];
    
    /**
     * @access  public
     * @param   string  $uri    The URI or pattern
     */
    public function __construct($uri) {
        $this->setUri($uri);
        $this->findSegments();
    }
    
    /**
     * @access  public
     * @param   string  $uri    The URI or pattern
     */
    public function setUri($uri) {
        $this->uri = $uri;
    }
    
    /**
     * @access  public
     * @return  The URI or pattern of this instance
     */
    public function getUri() {
        return $this->uri;
    }
    
    /**
     * Splits the URI after each / and puts the segments into an array
     * @access  public
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
     * @access  public
     * @return  array   Array of URI or pattern segments
     */
    public function getSegments() {
        return $this->segments;
    }
    
    /**
     * Retrieves a single URI segment by key
     * @access  public
     * @param   int     $key    The key of the uri segment
     * @return  string  A single uri segment
     */
    public function getSegment($key) {
        return $this->segments[$key];
    }
}
