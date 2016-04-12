<?php

/*
 * Configuration of database
 *
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2015-2016 Lisa Saalfrank
 * @license	    http://opensource.org/licenses/MIT MIT License
 */
$database = [

    /* 
     * PLEASE CHANGE THESE VALUES ACCORDINGLY!
     */
    'default' => [

        // The driver of your database
        'driver' => 'mysql',
        // The name of your database server
        'host' => 'localhost',
        // The name of your database user
        'user' => 'root',
        // The users password, if set, otherwise left empty
        'password' => '',
        // The name of the database
        'name' => 'database',
        // The default character set
        'char' => 'utf8',
        // Database prefix that's added to your table names
        'prefix' => ''   
    ],
    
];