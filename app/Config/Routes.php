<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');


$routes->match(['get','post'],'/', 'Users::index');
$routes->get('logout', 'Users::logout');
$routes->match(['get','post'],'register', 'Users::register');
$routes->match(['get','post'],'profile', 'Users::profile');
$routes->get('dashboard', 'Dashboard::index');
$routes->get('chat', 'Chat::index');
$routes->match(['get','post'],'sendmsg', 'Chat::send');

$routes->get('demo', 'Chat::chatDemo');

