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
require('./significance.php');

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

$app->get('/html/{numberString}/{digitsString}', function(string $numberString, string $digitsString, Request $request, Response $response, LoggerInterface $logger, Twig $twig) {
  $logger->debug('logging output from /html/{number}/{digits} route');
  $errorMessage = "";
  $number = 0.;
  $digits = 3;
  if (filter_var($numberString, FILTER_VALIDATE_FLOAT)) {
    $number = floatval($numberString);
  } else {
    $errorMessage = "Invalid number";
  }
  if (filter_var($digitsString, FILTER_VALIDATE_INT)) {
    $digits = intval($digitsString);
  } else {
    $errorMessage = "Invalid digits";
  }
  if ($digits < 1) {
    $errorMessage = "Digits must be positive.";
  }
  $logger->debug("error message - number - digits = " . $errorMessage . $number . $digits);
  return $twig->render($response, 'html.twig', ['formattedNumber' => ($errorMessage || sigFigFormat($number, $digits))]);
});

$app->get('/json/{data}', function(string $data, Request $request, Response $response, LoggerInterface $logger) {
  $response->getBody()->write(json_encode(['data' => $data]));
  $response = $response->withHeader('Content-Type', 'application/json');
  $logger->debug('logging output from /json/{data} route');
  return $response;
});

$app->run();
