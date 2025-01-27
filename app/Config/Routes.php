<?php

use App\Controllers\Users;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Users::class, 'index']);
$routes->get('/signin', [Users::class, 'signinPage']);
$routes->post('/signin', [Users::class, 'signin']);

$routes->get('/signup', [Users::class, 'signupPage']);
$routes->post('/signup', [Users::class, 'signup']);

$routes->get('/forgotPassword', [Users::class, 'forgotPasswordPage']);

$routes->get('/dashboard', [Users::class, 'dashboard']);
$routes->post('/update', [Users::class, 'update']);
$routes->get('/logout', [Users::class, 'logout']);