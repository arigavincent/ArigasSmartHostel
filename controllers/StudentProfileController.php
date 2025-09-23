<?php
require_once 'models/Student.php';

class StudentProfileController extends Controller {
    private $studentModel;

    public function __construct() {
        $this->studentModel = new Student();
    }

    public function index() {
        $this->requireLogin('student');
        
        $this->view('student/profile', [
            'title' => 'My Profile - ' . APP_NAME,
            'student' => $_SESSION['student_data']
        ]);
    }

    public function update() {
        $this->requireLogin('student');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $student_id = $_SESSION['student_id'];
            
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'address' => trim($_POST['address'])
            ];
            
            // Check if email is already taken by another student
            $existing_student = $this->studentModel->findByEmail($data['email']);
            if ($existing_student && $existing_student['id'] != $student_id) {
                $_SESSION['error'] = 'Email address is already taken by another student';
                $this->redirect('student/profile');
                return;
            }
            
            if ($this->studentModel->update($student_id, $data)) {
                // Update session data
                $_SESSION['student_data'] = $this->studentModel->find($student_id);
                $_SESSION['success'] = 'Profile updated successfully';
            } else {
                $_SESSION['error'] = 'Failed to update profile';
            }
            
            $this->redirect('student/profile');
        } else {
            $this->redirect('student/profile');
        }
    }

    public function changePassword() {
        $this->requireLogin('student');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $student_id = $_SESSION['student_id'];
            $current_password = $_POST['current_password'];
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];
            
            // Get current student data
            $student = $this->studentModel->find($student_id);
            
            // Verify current password
            if (!password_verify($current_password, $student['password'])) {
                $_SESSION['error'] = 'Current password is incorrect';
                $this->redirect('student/profile');
                return;
            }
            
            // Check if new passwords match
            if ($new_password !== $confirm_password) {
                $_SESSION['error'] = 'New passwords do not match';
                $this->redirect('student/profile');
                return;
            }
            
            // Check password length
            if (strlen($new_password) < 6) {
                $_SESSION['error'] = 'New password must be at least 6 characters long';
                $this->redirect('student/profile');
                return;
            }
            
            // Update password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            if ($this->studentModel->update($student_id, ['password' => $hashed_password])) {
                $_SESSION['success'] = 'Password changed successfully';
            } else {
                $_SESSION['error'] = 'Failed to change password';
            }
            
            $this->redirect('student/profile');
        } else {
            $this->redirect('student/profile');
        }
    }
}
?>