<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;

use DI\Container;
use DI\Bridge\Slim\Bridge;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;

require(__DIR__.'/../vendor/autoload.php');
require('./endpoints.php');
foreach ($endpoints as $endpoint) {
  require('./' . $endpoint . '.php');
}

// Create DI container
$container = new Container();
// Add Twig to Container
$container->set(Twig::class, function() {
  return Twig::create(__DIR__.'/../views');
});
// Add Monolog to Container
$container->set(LoggerInterface::class, function () {
  $logger = new Logger('default');
  $logger->pushHandler(new StreamHandler('php://stderr'), Level::Debug);
  return $logger;
});

// Create main Slim app
$app = Bridge::create($container);
// $app = AppFactory::create();
$app->addErrorMiddleware(true, false, false);

// Our web handlers
$app->get('/', function(Request $request, Response $response, LoggerInterface $logger, Twig $twig) {
  $logger->debug('logging output.');
  return $twig->render($response, 'index.twig');
});

// Each of following 4 routes does same thing: render instructions in html.
$routes = ['/html', '/html/', '/json', '/json/'];

foreach ($routes as $route) {
  $app->get($route, function(Request $request, Response $response, LoggerInterface $logger, Twig $twig) {
    $logger->debug('logging output from instructions route');
    return $twig->render($response, 'instructions.twig');
  });
};

$app->get('/significanceFormatter/{number}/{digits}', function(string $number, string $digits, Request $request, Response $response, LoggerInterface $logger, Twig $twig) {
  $logger->debug('logging output from /significanceFormatter/{number}/{digits} route');
  return $twig->render($response, 'html.twig', ['formattedNumber' => significanceFormatter($number, $digits)]);
});

// $app->get('/json/{data}', function(string $data, Request $request, Response $response, LoggerInterface $logger) {
  // $response->getBody()->write(json_encode(['data' => $data]));
  // $response = $response->withHeader('Content-Type', 'application/json');
  // $logger->debug('logging output from /json/{data} route');
  // return $response;
// });

$app->run();
