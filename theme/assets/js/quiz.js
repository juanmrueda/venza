/* Venza - Quiz de tipo de piel
 * La logica vive en frontend; textos e imagenes pueden venir desde ACF en Descubre Venza.
 */
(function () {
    'use strict';

    const config = window.venzaQuizConfig || {};
    const optionImages = config.optionImages || {};
    const productImages = config.productImages || {};
    const textConfig = config.texts || {};
    const buttonTexts = textConfig.buttons || {};
    const resultUrls = textConfig.urls || {};
    const stepTexts = textConfig.steps || {};
    const productTexts = textConfig.products || {};
    const progressTemplate = textConfig.progressLabel || 'Pregunta {current} de {total}';

    const textOr = (value, fallback) => (typeof value === 'string' && value.trim() !== '' ? value.trim() : fallback);

    const PRODUCTOS = {
        'crema-humectante': {
            nombre: 'Crema Humectante',
            descripcion: 'Tu piel pide nutricion constante. El jabon Crema Humectante es tu aliado diario para mantenerla hidratada, suave y protegida.',
            imagen: '/wp-content/themes/venza/assets/images/productos/crema-humectante.png',
            url: '/productos/crema-humectante/',
        },
        'frescura-extrema': {
            nombre: 'Eucalipto',
            descripcion: 'Tu piel pide frescura y energia. El jabon Eucalipto es tu match: ligero, herbal y perfecto para sentirte renovado cada dia.',
            imagen: '/wp-content/themes/venza/assets/images/productos/frescura-extrema.png',
            url: '/productos/frescura-extrema/',
        },
        'vitamina-e': {
            nombre: 'Vitamina E',
            descripcion: 'Tu energia necesita un boost de vitalidad. El jabon Vitamina E nutre tu piel y la deja luminosa, lista para brillar cada dia.',
            imagen: '/wp-content/themes/venza/assets/images/productos/vitamina-e.png',
            url: '/productos/vitamina-e/',
        },
        sabila: {
            nombre: 'Sabila',
            descripcion: 'Frescura calmante, asi eres tu. El jabon Sabila refresca tu piel, la cuida y la mantiene en equilibrio con un toque natural.',
            imagen: '/wp-content/themes/venza/assets/images/productos/sabila.png',
            url: '/productos/sabila/',
        },
        coco: {
            nombre: 'Coco',
            descripcion: 'Eres tropical y lleno de vida. Tu piel merece el jabon Coco: hidratacion profunda con aroma dulce que te transporta al paraiso.',
            imagen: '/wp-content/themes/venza/assets/images/productos/coco.png',
            url: '/productos/coco/',
        },
        avena: {
            nombre: 'Avena',
            descripcion: 'Tu match es el jabon Avena: suave, natural y perfecto para piel sensible. Te cuida con delicadeza mientras te da bienestar diario.',
            imagen: '/wp-content/themes/venza/assets/images/productos/avena.png',
            url: '/productos/avena/',
        },
    };

    Object.entries(productImages).forEach(([slug, imageUrl]) => {
        if (PRODUCTOS[slug] && typeof imageUrl === 'string' && imageUrl !== '') {
            PRODUCTOS[slug].imagen = imageUrl;
            PRODUCTOS[slug].customResultImage = true;
        }
    });

    Object.entries(productTexts).forEach(([slug, productText]) => {
        if (!PRODUCTOS[slug] || !productText || typeof productText !== 'object') {
            return;
        }

        PRODUCTOS[slug].nombre = textOr(productText.nombre, PRODUCTOS[slug].nombre);
        PRODUCTOS[slug].descripcion = textOr(productText.descripcion, PRODUCTOS[slug].descripcion);
        PRODUCTOS[slug].url = textOr(productText.url, PRODUCTOS[slug].url);
    });

    const PASOS = [
        {
            id: 'piel',
            titulo: '1. Como describes tu tipo de piel?',
            opciones: [
                { key: 'piel_normal', texto: 'Normal', imageKey: 'piel_normal', color: '#d9b28c', puntos: { avena: 2, coco: 1 } },
                { key: 'piel_seca', texto: 'Seca', imageKey: 'piel_seca', color: '#c88f69', puntos: { 'crema-humectante': 3, avena: 1 } },
                { key: 'piel_grasa', texto: 'Grasa', imageKey: 'piel_grasa', color: '#b97b57', puntos: { 'frescura-extrema': 2, sabila: 1 } },
                { key: 'piel_sensible', texto: 'Sensible', imageKey: 'piel_sensible', color: '#d18c8c', puntos: { sabila: 2, avena: 2 } },
                { key: 'piel_mixta', texto: 'Mixta', imageKey: 'piel_mixta', color: '#c57a55', puntos: { 'vitamina-e': 2, 'frescura-extrema': 1 } },
            ],
        },
        {
            id: 'cabello',
            titulo: '2. Color de cabello',
            opciones: [
                { key: 'cabello_negro', texto: 'Negro', imageKey: 'cabello_negro', color: '#25201e', puntos: { 'frescura-extrema': 1, coco: 1 } },
                { key: 'cabello_rubio', texto: 'Rubio', imageKey: 'cabello_rubio', color: '#d6b36f', puntos: { 'vitamina-e': 1, 'crema-humectante': 1 } },
                { key: 'cabello_castano_claro', texto: 'Castano claro', imageKey: 'cabello_castano_claro', color: '#845638', puntos: { avena: 1, 'vitamina-e': 1 } },
                { key: 'cabello_pelirrojo', texto: 'Pelirrojo', imageKey: 'cabello_pelirrojo', color: '#a33f24', puntos: { 'vitamina-e': 2, 'frescura-extrema': 1 } },
                { key: 'cabello_castano_oscuro', texto: 'Castano oscuro', imageKey: 'cabello_castano_oscuro', color: '#3f2a21', puntos: { coco: 1, 'frescura-extrema': 1 } },
                { key: 'cabello_gris', texto: 'Gris', imageKey: 'cabello_gris', color: '#bfc1c0', puntos: { 'crema-humectante': 2, avena: 1 } },
            ],
        },
        {
            id: 'aroma',
            titulo: '3. Cual es tu aroma favorito?',
            opciones: [
                { key: 'aroma_eucalipto', texto: 'Eucalipto', imageKey: 'aroma_eucalipto', puntos: { 'frescura-extrema': 3 } },
                { key: 'aroma_manzana', texto: 'Manzana', imageKey: 'aroma_manzana', puntos: { 'crema-humectante': 2, 'vitamina-e': 1 } },
                { key: 'aroma_coco', texto: 'Coco', imageKey: 'aroma_coco', puntos: { coco: 3 } },
                { key: 'aroma_menta', texto: 'Menta', imageKey: 'aroma_menta', puntos: { 'frescura-extrema': 3 } },
                { key: 'aroma_sabila', texto: 'Sabila', imageKey: 'aroma_sabila', puntos: { sabila: 3 } },
                { key: 'aroma_frutas_citricas', texto: 'Frutas citricas', imageKey: 'aroma_frutas_citricas', puntos: { 'vitamina-e': 3, 'frescura-extrema': 1 } },
            ],
        },
        {
            id: 'sensacion',
            titulo: '4. Despues de banarte, quieres sentir tu piel...',
            opciones: [
                { key: 'sensacion_hidratada', texto: 'Muy hidratada y protegida', puntos: { 'crema-humectante': 3 } },
                { key: 'sensacion_refrescada', texto: 'Refrescada y ligera', puntos: { 'frescura-extrema': 3 } },
                { key: 'sensacion_calmante', texto: 'Calmante y cuidada', puntos: { sabila: 3, avena: 1 } },
                { key: 'sensacion_nutritiva', texto: 'Nutritiva y revitalizada', puntos: { 'vitamina-e': 3 } },
                { key: 'sensacion_tropical', texto: 'Suave y tropical', puntos: { coco: 3 } },
            ],
        },
        {
            id: 'paisaje',
            titulo: '5. Elige el paisaje que mas te relaja',
            opciones: [
                { key: 'paisaje_playa_tropical', texto: 'Playa tropical', imageKey: 'paisaje_playa_tropical', puntos: { coco: 3 } },
                { key: 'paisaje_huerto_manzanas', texto: 'Huerto de manzanas', imageKey: 'paisaje_huerto_manzanas', puntos: { 'crema-humectante': 2, 'vitamina-e': 1 } },
                { key: 'paisaje_bosque_verde', texto: 'Bosque verde', imageKey: 'paisaje_bosque_verde', puntos: { sabila: 2, avena: 1 } },
                { key: 'paisaje_jardin_aloe', texto: 'Jardin de aloe', imageKey: 'paisaje_jardin_aloe', puntos: { sabila: 3 } },
                { key: 'paisaje_campo_avena', texto: 'Campo de avena', imageKey: 'paisaje_campo_avena', puntos: { avena: 3 } },
                { key: 'paisaje_montana', texto: 'Montana', imageKey: 'paisaje_montana', puntos: { 'frescura-extrema': 2, 'vitamina-e': 1 } },
            ],
        },
        {
            id: 'frecuencia',
            titulo: '6. Con que frecuencia te das un bano',
            opciones: [
                { key: 'frecuencia_una_vez', texto: 'Una vez al dia', puntos: { 'crema-humectante': 1, 'vitamina-e': 1 } },
                { key: 'frecuencia_dos_veces', texto: 'Dos veces al dia', puntos: { 'frescura-extrema': 2, sabila: 1 } },
                { key: 'frecuencia_cuatro', texto: '4 veces por semana', puntos: { avena: 2, coco: 1 } },
                { key: 'frecuencia_necesario', texto: 'Solo cuando hace falta', puntos: { avena: 2, 'crema-humectante': 1 } },
            ],
        },
    ];

    PASOS.forEach((paso) => {
        const overrides = stepTexts[paso.id] || {};
        paso.titulo = textOr(overrides.titulo, paso.titulo);

        const optionOverrides = overrides.opciones || {};
        paso.opciones.forEach((opcion) => {
            opcion.texto = textOr(optionOverrides[opcion.key], opcion.texto);
        });
    });

    const state = {
        pasoActual: 0,
        respuestas: {},
    };

    const app = document.getElementById('quiz-app');
    const stepsEl = document.getElementById('quiz-steps');
    const resultEl = document.getElementById('quiz-result');
    const progressBar = document.getElementById('quiz-progress-bar');
    const progressLabelEl = document.getElementById('quiz-progress-label');
    const restartBtn = document.getElementById('quiz-restart');
    const resultLink = document.getElementById('quiz-result-link');
    const allProductsLink = document.getElementById('quiz-all-products');

    if (!app || !stepsEl || !resultEl) return;

    function init() {
        PASOS.forEach((paso, i) => {
            stepsEl.appendChild(renderStep(paso, i));
        });

        if (restartBtn) {
            restartBtn.textContent = textOr(buttonTexts.restart, restartBtn.textContent);
            restartBtn.addEventListener('click', () => {
                state.pasoActual = 0;
                state.respuestas = {};
                resetSelections();
                app.classList.remove('is-result');
                resultEl.hidden = true;
                stepsEl.style.display = '';
                toggleProgress(false);
                mostrarPaso(0);
            });
        }

        if (allProductsLink) {
            allProductsLink.textContent = textOr(buttonTexts.allProducts, allProductsLink.textContent);
            allProductsLink.href = textOr(resultUrls.allProducts, allProductsLink.getAttribute('href') || '/productos/');
        }

        mostrarPaso(0, false);
    }

    function renderStep(paso, index) {
        const div = document.createElement('div');
        div.className = 'quiz-step';
        div.id = 'quiz-step-' + index;
        div.setAttribute('role', 'group');
        div.setAttribute('aria-labelledby', 'quiz-title-' + index);

        const titulo = document.createElement('p');
        titulo.className = 'quiz-step__title';
        titulo.id = 'quiz-title-' + index;
        titulo.textContent = paso.titulo;
        div.appendChild(titulo);

        const grid = document.createElement('div');
        grid.className = 'quiz-options';
        if (paso.opciones.some((op) => getOptionImage(op))) {
            grid.classList.add('quiz-options--visual');
        }
        div.appendChild(grid);

        paso.opciones.forEach((op, opIndex) => {
            const btn = document.createElement('button');
            const imageUrl = getOptionImage(op);
            btn.className = 'quiz-option';
            if (imageUrl) {
                btn.classList.add('quiz-option--has-image');
            } else if (op.color) {
                btn.classList.add('is-swatch');
            } else {
                btn.classList.add('quiz-option--text-only');
            }
            btn.setAttribute('type', 'button');
            btn.setAttribute('role', 'radio');
            btn.setAttribute('aria-selected', 'false');
            btn.dataset.paso = paso.id;
            btn.dataset.index = opIndex;

            if (imageUrl) {
                const img = document.createElement('img');
                img.src = imageUrl;
                img.alt = op.texto;
                img.loading = 'lazy';
                btn.appendChild(img);
            } else if (op.color) {
                const swatch = document.createElement('span');
                swatch.className = 'quiz-option__swatch';
                swatch.style.background = op.color;
                swatch.setAttribute('aria-hidden', 'true');
                btn.appendChild(swatch);
            }

            const label = document.createElement('span');
            label.className = 'quiz-option__label';
            label.textContent = op.texto;
            btn.appendChild(label);

            btn.addEventListener('click', () => seleccionar(paso, index, opIndex, btn, grid));
            grid.appendChild(btn);
        });

        const nav = document.createElement('div');
        nav.className = 'quiz-nav';

        if (index > 0) {
            const back = document.createElement('button');
            back.className = 'btn btn--ghost';
            back.type = 'button';
            back.textContent = textOr(buttonTexts.back, 'Atras');
            back.addEventListener('click', () => mostrarPaso(index - 1));
            nav.appendChild(back);
        }

        const next = document.createElement('button');
        next.className = 'btn btn--primary quiz-btn-next';
        next.type = 'button';
        next.textContent = index < PASOS.length - 1
            ? textOr(buttonTexts.next, 'Siguiente')
            : textOr(buttonTexts.result, 'Ver mi resultado');
        next.disabled = true;
        next.addEventListener('click', () => avanzar(index));
        nav.appendChild(next);

        div.appendChild(nav);
        return div;
    }

    function getOptionImage(op) {
        if (!op.imageKey) return '';
        const imageUrl = optionImages[op.imageKey];
        return typeof imageUrl === 'string' ? imageUrl : '';
    }

    function seleccionar(paso, pasoIndex, opIndex, btn, grid) {
        grid.querySelectorAll('.quiz-option').forEach((button) => {
            button.setAttribute('aria-selected', 'false');
        });
        btn.setAttribute('aria-selected', 'true');
        state.respuestas[paso.id] = opIndex;

        const nextBtn = document.querySelector('#quiz-step-' + pasoIndex + ' .quiz-btn-next');
        if (nextBtn) nextBtn.disabled = false;
    }

    function avanzar(index) {
        if (index < PASOS.length - 1) {
            mostrarPaso(index + 1);
            return;
        }

        mostrarResultado();
    }

    function mostrarPaso(index, shouldScroll = true) {
        app.classList.remove('is-result');
        state.pasoActual = index;
        document.querySelectorAll('.quiz-step').forEach((el, i) => {
            el.classList.toggle('is-active', i === index);
        });

        const pct = Math.round((index / PASOS.length) * 100);
        if (progressBar) progressBar.style.width = pct + '%';
        updateProgressLabel(index + 1);

        const paso = PASOS[index];
        const prevRespuesta = state.respuestas[paso.id];
        if (prevRespuesta !== undefined) {
            const stepEl = document.getElementById('quiz-step-' + index);
            const opts = stepEl.querySelectorAll('.quiz-option');
            if (opts[prevRespuesta]) {
                opts[prevRespuesta].setAttribute('aria-selected', 'true');
                const nextBtn = stepEl.querySelector('.quiz-btn-next');
                if (nextBtn) nextBtn.disabled = false;
            }
        }

        if (shouldScroll) {
            app.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    function mostrarResultado() {
        const puntajes = calcularPuntajes();
        const ganador = Object.entries(puntajes).sort((a, b) => b[1] - a[1])[0][0];
        const producto = PRODUCTOS[ganador];

        stepsEl.style.display = 'none';
        app.classList.add('is-result');
        toggleProgress(true);
        resultEl.hidden = false;

        const contenido = document.getElementById('quiz-result-producto');
        contenido.innerHTML = '';
        contenido.appendChild(renderResultCard(producto));

        if (resultLink) {
            resultLink.href = producto.url;
            resultLink.textContent = textOr(buttonTexts.knowMore, 'Conoce mas');
        }

        if (progressBar) progressBar.style.width = '100%';
        resultEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function renderResultCard(producto) {
        const card = document.createElement('article');
        card.className = 'quiz-result__card';
        const safeImage = String(producto.imagen || '').replace(/"/g, '\\"');
        if (safeImage) {
            card.style.setProperty('--quiz-result-image', `url("${safeImage}")`);
        }

        const copy = document.createElement('div');
        copy.className = 'quiz-result__copy';

        const title = document.createElement('h3');
        title.textContent = producto.nombre;
        copy.appendChild(title);

        const description = document.createElement('p');
        description.textContent = producto.descripcion;
        copy.appendChild(description);

        card.appendChild(copy);

        if (!producto.customResultImage && producto.imagen) {
            const image = document.createElement('img');
            image.className = 'quiz-result__image';
            image.src = producto.imagen;
            image.alt = producto.nombre;
            image.loading = 'lazy';
            card.appendChild(image);
        }

        return card;
    }

    function calcularPuntajes() {
        const puntajes = {};
        Object.keys(PRODUCTOS).forEach((slug) => {
            puntajes[slug] = 0;
        });

        PASOS.forEach((paso) => {
            const opIndex = state.respuestas[paso.id];
            if (opIndex === undefined || !paso.opciones[opIndex]) return;

            Object.entries(paso.opciones[opIndex].puntos).forEach(([slug, pts]) => {
                puntajes[slug] = (puntajes[slug] || 0) + pts;
            });
        });

        return puntajes;
    }

    function updateProgressLabel(current) {
        if (!progressLabelEl) return;
        progressLabelEl.textContent = progressTemplate
            .replace('{current}', String(current))
            .replace('{total}', String(PASOS.length));
    }

    function toggleProgress(hidden) {
        const progress = app.querySelector('.quiz-progress');
        const label = app.querySelector('.quiz-progress__label');
        if (progress) progress.toggleAttribute('hidden', hidden);
        if (label) label.toggleAttribute('hidden', hidden);
    }

    function resetSelections() {
        document.querySelectorAll('.quiz-option').forEach((button) => {
            button.setAttribute('aria-selected', 'false');
        });
        document.querySelectorAll('.quiz-btn-next').forEach((button) => {
            button.disabled = true;
        });
    }

    init();
})();
