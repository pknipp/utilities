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

// Allow for possibility that user may append a slash to url.
$options = ['', '/'];

require('./makeUtilities.php');
$utilities = makeUtilities();

$app->get('/', function(Request $request, Response $response, LoggerInterface $logger, Twig $twig) {
  $logger->debug(json_encode($GLOBALS['utilities']));
  return $twig->render($response, 'utilityList.twig', ['utilities' => $GLOBALS['utilities']]);
});

foreach ($utilities as $utility) {
  foreach ($options as $option) {
    $app->get("/{$utility['name']}$option", function(Request $request, Response $response, LoggerInterface $logger, Twig $twig) {
      $name = explode("/", $_SERVER['REQUEST_URI'])[1];
      $logger->debug("logging output from $name route");
      return $twig->render($response, 'utilityIntro.twig', $GLOBALS['utilities'][$name]);
    });
  }
}

foreach ($utilities as $utility) {
  foreach ($options as $option) {
    $app->get("/{$utility['name']}/json{$option}", function(Request $request, Response $response, LoggerInterface $logger, Twig $twig) {
      $path = $_SERVER['REQUEST_URI'];
      // $name = explode('/', $path)[1];
      $response->getBody()->write(json_encode(
        ['error' => "You need to type some input(s) after {$path}"],
        JSON_UNESCAPED_UNICODE,
      ));
      $response = $response->withHeader('Content-Type', 'application/json');
      return $response;
    });
  };
}

// WITH EACH ADDITIONAL UTILITY, COPY THE LINES FROM HERE ...
foreach (['', '/json'] as $option1) {
  foreach ($options as $option2) {
    // Mutation will be needed for the lines from here ...
    $app->get("/significanceFormatter{$option1}/{number}/{digits}$option2", function(string $number, string $digits, Request $request, Response $response, LoggerInterface $logger, Twig $twig) {
      $data = [
        'number' => $number,
        'digits' => $digits,
      ];
      // ... to here for each utility.
      $pathParts = explode('/', $_SERVER['REQUEST_URI']);
      $logger->debug(json_encode($pathParts));
      $isJson = $pathParts[2] == 'json';
      $name = $pathParts[1];
      require ("./utilities/{$name}/makeResponse.php");
      $output = makeResponse($data);
      if ($isJson) {
        $response->getBody()->write(json_encode($output, JSON_UNESCAPED_UNICODE));
        $response = $response->withHeader('Content-Type', 'application/json');
        return $response;
      } else {
        if (array_key_exists('message', $output)) {
          return $twig->render($response, "utilities/{$name}.twig", $output['message']);
        } else {
          return $twig->render(
            $response,
            'error.twig',
            [
              'path' => $path,
              'instructions' => "/{$name}",
              'error' => "Error: you need to type some input(s) after {$path}",
            ],
          );
        }
      }
    });
  }
}
// ... TO HERE.

$app->run();
