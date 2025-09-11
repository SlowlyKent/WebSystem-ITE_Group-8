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

// User Management routes
$routes->get('user-management', 'UserManagementController::index');
$routes->get('user-management/add', 'UserManagementController::add');
$routes->post('user-management/add', 'UserManagementController::create');
$routes->post('user-management/create', 'UserManagementController::create'); // Added to fix 404 on create

// Role-based dashboards
$routes->get('doctor/dashboard', 'DoctorDashboardController::index');
$routes->get('doctor/patients', 'DoctorDashboardController::patients');
$routes->get('doctor/my-schedule', 'DoctorDashboardController::mySchedule');
$routes->get('doctor/patient/(:num)', 'DoctorDashboardController::viewPatient/$1');
$routes->get('doctor/lab-results', 'DoctorDashboardController::labRequests');
$routes->get('doctor/prescriptions', 'DoctorDashboardController::prescriptions');
$routes->get('doctor/profile', 'DoctorDashboardController::profile');
$routes->post('doctor/profile', 'DoctorDashboardController::updateProfile');
$routes->get('doctor/settings', 'DoctorDashboardController::settings');

$routes->group('role_dashboard/receptionist', function($routes) {
$routes->get('dashboard', 'ReceptionistController::index');
$routes->get('patientregistration', 'ReceptionistController::patientregistration');
$routes->get('appointmentbooking', 'ReceptionistController::appointmentbooking');
$routes->post('saveAppointment', 'ReceptionistController::saveAppointment');
$routes->get('patientsearch_lookup', 'ReceptionistController::patientsearch_lookup');
$routes->get('scheduleviewer', 'ReceptionistController::scheduleviewer');
$routes->get('billing', 'ReceptionistController::billing');
$routes->get('reports', 'ReceptionistController::reports');
});

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
