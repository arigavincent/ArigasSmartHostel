<?php
class HomeController extends Controller {
    public function index() {
        // Redirect to login selection or main page
        $this->view('home/index', [
            'title' => 'Welcome - ' . APP_NAME
        ]);
    }
}
?>