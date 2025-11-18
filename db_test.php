<?php
// Enable error reporting for testing
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include database configuration
include 'db_config.php';

// Test database connection
echo "<h1>Database Connection Test</h1>";

try {
    $conn = getDBConnection();
    echo "<p style='color: green;'>✓ Database connection successful!</p>";

    // Test if the contacts table exists
    $table_check = $conn->query("SHOW TABLES LIKE 'contacts'");
    if ($table_check->num_rows > 0) {
        echo "<p style='color: green;'>✓ Contacts table exists!</p>";

        // Show table structure
        echo "<h2>Contacts Table Structure:</h2>";
        $result = $conn->query("DESCRIBE contacts");
        if ($result->num_rows > 0) {
            echo "<table border='1' cellpadding='5' cellspacing='0'>";
            echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['Field']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Type']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Null']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Key']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Default'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['Extra'] ?? '') . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    } else {
        echo "<p style='color: red;'>✗ Contacts table does not exist!</p>";
        echo "<p>You need to run <code>db_setup.php</code> first to create the database structure.</p>";
    }

} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Database connection failed: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p>Make sure MySQL service is running in XAMPP control panel.</p>";
}

echo "<hr>";
echo "<p><strong>Database Configuration:</strong></p>";
echo "<ul>";
echo "<li>Host: " . htmlspecialchars(DB_HOST) . "</li>";
echo "<li>Database: " . htmlspecialchars(DB_NAME) . "</li>";
echo "<li>User: " . htmlspecialchars(DB_USER) . "</li>";
echo "<li>Password: " . htmlspecialchars(DB_PASS ? '******' : '(empty)') . "</li>";
echo "</ul>";
?>
