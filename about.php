<!DOCTYPE html>
<html lang="en" data-theme="ember" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>About - PJ Photography</title>
  <meta name="description" content="Learn about our journey, passion for wedding photography, and the team behind PJ Photography.">

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
      <div class="max-w-7xl mx-auto px-6 flex justify-between items-center h-16">
        <a href="index.php" class="text-2xl font-bold" style="color: var(--primary);">PJ Photography</a>
        <div class="hidden md:flex items-center gap-6">
          <a href="index.php" class="hover:text-white transition magnetic">Home</a>
          <a href="about.php" class="text-orange-400 border-b-2 border-orange-400 pb-1 transition magnetic">About</a>
          <a href="portfolio.php" class="hover:text-white transition magnetic">Portfolio</a>
          <a href="films.php" class="hover:text-white transition magnetic">Films</a>
          <a href="couple-shoot.php" class="hover:text-white transition magnetic">Couple Shoot</a>
          <a href="testimonials.php" class="hover:text-white transition magnetic">Testimonials</a>
          <a href="faq.php" class="hover:text-white transition magnetic">FAQ</a>
          <a href="contact.php" class="hover:text-white transition magnetic">Contact</a>
        </div>
        <button id="mobile-btn" class="md:hidden text-white">
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
                <span class="block" style="color: var(--primary);">About</span>
                <span class="block" style="color: var(--accent);">PJ Photography</span>
            </h1>
            <p class="text-xl md:text-2xl mb-8 max-w-2xl mx-auto opacity-90">Founded in 2014, our journey began with a shared passion: turning weddings into timeless works of art.</p>
        </div>
    </section>

    <!-- ABOUT CONTENT -->
    <section id="about" class="py-24 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="glass rounded-2xl overflow-hidden tilt p-6 text-center transition-all duration-500">
            <div class="mb-4">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-r from-orange-400 to-orange-600 flex items-center justify-center text-white text-2xl font-bold">📖</div>
            </div>
            <h3 class="text-2xl font-bold mb-4 text-white">Our Story</h3>
            <p class="text-gray-300 leading-relaxed mb-4">Our passion for photography and storytelling started years ago. We believe every wedding is a unique story, and our goal is to capture those moments authentically.</p>
            <p class="text-gray-300 leading-relaxed">We are based in Mumbai, but we travel worldwide to document destination weddings.</p>
        </div>
        <div class="glass rounded-2xl overflow-hidden tilt p-6 text-center transition-all duration-500">
            <div class="mb-4">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center text-white text-2xl font-bold">🎨</div>
            </div>
            <h3 class="text-2xl font-bold mb-4 text-white">Our Style & Approach</h3>
            <p class="text-gray-300 leading-relaxed mb-4">Our style mixes candid reportage, fine-art compositions, and editorial light — so your photos look like they belong in a magazine.</p>
            <p class="text-gray-300 leading-relaxed">We master natural light and create emotional, evocative images.</p>
        </div>
        <div class="glass rounded-2xl overflow-hidden tilt p-6 text-center transition-all duration-500">
            <div class="mb-4">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-r from-purple-400 to-purple-600 flex items-center justify-center text-white text-2xl font-bold">🕒</div>
            </div>
            <h3 class="text-2xl font-bold mb-4 text-white">Our Journey</h3>
            <ul class="text-gray-300 space-y-1">
                <li><strong class="text-orange-400">2014:</strong> Founded PJ Photography</li>
                <li><strong class="text-orange-400">2016:</strong> First destination wedding</li>
                <li><strong class="text-orange-400">2018:</strong> Won first industry award</li>
                <li><strong class="text-orange-400">2020:</strong> Documented 300+ weddings</li>
                <li><strong class="text-orange-400">2023:</strong> Expanded to filmmaking</li>
            </ul>
        </div>
        <div class="glass rounded-2xl overflow-hidden tilt p-6 text-center transition-all duration-500">
            <img src="images/Crystalline-photography-2060.jpg" alt="Alice Photographer" class="w-32 h-32 rounded-full mx-auto mb-4 object-cover border-4 border-orange-400">
            <h3 class="text-2xl font-bold mb-2 text-white">Alice Photographer</h3>
            <p class="text-gray-300">Lead Photographer with 10+ years experience in wedding photography.</p>
        </div>
        <div class="glass rounded-2xl overflow-hidden tilt p-6 text-center transition-all duration-500">
            <img src="images/82456c14fd1ca34a63a6d3bac59ad506.jpg" alt="Bob Videographer" class="w-32 h-32 rounded-full mx-auto mb-4 object-cover border-4 border-blue-400">
            <h3 class="text-2xl font-bold mb-2 text-white">Bob Videographer</h3>
            <p class="text-gray-300">Expert in cinematic wedding films and storytelling.</p>
        </div>
        <div class="glass rounded-2xl overflow-hidden tilt p-6 text-center transition-all duration-500">
            <div class="mb-4">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-r from-green-400 to-green-600 flex items-center justify-center text-white text-2xl font-bold">🏆</div>
            </div>
            <h3 class="text-2xl font-bold mb-4 text-white">Why Choose Us?</h3>
            <p class="text-gray-300 leading-relaxed mb-4">With over 600 couples documented worldwide, we bring creativity, professionalism, and passion to every wedding we capture.</p>
            <p class="text-gray-300 leading-relaxed">Our work has been featured in leading publications and recognized with multiple industry awards.</p>
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
