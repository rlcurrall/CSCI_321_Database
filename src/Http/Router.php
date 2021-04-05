<?php

namespace ScrollLock\Http;

use ReflectionClass;
use ScrollLock\Http\Exception\NotFound;
use ScrollLock\Http\Exception\Unauthorized;

class Router
{
    private array $controllerArgs;

    private array $routes = [];

    public function __construct(array $controllerArgs)
    {
        $this->controllerArgs = $controllerArgs;
    }

    public function register(
        string $method,
        string $path,
        string $controller,
        string $handler,
        bool $guest = false
    ): self {
        if (!in_array($method, ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTION'])) {
            throw new \Exception("Invalid method type.");
        }

        if (!class_exists($controller)) {
            throw new \Exception("The controller does not exist: {$controller}");
        }

        if (!in_array($handler, get_class_methods($controller))) {
            throw new \Exception("Handler does not exist on designated controller: {$handler}");
        }

        $path = trim($path, "/ \t\n\r\0\x0B");

        $this->routes[] = compact('method', 'path', 'controller', 'handler', 'guest');

        return $this;
    }

    public function match(Request $request): ?array
    {
        $path = $request->getPath();
        $method = $request->getMethod();

        foreach ($this->routes as $definition) {
            $pattern = preg_replace('/\//', '\/', $definition['path']);
            $pattern = preg_replace('/{[A-z]+}/', '([\w-]+)', $pattern);

            if (
                preg_match('/^' . $pattern . '$/', $path) &&
                $definition['method'] === $method
            ) {
                $request->parsePathParams($definition['path']);
                return $definition;
            }
        }

        return null;
    }

    public function route(Request $request, Response $response): Response
    {
        $route = $this->match($request);

        if (!$route) {
            throw new NotFound('...');
        }

        if (!$route['guest'] && !$request->getUser()) {
            throw new Unauthorized('..');
        }

        $reflector = new ReflectionClass($route['controller']);
        $class = $reflector->newInstanceArgs($this->controllerArgs);

        $response = call_user_func_array([$class, $route['handler']], [$request, $response]);

        return $response;
    }
}
