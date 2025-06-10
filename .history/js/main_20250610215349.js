// Initialize AOS (Animate On Scroll)
AOS.init({
    duration: 1000,
    once: true
});

document.addEventListener('DOMContentLoaded', function() {
    // Initialize countdown timer
    initCountdown();
    
    // Initialize gallery
    initGallery();
    
    // Smooth scroll for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});

// Countdown Timer
function initCountdown() {
    const weddingDate = new Date('2025-06-10T14:00:00'); // Update with your actual wedding date and time
    
    function updateCountdown() {
        const now = new Date().getTime();
        const distance = weddingDate - now;
        
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        document.querySelectorAll('.countdown-item').forEach(item => {
            const unit = item.getAttribute('data-unit');
            const value = eval(unit);
            item.querySelector('.number').textContent = value.toString().padStart(2, '0');
        });
        
        if (distance < 0) {
            clearInterval(countdownInterval);
            document.getElementById('countdown').innerHTML = "<h3>The Wedding Day Is Here!</h3>";
        }
    }
    
    updateCountdown();
    const countdownInterval = setInterval(updateCountdown, 1000);
}

// Gallery initialization with lightbox
function initGallery() {
    const galleryGrid = document.getElementById('gallery-grid');
    if (!galleryGrid) return;

    // Gallery images data
    const images = [
        { src: '../assets/images/gallery/1.jpg', alt: 'Our Story 1' },
        { src: '../assets/images/gallery/2.jpg', alt: 'Our Story 2' },
        { src: '../assets/images/gallery/3.jpg', alt: 'Our Story 3' },
        { src: '../assets/images/gallery/4.jpg', alt: 'Our Story 4' },
        { src: '../assets/images/gallery/5.jpg', alt: 'Our Story 5' },
        { src: '../assets/images/gallery/6.jpg', alt: 'Our Story 6' }
    ];

    // Create gallery items
    images.forEach(img => {
        const col = document.createElement('div');
        col.className = 'col-md-4 col-6';
        col.innerHTML = `
            <div class="gallery-item" data-aos="fade-up">
                <img src="${img.src}" alt="${img.alt}" class="img-fluid" 
                     onclick="openLightbox('${img.src}')">
            </div>
        `;
        galleryGrid.appendChild(col);
    });
}

// Lightbox functionality
function openLightbox(imgSrc) {
    const lightbox = document.createElement('div');
    lightbox.className = 'lightbox';
    lightbox.innerHTML = `
        <div class="lightbox-content">
            <img src="${imgSrc}" alt="Gallery Image">
            <button class="close-lightbox" onclick="this.parentElement.parentElement.remove()">×</button>
        </div>
    `;
    document.body.appendChild(lightbox);
    
    lightbox.addEventListener('click', function(e) {
        if (e.target === lightbox) {
            lightbox.remove();
        }
    });
}

// Background music control
let bgMusic;
function toggleMusic() {
    if (!bgMusic) {
        bgMusic = new Audio('../assets/audio/buttercup.mp3');
        bgMusic.loop = true;
    }
    
    if (bgMusic.paused) {
        bgMusic.play();
        document.getElementById('musicBtn').classList.add('playing');
    } else {
        bgMusic.pause();
        document.getElementById('musicBtn').classList.remove('playing');
    }
}
