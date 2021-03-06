<?php

namespace Phphilosophy;

use Phphilosophy\Application\Config;

/**
 * View rendering class
 *
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2015-2016 Lisa Saalfrank
 * @license	http://opensource.org/licenses/MIT MIT License
 * @since       0.1.0
 * @version     0.1.0
 * @package     Phphilosophy
 */
class View {

    /**
     * @var string
     */
    private $views = '../application/views/';
    
    /**
     * @var string
     */
    private $fileExtension = '.php';
    
    /**
     * @var array
     */
    private $variables = [];
    
    /**
     * @param   string  $views
     */
    public function __construct($views = null)
    {
        if ($views !== null) {
            $this->views = $views;
        }
        $this->fileExtension = Config::get('view.extension', '.php');
    }
    
    /**
     * @param   string  $file
     *
     * @return  void
     */
    public function render($file)
    {
        $file = rtrim($file, $this->fileExtension).$this->fileExtension;
        if (file_exists($this->views.$file)) {
            include $this->views.$file;
        }
    }
    
    /**
     * @param   string  $name
     * @param   mixed	$value
     *
     * @return  void
     */
    public function __set($name, $value) {
        $this->variables[$name] = $value;
    }
    
    /**
     * @param   string  $name
     * @return  mixed
     */
    public function __get($name) {
        return $this->variables[$name];
    }
}