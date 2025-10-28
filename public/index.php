<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\TicketController;

// Initialize Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
$twig = new \Twig\Environment($loader, [
    'cache' => false, // Disable cache for development
    'debug' => true
]);

// Add debug extension
$twig->addExtension(new \Twig\Extension\DebugExtension());

// Simple routing
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Route handling
try {
    if ($uri === '/' && $method === 'GET') {
        $controller = new HomeController($twig);
        echo $controller->index();
        
    } elseif ($uri === '/login' && $method === 'GET') {
        $controller = new AuthController($twig);
        echo $controller->showLogin();
        
    } elseif ($uri === '/login' && $method === 'POST') {
        $controller = new AuthController($twig);
        echo $controller->login();
        
    } elseif ($uri === '/signup' && $method === 'GET') {
        $controller = new AuthController($twig);
        echo $controller->showSignup();
        
    } elseif ($uri === '/signup' && $method === 'POST') {
        $controller = new AuthController($twig);
        echo $controller->signup();
        
    } elseif ($uri === '/logout') {
        $controller = new AuthController($twig);
        $controller->logout();
        
    } elseif ($uri === '/dashboard' && $method === 'GET') {
        $controller = new DashboardController($twig);
        echo $controller->index();
        
    } elseif ($uri === '/tickets' && $method === 'GET') {
        $controller = new TicketController($twig);
        echo $controller->index();
        
    } elseif ($uri === '/tickets/create' && $method === 'POST') {
        $controller = new TicketController($twig);
        echo $controller->create();
        
    } elseif (preg_match('/^\/tickets\/(\d+)\/edit$/', $uri, $matches) && $method === 'GET') {
        $controller = new TicketController($twig);
        echo $controller->edit($matches[1]);
        
    } elseif (preg_match('/^\/tickets\/(\d+)\/update$/', $uri, $matches) && $method === 'POST') {
        $controller = new TicketController($twig);
        echo $controller->update($matches[1]);
        
    } elseif (preg_match('/^\/tickets\/(\d+)\/delete$/', $uri, $matches) && $method === 'POST') {
        $controller = new TicketController($twig);
        $controller->delete($matches[1]);
        
    } else {
        http_response_code(404);
        echo $twig->render('pages/404.html.twig');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo "Error: " . $e->getMessage();
}