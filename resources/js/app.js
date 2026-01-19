import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded", function () {
    // --- LOGIKA CAROUSEL OTOMATIS ---
    const slides = document.querySelectorAll(".carousel-slide");
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");

    // Pengecekan agar JS tidak error di halaman yang tidak punya slider
    if (slides.length > 0) {
        let currentSlide = 0;
        const slideInterval = 5000; // Ganti slide setiap 5 detik (5000ms)
        let autoSlide;

        // Fungsi untuk menampilkan slide berdasarkan index
        function showSlide(index) {
            slides.forEach((slide, i) => {
                if (i === index) {
                    // Tampilkan slide aktif
                    slide.classList.remove("opacity-0");
                    slide.classList.add("opacity-100");
                    // Tambahkan z-index agar slide aktif berada di atas (untuk klik modal)
                    slide.style.zIndex = 10;
                } else {
                    // Sembunyikan slide lain
                    slide.classList.remove("opacity-100");
                    slide.classList.add("opacity-0");
                    slide.style.zIndex = 0;
                }
            });
        }

        // Fungsi Slide Berikutnya
        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        // Fungsi Slide Sebelumnya
        function prevSlide() {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(currentSlide);
        }

        // Jalankan slide otomatis
        function startAutoSlide() {
            autoSlide = setInterval(nextSlide, slideInterval);
        }

        // Reset timer jika user menekan tombol (agar slide tidak langsung ganti)
        function resetTimer() {
            clearInterval(autoSlide);
            startAutoSlide();
        }

        // Event Listener Tombol Next
        if (nextBtn) {
            nextBtn.addEventListener("click", (e) => {
                // e.stopPropagation() mencegah klik tembus ke modal (jika tombol ada di atas gambar)
                e.stopPropagation();
                nextSlide();
                resetTimer();
            });
        }

        // Event Listener Tombol Prev
        if (prevBtn) {
            prevBtn.addEventListener("click", (e) => {
                e.stopPropagation();
                prevSlide();
                resetTimer();
            });
        }

        // Mulai slider saat halaman dimuat
        startAutoSlide();
    }
});

document.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById("navbar-toggle-btn");
    const menu = document.getElementById("navbar-default");

    if (btn && menu) {
        btn.addEventListener("click", () => {
            menu.classList.toggle("hidden");
        });
    }
});
