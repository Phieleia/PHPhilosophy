<?php

namespace Phphilosophy\Validation;

/**
 * Phphilosophy Input Validation
 *
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2015-2016 Lisa Saalfrank
 * @license	http://opensource.org/licenses/MIT MIT License
 * @since       0.1.0
 * @version     0.1.0
 * @package     Phphilosophy
 */
class Errors {
    
    /**
     * @var array
     */
    $errors = [];
    
    /**
     * @param   string  $name
     * @param   string  $value
     *
     * @return  void
     */
    public function add($name, $value) {
        $this->errors[$name] = $value;
    }
    
    /**
     * @param   string  $name
     *
     * @return  void
     */
    public function get($name)
    {
        if ($this->has($name)) {
            echo $name;
        }
    }
    
    /**
     * @param   string  $name
     *
     * @return  boolean
     */
    public function has($name) {
        return array_key_exists($name, $this->errors);
    }
}