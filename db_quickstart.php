<?php
// Quick database initialization and test
echo "<h1>Quick Database Setup</h1>";
echo "<pre>";

// Try to connect and create database directly
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'pj_photography';

echo "Testing connection...\n";

$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
    echo "❌ Connection failed: " . $conn->connect_error . "\n";
    echo "This usually means:\n";
    echo "1. MySQL service is not running\n";
    echo "2. Wrong credentials\n";
    echo "\nPlease:\n";
    echo "- Open XAMPP Control Panel\n";
    echo "- Start MySQL service\n";
    echo "- Then refresh this page\n";
    exit;
}

echo "✅ Connected to MySQL\n";

// Create database
echo "Creating database...\n";
if ($conn->query("CREATE DATABASE IF NOT EXISTS $db")) {
    echo "✅ Database created\n";
} else {
    echo "❌ Database creation failed: " . $conn->error . "\n";
    exit;
}

// Select database
$conn->select_db($db);
echo "✅ Database selected\n";

// Create table
echo "Creating contacts table...\n";
$table_sql = "CREATE TABLE IF NOT EXISTS contacts (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    phone VARCHAR(20),
    wedding_date DATE,
    venue VARCHAR(100),
    days INT,
    service VARCHAR(50),
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($table_sql)) {
    echo "✅ Table created\n";
} else {
    echo "❌ Table creation failed: " . $conn->error . "\n";
    exit;
}

// Test insert
echo "Testing data insertion...\n";
$name = "Test User";
$email = "test@example.com";
$message = "Test message";

$stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $message);

if ($stmt->execute()) {
    echo "✅ Test data inserted (ID: " . $conn->insert_id . ")\n";
} else {
    echo "❌ Insert failed: " . $stmt->error . "\n";
}

$stmt->close();
$conn->close();

echo "\n🎉 Setup complete!\n\n";
echo "Your contact form should now work.\n";
echo "Test it at: contact.php\n\n";

echo "</pre>";
echo "<p><a href='contact.php' style='color: blue; font-size: 16px;'>← Test Contact Form</a></p>";
?>
