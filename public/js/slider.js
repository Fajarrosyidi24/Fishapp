let currentSlide = 0;
const slides = document.querySelectorAll('.slide-content');
const slideButtons = document.querySelectorAll('#bullets label');

function showSlide(slideIndex) {
    slides.forEach((slide) => {
        slide.style.display = 'none';
    });

    slides[slideIndex].style.display = 'block';
}

function updateSlideButtons() {
    slideButtons.forEach((button, index) => {
        if (index === currentSlide) {
            button.classList.add('active');
        } else {
            button.classList.remove('active');
        }
    });
}

function nextSlide() {
    currentSlide++;
    if (currentSlide >= slides.length) {
        currentSlide = 0;
    }
    showSlide(currentSlide);
    updateSlideButtons();
}

function prevSlide() {
    currentSlide--;
    if (currentSlide < 0) {
        currentSlide = slides.length - 1;
    }
    showSlide(currentSlide);
    updateSlideButtons();
}

showSlide(currentSlide);
updateSlideButtons();

document.getElementById('geser_kiri').addEventListener('click', prevSlide);
document.getElementById('geser_kanan').addEventListener('click', nextSlide);

// Contoh inisialisasi dengan opsi
var myCarousel = new bootstrap.Carousel(document.getElementById('carouselExampleCaptions'), {
    interval: 5000, // Sesuaikan interval sesuai kebutuhan
    wrap: true
});

