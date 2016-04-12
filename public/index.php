<?php

use Phphilosophy\Phphilosophy;

/*
 * Phphilosophy index file
 *
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2015-2016 Lisa Saalfrank
 */

require __DIR__.'/../bootstrap/bootstrap.php';

$app = new Phphilosophy(); 

/*
 * PLEASE ADD YOUR ROUTES HERE
 */
$app->get('/', function() {
    echo 'Welcome to PHPhilosophy!';
});

/*
 * HERE YOU CAN CUSTOMIZE YOUR ERROR PAGE
 */
$app->notFound(function() {
    echo 'The page you requested could not be found!';
});

$app->run();