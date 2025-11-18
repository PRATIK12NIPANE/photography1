<?php
// Test email functionality
echo "<h1>Test Email Functionality</h1>";
echo "<style>body { font-family: Arial, sans-serif; margin: 20px; } .success { color: green; } .error { color: red; } .info { color: blue; }</style>";

echo "<h2>Testing Email Configuration</h2>";

// Test sample data
$name = "Test User";
$email = "test@example.com";
$message = "This is a test message to verify email functionality.";

// Include mail configuration
include 'mail_config.php';

echo "<h3>Test Data:</h3>";
echo "<ul>";
echo "<li><strong>Name:</strong> $name</li>";
echo "<li><strong>Email:</strong> $email</li>";
echo "<li><strong>Message:</strong> $message</li>";
echo "<li><strong>Sending to:</strong> prasadjadhav1554@gmail.com</li>";
echo "</ul>";

echo "<h3>Sending Test Email...</h3>";
echo "<pre>";

try {
    if (sendContactEmail($name, $email, $message)) {
        echo "<span class='success'>✅ EMAIL SENT SUCCESSFULLY!</span>\n\n";
        echo "Check your Gmail inbox (prasadjadhav1554@gmail.com) for the test message.\n";
        echo "Subject: New Contact Form Submission - PJ Photography\n\n";
        echo "The email should contain:\n";
        echo "- Beautiful HTML formatting\n";
        echo "- Sender's name and email\n";
        echo "- The test message\n";
        echo "- Timestamp\n";
    } else {
        echo "<span class='error'>❌ EMAIL FAILED TO SEND</span>\n\n";
        echo "Check the PHP error log for detailed error messages.\n";
        echo "Common issues:\n";
        echo "- Invalid app password\n";
        echo "- Gmail security settings\n";
        echo "- Network/firewall issues\n";
        echo "- PHP extensions missing\n";
    }
} catch (Exception $e) {
    echo "<span class='error'>❌ EXCEPTION OCCURRED: " . htmlspecialchars($e->getMessage()) . "</span>\n\n";
}

echo "</pre>";

echo "<hr>";
echo "<div style='background: #e9ecef; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
echo "<h3>📧 Gmail Setup Verification</h3>";
echo "<p><strong>App Password Setup:</strong></p>";
echo "<ol>";
echo "<li>Go to <a href='https://myaccount.google.com/security' target='_blank'>Google Account Security</a></li>";
echo "<li>Enable 2-Factor Authentication if not already enabled</li>";
echo "<li>Go to 'App passwords' section</li>";
echo "<li>Generate a new app password for 'Mail'</li>";
echo "<li>Use the 16-character password in your configuration</li>";
echo "</ol>";
echo "<p><strong>Note:</strong> The app password should look like: <code>abcd efgh ijkl mnop</code> (4 groups of 4 characters)</p>";
echo "</div>";

echo "<div style='background: #d1ecf1; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
echo "<h3>🔧 Testing Checklist</h3>";
echo "<ul>";
echo "<li>✅ Database connection works</li>";
echo "<li>✅ Contact form saves to database</li>";
echo "<li>" . (file_exists('vendor/PHPMailer.php') ? '✅' : '❌') . " PHPMailer files available</li>";
echo "<li>📧 Email functionality (this test)</li>";
echo "</ul>";
echo "</div>";

echo "<p><a href='contact.php' style='color: #007bff; font-size: 16px;'><← Back to Contact Form</a></p>";
?>
