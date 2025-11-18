<?php
// Enable error reporting for development
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include database configuration
include 'db_config.php';

// Initialize variables
$success_message = '';
$error_message = '';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message_content = trim($_POST['message'] ?? '');

    // Basic validation
    $errors = [];

    if (empty($name)) {
        $errors[] = "Name is required";
    }

    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    if (empty($message_content)) {
        $errors[] = "Message is required";
    }

    // If no validation errors, process submission
    if (empty($errors)) {
        $dbSuccess = false;
        $emailSuccess = false;

        try {
            // Step 1: Save to database
            $conn = getDBConnection();
            $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $message_content);

            if ($stmt->execute()) {
                $dbSuccess = true;
                error_log("Contact form data saved to database for: $email");
            } else {
                error_log("Database insert error: " . $stmt->error);
            }
            $stmt->close();

        } catch (Exception $e) {
            error_log("Database error: " . $e->getMessage());
        }

        try {
            // Step 2: Send email notification
            include 'mail_config.php';

            if (sendContactEmail($name, $email, $message_content)) {
                $emailSuccess = true;
                error_log("Contact form email sent successfully to: prasadjadhav1554@gmail.com");
            } else {
                error_log("Failed to send contact form email");
            }

        } catch (Exception $e) {
            error_log("Email sending error: " . $e->getMessage());
        }

        // Step 3: Determine success/failure response
        if ($dbSuccess && $emailSuccess) {
            $success_message = "Thank you for your message! We have received your inquiry and will get back to you within 24 hours.";
        } elseif ($dbSuccess && !$emailSuccess) {
            $success_message = "Thank you for your message! Your inquiry has been saved and we will get back to you within 24 hours.";
        } elseif (!$dbSuccess && $emailSuccess) {
            $success_message = "Thank you for your message! We have received your inquiry and will get back to you within 24 hours.";
        } else {
            $error_message = "Sorry, there was an error processing your message. Please try again or contact us directly at info@pjphotography.com";
        }

        // Clear form data on successful processing
        if ($dbSuccess || $emailSuccess) {
            $name = $email = $message_content = '';
        }

    } else {
        $error_message = "Please correct the following errors: " . implode(", ", $errors);
    }
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="ember" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Contact - PJ Photography</title>
    <meta name="description" content="Get in touch with PJ Photography for your wedding photography needs.">
    <!-- Tailwind + DaisyUI -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <!-- GSAP -->
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>

    <!-- Vanilla Tilt -->
    <script src="https://cdn.jsdelivr.net/npm/vanilla-tilt@1.8.1/dist/vanilla-tilt.min.js"></script>

    <style>
      :root {
        --primary: #ff4500; --accent: #ff8c00; --bg: #0a0a0a; --card: rgba(30,30,30,0.6); --text: #f5f5f5; --glass: rgba(255,255,255,0.05);
      }
      [data-theme="arctic"] { --primary: #00eaff; --accent: #00bfff; --bg: #0f1b2e; --card: rgba(20,40,70,0.5); }
      [data-theme="forest"] { --primary: #1a5f3d; --accent: #2d9d6b; --bg: #0f2419; --card: rgba(20,50,35,0.6); }
      [data-theme="cosmic"] { --primary: #8b5cf6; --accent: #c084fc; --bg: #0f0a1a; --card: rgba(35,20,60,0.5); }
      [data-theme="sunset"] { --primary: #ff6b35; --accent: #ffb800; --bg: #1a0d05; --card: rgba(50,25,15,0.6); }
      [data-theme="midnight"] { --primary: #e91e63; --accent: #ff4081; --bg: #0a0014; --card: rgba(40,10,30,0.6); }
      [data-theme="steel"] { --primary: #636e72; --accent: #b2bec3; --bg: #1e272e; --card: rgba(40,50,55,0.6); }
      [data-theme="golden"] { --primary: #d4a017; --accent: #f4d03f; --bg: #2c1a0d; --card: rgba(60,40,20,0.6); }

      body { background: var(--bg); color: var(--text); font-family: 'Inter', sans-serif; }
      .glass { backdrop-filter: blur(16px); background: var(--glass); border: 1px solid rgba(255,255,255,0.1); }
      .mesh-bg { background: radial-gradient(circle at 20% 80%, var(--primary)15, transparent 50%),
                         radial-gradient(circle at 80% 20%, var(--accent)15, transparent 50%),
                         radial-gradient(circle at 40% 40%, #ffffff08, transparent 50%); }
      .tilt { transition: transform 0.3s; }
      .magnetic { transition: transform 0.2s ease-out; }
      #cursor { position: fixed; width: 14px; height: 14px; background: var(--accent); border-radius: 50%; pointer-events: none; z-index: 9999; transform: translate(-50%, -50%); mix-blend-mode: difference; }
      .theme-btn { width: 32px; height: 32px; border-radius: 50%; border: 2px solid rgba(255,255,255,0.2); cursor: pointer; transition: all 0.3s; }
      .theme-btn.active { border-color: white; transform: scale(1.2); box-shadow: 0 0 15px var(--accent); }
    </style>
</head>
<body class="min-h-screen overflow-x-hidden">

    <!-- Cursor -->
    <div id="cursor"></div>

    <!-- NAVBAR -->
    <nav class="fixed top-0 w-full z-50 glass border-b border-white/10">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 flex justify-between items-center h-16">
        <a href="index.php" class="text-xl sm:text-2xl font-bold" style="color: var(--primary);">PJ Photography</a>
        <div class="hidden md:flex items-center gap-6">
          <a href="index.php" class="hover:text-white transition magnetic py-2">Home</a>
          <a href="about.php" class="hover:text-white transition magnetic py-2">About</a>
          <a href="portfolio.php" class="hover:text-white transition magnetic py-2">Portfolio</a>
          <a href="films.php" class="hover:text-white transition magnetic py-2">Films</a>
          <a href="couple-shoot.php" class="hover:text-white transition magnetic py-2">Couple Shoot</a>
          <a href="testimonials.php" class="hover:text-white transition magnetic py-2">Testimonials</a>
          <a href="faq.php" class="hover:text-white transition magnetic py-2">FAQ</a>
          <a href="contact.php" class="text-orange-400 border-b-2 border-orange-400 pb-1 transition magnetic py-2">Contact</a>
        </div>
        <button id="mobile-btn" class="md:hidden text-white p-2 min-h-[44px] min-w-[44px] flex items-center justify-center">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
      </div>
      <!-- Mobile Menu -->
      <div id="mobile-menu" class="md:hidden absolute top-full left-0 w-full bg-black/95 glass backdrop-blur-md border-t border-white/10 p-6 flex flex-col justify-center items-center hidden">
        <a href="index.php" class="text-white hover:text-orange-400 transition py-2 text-center w-full">PJ Photography</a>
        <a href="index.php" class="text-white hover:text-orange-400 transition py-2 text-center w-full">Home</a>
        <a href="about.php" class="text-white hover:text-orange-400 transition py-2 text-center w-full">About</a>
        <a href="portfolio.php" class="text-white hover:text-orange-400 transition py-2 text-center w-full">Portfolio</a>
        <a href="films.php" class="text-white hover:text-orange-400 transition py-2 text-center w-full">Films</a>
        <a href="couple-shoot.php" class="text-white hover:text-orange-400 transition py-2 text-center w-full">Couple Shoot</a>
        <a href="testimonials.php" class="text-white hover:text-orange-400 transition py-2 text-center w-full">Testimonials</a>
        <a href="faq.php" class="text-white hover:text-orange-400 transition py-2 text-center w-full">FAQ</a>
        <a href="contact.php" class="text-white hover:text-orange-400 transition py-2 text-center w-full">Contact</a>
      </div>
    </nav>

    <!-- HERO -->
    <section id="hero" class="hero relative h-screen flex items-center justify-center overflow-hidden mesh-bg">
        <div class="absolute inset-0 opacity-30">
            <img src="images/hero-wedding.jpg" class="w-full h-full object-cover">
        </div>
    <div class="relative text-center px-6 z-10 glass p-8 rounded-3xl shadow-2xl mx-4 max-w-4xl">
            <h1 class="text-6xl md:text-8xl font-bold mb-4 leading-tight">
                <span class="block" style="color: var(--primary);">Contact</span>
                <span class="block" style="color: var(--accent);">Us</span>
            </h1>
            <p class="text-xl md:text-2xl mb-8 max-w-2xl mx-auto opacity-90">Ready to capture your love story? Let's talk about making your wedding memories unforgettable.</p>
        </div>
    </section>

    <!-- CONTACT CONTENT -->
    <section id="contact" class="py-24 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="glass rounded-2xl overflow-hidden tilt p-6 text-center transition-all duration-500">
            <div class="mb-4">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center text-white text-2xl font-bold">✉️</div>
            </div>
            <h3 class="text-2xl font-bold mb-4 text-white">Get in Touch</h3>
            <p class="text-gray-300 leading-relaxed mb-4"><strong>Email:</strong> info@pjphotography.com</p>
            <p class="text-gray-300 leading-relaxed mb-4"><strong>Phone:</strong> +91 98765 43210</p>
            <p class="text-gray-300 leading-relaxed"><strong>Location:</strong> Based in Mumbai, India. We travel worldwide.</p>
        </div>
        <div class="glass rounded-2xl overflow-hidden tilt p-6 text-center transition-all duration-500">
            <div class="mb-4">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-r from-green-400 to-green-600 flex items-center justify-center text-white text-2xl font-bold">🌍</div>
            </div>
            <h3 class="text-2xl font-bold mb-4 text-white">Service Areas</h3>
            <p class="text-gray-300 leading-relaxed mb-4">We serve destinations worldwide including:</p>
            <ul class="text-gray-300 space-y-1 text-left">
                <li>• Mumbai & Maharashtra</li>
                <li>• Goa & Kerala</li>
                <li>• Rajasthan Palaces</li>
                <li>• International Locations</li>
            </ul>
        </div>
        <div class="glass rounded-2xl overflow-hidden tilt p-6 text-center transition-all duration-500">
            <div class="mb-4">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-r from-purple-400 to-purple-600 flex items-center justify-center text-white text-2xl font-bold">⏰</div>
            </div>
            <h3 class="text-2xl font-bold mb-4 text-white">Response Time</h3>
            <p class="text-gray-300 leading-relaxed mb-2">We respond to all inquiries within 24 hours.</p>
            <p class="text-gray-300 leading-relaxed mb-2">Consultations scheduled within 3-5 business days.</p>
            <p class="text-gray-300 leading-relaxed">Custom quotes provided within 48 hours.</p>
        </div>
        <div class="glass rounded-2xl overflow-hidden tilt p-6 text-center transition-all duration-500">
            <div class="mb-4">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-r from-orange-400 to-orange-600 flex items-center justify-center text-white text-2xl font-bold">📅</div>
            </div>
            <h3 class="text-2xl font-bold mb-4 text-white">Business Hours</h3>
            <p class="text-gray-300 leading-relaxed mb-2"><strong>Monday - Friday:</strong> 9:00 AM - 7:00 PM IST</p>
            <p class="text-gray-300 leading-relaxed mb-2"><strong>Saturday:</strong> 10:00 AM - 5:00 PM IST</p>
            <p class="text-gray-300 leading-relaxed"><strong>Sunday:</strong> By appointment only</p>
        </div>
        <div class="glass rounded-2xl overflow-hidden tilt p-6 text-center transition-all duration-500 md:col-span-2 lg:col-span-1">
            <div class="mb-4">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-r from-red-400 to-red-600 flex items-center justify-center text-white text-2xl font-bold">🚨</div>
            </div>
            <h3 class="text-2xl font-bold mb-4 text-white">Emergency Contact</h3>
            <p class="text-gray-300 leading-relaxed mb-4">For urgent wedding inquiries or last-minute bookings:</p>
            <p class="text-gray-300 leading-relaxed mb-2"><strong>Phone:</strong> +91 98765 43210</p>
            <p class="text-gray-300 leading-relaxed"><strong>WhatsApp:</strong> Available 24/7</p>
        </div>
            </div>

            <!-- CONTACT FORM -->
            <div class="mt-12">
                <div class="glass rounded-2xl overflow-hidden tilt max-w-2xl mx-auto p-8 transition-all duration-500">
                    <?php if (!empty($success_message)): ?>
                        <div class="bg-green-600 text-white p-4 rounded-lg mb-6 text-center">
                            <?php echo htmlspecialchars($success_message); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($error_message)): ?>
                        <div class="bg-red-600 text-white p-4 rounded-lg mb-6 text-center">
                            <?php echo htmlspecialchars($error_message); ?>
                        </div>
                    <?php endif; ?>

                    <h2 class="text-3xl font-bold mb-6 text-white text-center">Send us a message</h2>

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="space-y-4 sm:space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Your Name</label>
                            <input type="text" id="name" name="name" required class="w-full px-4 py-3 min-h-[48px] bg-black/30 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:border-orange-400 focus:outline-none transition text-base">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                            <input type="email" id="email" name="email" required class="w-full px-4 py-3 min-h-[48px] bg-black/30 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:border-orange-400 focus:outline-none transition text-base">
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-300 mb-2">Message</label>
                            <textarea id="message" name="message" rows="4" required class="w-full px-4 py-3 min-h-[120px] bg-black/30 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:border-orange-400 focus:outline-none transition resize-none text-base"></textarea>
                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-orange-400 to-orange-600 text-white py-4 min-h-[52px] rounded-lg font-semibold hover:from-orange-500 hover:to-orange-700 transition-all duration-300 transform hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl flex items-center justify-center active:bg-opacity-90 text-lg touch-action: manipulation;">
                            <span class="font-semibold">Send Message</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="py-12 text-center opacity-60 text-sm">
        <p>© <span id="year"></span> PJ Photography. All rights reserved.</p>
    </footer>

    <!-- JS -->
    <script>
        // GSAP
        gsap.registerPlugin(ScrollTrigger);
        gsap.from('#hero h1 span', { y: 120, opacity: 0, duration: 1.4, stagger: 0.3, ease: "power4.out" });

        // Vanilla Tilt
        VanillaTilt.init(document.querySelectorAll(".tilt"), { max: 12, speed: 400, glare: true, "max-glare": 0.4 });

        // Magnetic nav
        document.querySelectorAll('.magnetic').forEach(el => {
            el.addEventListener('mousemove', (e) => {
                const rect = el.getBoundingClientRect();
                const x = (e.clientX - rect.left - rect.width / 2) * 0.3;
                const y = (e.clientY - rect.top - rect.height / 2) * 0.3;
                el.style.transform = `translate(${x}px, ${y}px)`;
            });
            el.addEventListener('mouseout', () => el.style.transform = 'translate(0,0)');
        });

        // Cursor
        const cursor = document.getElementById('cursor');
        document.addEventListener('mousemove', (e) => {
            cursor.style.left = e.clientX + 'px';
            cursor.style.top = e.clientY + 'px';
        });

        // Mobile menu
        document.getElementById('mobile-btn').onclick = () => {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
            mobileMenu.classList.toggle('flex');
        };

        // Year
        document.getElementById('year').textContent = new Date().getFullYear();
    </script>
</body>
</html>
