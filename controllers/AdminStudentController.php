<?php
require_once 'models/Student.php';
require_once 'models/Booking.php';

class AdminStudentController extends Controller {
    private $studentModel;
    private $bookingModel;

    public function __construct() {
        $this->studentModel = new Student();
        $this->bookingModel = new Booking();
    }

    public function index() {
        $this->requireLogin('admin');
        
        $students = $this->studentModel->getAllStudentsWithBookings();
        
        $this->view('admin/students', [
            'title' => 'Manage Students - ' . APP_NAME,
            'students' => $students,
            'admin' => $_SESSION['admin_data']
        ]);
    }

    public function resetPassword() {
        $this->requireLogin('admin');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $student_id = $_POST['student_id'];
            $new_password = $_POST['new_password'] ?? 'student123';
            
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            
            if ($this->studentModel->update($student_id, ['password' => $hashed_password])) {
                $_SESSION['success'] = 'Password reset successfully. New password: ' . $new_password;
            } else {
                $_SESSION['error'] = 'Failed to reset password';
            }
        }
        
        $this->redirect('admin/students');
    }

    public function viewStudent() {
        $this->requireLogin('admin');
        
        $student_id = $_GET['id'] ?? 0;
        $student = $this->studentModel->find($student_id);
        
        if (!$student) {
            $_SESSION['error'] = 'Student not found';
            $this->redirect('admin/students');
            return;
        }
        
        $bookings = $this->bookingModel->getStudentBookings($student_id);
        
        $this->view('admin/student-details', [
            'title' => 'Student Details - ' . APP_NAME,
            'student' => $student,
            'bookings' => $bookings,
            'admin' => $_SESSION['admin_data']
        ]);
    }
}
?>