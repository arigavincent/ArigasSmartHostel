<?php
require_once 'models/Admin.php';

class AdminProfileController extends Controller {
    private $adminModel;

    public function __construct() {
        $this->adminModel = new Admin();
    }

    public function index() {
        $this->requireLogin('admin');

        $this->view('admin/profile', [
            'title' => 'Admin Profile - ' . APP_NAME,
            'admin' => $_SESSION['admin_data']
        ]);
    }

    public function update() {
        $this->requireLogin('admin');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $admin_id = $_SESSION['admin_id'];
            $data = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email'])
            ];

            // Check for duplicates
            $existing_admin = $this->adminModel->findByUsername($data['username']);
            if ($existing_admin && $existing_admin['id'] != $admin_id) {
                $_SESSION['error'] = 'Username is already taken by another admin';
                return $this->redirect('admin/profile');
            }

            $existing_email = $this->adminModel->findByEmail($data['email']);
            if ($existing_email && $existing_email['id'] != $admin_id) {
                $_SESSION['error'] = 'Email address is already taken by another admin';
                return $this->redirect('admin/profile');
            }

            if ($this->adminModel->update($admin_id, $data)) {
                $_SESSION['admin_data'] = $this->adminModel->find($admin_id);
                $_SESSION['success'] = 'Profile updated successfully';
            } else {
                $_SESSION['error'] = 'Failed to update profile';
            }

            $this->redirect('admin/profile');
        } else {
            $this->redirect('admin/profile');
        }
    }

    public function changePassword() {
        $this->requireLogin('admin');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $admin_id = $_SESSION['admin_id'];
            $current_password = $_POST['current_password'];
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            $admin = $this->adminModel->find($admin_id);

            if (!password_verify($current_password, $admin['password'])) {
                $_SESSION['error'] = 'Current password is incorrect';
                return $this->redirect('admin/profile');
            }

            if ($new_password !== $confirm_password) {
                $_SESSION['error'] = 'New passwords do not match';
                return $this->redirect('admin/profile');
            }

            if (strlen($new_password) < 6) {
                $_SESSION['error'] = 'New password must be at least 6 characters long';
                return $this->redirect('admin/profile');
            }

            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            if ($this->adminModel->update($admin_id, ['password' => $hashed_password])) {
                $_SESSION['success'] = 'Password changed successfully';
            } else {
                $_SESSION['error'] = 'Failed to change password';
            }

            $this->redirect('admin/profile');
        } else {
            $this->redirect('admin/profile');
        }
    }

    public function manageAdmins() {
        $this->requireLogin('admin');

        if ($_SESSION['admin_data']['role'] !== 'super_admin') {
            $_SESSION['error'] = 'Access denied. Only super admins can manage other admins.';
            return $this->redirect('admin/dashboard');
        }

        $admins = $this->adminModel->findAll();

        $this->view('admin/manage-admins', [
            'title' => 'Manage Admins - ' . APP_NAME,
            'admins' => $admins,
            'admin' => $_SESSION['admin_data']
        ]);
    }

    public function addAdmin() {
        $this->requireLogin('admin');

        if ($_SESSION['admin_data']['role'] !== 'super_admin') {
            $_SESSION['error'] = 'Access denied. Only super admins can add new admins.';
            return $this->redirect('admin/dashboard');
        }

        $this->view('admin/add-admin', [
            'title' => 'Add New Admin - ' . APP_NAME,
            'admin' => $_SESSION['admin_data']
        ]);
    }

    public function storeAdmin() {
        $this->requireLogin('admin');

        if ($_SESSION['admin_data']['role'] !== 'super_admin') {
            $_SESSION['error'] = 'Access denied';
            return $this->redirect('admin/dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            if ($password !== $confirm_password) {
                $_SESSION['error'] = 'Passwords do not match';
                return $this->redirect('admin/add-admin');
            }

            if (strlen($password) < 8) {
                $_SESSION['error'] = 'Password must be at least 8 characters long';
                return $this->redirect('admin/add-admin');
            }

            $data = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role' => $_POST['role']
            ];

            if ($this->adminModel->findByUsername($data['username'])) {
                $_SESSION['error'] = 'Username already exists';
                return $this->redirect('admin/add-admin');
            }

            if ($this->adminModel->findByEmail($data['email'])) {
                $_SESSION['error'] = 'Email already exists';
                return $this->redirect('admin/add-admin');
            }

            if ($this->adminModel->create($data)) {
                $this->sendWelcomeEmail($data['email'], $data['username'], $_POST['password']);

                $_SESSION['success'] = 'New administrator "' . $data['username'] . '" created successfully!';
                return $this->redirect('admin/manage-admins');
            } else {
                $_SESSION['error'] = 'Failed to create administrator account';
                return $this->redirect('admin/add-admin');
            }
        } else {
            $this->redirect('admin/add-admin');
        }
    }

    public function deleteAdmin() {
        $this->requireLogin('admin');

        if ($_SESSION['admin_data']['role'] !== 'super_admin') {
            $_SESSION['error'] = 'Access denied';
            return $this->redirect('admin/manage-admins');
        }

        $admin_id = $_GET['id'] ?? 0;
        $admin_to_delete = $this->adminModel->find($admin_id);

        if (!$admin_to_delete) {
            $_SESSION['error'] = 'Admin not found';
            return $this->redirect('admin/manage-admins');
        }

        if ($admin_id == $_SESSION['admin_id']) {
            $_SESSION['error'] = 'You cannot delete your own account';
            return $this->redirect('admin/manage-admins');
        }

        if ($this->adminModel->delete($admin_id)) {
            $_SESSION['success'] = 'Admin deleted successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete admin';
        }

        $this->redirect('admin/manage-admins');
    }

    private function sendWelcomeEmail($email, $username, $password) {
        // Simulate email sending
        $_SESSION['email_sent'] = "Welcome email sent to $email for $username";
    }
}
