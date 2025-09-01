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

// Doctor Dashboard routes
$routes->get('/doctor', 'DoctorDashboardController::index');
$routes->get('/doctor/patient-ehr', 'DoctorDashboardController::patientEhr');
$routes->get('/doctor/my-schedule', 'DoctorDashboardController::mySchedule');
$routes->get('/doctor/lab-results', 'DoctorDashboardController::labResults');
$routes->get('/doctor/prescriptions', 'DoctorDashboardController::prescriptions');

// Doctor API Routes - Patient Management
$routes->get('/doctor/api/patients', 'DoctorDashboardController::getPatients');
$routes->get('/doctor/api/patients/(:num)', 'DoctorDashboardController::getPatientDetails/$1');

// Doctor API Routes - Appointments
$routes->get('/doctor/api/appointments', 'DoctorDashboardController::getAppointments');
$routes->post('/doctor/api/appointments', 'DoctorDashboardController::createAppointment');
$routes->put('/doctor/api/appointments/(:num)', 'DoctorDashboardController::updateAppointment/$1');
$routes->delete('/doctor/api/appointments/(:num)', 'DoctorDashboardController::deleteAppointment/$1');

// Doctor API Routes - Lab Requests
$routes->post('/doctor/api/lab-requests', 'DoctorDashboardController::createLabRequest');
$routes->get('/doctor/api/lab-requests/(:num)', 'DoctorDashboardController::getLabRequestDetails/$1');
$routes->put('/doctor/api/lab-requests/(:num)', 'DoctorDashboardController::updateLabRequest/$1');
$routes->delete('/doctor/api/lab-requests/(:num)', 'DoctorDashboardController::deleteLabRequest/$1');
$routes->get('/doctor/api/lab-requests/search', 'DoctorDashboardController::searchLabRequests');

// Doctor API Routes - Prescriptions
$routes->post('/doctor/api/prescriptions', 'DoctorDashboardController::createPrescription');
$routes->get('/doctor/api/prescriptions/(:num)', 'DoctorDashboardController::getPrescription/$1');
$routes->put('/doctor/api/prescriptions/(:num)', 'DoctorDashboardController::updatePrescription/$1');
$routes->delete('/doctor/api/prescriptions/(:num)', 'DoctorDashboardController::deletePrescription/$1');
$routes->get('/doctor/api/prescriptions/search', 'DoctorDashboardController::searchPrescriptions');

// Doctor API Routes - Medical Notes
$routes->post('/doctor/api/medical-notes', 'DoctorDashboardController::addMedicalNote');
$routes->get('/doctor/api/medical-notes/patient/(:num)', 'DoctorDashboardController::getPatientMedicalNotes/$1');

// Doctor API Routes - Dashboard
$routes->get('/doctor/api/dashboard/stats', 'DoctorDashboardController::getDashboardStats');

// Dashboard routes
$routes->get('dashboard', 'DashboardController::index');
$routes->get('dashboard/profile', 'DashboardController::profile');
$routes->post('dashboard/profile', 'DashboardController::updateProfile');

// User Management routes (Admin and IT Staff only)
$routes->group('user-management', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'UserManagementController::index');
    $routes->get('create', 'UserManagementController::create');
    $routes->post('create', 'UserManagementController::create');
    $routes->get('edit/(:num)', 'UserManagementController::edit/$1');
    $routes->post('edit/(:num)', 'UserManagementController::edit/$1');
    $routes->get('delete/(:num)', 'UserManagementController::delete/$1');
});

// Default route - redirect to login
$routes->get('/', 'AuthController::index');
