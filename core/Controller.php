<?php
class Controller {
    protected function view($view, $data = []) {
        extract($data);
        $view_file = 'views/' . $view . '.php';
        if (file_exists($view_file)) {
            require_once $view_file;
        } else {
            echo "View not found: " . $view;
        }
    }

    protected function redirect($url) {
        $redirect_url = defined('APP_URL') ? APP_URL . $url : 'http://localhost/Ariga\'s-Smart-Hostel-Management-System/' . $url;
        header('Location: ' . $redirect_url);
        exit();
    }

    protected function isLoggedIn($type = 'student') {
        return isset($_SESSION[$type . '_id']);
    }

    protected function requireLogin($type = 'student') {
        if (!$this->isLoggedIn($type)) {
            $this->redirect($type . '/login');
        }
    }
}
?>