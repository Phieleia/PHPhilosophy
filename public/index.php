<?php

use Phphilosophy\Phphilosophy;
use Phphilosophy\Http\Request;

/*
 * Phphilosophy index file
 *
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2015-2017 Lisa Saalfrank
 */

require __DIR__.'/../bootstrap/bootstrap.php';

$request = new Request();
Phphilosophy::register($request);

/*
 * PLEASE ADD YOUR ROUTES HERE
 */
Phphilosophy::get('/', function() {
    echo 'Welcome to PHPhilosophy!';
});

/*
 * HERE YOU CAN CUSTOMIZE YOUR ERROR PAGE
 */
Phphilosophy::notFound(function() {
    echo 'The page you requested could not be found!';
});

Phphilosophy::run();
