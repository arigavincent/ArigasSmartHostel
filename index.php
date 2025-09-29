<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once 'config/config.php';
require_once 'config/database.php';
require_once 'core/Router.php';
require_once 'core/Controller.php';
require_once 'core/Model.php';

// Get the URL
$url = $_GET['url'] ?? '';

// Initialize router
$router = new Router();

// Define routes
$router->add('', 'HomeController@index');
$router->add('student/login', 'StudentController@loginForm');
$router->add('student/register', 'StudentController@registerForm');
$router->add('student/authenticate', 'StudentController@authenticate');
$router->add('student/store', 'StudentController@register');
$router->add('student/rooms', 'RoomController@index');
$router->add('student/room-details', 'RoomController@show');
$router->add('student/book', 'BookingController@create');
$router->add('student/book/store', 'BookingController@store');
$router->add('student/bookings', 'BookingController@index');
$router->add('student/cancel-booking', 'BookingController@cancel');
$router->add('student/payments', 'StudentPaymentController@index');
$router->add('student/make-payment', 'StudentPaymentController@pay');
$router->add('student/process-payment', 'StudentPaymentController@processPayment');
$router->add('student/payment-history', 'StudentPaymentController@history');
$router->add('student/profile', 'StudentProfileController@index');
$router->add('student/update-profile', 'StudentProfileController@update');
$router->add('student/change-password', 'StudentProfileController@changePassword');
$router->add('student/dashboard', 'StudentController@dashboard');
$router->add('student/logout', 'StudentController@logout');
$router->add('admin/login', 'AdminController@loginForm');
$router->add('admin/authenticate', 'AdminController@authenticate');
$router->add('admin/dashboard', 'AdminController@dashboard');
$router->add('admin/logout', 'AdminController@logout');
$router->add('admin/rooms', 'AdminRoomController@index');
$router->add('admin/rooms/create', 'AdminRoomController@create');
$router->add('admin/rooms/store', 'AdminRoomController@store');
$router->add('admin/rooms/edit', 'AdminRoomController@edit');
$router->add('admin/rooms/update', 'AdminRoomController@update');
$router->add('admin/rooms/delete', 'AdminRoomController@delete');
$router->add('admin/bookings', 'AdminRoomController@bookings');
$router->add('admin/update-payment', 'AdminRoomController@updatePayment');
$router->add('admin/students', 'AdminStudentController@index');
$router->add('admin/student-details', 'AdminStudentController@viewStudent');
$router->add('admin/reset-password', 'AdminStudentController@resetPassword');
$router->add('admin/reports', 'AdminReportsController@index');

// --- Student Clearance Routes ---
$router->add('student/clearance', 'StudentClearanceController@index');
$router->add('student/request-clearance', 'StudentClearanceController@requestForm');
$router->add('student/submit-clearance', 'StudentClearanceController@submitRequest');
$router->add('student/clearance-certificate', 'StudentClearanceController@viewClearance');

// --- Admin Clearance Routes ---
$router->add('admin/clearance-requests', 'AdminClearanceController@index');
$router->add('admin/review-clearance', 'AdminClearanceController@review');
$router->add('admin/approve-clearance', 'AdminClearanceController@approve');
$router->add('admin/reject-clearance', 'AdminClearanceController@reject');
$router->add('admin/download-clearance-pdf', 'AdminClearanceController@downloadPDF');


// Dispatch the route
$router->dispatch($url);
?>