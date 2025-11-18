<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include database configuration
include 'db_config.php';

echo "<h1>Contact Form Debug Test</h1>";

// Test database connection first
try {
    echo "<h2>Testing Database Connection...</h2>";
    $conn = getDBConnection();
    echo "<p style='color: green;'>✓ Database connection successful!</p>";

    // Test if database exists
    $db_check = $conn->query("SELECT DATABASE()");
    $current_db = $db_check->fetch_row()[0];
    echo "<p>Current database: <strong>" . htmlspecialchars($current_db) . "</strong></p>";

    // Test if contacts table exists
    $table_check = $conn->query("SHOW TABLES LIKE 'contacts'");
    if ($table_check->num_rows > 0) {
        echo "<p style='color: green;'>✓ Contacts table exists!</p>";
    } else {
        echo "<p style='color: red;'>✗ Contacts table does not exist!</p>";
        echo "<p><a href='db_setup.php'>Click here to create the table</a></p>";
    }

    echo "<hr>";

} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Database connection failed: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p>Database configuration:</p>";
    echo "<ul>";
    echo "<li>Host: " . htmlspecialchars(DB_HOST) . "</li>";
    echo "<li>Database: " . htmlspecialchars(DB_NAME) . "</li>";
    echo "<li>User: " . htmlspecialchars(DB_USER) . "</li>";
    echo "<li>Password: " . htmlspecialchars(DB_PASS ? '******' : '(empty)') . "</li>";
    echo "</ul>";
    echo "<p><strong>Troubleshooting:</strong></p>";
    echo "<ul>";
    echo "<li>Make sure MySQL service is running in XAMPP control panel</li>";
    echo "<li>Try accessing <a href='db_setup.php'>db_setup.php</a> first to create the database</li>";
    echo "<li>Check if the password for root user is correct (usually empty in XAMPP)</li>";
    echo "</ul>";
    exit;
}

// Now test the form logic with sample data
echo "<h2>Testing Form Submission Logic...</h2>";

$name = "Test User";
$email = "test@example.com";
$message_content = "This is a test message";

try {
    // Get database connection
    $conn = getDBConnection();

    // Prepare and bind the insert statement
    $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message_content);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<p style='color: green;'>✓ Test data inserted successfully!</p>";
    } else {
        echo "<p style='color: red;'>✗ Insert failed: " . htmlspecialchars($stmt->error) . "</p>";
    }

    // Close statement
    $stmt->close();

} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Form submission test failed: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<hr><p><a href='contact.php'>← Back to Contact Form</a></p>";
?>
