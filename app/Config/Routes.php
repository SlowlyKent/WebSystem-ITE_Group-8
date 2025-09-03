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

// Pharmacy & Inventory routes
$routes->group('pharmacy', function($routes) {
    $routes->get('/', 'PharmacyController::index');
    $routes->get('inventory', 'PharmacyController::inventory');
    $routes->get('dispense', 'PharmacyController::dispense');
    $routes->get('receive', 'PharmacyController::receive');
    $routes->get('alerts', 'PharmacyController::alerts');
    $routes->get('reports', 'PharmacyController::reports');

    // Patient Prescription Lookup
    $routes->get('lookup', 'PrescriptionController::lookup');
    $routes->get('lookup/view/(:num)', 'PrescriptionController::view/$1');
    $routes->match(['get','post'], 'lookup/dispense/(:num)', 'PrescriptionController::dispense/$1');

    // Medicines CRUD
    $routes->get('medicines/create', 'PharmacyController::createMedicine');
    $routes->post('medicines/store', 'PharmacyController::storeMedicine');
    $routes->get('medicines/edit/(:num)', 'PharmacyController::editMedicine/$1');
    $routes->post('medicines/update/(:num)', 'PharmacyController::updateMedicine/$1');
    $routes->post('medicines/delete/(:num)', 'PharmacyController::deleteMedicine/$1');
});

// Removed UserManagementController routes as controller is deleted

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


