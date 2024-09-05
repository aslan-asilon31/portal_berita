// scripts.js
let slideIndex = 0;
const slides = document.querySelectorAll('.carousel-item');
const totalSlides = slides.length;
const slideInterval = 100000; // Durasi otomatis bergeser dalam milidetik (5000 ms = 5 detik)

// Menampilkan slide yang sesuai dengan indeks saat ini
function showSlides() {
    if (slides.length === 0) return; // Jika tidak ada slide, hentikan eksekusi
    if (slideIndex >= totalSlides) {
        slideIndex = 0;
    } 
    if (slideIndex < 0) {
        slideIndex = totalSlides - 1;
    }
    slides.forEach((slide, index) => {
        slide.style.transform = `translateX(-${slideIndex * 100}%)`;
    });
}

// Mengubah slide ke berikutnya
function nextSlide() {
    slideIndex++;
    showSlides();
}

// Mengubah slide ke sebelumnya
function prevSlide() {
    slideIndex--;
    showSlides();
}

// Inisialisasi carousel
function initCarousel() {
    showSlides(); // Tampilkan slide awal
    // Atur interval otomatis untuk berpindah slide setiap 5 detik
    setInterval(nextSlide, slideInterval);
}

// Event listener untuk tombol navigasi
document.querySelector('.carousel-prev').addEventListener('click', prevSlide);
document.querySelector('.carousel-next').addEventListener('click', nextSlide);

// Inisialisasi carousel ketika halaman dimuat
document.addEventListener('DOMContentLoaded', initCarousel);



// Navbar toggle functionality
const navbarToggle = document.getElementById('navbar-toggle');
const navbarRight = document.getElementById('navbar-right');
const submenus = document.querySelectorAll('.submenu');

navbarToggle.addEventListener('click', () => {
    navbarRight.classList.toggle('active');
});

// Handle submenu toggle on click
submenus.forEach(submenu => {
    submenu.addEventListener('click', (event) => {
        event.stopPropagation(); // Prevent event from bubbling up
        submenu.classList.toggle('active');
        // Close other open submenus
        submenus.forEach(otherSubmenu => {
            if (otherSubmenu !== submenu) {
                otherSubmenu.classList.remove('active');
            }
        });
    });
});

// Close menu if clicked outside
document.addEventListener('click', (event) => {
    if (!navbarRight.contains(event.target) && !navbarToggle.contains(event.target)) {
        navbarRight.classList.remove('active');
    }
});
