<?php
// Comprehensive database troubleshooting script
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>Database Connection Troubleshooting</h1>";
echo "<style>body { font-family: Arial, sans-serif; margin: 20px; } .error { color: red; } .success { color: green; } .info { color: blue; }</style>";

// Step 1: Test basic PHP MySQL extension
echo "<h2>Step 1: PHP Extensions</h2>";
if (extension_loaded('mysqli')) {
    echo "<p class='success'>✓ MySQLi extension is loaded</p>";
} else {
    echo "<p class='error'>✗ MySQLi extension is NOT loaded</p>";
    echo "<p>This is required for database connections.</p>";
    exit;
}

// Step 2: Test direct database connection with manual credentials
echo "<h2>Step 2: Basic Connection Test</h2>";

// Try different possible configurations
$configs = [
    ['host' => 'localhost', 'user' => 'root', 'pass' => '', 'db' => 'pj_photography'],
    ['host' => '127.0.0.1', 'user' => 'root', 'pass' => '', 'db' => 'pj_photography'],
    ['host' => 'localhost', 'user' => 'root', 'pass' => 'root', 'db' => 'pj_photography'],
];

$working_config = null;

foreach ($configs as $i => $config) {
    echo "<h3>Testing Configuration " . ($i + 1) . ":</h3>";
    echo "<ul>";
    echo "<li>Host: <code>" . htmlspecialchars($config['host']) . "</code></li>";
    echo "<li>User: <code>" . htmlspecialchars($config['user']) . "</code></li>";
    echo "<li>Password: <code>" . (empty($config['pass']) ? '(empty)' : '******') . "</code></li>";
    echo "<li>Database: <code>" . htmlspecialchars($config['db']) . "</code></li>";
    echo "</ul>";

    try {
        $test_conn = new mysqli($config['host'], $config['user'], $config['pass']);

        if ($test_conn->connect_error) {
            echo "<p class='error'>✗ Connection failed: " . htmlspecialchars($test_conn->connect_error) . "</p>";
        } else {
            echo "<p class='success'>✓ Basic connection successful!</p>";

            // Try to select database
            if ($test_conn->select_db($config['db'])) {
                echo "<p class='success'>✓ Database selection successful!</p>";
                $working_config = $config;

                // Test table existence
                $result = $test_conn->query("SHOW TABLES LIKE 'contacts'");
                if ($result && $result->num_rows > 0) {
                    echo "<p class='success'>✓ Contacts table exists!</p>";
                } else {
                    echo "<p class='error'>✗ Contacts table does NOT exist!</p>";
                }

            } else {
                echo "<p class='error'>✗ Database selection failed: " . htmlspecialchars($test_conn->error) . "</p>";
                echo "<p>Creating database...</p>";

                // Try to create database
                $create_sql = "CREATE DATABASE IF NOT EXISTS pj_photography";
                if ($test_conn->query($create_sql)) {
                    echo "<p class='success'>✓ Database created!</p>";
                    $working_config = $config;

                    // Select the database
                    $test_conn->select_db($config['db']);

                    // Create the contacts table
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

                    if ($test_conn->query($table_sql)) {
                        echo "<p class='success'>✓ Contacts table created!</p>";
                    } else {
                        echo "<p class='error'>✗ Table creation failed: " . htmlspecialchars($test_conn->error) . "</p>";
                    }
                } else {
                    echo "<p class='error'>✗ Database creation failed: " . htmlspecialchars($test_conn->error) . "</p>";
                }
            }
        }

        $test_conn->close();

    } catch (Exception $e) {
        echo "<p class='error'>✗ Exception: " . htmlspecialchars($e->getMessage()) . "</p>";
    }

    echo "<hr>";
}

// Step 3: Update configuration file if we found a working config
if ($working_config) {
    echo "<h2>Step 3: Update Configuration</h2>";

    $config_content = "<?php
// Database configuration - UPDATED BY TROUBLESHOOTING
define('DB_HOST', '" . addslashes($working_config['host']) . "');
define('DB_USER', '" . addslashes($working_config['user']) . "');
define('DB_PASS', '" . addslashes($working_config['pass']) . "');
define('DB_NAME', '" . addslashes($working_config['db']) . "');

// Create connection
function getDBConnection() {
    static \$conn = null;

    if (\$conn === null) {
        \$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        // Check connection
        if (\$conn->connect_error) {
            error_log('Database connection failed: ' . \$conn->connect_error);
            die('Sorry, we are experiencing technical difficulties. Please try again later.');
        }

        // Set charset to utf8mb4 for better Unicode support
        \$conn->set_charset('utf8mb4');
    }

    return \$conn;
}
?>";

    if (file_put_contents('db_config.php', $config_content)) {
        echo "<p class='success'>✓ Configuration file updated!</p>";
    } else {
        echo "<p class='error'>✗ Could not update configuration file. Please check file permissions.</p>";
    }

    echo "<h3>Final Test</h3>";
    echo "<p><a href='db_test.php'>Click here to run the final connectivity test</a></p>";
    echo "<p><a href='contact.php'>Then try the contact form</a></p>";

} else {
    echo "<h2 class='error'>No working configuration found!</h2>";
    echo "<p class='error'>Please check:</p>";
    echo "<ul>";
    echo "<li>Is MySQL service running in XAMPP control panel?</li>";
    echo "<li>Are you using XAMPP 7.4 or later?</li>";
    echo "<li>Does the root user have a password set?</li>";
    echo "<li>Are there firewall or antivirus blocking MySQL?</li>";
    echo "</ul>";
}
?>
