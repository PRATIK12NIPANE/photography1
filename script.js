// Enhanced Mobile Menu Toggle
const nav = document.querySelector('nav ul');
const navToggle = document.createElement('button');
navToggle.innerHTML = '&#9776;'; // Hamburger icon
navToggle.className = 'nav-toggle';
navToggle.setAttribute('aria-label', 'Toggle navigation menu');
navToggle.style.display = 'none';
navToggle.style.background = 'rgba(255,255,255,0.9)';
navToggle.style.border = '2px solid #e84393';
navToggle.style.borderRadius = '8px';
navToggle.style.padding = '0.5rem';
navToggle.style.fontSize = '1.2rem';
navToggle.style.cursor = 'pointer';
navToggle.style.color = '#e84393';
navToggle.style.transition = 'all 0.3s';

document.querySelector('nav').appendChild(navToggle);

function toggleMenu() {
    nav.classList.toggle('active');
    navToggle.innerHTML = nav.classList.contains('active') ? '&#10005;' : '&#9776;'; // X or hamburger
}

navToggle.addEventListener('click', toggleMenu);

// Close menu when clicking outside
document.addEventListener('click', (e) => {
    if (!nav.contains(e.target) && !navToggle.contains(e.target)) {
        nav.classList.remove('active');
        navToggle.innerHTML = '&#9776;';
    }
});

// Show/hide toggle button on mobile
function checkScreenSize() {
    if (window.innerWidth <= 768) {
        navToggle.style.display = 'block';
        nav.style.display = 'none';
        nav.classList.remove('active');
        navToggle.innerHTML = '&#9776;';
    } else {
        navToggle.style.display = 'none';
        nav.style.display = 'flex';
        nav.classList.remove('active');
    }
}

window.addEventListener('resize', checkScreenSize);
checkScreenSize();

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
});

// Add active class to nav links on scroll (optional)
const sections = document.querySelectorAll('section');
const navLinks = document.querySelectorAll('nav ul li a');

window.addEventListener('scroll', () => {
    let current = '';
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        if (pageYOffset >= sectionTop - 60) {
            current = section.getAttribute('id');
        }
    });

    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href').includes(current)) {
            link.classList.add('active');
        }
    });
});
