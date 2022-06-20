<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

//twig 引入-------------------------------------------------
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
//----------------------------------------------------------

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

//twig 配置-------------------------------------------------------------
$twig = Twig::create( __DIR__ . '/../src/views', ['cache' => false] );
$app->add(TwigMiddleware::create($app, $twig));
//---------------------------------------------------------------------

$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("Hello, world~~");
    return $response;
});

$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
});

//twig 範例------------------------------------------------
$app->get('/twig', function ($request, $response) {
    $view = Twig::fromRequest($request);
    return $view->render($response, 'bbb.html',[
        'name' => 'i am yiheng'
    ]);
});
//--------------------------------------------------------


$app->run();