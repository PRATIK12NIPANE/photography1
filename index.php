<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>PixelCraft – Cinematic Photography</title>

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
      <a href="#" class="text-xl sm:text-2xl font-bold" style="color: var(--primary);">PJ Photography</a>
      <div class="hidden md:flex items-center gap-6">
        <a href="#hero" class="hover:text-white transition magnetic py-2">Home</a>
        <a href="about.php" class="hover:text-white transition magnetic py-2">About</a>
        <a href="portfolio.php" class="hover:text-white transition magnetic py-2">Portfolio</a>
        <a href="films.php" class="hover:text-white transition magnetic py-2">Films</a>
        <a href="couple-shoot.php" class="hover:text-white transition magnetic py-2">Couple Shoot</a>
        <a href="testimonials.php" class="hover:text-white transition magnetic py-2">Testimonials</a>
        <a href="faq.php" class="hover:text-white transition magnetic py-2">FAQ</a>
        <a href="contact.php" class="hover:text-white transition magnetic py-2">Contact</a>
      </div>
      <button id="mobile-btn" class="md:hidden text-white p-2 min-h-[44px] min-w-[44px] flex items-center justify-center">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
      </button>
    </div>
  </nav>

  <!-- HERO -->
  <section id="hero" class="relative min-h-screen flex items-center justify-center overflow-hidden mesh-bg">
    <div class="absolute inset-0 opacity-30">
      <img src="images/hero-wedding.jpg" class="w-full h-full object-cover">
    </div>
    <div class="relative text-center px-4 sm:px-6 z-10 max-w-6xl mx-auto">
      <h1 class="text-4xl sm:text-6xl md:text-8xl font-bold mb-4 leading-tight">
        <span class="block" style="color: var(--primary);">PJ</span>
        <span class="block" style="color: var(--accent);">Photography</span>
      </h1>
      <p class="text-lg sm:text-xl md:text-2xl mb-8 max-w-2xl mx-auto opacity-90">We don't just capture weddings — we celebrate love in its most beautiful, raw & unforgettable moments.</p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center max-w-xs sm:max-w-none mx-auto">
        <a href="#work" class="w-full sm:w-auto px-8 py-4 min-h-[52px] rounded-full text-black font-bold text-center text-lg transition-all duration-300 transform hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl flex items-center justify-center active:bg-opacity-90" style="background: linear-gradient(135deg, var(--primary), var(--accent)); touch-action: manipulation;">
          <span class="font-semibold">View Gallery</span>
        </a>
        <a href="#contact" class="w-full sm:w-auto px-8 py-4 min-h-[52px] rounded-full border-2 font-bold text-center text-lg transition-all duration-300 transform hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl flex items-center justify-center active:bg-opacity-10" style="border-color: var(--accent); color: var(--accent); touch-action: manipulation;">
          <span class="font-semibold">Book Now</span>
        </a>
      </div>
    </div>
  </section>

  <!-- PORTFOLIO -->
  <section id="work" class="py-16 sm:py-24 px-4 sm:px-6">
    <div class="max-w-7xl mx-auto">
      <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-center mb-8 sm:mb-12 lg:mb-16" style="background: linear-gradient(90deg, var(--primary), var(--accent)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
        Cinematic Frames
      </h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
        <div class="glass rounded-2xl overflow-hidden tilt" data-tilt data-tilt-glare data-tilt-max-glare="0.5">
          <img src="images/Crystalline-photography-2060.jpg" class="w-full h-48 sm:h-64 lg:h-80 object-cover transition-transform duration-700 hover:scale-110">
          <div class="p-4 sm:p-6">
            <h3 class="text-lg sm:text-xl lg:text-2xl font-bold mb-2">Wedding at Oleander Farms</h3>
            <p class="opacity-80 text-sm sm:text-base">Karjat – Dhruv & Pippa</p>
          </div>
        </div>
        <div class="glass rounded-2xl overflow-hidden tilt" data-tilt>
          <img src="images/must-take-wedding-photos-bride-groom-walk-clary-prfeiffer-photography-0723-twitter-212172493c164f1986a02e9da665ff85.jpg" class="w-full h-48 sm:h-64 lg:h-80 object-cover transition-transform duration-700 hover:scale-110">
          <div class="p-4 sm:p-6">
            <h3 class="text-lg sm:text-xl lg:text-2xl font-bold mb-2">Beach Wedding</h3>
            <p class="opacity-80 text-sm sm:text-base">Sarah & John</p>
          </div>
        </div>
        <div class="glass rounded-2xl overflow-hidden tilt" data-tilt>
          <img src="images/images.jpeg" class="w-full h-48 sm:h-64 lg:h-80 object-cover transition-transform duration-700 hover:scale-110">
          <div class="p-4 sm:p-6">
            <h3 class="text-lg sm:text-xl lg:text-2xl font-bold mb-2">Garden Ceremony</h3>
            <p class="opacity-80 text-sm sm:text-base">Emma & Michael</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ABOUT -->
  <section id="about" class="py-16 sm:py-24 px-4 sm:px-6">
    <div class="max-w-4xl mx-auto text-center">
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-6 sm:mb-8" style="color: var(--primary);">PJ Photography</h2>
      <p class="text-lg sm:text-xl leading-relaxed opacity-90">
        We don't just capture weddings — we celebrate love in its most beautiful, raw & unforgettable moments.
      </p>
      <a href="#contact" class="inline-block mt-6 sm:mt-8 px-8 py-4 min-h-[52px] rounded-full font-bold text-center text-lg transition-all duration-300 transform hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl flex items-center justify-center active:bg-opacity-90" style="background: var(--accent); color: black; touch-action: manipulation;">
        <span class="font-semibold">Let's Shoot</span>
      </a>
    </div>
  </section>

  <!-- CONTACT -->
  <section id="contact" class="py-16 sm:py-24 px-4 sm:px-6">
    <div class="max-w-3xl mx-auto text-center">
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-6 sm:mb-8" style="color: var(--accent);">Your Story Awaits</h2>
      <div class="glass p-6 sm:p-8 rounded-3xl">
        <h3 class="text-xl sm:text-2xl md:text-3xl font-bold mb-4">Ready to Start Your Wedding Story?</h3>
        <p class="mb-6 opacity-90 text-base sm:text-lg">Contact us today for your free consultation and custom quote.</p>
        <button class="w-full py-4 min-h-[52px] rounded-xl font-bold text-black text-center text-lg transition-all duration-300 transform hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl flex items-center justify-center active:bg-opacity-90" style="background: linear-gradient(135deg, var(--primary), var(--accent)); touch-action: manipulation;" onclick="window.location.href='about.php'">
          <span class="font-semibold">Begin the Journey</span>
        </button>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="py-12 text-center opacity-60 text-sm">
    <p>© <span id="year"></span> PJ Photography. All light reserved.</p>
  </footer>

  <!-- JS -->
  <script>
    // Theme System
    function setTheme(theme) {
      const root = document.documentElement;
      root.setAttribute('data-theme', theme === 'ember' ? '' : theme);
      localStorage.setItem('theme', theme);
      document.querySelectorAll('.theme-btn').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.theme === theme);
      });
    }

    // Init theme
    const saved = localStorage.getItem('theme') || 'ember';
    setTheme(saved);

    // Theme buttons
    document.querySelectorAll('.theme-btn').forEach(btn => {
      btn.onclick = () => setTheme(btn.dataset.theme);
    });

    // GSAP
    gsap.registerPlugin(ScrollTrigger);
    gsap.from('#hero h1 span', { y: 120, opacity: 0, duration: 1.4, stagger: 0.3, ease: "power4.out" });
    gsap.from('.tilt', {
      scrollTrigger: { trigger: '#work', start: "top 80%" },
      y: 80, opacity: 0, duration: 1.2, stagger: 0.2, ease: "power3.out"
    });

    // Tilt
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
      const nav = document.querySelector('nav > div');
      nav.classList.toggle('h-16');
      nav.classList.toggle('h-auto');
    };

    // Year
    document.getElementById('year').textContent = new Date().getFullYear();
  </script>
</body>
</html>
