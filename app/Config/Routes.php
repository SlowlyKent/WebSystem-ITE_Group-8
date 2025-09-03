<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Authentication routes
$routes->get('login', 'AuthController::index');
$routes->post('login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');
$routes->get('change-password', 'AuthController::changePassword');
$routes->post('change-password', 'AuthController::changePassword');
$routes->get('forgot-password', 'AuthController::forgotPassword');
$routes->post('forgot-password', 'AuthController::forgotPassword');

// Dashboard routes
$routes->get('dashboard', 'DashboardController::index');
$routes->get('dashboard/profile', 'DashboardController::profile');
$routes->post('dashboard/profile', 'DashboardController::updateProfile');
$routes->post('dashboard/change-password', 'DashboardController::changePassword');

// Profile routes
$routes->post('/profile/changePassword', 'UserManagementController::changePassword');

// Default route - redirect to login
$routes->get('/', 'AuthController::index');

// Patient Registration & EHR routes
$routes->get('/patients', 'PatientController::index');
$routes->get('/patients/view/(:num)', 'PatientController::view/$1');
$routes->get('/patients/create', 'PatientController::create');
$routes->post('/patients/store', 'PatientController::store');
$routes->get('/patients/edit/(:num)', 'PatientController::edit/$1');
$routes->post('/patients/update/(:num)', 'PatientController::update/$1');
$routes->get('/patients/delete/(:num)', 'PatientController::delete/$1');

// Temporary route for checking tables
$routes->get('/check-tables', 'CheckTables::index');


