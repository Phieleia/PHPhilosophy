<?php

namespace Phphilosophy\Database;

/**
 * Phphilosophy database driver interface
 *
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2015-2016 Lisa Saalfrank
 * @license	    http://opensource.org/licenses/MIT MIT License
 * @since       0.1.0
 * @version     0.1.0
 * @package     Phphilosophy
 * @subpackage  Database
 */
interface DriverInterface {
    
    /**
     * Opens a connection to the database
     *
     * @access  public
     * @return  bool
     */
    public function connect();
    
    /**
     * Closes the connection to the database
     *
     * @access  public
     * @return  void
     */
    public function disconnect();
}