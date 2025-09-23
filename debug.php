<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Debug Information</h1>";

echo "<h2>URL Information:</h2>";
echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "URL parameter: " . ($_GET['url'] ?? 'NOT SET') . "<br>";
echo "REQUEST_METHOD: " . $_SERVER['REQUEST_METHOD'] . "<br>";

echo "<h2>POST Data:</h2>";
if (!empty($_POST)) {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
} else {
    echo "No POST data<br>";
}

echo "<h2>Testing Router:</h2>";
$url = $_GET['url'] ?? '';
echo "URL to route: '" . $url . "'<br>";

// Test the router
require_once 'core/Router.php';
$router = new Router();
$router->add('student/authenticate', 'StudentController@authenticate');

echo "<h2>Available Routes:</h2>";
// We can't access private routes property, so let's just test
echo "Testing if 'student/authenticate' route exists...<br>";

try {
    $router->dispatch('student/authenticate');
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>