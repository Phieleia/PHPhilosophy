<?php

namespace Phphilosophy\Http;

/**
 * Phphilosophy Micro PHP Framework for PHP 7.0
 *
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2015-2017 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @version     0.1.0
 * @package     Phphilosophy
 */
class Request {
    
    /**
     * @var string
     */
    private $method;
    
    /**
     * @var string
     */
    private $uri;
    
    /**
     * @var array
     */
    private $input = [];
    
    /**
     * @return  self
     */
    public static function createFromGlobals()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        return new static($method, $uri, $_GET, $_POST);
    }
    
    /**
     * @param   string  $method
     * @param   string  $uri
     * @param   array   $get
     * @param   array   $post
     */
    public function __construct(string $method, string $uri, array $get, array $post)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->input['get'] = $get;
        $this->input['post'] = $post;
    }
    
    /**
     * Retrieves the HTTP method of the request.
     * @return  string  Returns the request method.
     */
    public function getMethod() {
        return $this->method;
    }
    
    /**
     * Returns the request URI as a string
     * @return  string  The request uri
     */
    public function getRequestTarget() {
        return $this->uri;
    }
    
    /**
     * Returns the segments of the request URI
     * @return  array   The array with URI segments
     */
    public function uriSegments()
    {
        $uri = new Uri($this->uri);
        return $uri->getSegments();
    }
    
    /**
     * @param   string  $method
     * @param   string  $name
     * @param   mixed   $default
     *
     * @return  mixed
     */
    private function input(
        string $method = 'get',
        string $name = null,
        $default = null
    ) {
        // Checks, whether a specific value was requested
        if (isset($name))
        {
            // Does the requested value exist?
            if (isset($this->input[$method][$name]))
            {
                // Positive: return the value
                return $this->input[$method][$name];
            }
            // Negative: the default value
            return $default;
        }
        // return the entire array
        return $this->input[$method];
    }
    
    /**
     * @param   string|null $key        get key
     * @param   mixed|null  $default    default value
     * @return  mixed|array
     */
    public function get($key = null, $default = null) {
        return $this->input($key, $default);
    }
    
    /**
     * @param   string|null $key        get key
     * @param   mixed|null  $default    default value
     * @return  mixed|array
     */
    public function post($key = null, $default = null) {
        return $this->input($key, $default, 'post');
    }
}
