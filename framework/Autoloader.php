<?php

namespace Phphilosophy;

/**
 * Autoloader
 *
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016 Lisa Saalfrank
 * @license	http://opensource.org/licenses/MIT MIT License
 * @since       0.1.0
 * @version     0.1.0
 * @package     Phphilosophy
 */
class Autoloader {
    
    /**
     * Complete list of all added namespace prefixes
     *
     * @var array
     */
    private $prefixes = [];
    
    /**
     * Register the autoloader
     *
     * @return  void
     */
    public function register()
    {
        spl_autoload_register([$this, 'loadClass']);
    }
    
    /**
     * Add a namespace prefix to the collection
     *
     * @param   string  $prefix
     * @param   string  $path
     */
    public function addNamespace($prefix, $path)
    {
        $prefix = trim($prefix, '\\') . '\\';
        $this->prefixes[$prefix] = rtrim($path, '/') . '/';
    }
    
    /**
     * Load class from the file path
     *
     * @param   string  $class
     * @return  boolean
     */
    private function loadClass($class)
    {
        $prefixes = array_keys($this->prefixes);
        
        foreach ($prefixes as $prefix)
        {
            if (0 === strpos($class, $prefix)) {
                return $this->loadMappedFile($prefix, $class);
            }
        }
        
        return false;
    }
    
    /**
     * Load the file for the given parameters
     *
     * @param   string  $prefix
     * @param   string  $class
     * @return  boolean
     */
    private function loadMappedFile($prefix, $class)
    {
        $path = $this->prefixes[$prefix];
        $class = substr($class, strlen($prefix));
        
        $file = $path . str_replace('\\', '/', $class) . '.php';
        
        return $this->requireFile($file);
    }
    
    /**
     * If the given file exists, require it from the file system
     *
     * @param   string  $file
     * @return  void
     */
    private function requireFile($file)
    {
        $exists = file_exists($file);
        
        if ($exists) {
            require $file;
        }
        
        return $exists;
    }
}