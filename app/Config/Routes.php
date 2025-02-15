<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


// Login
$routes->get('/', 'AuthController::index');
$routes->post('/login', 'AuthController::login');

// Register
$routes->get('/register', 'AuthController::register');
$routes->post('/register-user', 'AuthController::registerUser');

// Home
$routes->get('/home', 'HomeController::index');
$routes->get('/home/add-quiz', 'HomeController::addQuiz');
$routes->post('/home/store-quiz', 'HomeController::storeQuiz');
$routes->get('/home/edit-quiz/(:num)', 'HomeController::editQuiz/$1');
$routes->post('/home/update-quiz/(:num)', 'HomeController::updateQuiz/$1');
$routes->get('/home/delete-quiz/(:num)', 'HomeController::deleteQuiz/$1');

// User
$routes->get('/users', 'UserController::index');
$routes->get('/users/add', 'UserController::add');
$routes->post('/users/store', 'UserController::store');
$routes->get('/users/edit/(:num)', 'UserController::edit/$1');
$routes->post('/users/update/(:num)', 'UserController::update/$1');
$routes->get('/users/delete/(:num)', 'UserController::delete/$1');