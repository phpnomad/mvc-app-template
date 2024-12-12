<?php

use App\Application;
use PHPNomad\Core\Events\Ready;
use PHPNomad\Core\Facades\Event;
use PHPNomad\FastRoute\Component\Events\RequestInitiated;
use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;

require_once './vendor/autoload.php';

$whoops = new Run();
$whoops->pushHandler(new PrettyPageHandler());
$whoops->register();

(new Application())
  ->setConfig('cache', './configs/cache.json')
  ->setConfig('app','./configs/app.json')
  ->init();

Event::broadcast(new Ready());

$event = new RequestInitiated($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
Event::broadcast($event);

$response = $event->getResponse();

http_response_code($response->getStatus());

// Send headers
foreach ($response->getHeaders() as $name => $value) {
    header("$name: $value");
}

// Output the response body
echo $response->getBody();