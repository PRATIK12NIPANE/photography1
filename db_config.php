<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'pj_photography');

// Create connection
function getDBConnection() {
    static $conn = null;

    if ($conn === null) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        // Check connection
        if ($conn->connect_error) {
            error_log("Database connection failed: " . $conn->connect_error);
            die("Sorry, we are experiencing technical difficulties. Please try again later.");
        }

        // Set charset to utf8mb4 for better Unicode support
        $conn->set_charset("utf8mb4");
    }

    return $conn;
}
?>
