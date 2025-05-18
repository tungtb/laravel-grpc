<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';

use Spiral\RoadRunner\GRPC\Server;
use Spiral\RoadRunner\Worker;
use App\Grpc\ExampleServiceImpl;

try {
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

    $server = $app->make(Server::class, [ ['debug' => true]]);

    $server->registerService(\Example\ExampleServiceInterface::class, new ExampleServiceImpl());

    $worker = new  Worker(new Spiral\Goridge\StreamRelay(STDIN, STDOUT));

    $server->serve($worker);
} catch (\Throwable $e) {
    file_put_contents('php://stderr', "Error: " . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n");
    exit(1);
}
