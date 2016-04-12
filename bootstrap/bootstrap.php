<?php 

use Phphilosophy\Autoloader;
use Phphilosophy\Application\Config;

/*
 * Phphilosophy bootstrap file
 *
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2015-2016 Lisa Saalfrank
 * @license	    http://opensource.org/licenses/MIT MIT License
 */

// Require the autoload and the config file
require __DIR__.'/../framework/Autoloader.php';
require __DIR__.'/../application/configs/application.php';
require __DIR__.'/../application/configs/database.php';

// create the autoload instance
$autoload = new Autoloader();

// Add namespace prefixes
$autoload->addNamespace('Phphilosophy', __DIR__.'/../framework/');
$autoload->addNamespace($configs['app.name'].'\\Model', __DIR__.'/../application/models/');
$autoload->addNamespace($configs['app.name'].'\\Controller', __DIR__.'/../application/controllers/');
$autoload->addNamespace($configs['app.name'].'\\Library', __DIR__.'/../application/libraries/');

// register the autoloader
$autoload->register();

// Add config values
Config::set('database', $database);
Config::set('app.name', $configs['app.name']);