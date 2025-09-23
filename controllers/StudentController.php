<?php
require_once 'models/Student.php';
require_once 'models/Booking.php';

class StudentController extends Controller {
    private $studentModel;

    public function __construct() {
        $this->studentModel = new Student();
    }

    public function loginForm() {
        if ($this->isLoggedIn('student')) {
            $this->redirect('student/dashboard');
        }
        
        $this->view('student/login', [
            'title' => 'Student Login - ' . APP_NAME
        ]);
    }

    public function registerForm() {
        if ($this->isLoggedIn('student')) {
            $this->redirect('student/dashboard');
        }
        
        $this->view('student/register', [
            'title' => 'Student Registration - ' . APP_NAME
        ]);
    }

    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']) ?? '';
            $password = trim($_POST['password']) ?? '';
            
            // Find student by email
            $student = $this->studentModel->findByEmail($email);
            
            if ($student && password_verify($password, $student['password'])) {
                // Login successful
                $_SESSION['student_id'] = $student['id'];
                $_SESSION['student_data'] = $student;
                $_SESSION['user_type'] = 'student';
                
                $this->redirect('student/dashboard');
            } else {
                // Login failed
                $_SESSION['login_error'] = 'Invalid email or password';
                $this->redirect('student/login');
            }
        } else {
            $this->redirect('student/login');
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'student_id' => trim($_POST['student_id']),
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'phone' => trim($_POST['phone']),
                'address' => trim($_POST['address'])
            ];
            
            // Check if email or student_id already exists
            if ($this->studentModel->findByEmail($data['email'])) {
                $_SESSION['register_error'] = 'Email already exists';
                $this->redirect('student/register');
                return;
            }
            
            if ($this->studentModel->findByStudentId($data['student_id'])) {
                $_SESSION['register_error'] = 'Student ID already exists';
                $this->redirect('student/register');
                return;
            }
            
            if ($this->studentModel->create($data)) {
                $_SESSION['register_success'] = 'Registration successful! You can now login.';
                $this->redirect('student/login');
            } else {
                $_SESSION['register_error'] = 'Registration failed. Please try again.';
                $this->redirect('student/register');
            }
        } else {
            $this->redirect('student/register');
        }
    }

    public function logout() {
        session_destroy();
        $this->redirect('');
    }

    public function dashboard() {
        $this->requireLogin('student');
        $student_id = $_SESSION['student_id'];
        $bookings = (new Booking())->getStudentBookings($student_id);
        $current_booking = null;
        foreach ($bookings as $b) {
            if ($b['booking_status'] === 'active') {
                $current_booking = $b;
                break;
            }
        }
        $this->view('student/dashboard', [
            'title' => 'Dashboard - ' . APP_NAME,
            'student' => $_SESSION['student_data'],
            'current_booking' => $current_booking,
            'bookings' => $bookings
        ]);
    }
}
?>