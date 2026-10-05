<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/about', 'About::index');
$routes->get('/services', 'Services::index');
$routes->match(['get', 'post'], '/contact', 'Contact::index');
$routes->get('/register', 'Register::index');
$routes->post('/register', 'Register::create');
$routes->get('dashboard', 'Dashboard::index');
$routes->get('account/(:num)', 'Dashboard::viewAccount/$1');
$routes->get('login', 'Login::index');
$routes->post('login', 'Login::authenticate');
$routes->post('logout', 'Login::logout');
$routes->get('account/create', 'Dashboard::createAccount');
$routes->post('account/create', 'Dashboard::storeAccount');
$routes->get('account/edit/(:num)', 'Dashboard::editAccount/$1');
$routes->post('account/update/(:num)', 'Dashboard::updateAccount/$1');
$routes->post('account/delete/(:num)', 'Dashboard::deleteAccount/$1');