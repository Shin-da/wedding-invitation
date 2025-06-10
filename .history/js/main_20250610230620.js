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

// Gallery image loading with lightbox and animations
const galleryImages = [
    { 
        src: '../assets/images/prenup/ABC00834.JPG',
        thumb: '../assets/images/prenup/ABC00834.JPG',
        alt: 'Prenup Photo 1'
    },
    { 
        src: '../assets/images/prenup/ABC01000.JPG',
        thumb: '../assets/images/prenup/ABC01000.JPG',
        alt: 'Prenup Photo 2'
    },
    { 
        src: '../assets/images/prenup/ABC01003.JPG',
        thumb: '../assets/images/prenup/ABC01003.JPG',
        alt: 'Prenup Photo 3'
    },
    { 
        src: '../assets/images/prenup/ABC01007.JPG',
        thumb: '../assets/images/prenup/ABC01007.JPG',
        alt: 'Prenup Photo 4'
    },
    { 
        src: '../assets/images/prenup/ABC01035.JPG',
        thumb: '../assets/images/prenup/ABC01035.JPG',
        alt: 'Prenup Photo 5'
    },
    { 
        src: '../assets/images/prenup/ABC01122.JPG',
        thumb: '../assets/images/prenup/ABC01122.JPG',
        alt: 'Prenup Photo 6'
    }
];

function loadGallery() {
    const galleryGrid = document.getElementById('gallery-grid');
    if (!galleryGrid) return;

    galleryImages.forEach((image, index) => {
        const col = document.createElement('div');
        col.className = 'col-md-4 col-sm-6';
        col.setAttribute('data-aos', 'fade-up');
        col.setAttribute('data-aos-delay', (index * 100).toString());

        col.innerHTML = `
            <a href="${image.src}" 
               class="gallery-item" 
               data-lg-size="1600-2400"
               data-src="${image.src}"
               data-sub-html="<h4>${image.alt}</h4>">
                <img                    src="${image.thumb}" 
                    alt="${image.alt}" 
                    class="img-fluid" 
                    loading="lazy"
                    width="800"
                    height="1200"
                />
                <div class="gallery-overlay">
                    <i class="fas fa-search-plus"></i>
                </div>
            </a>
        `;
        galleryGrid.appendChild(col);
    });

    // Initialize lightGallery
    const lgElement = document.getElementById('gallery-grid');
    lightGallery(lgElement, {
        speed: 500,
        plugins: [lgZoom],
        selector: '.gallery-item',
        download: false,
        thumbnail: true,
        animateThumb: true,
        zoomFromOrigin: true,
        allowMediaOverlap: true,
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
