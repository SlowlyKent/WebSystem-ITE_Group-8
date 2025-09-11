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

// Role-based dashboards - Doctor
$routes->get('doctor/dashboard', 'DoctorDashboardController::index');
$routes->get('doctor/patients', 'DoctorDashboardController::patients');
$routes->get('doctor/my-schedule', 'DoctorDashboardController::mySchedule');
$routes->get('doctor/patient/(:num)', 'DoctorDashboardController::viewPatient/$1');
$routes->get('doctor/lab-results', 'DoctorDashboardController::labRequests');
$routes->get('doctor/prescriptions', 'DoctorDashboardController::prescriptions');
$routes->get('doctor/profile', 'DoctorDashboardController::profile');
$routes->post('doctor/profile', 'DoctorDashboardController::updateProfile');
$routes->get('doctor/settings', 'DoctorDashboardController::settings');

// Role-based dashboards - Nurse
$routes->get('nurse/dashboard', 'NurseDashboardController::index');
$routes->get('nurse/patient-assignments', 'NurseDashboardController::patientAssignments');
$routes->get('nurse/vital-signs', 'NurseDashboardController::vitalSigns');
$routes->get('nurse/medication-admin', 'NurseDashboardController::medicationAdmin');
$routes->get('nurse/nursing-notes', 'NurseDashboardController::nursingNotes');
$routes->get('nurse/shift-handover', 'NurseDashboardController::shiftHandover');
$routes->get('nurse/profile', 'NurseDashboardController::profile');
$routes->post('nurse/profile/update', 'NurseDashboardController::updateProfile');

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

// Database Status route (with authentication filter)
$routes->get('database-status', 'DatabaseController::status', ['filter' => 'auth']);

// Temporary route for checking tables
$routes->get('/check-tables', 'CheckTables::index');
