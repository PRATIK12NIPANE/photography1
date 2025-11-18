<?php
// Email configuration for Gmail SMTP
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'prasadjadhav1554@gmail.com');
define('SMTP_PASSWORD', 'tvhp efpl fmvb mcrl');

// Sender information
define('FROM_EMAIL', 'prasadjadhav1554@gmail.com');
define('FROM_NAME', 'PJ Photography Contact');

// Recipient email (where contact forms are sent)
define('TO_EMAIL', 'prasadjadhav1554@gmail.com');
define('TO_NAME', 'PJ Photography');

function sendContactEmail($name, $email, $message) {
    // Import PHPMailer classes (PHPMailer 6.8.0 with namespaces)
    require_once 'vendor/PHPMailer.php';
    require_once 'vendor/SMTP.php';
    require_once 'vendor/Exception.php';

    // Create PHPMailer instance using fully qualified class name
    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = 0; // Disable verbose debug output for production
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USERNAME;
        $mail->Password   = SMTP_PASSWORD;
        $mail->SMTPSecure = 'tls';
        $mail->Port       = SMTP_PORT;

        // Recipients
        $mail->setFrom(FROM_EMAIL, FROM_NAME);
        $mail->addAddress(TO_EMAIL, TO_NAME);

        // Also reply to the person who sent the contact form
        $mail->addReplyTo($email, $name);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Contact Form Submission - PJ Photography';

        // HTML email body
        $mail->Body = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .header { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 20px; border-radius: 10px 10px 0 0; }
                .content { background: #f9f9f9; padding: 20px; border-radius: 0 0 10px 10px; }
                .field { margin-bottom: 15px; }
                .label { font-weight: bold; color: #555; }
                .value { background: white; padding: 10px; border-radius: 5px; border-left: 4px solid #f5576c; }
            </style>
        </head>
        <body>
            <div class='header'>
                <h2>📸 New Contact Form Message</h2>
                <p>You have received a new message from your PJ Photography website.</p>
            </div>
            <div class='content'>
                <div class='field'>
                    <div class='label'>👤 Name:</div>
                    <div class='value'>" . htmlspecialchars($name) . "</div>
                </div>
                <div class='field'>
                    <div class='label'>📧 Email:</div>
                    <div class='value'>" . htmlspecialchars($email) . "</div>
                </div>
                <div class='field'>
                    <div class='label'>💬 Message:</div>
                    <div class='value'>" . nl2br(htmlspecialchars($message)) . "</div>
                </div>
                <hr>
                <p><small>This message was sent from the contact form on your website at " . date('Y-m-d H:i:s') . "</small></p>
            </div>
        </body>
        </html>";

        // Plain text version
        $mail->AltBody = "New Contact Form Message from PJ Photography\n\n" .
                        "Name: $name\n" .
                        "Email: $email\n" .
                        "Message:\n$message\n\n" .
                        "Sent at: " . date('Y-m-d H:i:s');

        $mail->send();

        error_log("Email sent successfully from contact form: $email");
        return true;

    } catch (\PHPMailer\PHPMailer\Exception $e) {
        error_log("Email sending failed: " . $mail->ErrorInfo);
        return false;
    }
}
?>
