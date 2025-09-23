<?php
require_once 'models/Admin.php';

class AdminController extends Controller {
    private $adminModel;

    public function __construct() {
        $this->adminModel = new Admin();
    }

    public function loginForm() {
        if ($this->isLoggedIn('admin')) {
            $this->redirect('admin/dashboard');
        }
        
        $this->view('admin/login', [
            'title' => 'Admin Login - ' . APP_NAME
        ]);
    }

    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']); // Fixed the trimming issue you mentioned
            
            // Find admin by email
            $admin = $this->adminModel->findByEmail($email);
            
            if ($admin && password_verify($password, $admin['password'])) {
                // Login successful
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_data'] = $admin;
                $_SESSION['user_type'] = 'admin';
                
                $this->redirect('admin/dashboard');
            } else {
                // Login failed
                $_SESSION['admin_login_error'] = 'Invalid email or password';
                $this->redirect('admin/login');
            }
        } else {
            $this->redirect('admin/login');
        }
    }

    public function logout() {
        session_destroy();
        $this->redirect('');
    }

    public function dashboard() {
        $this->requireLogin('admin');
        
        $this->view('admin/dashboard', [
            'title' => 'Admin Dashboard - ' . APP_NAME,
            'admin' => $_SESSION['admin_data']
        ]);
    }
}
?>