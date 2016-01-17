<?php

namespace Phphilosophy\Application;

/**
 * Phphilosophy configuration container
 *
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2015-2016 Lisa Saalfrank
 * @license	    http://opensource.org/licenses/MIT MIT License
 * @since       0.1.0
 * @version     0.1.0
 * @package     Phphilosophy
 * @subpackage  Application
 */
class Config {
    
    /**
     * @access  private
     * @var     array   Array with configuration values
     */
    private $config = [];
    
    /**
     * @access  protected
     * @var     \Phphilosophy\Application\Config    Instance of this class
     */
    protected static $instance;
    
    /**
     * @access  private
     */
    private function __construct() {}
    
    /**
     * Replacement for the now private constructor
     * @access  public
     * @return  \Phphilosophy\Application\Config    Self
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * @access  public
     * @param   string  $key    The configuration name
     * @param   mixed   $value  The configuration item
     * @return  void
     */
    public function set($key, $value) {
        $this->config[$key] = $value;
    }
    
    /**
     * @access  public
     * @param   string  $key    The configuration name
     * @return  mixed   The configuration value
     */
    public function get($key) {
        return $this->config[$key];
    }
}