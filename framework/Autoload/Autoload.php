<?php

namespace Phphilosophy\Autoload;

/**
 * Phphilosophy PSR-4 Classloader
 *
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2015-2016 Lisa Saalfrank
 * @license	http://opensource.org/licenses/MIT MIT License
 * @since       0.1.0
 * @version     0.1.0
 * @package     Phphilosophy
 * @subpackage  Autoload
 */
class Autoload {
    
    /**
     * @var     array   Array of namespace prefixes
     */
    private $prefixes = [];
    
    /**
     * @var     string  The current namespace prefix
     */
    private $currentPrefix;
    
    /**
     * @param   string  $prefix     Namespace prefix
     * @param   string  $directory  Referenced directory
     * @return  void
     */
    public function add($prefix, $directory)
    {
        $prefix = trim($prefix, '\\') . '\\';
        $directory = rtrim($directory, '/') . '/';
        $this->prefixes[$prefix] = $directory;
    }
    
    /**
     * @param   string  $class  The classname
     * @return  bool    Returns, whether a known base path was found
     */
    private function findCurrentPrefix($class)
    {
        // Extract array keys to use them as a search array.
        $prefixes = array_keys($this->prefixes);
        
        // Searches the current classname for a known prefix.
        foreach ($prefixes as $prefix) {
        
            // Finds out whether a prefix was found at the beginning of a classname.
            // If one was found it will be saved and true will be returned.
            if (0 === strpos($class, $prefix)) {
                
                // ... as well as the found namespace prefix
                $this->currentPrefix = (string) $prefix;
                
                return true;
            }
        }
        
        // If no prefix was found return false
        return false;
    }
    
    /**
     * @param   string  $classname  The current classname
     * @return  string  The path to the class
     */
    private function findPathToClass($classname) 
    {
        // Normalize the classname
        $class = ltrim($classname, '\\');
        
        if ($this->findCurrentPrefix($class) === true) {
            
            // Length of the prefix
            $prefixEnd = strlen($this->currentPrefix);
            
            // Delete prefix from classname
            $withoutPrefix = substr($class, $prefixEnd);
            
            // Replaces \\ with /
            $namespaceToPath = str_replace('\\', '/', $withoutPrefix);
            
            // Now build the path to the class by using the found components and adding .php
            $pathToFile = $this->prefixes[$this->currentPrefix] . $namespaceToPath . '.php';
            
            return $pathToFile;
        }
    }
    
    /**
     * @param   string  $class  The class to load
     * @return  bool    Whether the class could be loaded
     */
    public function loadClass($class)
    {
        $path = $this->findPathToClass($class);
        
        // Will be run only if the class could be found
        if ($path !== null) {
            require $path;
            return true;
        }
        
        return false;
    }
    
    /**
     * @param   bool    $prepend    Config for autoload function
     * @return  void
     */
    public function register($prepend = false) {
        spl_autoload_register(array($this, 'loadClass'), true, $prepend);
    }
}