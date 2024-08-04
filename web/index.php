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

$utilityNames = [
  'significanceFormatter',
];
$makeHtmls = [];
foreach ($utilitieNames as $name) {
  require ('./utilities/' . $name . 'php');
  $makeHtmls[$name] = makeHtml;
};

// Our web handlers
$app->get('/', function(Request $request, Response $response, LoggerInterface $logger, Twig $twig) {
  $logger->debug('logging output.');
  return $twig->render($response, 'utilityList.twig', ['utilities' => $utilityNames]);
});

// Each of following 4 routes does same thing: render instructions in html.
// This'll need to be changed.
// $routes = ['/html', '/html/', '/json', '/json/'];

// foreach ($routes as $route) {
  // $app->get($route, function(Request $request, Response $response, LoggerInterface $logger, Twig $twig) {
    // $logger->debug('logging output from instructions route');
    // return $twig->render($response, 'instructions.twig');
  // });
// };

// require('./significanceFormatter.php');

$name = 'significanceFormatter';
$app->get('/' . $name . '/html/{number}/{digits}', function(string $number, string $digits, Request $request, Response $response, LoggerInterface $logger, Twig $twig) {
    $name = 'significanceFormatter';
    $data = [
      'number' => $number,
      'digits' => $digits,
    ];
    $logger->debug('logging output for ' . $name);
    // $twigFile = $name . '.twig';
    // $logger->debug('$twigFile = ' . $twigFile);
    // $logger->debug('$utilities[$name] = ' . $utilities[$name]);
    // function makeHtml = $utilities[$name]['makeHtml'];
    return $twig->render($response, $name . '.twig',
    makeHtmls[$name]($data));
    // return $twig->render($response, $name . '.twig',
    // $utilities[$name]['makeHtml']($data));
    // makeHtml($data));
  });

// $app->get('/significance-formatter/json/{number}/{digits}', function(string $number, $digits, Request $request, Response $response, LoggerInterface $logger) {
  // $response->getBody()->write(json_encode(significanceFormatter($number, $digits)));
  // $response = $response->withHeader('Content-Type', 'application/json');
  // $logger->debug('logging output from /significanceFormatter/json/{data} route');
  // return $response;
// });

$app->run();
