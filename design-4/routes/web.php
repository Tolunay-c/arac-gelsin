<?php

declare(strict_types=1);

/**
 * Public site route map. Each handler simply requires the matching page
 * template under /pages — templates fetch their own data and render
 * through includes/header.php + includes/footer.php, same as any other
 * plain PHP page, just reached through a clean URL instead of a bare
 * .php file path.
 */

use App\Core\Router;

$router = new Router();

$router->get('/', static function (): void {
    require BASE_PATH . '/pages/home.php';
});

$router->get('/hakkimizda', static function (): void {
    require BASE_PATH . '/pages/about.php';
});

$router->get('/filo', static function (): void {
    require BASE_PATH . '/pages/fleet.php';
});

$router->get('/kullanim-senaryolari', static function (): void {
    require BASE_PATH . '/pages/use-cases.php';
});

$router->get('/iletisim', static function (): void {
    require BASE_PATH . '/pages/contact.php';
});

$router->post('/lead-submit', static function (): void {
    require BASE_PATH . '/pages/lead-submit-handler.php';
});

$router->notFound(static function (): void {
    require BASE_PATH . '/pages/404.php';
});

return $router;
