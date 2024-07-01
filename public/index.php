<?php

require __DIR__ . '/../vendor/autoload.php';

use FastRoute\RouteCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// Define routes
$dispatcher = FastRoute\simpleDispatcher(function(RouteCollector $r) {
    $r->addRoute('POST', '/zap-lite/trigger', 'ZapLite\Controllers\ActionsController@handleTrigger');
    $r->addRoute('POST', '/zap-lite/action', 'ZapLite\Controllers\ActionsController@handleAction');
});

// Fetch method and URI from server
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        header("HTTP/1.0 405 Method Not Allowed");
        echo "405 Method Not Allowed";
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        list($class, $method) = explode('@', $handler);
        $controller = new $class();

        // Create a Request object
        $request = Request::createFromGlobals();

        // Pass the request to the controller method
        call_user_func_array([$controller, $method], [$request]);
        break;
}
