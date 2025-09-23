<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>PHP Test Page</h1>";
echo "<p>If you see this, PHP is working!</p>";
echo "<p>Current directory: " . __DIR__ . "</p>";

// Test if files exist
$files_to_check = [
    'config/config.php',
    'config/database.php', 
    'core/Router.php',
    'core/Controller.php',
    'core/Model.php'
];

echo "<h2>File Check:</h2>";
foreach($files_to_check as $file) {
    if(file_exists($file)) {
        echo "<p>✅ $file - EXISTS</p>";
    } else {
        echo "<p>❌ $file - MISSING</p>";
    }
}

// Test config loading
echo "<h2>Testing config loading:</h2>";
try {
    require_once 'config/config.php';
    echo "<p>✅ Config loaded successfully</p>";
    echo "<p>APP_NAME: " . (defined('APP_NAME') ? APP_NAME : 'NOT DEFINED') . "</p>";
} catch(Exception $e) {
    echo "<p>❌ Config error: " . $e->getMessage() . "</p>";
}
?>