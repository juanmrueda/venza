/* Venza - JS Global */
(function () {
    'use strict';

    // --- Menu movil ---
    const toggle = document.getElementById('nav-toggle');
    const nav = document.getElementById('site-nav');

    if (toggle && nav) {
        toggle.addEventListener('click', () => {
            const open = toggle.getAttribute('aria-expanded') === 'true';
            toggle.setAttribute('aria-expanded', String(!open));
            nav.classList.toggle('is-open', !open);
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && nav.classList.contains('is-open')) {
                toggle.setAttribute('aria-expanded', 'false');
                nav.classList.remove('is-open');
                toggle.focus();
            }
        });
    }

    // --- Dropdown tactil en movil ---
    document.querySelectorAll('.menu-item-has-children > a').forEach((link) => {
        link.addEventListener('click', function (e) {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                this.parentElement.classList.toggle('is-open');
            }
        });
    });

    // --- Estado de header al hacer scroll ---
    const header = document.getElementById('site-header');
    if (header) {
        window.addEventListener('scroll', () => {
            header.classList.toggle('is-scrolled', window.scrollY > 20);
        }, { passive: true });
    }

    // --- Hero slider Home ---
    const heroCarousel = document.getElementById('home-hero-carousel');
    if (heroCarousel) {
        const slides = Array.from(heroCarousel.querySelectorAll('.home-hero__slide'));
        const dots = Array.from(document.querySelectorAll('.home-hero__dot'));
        const prevBtn = heroCarousel.querySelector('.home-hero__control--prev');
        const nextBtn = heroCarousel.querySelector('.home-hero__control--next');

        let currentIndex = 0;
        let timer = null;

        const showSlide = (index) => {
            if (!slides.length) return;

            currentIndex = (index + slides.length) % slides.length;

            slides.forEach((slide, idx) => {
                const isActive = idx === currentIndex;
                slide.classList.toggle('is-active', isActive);

                const video = slide.querySelector('video');
                if (video) {
                    if (isActive) {
                        const playPromise = video.play();
                        if (playPromise && typeof playPromise.catch === 'function') {
                            playPromise.catch(() => {});
                        }
                    } else {
                        video.pause();
                    }
                }
            });

            dots.forEach((dot, idx) => {
                dot.classList.toggle('is-active', idx === currentIndex);
            });
        };

        const nextSlide = () => showSlide(currentIndex + 1);
        const prevSlide = () => showSlide(currentIndex - 1);

        const stopAuto = () => {
            if (timer) {
                clearInterval(timer);
                timer = null;
            }
        };

        const startAuto = () => {
            if (slides.length <= 1) return;
            stopAuto();
            timer = setInterval(nextSlide, 6000);
        };

        if (prevBtn) prevBtn.addEventListener('click', () => { prevSlide(); startAuto(); });
        if (nextBtn) nextBtn.addEventListener('click', () => { nextSlide(); startAuto(); });

        dots.forEach((dot) => {
            dot.addEventListener('click', () => {
                const target = Number(dot.getAttribute('data-slide-to'));
                if (!Number.isNaN(target)) {
                    showSlide(target);
                    startAuto();
                }
            });
        });

        heroCarousel.addEventListener('mouseenter', stopAuto);
        heroCarousel.addEventListener('mouseleave', startAuto);

        showSlide(0);
        startAuto();
    }

    // --- Carrusel YouTube (Descubre Venza) ---
    const carousel = document.querySelector('.youtube-carousel');
    const track = document.getElementById('yt-track');
    const btnPrev = document.querySelector('.carousel-btn--prev');
    const btnNext = document.querySelector('.carousel-btn--next');

    if (carousel && track) {
        const playlistId = carousel.dataset.playlist;
        let currentIndex = 0;
        const VISIBLE = 4;

        if (playlistId) {
            console.info('YouTube playlist:', playlistId, '- integrar con YouTube Data API v3 cuando este disponible');
        }

        if (btnPrev) btnPrev.addEventListener('click', () => slide(-1));
        if (btnNext) btnNext.addEventListener('click', () => slide(1));

        function slide(dir) {
            const items = track.querySelectorAll('.yt-video-item');
            if (!items.length) return;

            const max = Math.max(0, items.length - VISIBLE);
            currentIndex = Math.min(max, Math.max(0, currentIndex + dir));
            const itemWidth = items[0].offsetWidth + 16;
            track.style.transform = `translateX(-${currentIndex * itemWidth}px)`;
        }
    }

    // --- Modal de video (YouTube o archivo local) ---
    document.querySelectorAll('.video-play-btn').forEach((btn) => {
        btn.addEventListener('click', function () {
            const youtubeId = this.dataset.video;
            const localVideo = this.dataset.videoSrc;

            if (!youtubeId && !localVideo) return;

            const modal = document.createElement('div');
            modal.className = 'video-modal';

            const mediaMarkup = youtubeId
                ? `<iframe
                        src="https://www.youtube.com/embed/${youtubeId}?autoplay=1&rel=0"
                        allow="autoplay; fullscreen"
                        allowfullscreen
                        width="900"
                        height="506"
                        frameborder="0"
                        title="Video Venza"
                    ></iframe>`
                : `<video controls autoplay playsinline>
                        <source src="${localVideo}" type="video/mp4">
                    </video>`;

            modal.innerHTML = `
                <div class="video-modal__backdrop"></div>
                <div class="video-modal__content">
                    <button class="video-modal__close" aria-label="Cerrar video">&times;</button>
                    ${mediaMarkup}
                </div>
            `;

            document.body.appendChild(modal);
            document.body.style.overflow = 'hidden';

            const closeModal = () => {
                modal.remove();
                document.body.style.overflow = '';
            };

            modal.querySelector('.video-modal__close').addEventListener('click', closeModal);
            modal.querySelector('.video-modal__backdrop').addEventListener('click', closeModal);

            const onEsc = (e) => {
                if (e.key === 'Escape') {
                    closeModal();
                    document.removeEventListener('keydown', onEsc);
                }
            };

            document.addEventListener('keydown', onEsc);
        });
    });
})();
