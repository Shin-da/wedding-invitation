// Modern Wedding Website JavaScript

// Initialize AOS (Animate On Scroll)
AOS.init({
    duration: 800,
    easing: 'ease',
    once: true
});

// Wedding date countdown
const weddingDate = new Date('2025-06-10T14:00:00').getTime();

function updateCountdown() {
    const now = new Date().getTime();
    const distance = weddingDate - now;

    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    document.getElementById('countdown').innerHTML = `
        <div class="countdown-item">
            <span class="number">${days}</span>
            <span class="label">Days</span>
        </div>
        <div class="countdown-item">
            <span class="number">${hours}</span>
            <span class="label">Hours</span>
        </div>
        <div class="countdown-item">
            <span class="number">${minutes}</span>
            <span class="label">Minutes</span>
        </div>
        <div class="countdown-item">
            <span class="number">${seconds}</span>
            <span class="label">Seconds</span>
        </div>
    `;
}

// Update countdown every second
setInterval(updateCountdown, 1000);

// Timeline events
const timelineEvents = [
    {
        date: 'Our First Meeting',
        title: 'Where It All Began',
        description: 'A chance encounter that changed our lives forever.'
    },
    {
        date: 'First Date',
        title: 'The Beginning of Forever',
        description: 'When we knew this was something special.'
    },
    {
        date: 'The Proposal',
        title: 'She Said Yes!',
        description: 'A magical moment that led us here.'
    }
];

// Gallery images
const galleryImages = [
    { src: '../assets/images/gallery/a.jpg', alt: 'Our Journey 1' },
    { src: '../assets/images/gallery/b.jpg', alt: 'Our Journey 2' },
    { src: '../assets/images/gallery/c.jpg', alt: 'Our Journey 3' },
    { src: '../assets/images/gallery/d.jpg', alt: 'Our Journey 4' },
    { src: '../assets/images/gallery/e.jpg', alt: 'Our Journey 5' },
    { src: '../assets/images/gallery/f.jpg', alt: 'Our Journey 6' }
];

// Load gallery images
function loadGallery() {
    const galleryGrid = document.getElementById('gallery-grid');
    if (!galleryGrid) return;

    galleryImages.forEach((image, index) => {
        const col = document.createElement('div');
        col.className = 'col-md-4 col-sm-6';
        col.setAttribute('data-aos', 'fade-up');
        col.setAttribute('data-aos-delay', (index * 100).toString());

        col.innerHTML = `
            <div class="gallery-item">
                <img src="${image.src}" 
                     alt="${image.alt}" 
                     class="img-fluid" 
                     loading="lazy">
            </div>
        `;
        galleryGrid.appendChild(col);
    });
}

// Load timeline events
function loadTimeline() {
    const timelineContainer = document.querySelector('.timeline');
    if (!timelineContainer) return;

    timelineEvents.forEach((event, index) => {
        const timelineItem = document.createElement('div');
        timelineItem.className = `timeline-item ${index % 2 === 0 ? 'left' : 'right'}`;
        timelineItem.setAttribute('data-aos', index % 2 === 0 ? 'fade-right' : 'fade-left');

        timelineItem.innerHTML = `
            <div class="timeline-content">
                <span class="date">${event.date}</span>
                <h3>${event.title}</h3>
                <p>${event.description}</p>
            </div>
        `;
        timelineContainer.appendChild(timelineItem);
    });
}

// Background music controls
let bgMusic = document.getElementById('bgMusic');
const musicToggle = document.getElementById('musicToggle');

if (musicToggle && bgMusic) {
    musicToggle.addEventListener('click', () => {
        if (bgMusic.paused) {
            bgMusic.play();
            musicToggle.innerHTML = '<i class="fas fa-volume-up"></i>';
        } else {
            bgMusic.pause();
            musicToggle.innerHTML = '<i class="fas fa-volume-mute"></i>';
        }
    });
}

// Smooth scroll for navigation
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    updateCountdown();
    loadGallery();
    loadTimeline();
});
