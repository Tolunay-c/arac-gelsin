<?php

declare(strict_types=1);

namespace App\Core;

/**
 * A deliberately small front-controller router: exact-path GET/POST routes
 * mapped to a callable. No third-party dependency, no magic — enough to
 * give the public site real, clean URLs (/hakkimizda, /filo, …) instead of
 * bare .php file paths, dispatched from a single index.php entry point.
 *
 * Pair with the front-controller rewrite in /.htaccess, which lets real
 * files (assets, uploads, admin/*.php) pass through untouched and sends
 * everything else here.
 */
final class Router
{
    /** @var array<string, array<string, callable>> */
    private array $routes = [];

    /** @var callable|null */
    private $notFoundHandler = null;

    public function get(string $path, callable $handler): void
    {
        $this->routes['GET'][$this->normalize($path)] = $handler;
    }

    public function post(string $path, callable $handler): void
    {
        $this->routes['POST'][$this->normalize($path)] = $handler;
    }

    public function notFound(callable $handler): void
    {
        $this->notFoundHandler = $handler;
    }

    public function dispatch(string $method, string $requestUri): void
    {
        $path = $this->normalize((string) parse_url($requestUri, PHP_URL_PATH));
        $handler = $this->routes[$method][$path] ?? null;

        if ($handler === null) {
            http_response_code(404);
            if ($this->notFoundHandler !== null) {
                ($this->notFoundHandler)();
            } else {
                echo 'Not Found';
            }
            return;
        }

        $handler();
    }

    private function normalize(string $path): string
    {
        $path = '/' . trim($path, '/');

        return $path;
    }
}
