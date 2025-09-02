<<<<<<< HEAD
﻿<?php
=======
<?php
>>>>>>> a353678cfce4d1f15b5eab45fa396d20e69e8d39

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
<<<<<<< HEAD
$routes->post('dashboard/change-password', 'DashboardController::changePassword');
=======

// Pharmacist dashboard
$routes->get('pharmacist', 'PharmacistController::index');

// Pharmacist feature routes
$routes->group('pharmacist', static function($routes) {
    $routes->get('inventory', 'PharmacistController::inventory');
    $routes->get('alerts', 'PharmacistController::alerts');
    $routes->get('reports', 'PharmacistController::reports');
    $routes->get('lookup', 'PharmacistController::lookup');
    $routes->get('dispense', 'PharmacistController::dispense');
    $routes->post('dispense', 'PharmacistController::dispense');
});
>>>>>>> a353678cfce4d1f15b5eab45fa396d20e69e8d39

// User Management routes (Admin and IT Staff only)
$routes->group('user-management', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'UserManagementController::index');
    $routes->get('create', 'UserManagementController::create');
    $routes->post('create', 'UserManagementController::create');
    $routes->get('edit/(:num)', 'UserManagementController::edit/$1');
    $routes->post('edit/(:num)', 'UserManagementController::edit/$1');
    $routes->get('delete/(:num)', 'UserManagementController::delete/$1');
});

<<<<<<< HEAD
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


=======
// Default route - redirect to login
$routes->get('/', 'AuthController::index');
>>>>>>> a353678cfce4d1f15b5eab45fa396d20e69e8d39
