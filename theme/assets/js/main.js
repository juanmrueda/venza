/* Venza — JS Global */
(function () {
    'use strict';

    // --- Menú móvil ---
    const toggle = document.getElementById('nav-toggle');
    const nav    = document.getElementById('site-nav');
    if (toggle && nav) {
        toggle.addEventListener('click', () => {
            const open = toggle.getAttribute('aria-expanded') === 'true';
            toggle.setAttribute('aria-expanded', String(!open));
            nav.classList.toggle('is-open', !open);
        });

        // Cerrar con Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && nav.classList.contains('is-open')) {
                toggle.setAttribute('aria-expanded', 'false');
                nav.classList.remove('is-open');
                toggle.focus();
            }
        });
    }

    // --- Dropdown táctil en móvil ---
    document.querySelectorAll('.menu-item-has-children > a').forEach(link => {
        link.addEventListener('click', function (e) {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                const parent = this.parentElement;
                parent.classList.toggle('is-open');
            }
        });
    });

    // --- Header sticky: agregar clase al hacer scroll ---
    const header = document.getElementById('site-header');
    if (header) {
        window.addEventListener('scroll', () => {
            header.classList.toggle('is-scrolled', window.scrollY > 20);
        }, { passive: true });
    }

    // --- Carrusel YouTube (Descubre Venza) ---
    const carousel  = document.querySelector('.youtube-carousel');
    const track     = document.getElementById('yt-track');
    const btnPrev   = document.querySelector('.carousel-btn--prev');
    const btnNext   = document.querySelector('.carousel-btn--next');

    if (carousel && track) {
        const playlistId = carousel.dataset.playlist;
        let currentIndex = 0;
        const VISIBLE = 4;

        // Carga básica de playlist vía oEmbed/iframe
        // Los thumbnails se cargan como botones que abren el video en modal
        if (playlistId) {
            loadYouTubePlaylist(playlistId);
        }

        function loadYouTubePlaylist(pid) {
            // Sin API key: cargamos 4 videos hardcodeados desde ACF o via YouTube API
            // Esta función se puede extender con YouTube Data API v3
            console.info('YouTube playlist:', pid, '— integrar con YouTube Data API v3 cuando esté disponible');
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

    // --- Video hero con modal ---
    document.querySelectorAll('.video-play-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const videoId = this.dataset.video;
            if (!videoId) return;

            const modal = document.createElement('div');
            modal.className = 'video-modal';
            modal.innerHTML = `
                <div class="video-modal__backdrop"></div>
                <div class="video-modal__content">
                    <button class="video-modal__close" aria-label="Cerrar video">&times;</button>
                    <iframe
                        src="https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0"
                        allow="autoplay; fullscreen"
                        allowfullscreen
                        width="900"
                        height="506"
                        frameborder="0"
                        title="Video Venza"
                    ></iframe>
                </div>
            `;
            document.body.appendChild(modal);
            document.body.style.overflow = 'hidden';

            function closeModal() {
                modal.remove();
                document.body.style.overflow = '';
            }

            modal.querySelector('.video-modal__close').addEventListener('click', closeModal);
            modal.querySelector('.video-modal__backdrop').addEventListener('click', closeModal);
            document.addEventListener('keydown', function esc(e) {
                if (e.key === 'Escape') { closeModal(); document.removeEventListener('keydown', esc); }
            });
        });
    });

})();
