<?php

require_once __DIR__ . '/../app/bootstrap.php';

use App\Core\Router;

$router = new Router();

// Auth Routes
$router->add('GET', 'login', 'AuthController@showLogin');
$router->add('POST', 'login', 'AuthController@login');
$router->add('GET', 'signup', 'AuthController@showSignup');
$router->add('POST', 'signup', 'AuthController@signup');
$router->add('GET', 'logout', 'AuthController@logout');
$router->add('GET', 'forgot-password', 'AuthController@showForgotPassword');
$router->add('POST', 'forgot-password', 'AuthController@forgotPassword');
$router->add('GET', 'reset-password/{token}', 'AuthController@showResetPassword');
$router->add('POST', 'reset-password', 'AuthController@resetPassword');

// Dashboard Routes
$router->add('GET', 'dashboard', 'DashboardController@index');
$router->add('GET', '', 'DashboardController@index');

$url = $_GET['url'] ?? '';
$router->dispatch($url);
