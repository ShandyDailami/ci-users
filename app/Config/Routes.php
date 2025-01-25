<?php

use App\Controllers\Users;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Users::class, 'index']);
$routes->get('/signin', [Users::class, 'signinPage']);
$routes->get('/signup', [Users::class, 'signupPage']);
$routes->get('/forgotPassword', [Users::class, 'forgotPasswordPage']);