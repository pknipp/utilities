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
$option1s = ['', '/json'];
// Allow for possibility that user may append a slash to url.
$option2s = ['', '/'];

$utilities = makeUtilities();
$app->get('/', function(Request $request, Response $response, LoggerInterface $logger, Twig $twig) {
  $logger->debug($GLOBALS["utilities"]);
  return $twig->render($response, 'utilityList.twig', $GLOBALS["utilities"]);
});

// foreach ($utilities as $utility) {
  // foreach ($option2s as $option) {
    // $app->get("/{$utility['name']}$option", function(Request $request, Response $response, LoggerInterface $logger, Twig $twig) {
      // $name = substr($_SERVER['REQUEST_URI'], 1);
      // $logger->debug("logging output from $name route");
      require("./utilities/{$name}/makeUtility.php");
      // return $twig->render($response, 'utilityIntro.twig', $GLOBALS["utilities"][$name]);
    // });
  // }
// }

// foreach (makeUtilities()['utilities'] as $utility) {
  // foreach ($option2s as $option) {
    // $app->get("/{$utility['name']}/json{$option}", function(Request $request, Response $response, LoggerInterface $logger, Twig $twig) {
      // $path = $_SERVER['REQUEST_URI'];
      // $name = explode("/", $path)[1];
      // return $twig->render($response, 'error.twig', ['path' => $path, 'instructions' => "/$name"]);
    // });
  // };
// }

// WITH EACH ADDITIONAL UTILITY, COPY THE LINES FROM HERE ...
foreach ($option1s as $option1) {
  foreach ($option2s as $option2) {
    // Mutation will be needed for the lines from here ...
    $app->get("/significanceFormatter$option1/{number}/{digits}$option2", function(string $number, string $digits, Request $request, Response $response, LoggerInterface $logger, Twig $twig) {
      $data = [
        'number' => $number,
        'digits' => $digits,
      ];
      // ... to here for each utility.
      $pathParts = explode('/', $_SERVER['REQUEST_URI']);
      $isJson = $pathParts[2] == 'json';
      $name = $pathParts[1];
      $logger->debug("logging output for $name $option1 route");
      require ("./utilities/$name/makeHtml.php");
      $output = makeHtml($data);
      if ($isJson) {
        $response->getBody()->write(json_encode($output));
        $response = $response->withHeader('Content-Type', 'application/json');
        return $response;
      } else {
        return $twig->render($response, "utilities/$name.twig", $output);
      }
    });
  }
}
// ... TO HERE.

$app->run();
