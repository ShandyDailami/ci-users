<?php

use App\Controllers\Admins;
use App\Controllers\Users;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('', function ($routes) {
  $routes->get('/', [Users::class, 'index']);
  $routes->get('/signin', [Users::class, 'signinPage']);
  $routes->post('/signin', [Users::class, 'signin']);

  $routes->get('/signup', [Users::class, 'signupPage']);
  $routes->post('/signup', [Users::class, 'signup']);

  $routes->get('/forgotPassword', [Users::class, 'forgotPasswordPage']);

  $routes->get('/profile', [Users::class, 'profile']);
  $routes->post('/update', [Users::class, 'update']);
  $routes->get('/logout', [Users::class, 'logout']);
});

$routes->group('admin', function ($routes) {
  $routes->get('signin', [Admins::class, 'index']);
  $routes->post('signin', [Admins::class, 'signinAdmin']);

  $routes->get('signup', [Admins::class, 'signupAdminPage']);
  $routes->post('signup', [Admins::class, 'signupAdmin']);

  $routes->get('panel', [Admins::class, 'panel']);
  $routes->get('forgotPassword', [Admins::class, 'forgotPasswordAdminPage']);
});