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
    const isMobileNav = () => window.matchMedia('(max-width: 1100px)').matches;

    document.querySelectorAll('.site-nav .menu-item-has-children > a').forEach((link) => {
        link.addEventListener('click', function (e) {
            if (isMobileNav()) {
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
        let activeVideoEndTarget = null;
        let activeVideoEndHandler = null;

        const detachVideoEndListener = () => {
            if (activeVideoEndTarget && activeVideoEndHandler) {
                activeVideoEndTarget.removeEventListener('ended', activeVideoEndHandler);
            }
            activeVideoEndTarget = null;
            activeVideoEndHandler = null;
        };

        const showSlide = (index) => {
            if (!slides.length) return;

            currentIndex = (index + slides.length) % slides.length;
            detachVideoEndListener();

            slides.forEach((slide, idx) => {
                const isActive = idx === currentIndex;
                slide.classList.toggle('is-active', isActive);

                const video = slide.querySelector('video');
                if (video) {
                    if (isActive) {
                        if (video.dataset.waitEnd === '1') {
                            video.loop = false;
                            try {
                                video.currentTime = 0;
                            } catch (e) {}
                        }
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

        const stopAuto = () => {
            if (timer) {
                clearInterval(timer);
                timer = null;
            }
            detachVideoEndListener();
        };

        const startAuto = () => {
            if (slides.length <= 1) return;
            stopAuto();

            const currentSlide = slides[currentIndex];
            const waitEndVideo = currentSlide ? currentSlide.querySelector('video[data-wait-end="1"]') : null;

            if (waitEndVideo) {
                activeVideoEndTarget = waitEndVideo;
                activeVideoEndHandler = () => {
                    detachVideoEndListener();
                    showSlide(currentIndex + 1);
                    startAuto();
                };

                waitEndVideo.addEventListener('ended', activeVideoEndHandler, { once: true });
                return;
            }

            timer = setInterval(() => {
                showSlide(currentIndex + 1);
                startAuto();
            }, 6000);
        };

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                showSlide(currentIndex - 1);
                startAuto();
            });
        }
        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                showSlide(currentIndex + 1);
                startAuto();
            });
        }

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

    // --- Rotador de producto por línea (Home) ---
    const productRotators = Array.from(document.querySelectorAll('[data-home-product-rotator]'));
    productRotators.forEach((rotator) => {
        const rawSlides = rotator.getAttribute('data-home-product-rotator') || '';
        if (!rawSlides) return;

        let slides = [];
        try {
            const parsed = JSON.parse(rawSlides);
            if (Array.isArray(parsed)) {
                slides = parsed.filter((slide) => slide && typeof slide.image === 'string' && slide.image !== '');
            }
        } catch (err) {
            return;
        }

        if (slides.length <= 1) {
            return;
        }

        const imageEl = rotator.querySelector('.js-home-producto-img');
        const captionEl = rotator.querySelector('.js-home-producto-caption');
        if (!imageEl || !captionEl) {
            return;
        }

        const intervalAttr = Number(rotator.getAttribute('data-rotate-interval'));
        const rotateInterval = Number.isFinite(intervalAttr) && intervalAttr > 1200 ? intervalAttr : 4500;
        let index = 0;
        let timer = null;

        const renderSlide = (targetIndex) => {
            const slide = slides[targetIndex];
            if (!slide) return;

            imageEl.classList.add('is-fading');
            captionEl.classList.add('is-fading');

            window.setTimeout(() => {
                imageEl.src = slide.image;
                imageEl.alt = slide.name || 'Producto';
                captionEl.textContent = slide.name || 'Producto';
                imageEl.classList.remove('is-fading');
                captionEl.classList.remove('is-fading');
            }, 180);
        };

        const stop = () => {
            if (timer) {
                window.clearInterval(timer);
                timer = null;
            }
        };

        const start = () => {
            if (timer || slides.length <= 1) {
                return;
            }

            timer = window.setInterval(() => {
                index = (index + 1) % slides.length;
                renderSlide(index);
            }, rotateInterval);
        };

        rotator.addEventListener('mouseenter', stop);
        rotator.addEventListener('mouseleave', start);

        start();
    });

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

    // --- Carrusel videos Descubre Venza ---
    document.querySelectorAll('.blog-t2-video-strip').forEach((videoCarousel) => {
        const viewport = videoCarousel.querySelector('.blog-t2-video-strip__viewport');
        const prev = videoCarousel.querySelector('.blog-t2-video-strip__arrow--prev');
        const next = videoCarousel.querySelector('.blog-t2-video-strip__arrow--next');

        if (!viewport || !prev || !next) return;

        const getScrollAmount = () => {
            const card = viewport.querySelector('.blog-t2-video-card');
            if (!card) {
                return viewport.clientWidth;
            }

            return Math.max(card.getBoundingClientRect().width, viewport.clientWidth * 0.25);
        };

        const updateButtons = () => {
            const maxScroll = viewport.scrollWidth - viewport.clientWidth - 4;
            prev.disabled = viewport.scrollLeft <= 4;
            next.disabled = viewport.scrollLeft >= maxScroll;
        };

        prev.addEventListener('click', () => {
            viewport.scrollBy({ left: -getScrollAmount(), behavior: 'smooth' });
        });

        next.addEventListener('click', () => {
            viewport.scrollBy({ left: getScrollAmount(), behavior: 'smooth' });
        });

        viewport.addEventListener('scroll', updateButtons, { passive: true });
        window.addEventListener('resize', updateButtons);
        updateButtons();
    });

    // --- Selector de video destacado (Descubre Venza) ---
    const escapeAttr = (value) => String(value || '').replace(/[&<>"']/g, (char) => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    }[char]));

    const getYouTubeId = (rawUrl) => {
        const value = String(rawUrl || '').trim();
        if (!value) return '';

        try {
            const url = new URL(value, window.location.href);
            const host = url.hostname.replace(/^www\./, '').toLowerCase();
            const parts = url.pathname.split('/').filter(Boolean);

            if (host === 'youtu.be') {
                return /^[A-Za-z0-9_-]{6,}$/.test(parts[0] || '') ? parts[0] : '';
            }

            if (host === 'youtube.com' || host === 'm.youtube.com' || host === 'youtube-nocookie.com') {
                const watchId = url.searchParams.get('v');
                if (watchId && /^[A-Za-z0-9_-]{6,}$/.test(watchId)) {
                    return watchId;
                }

                const route = parts[0] || '';
                if (['embed', 'shorts', 'live'].includes(route) && /^[A-Za-z0-9_-]{6,}$/.test(parts[1] || '')) {
                    return parts[1];
                }
            }
        } catch (err) {
            return /^[A-Za-z0-9_-]{6,}$/.test(value) ? value : '';
        }

        return '';
    };

    const isVideoFileUrl = (rawUrl) => {
        try {
            const url = new URL(String(rawUrl || ''), window.location.href);
            return /\.(mp4|webm|mov)$/i.test(url.pathname);
        } catch (err) {
            return /\.(mp4|webm|mov)(\?|#|$)/i.test(String(rawUrl || ''));
        }
    };

    const renderDescubreFeatureVideo = (feature, rawUrl, options = {}) => {
        if (!feature || !rawUrl) return false;

        const youtubeId = getYouTubeId(rawUrl);
        const title = escapeAttr(options.title || 'Video Venza');

        if (youtubeId) {
            feature.innerHTML = `
                <div class="blog-t2-feature-video__link blog-t2-feature-video__link--embed">
                    <iframe
                        src="https://www.youtube.com/embed/${youtubeId}?autoplay=1&rel=0"
                        title="${title}"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen
                    ></iframe>
                </div>
            `;
            return true;
        }

        if (!isVideoFileUrl(rawUrl)) {
            return false;
        }

        const src = escapeAttr(rawUrl);
        const mime = escapeAttr(options.mime || 'video/mp4');
        const poster = options.poster ? ` poster="${escapeAttr(options.poster)}"` : '';

        feature.innerHTML = `
            <div class="blog-t2-feature-video__link blog-t2-feature-video__link--video">
                <video controls autoplay playsinline${poster}>
                    <source src="${src}" type="${mime}">
                </video>
            </div>
        `;
        return true;
    };

    document.querySelectorAll('[data-descubre-video-card]').forEach((card) => {
        card.addEventListener('click', (event) => {
            const feature = document.querySelector('[data-descubre-feature-video]');
            const url = card.dataset.videoUrl || card.getAttribute('href') || '';
            const rendered = renderDescubreFeatureVideo(feature, url, {
                mime: card.dataset.videoMime,
                poster: card.dataset.videoPoster,
                title: card.dataset.videoTitle
            });

            if (!rendered) {
                return;
            }

            event.preventDefault();
            document.querySelectorAll('[data-descubre-video-card]').forEach((item) => {
                item.classList.toggle('is-active', item === card);
            });
            feature.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

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
    // --- Galeria de noticias (Slider Infinito Responsivo) ---
    const gallerySlider = document.getElementById('noticia-gallery-slider');
    if (gallerySlider) {
        const viewport = gallerySlider.querySelector('.noticia-gallery__viewport');
        const track = gallerySlider.querySelector('.noticia-gallery__track');
        const originalItems = Array.from(track.querySelectorAll('.noticia-gallery__item'));
        const prev = gallerySlider.querySelector('.noticia-gallery__arrow--prev');
        const next = gallerySlider.querySelector('.noticia-gallery__arrow--next');

        if (viewport && track && originalItems.length > 0) {
            let currentIndex = 0;
            let isTransitioning = false;
            
            const getItemsPerView = () => {
                if (window.innerWidth <= 600) return 1;
                if (window.innerWidth <= 1100) return 2;
                return 4;
            };

            const itemsToClone = 4; // Clonamos 4 para cubrir el peor caso
            
            // Clonar elementos
            const firstClones = originalItems.slice(0, itemsToClone).map(item => item.cloneNode(true));
            const lastClones = originalItems.slice(-itemsToClone).map(item => item.cloneNode(true));

            lastClones.forEach(clone => track.insertBefore(clone, track.firstChild));
            firstClones.forEach(clone => track.appendChild(clone));

            const getMoveAmount = () => {
                const item = track.querySelector('.noticia-gallery__item');
                const style = window.getComputedStyle(track);
                const gap = parseFloat(style.gap) || 24;
                return item.offsetWidth + gap;
            };

            const updatePosition = (smooth = true) => {
                const offset = -(currentIndex + itemsToClone) * getMoveAmount();
                track.style.transition = smooth ? 'transform 0.5s ease-out' : 'none';
                track.style.transform = `translateX(${offset}px)`;
            };

            // Posicion inicial
            updatePosition(false);

            let autoplayTimer = null;
            const startAutoplay = () => {
                stopAutoplay();
                autoplayTimer = setInterval(() => next.click(), 5000);
            };
            const stopAutoplay = () => {
                if (autoplayTimer) clearInterval(autoplayTimer);
            };

            startAutoplay();
            gallerySlider.addEventListener('mouseenter', stopAutoplay);
            gallerySlider.addEventListener('mouseleave', startAutoplay);

            next.addEventListener('click', () => {
                if (isTransitioning) return;
                isTransitioning = true;
                currentIndex++;
                updatePosition();
                stopAutoplay(); // Reset timer on click
                startAutoplay();
            });

            prev.addEventListener('click', () => {
                if (isTransitioning) return;
                isTransitioning = true;
                currentIndex--;
                updatePosition();
                stopAutoplay(); // Reset timer on click
                startAutoplay();
            });

            track.addEventListener('transitionend', () => {
                isTransitioning = false;
                if (currentIndex >= originalItems.length) {
                    currentIndex = 0;
                    updatePosition(false);
                } else if (currentIndex <= -originalItems.length) {
                    currentIndex = 0;
                    updatePosition(false);
                } else if (currentIndex < 0 && Math.abs(currentIndex) >= itemsToClone) {
                    currentIndex = originalItems.length + currentIndex;
                    updatePosition(false);
                }
            });

            window.addEventListener('resize', () => {
                currentIndex = 0;
                updatePosition(false);
            });

            // Soporte touch basico
            let touchStart = 0;
            viewport.addEventListener('touchstart', (e) => {
                touchStart = e.touches[0].clientX;
                stopAutoplay();
            }, {passive: true});
            
            viewport.addEventListener('touchend', (e) => {
                const touchEnd = e.changedTouches[0].clientX;
                if (touchStart - touchEnd > 50) next.click();
                if (touchStart - touchEnd < -50) prev.click();
                startAutoplay();
            }, {passive: true});
        }
    }

    // Lightbox Slider
    const galleryLinks = Array.from(document.querySelectorAll('.js-noticia-gallery-item'));
    galleryLinks.forEach((link, index) => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            let currentIndex = index;

            const modal = document.createElement('div');
            modal.className = 'gallery-modal';
            modal.innerHTML = `
                <div class="gallery-modal__backdrop"></div>
                <div class="gallery-modal__content">
                    <button class="gallery-modal__close" aria-label="Cerrar">&times;</button>
                    <button class="gallery-modal__nav gallery-modal__nav--prev" aria-label="Anterior">&#10094;</button>
                    <img src="${galleryLinks[currentIndex].getAttribute('href')}" class="gallery-modal__image" alt="">
                    <button class="gallery-modal__nav gallery-modal__nav--next" aria-label="Siguiente">&#10095;</button>
                </div>
            `;

            document.body.appendChild(modal);
            document.body.style.overflow = 'hidden';

            const modalImg = modal.querySelector('.gallery-modal__image');
            const btnPrev = modal.querySelector('.gallery-modal__nav--prev');
            const btnNext = modal.querySelector('.gallery-modal__nav--next');

            const updateModalImage = (newIndex) => {
                currentIndex = (newIndex + galleryLinks.length) % galleryLinks.length;
                modalImg.style.opacity = '0';
                setTimeout(() => {
                    modalImg.src = galleryLinks[currentIndex].getAttribute('href');
                    modalImg.style.opacity = '1';
                }, 200);
            };

            btnPrev.addEventListener('click', (e) => { e.stopPropagation(); updateModalImage(currentIndex - 1); });
            btnNext.addEventListener('click', (e) => { e.stopPropagation(); updateModalImage(currentIndex + 1); });

            // Forzar reflow
            modal.offsetWidth;
            modal.classList.add('is-active');

            const closeLightbox = () => {
                modal.classList.remove('is-active');
                setTimeout(() => {
                    modal.remove();
                    document.body.style.overflow = '';
                }, 400);
            };

            modal.querySelector('.gallery-modal__close').addEventListener('click', closeLightbox);
            modal.querySelector('.gallery-modal__backdrop').addEventListener('click', closeLightbox);
            
            const handleKeys = (e) => {
                if (e.key === 'Escape') closeLightbox();
                if (e.key === 'ArrowLeft') updateModalImage(currentIndex - 1);
                if (e.key === 'ArrowRight') updateModalImage(currentIndex + 1);
                if (e.key === 'Escape' || e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
                    // Limpiar evento si se cierra
                    if (e.key === 'Escape') document.removeEventListener('keydown', handleKeys);
                }
            };
            document.addEventListener('keydown', handleKeys);
        });
    });

})();
