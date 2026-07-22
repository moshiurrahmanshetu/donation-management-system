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

// Role Management Routes
$router->add('GET', 'roles', 'RoleController@index');
$router->add('GET', 'roles/list', 'RoleController@list');
$router->add('POST', 'roles/store', 'RoleController@store');
$router->add('GET', 'roles/edit/{id}', 'RoleController@edit');
$router->add('POST', 'roles/update/{id}', 'RoleController@update');
$router->add('POST', 'roles/delete/{id}', 'RoleController@delete');
$router->add('POST', 'roles/toggle-status/{id}', 'RoleController@toggleStatus');
$router->add('GET', 'roles/show/{id}', 'RoleController@show');

// Permission Management Routes
$router->add('GET', 'permissions', 'PermissionController@index');
$router->add('GET', 'permissions/list', 'PermissionController@list');
$router->add('POST', 'permissions/store', 'PermissionController@store');
$router->add('GET', 'permissions/edit/{id}', 'PermissionController@edit');
$router->add('POST', 'permissions/update/{id}', 'PermissionController@update');
$router->add('POST', 'permissions/delete/{id}', 'PermissionController@delete');

// Module Management Routes
$router->add('GET', 'permissions/modules', 'PermissionController@modules');
$router->add('GET', 'permissions/module-list', 'PermissionController@moduleList');
$router->add('POST', 'permissions/module-store', 'PermissionController@moduleStore');
$router->add('POST', 'permissions/module-delete/{id}', 'PermissionController@moduleDelete');

$url = $_GET['url'] ?? '';
$router->dispatch($url);
