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
// require('./endpoints.php');
// $endpoints = ['significanceFormatter'];
// foreach ($endpoints as $endpoint) {
  // require('./' . $endpoint . '.php');
// }
require('./significanceFormatter.php');

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

$app->get('/significanceFormatter/html/{number}/{digits}', function(string $number, string $digits, Request $request, Response $response, LoggerInterface $logger, Twig $twig) {
  $logger->debug('logging output from /significanceFormatter/{number}/{digits} route');
  return $twig->render($response, 'significanceFormatter.twig', significanceFormatter($number, $digits));
});

$app->get('/significanceFormatter/json/{number}/{digits}', function(string $number, $digits, Request $request, Response $response, LoggerInterface $logger) {
  $response->getBody()->write(json_encode(significanceFormatter($number, $digits)));
  $response = $response->withHeader('Content-Type', 'application/json');
  $logger->debug('logging output from /significanceFormatter/json/{data} route');
  return $response;
});

$app->run();
