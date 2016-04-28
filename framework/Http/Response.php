<?php

namespace Phphilosophy\Http;

/**
 * Phphilosophy Response
 *
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2015-2016 Lisa Saalfrank
 * @license	http://opensource.org/licenses/MIT MIT License
 * @since       0.1.0
 * @version     0.1.0
 * @package     Phphilosophy
 * @subpackage  Http
 */
class Response {
    
    /**
     * @var string
     */
    private $content;
    
    /**
     * @param   mixed   $content
     */
    public function __construct($content) {
        $this->content = (string) $content;
    }
    
    /**
     * @return  string
     */
    public function getContent() {
        return $this->content;
    }
    
    /**
     * @param   mixed   $content
     *
     * @return  self
     */
    public function withContent($content)
    {
        $clone = clone $this;
        $clone->content = (string) $content;
        return $clone;
    }
    
    /**
     * @return  void
     */
    public function send() {
        echo $this->content;
    }
}