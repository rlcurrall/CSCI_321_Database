<?php

ini_set('display_errors', 0);

require dirname(__DIR__) . '/vendor/autoload.php';

session_start();

$pdo = \ScrollLock\Factory\DatabaseFactory::make();
$request = \ScrollLock\Factory\RequestFactory::make($pdo);
$router = \ScrollLock\Factory\RouterFactory::make([$pdo]);
$response = new \ScrollLock\Http\Response();

try {
    $response = $router->route($request, $response);
} catch (\ScrollLock\Http\Exception\NotFound $th) {
    $response->redirect('/login');
} catch (\ScrollLock\Http\Exception\Unauthorized $th) {
    $response->redirect('/login');
} catch (\Throwable $th) {
    $response->status(500)->error($th);
}

$response->send();
