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

require('./makeUtilities.php');
// Allow for possibility that user may append a slash to url.
$options = ['/', ''];

$app->get('/', function(Request $request, Response $response, LoggerInterface $logger, Twig $twig) {
  return $twig->render($response, 'utilityList.twig', makeUtilities());
});

foreach (makeUtilities()['utilities'] as $utility) {
  foreach ($options as $option) {
    $app->get("/$utility$option", function(Request $request, Response $response, LoggerInterface $logger, Twig $twig) {
      $utility = substr($_SERVER['REQUEST_URI'], 1);
      $logger->debug("logging output from $utility route");
      require("./utilities/{$utility}/makeUtility.php");
      return $twig->render($response, 'utilityIntro.twig', makeUtility($utility));
    });
  }
}

foreach (makeUtilities()['utilities'] as $utility) {
  foreach ($options as $option) {
    $app->get("/{$utility}/json{$option}", function(Request $request, Response $response, LoggerInterface $logger, Twig $twig) {
      $path = $_SERVER['REQUEST_URI'];
      $utility = explode("/", $path)[1];
      return $twig->render($response, 'error.twig', ['path' => $path, 'instructions' => "/$instructions"]);
    });
  };
}

foreach ($options as $option) {
  $app->get("/significanceFormatter/{number}/{digits}$option", function(string $number, string $digits, Request $request, Response $response, LoggerInterface $logger, Twig $twig) {
    $data = [
      'number' => $number,
      'digits' => $digits,
    ];
    $name = explode('/', $_SERVER['REQUEST_URI'])[1];
    $logger->debug("logging output for $name route");
    require ("./utilities/$name/makeHtml.php");
    return $twig->render($response, "utilities/$name.twig",
    makeHtml($data));
  });
}

// $app->get('/significance-formatter/json/{number}/{digits}', function(string $number, $digits, Request $request, Response $response, LoggerInterface $logger) {
  // $response->getBody()->write(json_encode(significanceFormatter($number, $digits)));
  // $response = $response->withHeader('Content-Type', 'application/json');
  // $logger->debug('logging output from /significanceFormatter/json/{data} route');
  // return $response;
// });

$app->run();
