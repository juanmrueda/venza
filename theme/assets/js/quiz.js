/* Venza - Quiz de tipo de piel
 * La lógica vive en frontend; las imágenes pueden venir desde ACF en Descubre Venza.
 */
(function () {
    'use strict';

    const config = window.venzaQuizConfig || {};
    const optionImages = config.optionImages || {};
    const productImages = config.productImages || {};

    const PRODUCTOS = {
        'crema-humectante': {
            nombre: 'Crema Humectante',
            descripcion: 'Tu piel pide nutrición constante. El jabón Crema Humectante es tu aliado diario para mantenerla hidratada, suave y protegida.',
            imagen: '/wp-content/themes/venza/assets/images/productos/crema-humectante.png',
            url: '/productos/crema-humectante/',
        },
        'frescura-extrema': {
            nombre: 'Frescura Extrema',
            descripcion: 'Tu piel pide frescura y energía. El jabón Frescura Extrema es tu match: ligero, herbal y perfecto para sentirte renovado cada día.',
            imagen: '/wp-content/themes/venza/assets/images/productos/frescura-extrema.png',
            url: '/productos/frescura-extrema/',
        },
        'vitamina-e': {
            nombre: 'Vitamina E',
            descripcion: 'Tu energía necesita un boost de vitalidad. El jabón Vitamina E nutre tu piel y la deja luminosa, lista para brillar cada día.',
            imagen: '/wp-content/themes/venza/assets/images/productos/vitamina-e.png',
            url: '/productos/vitamina-e/',
        },
        'sabila': {
            nombre: 'Sábila',
            descripcion: 'Frescura calmante, así eres tú. El jabón Sábila refresca tu piel, la cuida y la mantiene en equilibrio con un toque natural.',
            imagen: '/wp-content/themes/venza/assets/images/productos/sabila.png',
            url: '/productos/sabila/',
        },
        'coco': {
            nombre: 'Coco',
            descripcion: 'Eres tropical y lleno de vida. Tu piel merece el jabón Coco: hidratación profunda con aroma dulce que te transporta al paraíso.',
            imagen: '/wp-content/themes/venza/assets/images/productos/coco.png',
            url: '/productos/coco/',
        },
        'avena': {
            nombre: 'Avena',
            descripcion: 'Tu match es el jabón Avena: suave, natural y perfecto para piel sensible. Te cuida con delicadeza mientras te da bienestar diario.',
            imagen: '/wp-content/themes/venza/assets/images/productos/avena.png',
            url: '/productos/avena/',
        },
    };

    Object.entries(productImages).forEach(([slug, imageUrl]) => {
        if (PRODUCTOS[slug] && typeof imageUrl === 'string' && imageUrl !== '') {
            PRODUCTOS[slug].imagen = imageUrl;
        }
    });

    const PASOS = [
        {
            id: 'piel',
            titulo: '1. ¿Cómo describes tu tipo de piel?',
            opciones: [
                { texto: 'Normal', imageKey: 'piel_normal', color: '#d9b28c', puntos: { avena: 2, coco: 1 } },
                { texto: 'Seca', imageKey: 'piel_seca', color: '#c88f69', puntos: { 'crema-humectante': 3, avena: 1 } },
                { texto: 'Grasa', imageKey: 'piel_grasa', color: '#b97b57', puntos: { 'frescura-extrema': 2, sabila: 1 } },
                { texto: 'Sensible', imageKey: 'piel_sensible', color: '#d18c8c', puntos: { sabila: 2, avena: 2 } },
                { texto: 'Mixta', imageKey: 'piel_mixta', color: '#c57a55', puntos: { 'vitamina-e': 2, 'frescura-extrema': 1 } },
            ],
        },
        {
            id: 'cabello',
            titulo: '2. Color de cabello',
            opciones: [
                { texto: 'Negro', imageKey: 'cabello_negro', color: '#25201e', puntos: { 'frescura-extrema': 1, coco: 1 } },
                { texto: 'Rubio', imageKey: 'cabello_rubio', color: '#d6b36f', puntos: { 'vitamina-e': 1, 'crema-humectante': 1 } },
                { texto: 'Castaño claro', imageKey: 'cabello_castano_claro', color: '#845638', puntos: { avena: 1, 'vitamina-e': 1 } },
                { texto: 'Pelirrojo', imageKey: 'cabello_pelirrojo', color: '#a33f24', puntos: { 'vitamina-e': 2, 'frescura-extrema': 1 } },
                { texto: 'Castaño oscuro', imageKey: 'cabello_castano_oscuro', color: '#3f2a21', puntos: { coco: 1, 'frescura-extrema': 1 } },
                { texto: 'Gris', imageKey: 'cabello_gris', color: '#bfc1c0', puntos: { 'crema-humectante': 2, avena: 1 } },
            ],
        },
        {
            id: 'aroma',
            titulo: '3. ¿Cuál es tu aroma favorito?',
            opciones: [
                { texto: 'Eucalipto', imageKey: 'aroma_eucalipto', puntos: { 'frescura-extrema': 3 } },
                { texto: 'Manzana', imageKey: 'aroma_manzana', puntos: { 'crema-humectante': 2, 'vitamina-e': 1 } },
                { texto: 'Coco', imageKey: 'aroma_coco', puntos: { coco: 3 } },
                { texto: 'Menta', imageKey: 'aroma_menta', puntos: { 'frescura-extrema': 3 } },
                { texto: 'Sábila', imageKey: 'aroma_sabila', puntos: { sabila: 3 } },
                { texto: 'Frutas cítricas', imageKey: 'aroma_frutas_citricas', puntos: { 'vitamina-e': 3, 'frescura-extrema': 1 } },
            ],
        },
        {
            id: 'sensacion',
            titulo: '4. Después de bañarte, quieres sentir tu piel...',
            opciones: [
                { texto: 'Muy hidratada y protegida', puntos: { 'crema-humectante': 3 } },
                { texto: 'Refrescada y ligera', puntos: { 'frescura-extrema': 3 } },
                { texto: 'Calmante y cuidada', puntos: { sabila: 3, avena: 1 } },
                { texto: 'Nutritiva y revitalizada', puntos: { 'vitamina-e': 3 } },
                { texto: 'Suave y tropical', puntos: { coco: 3 } },
            ],
        },
        {
            id: 'paisaje',
            titulo: '5. Elige el paisaje que más te relaja',
            opciones: [
                { texto: 'Playa tropical', imageKey: 'paisaje_playa_tropical', puntos: { coco: 3 } },
                { texto: 'Huerto de manzanas', imageKey: 'paisaje_huerto_manzanas', puntos: { 'crema-humectante': 2, 'vitamina-e': 1 } },
                { texto: 'Bosque verde', imageKey: 'paisaje_bosque_verde', puntos: { sabila: 2, avena: 1 } },
                { texto: 'Jardín de aloe', imageKey: 'paisaje_jardin_aloe', puntos: { sabila: 3 } },
                { texto: 'Campo de avena', imageKey: 'paisaje_campo_avena', puntos: { avena: 3 } },
                { texto: 'Montaña', imageKey: 'paisaje_montana', puntos: { 'frescura-extrema': 2, 'vitamina-e': 1 } },
            ],
        },
        {
            id: 'frecuencia',
            titulo: '6. Con qué frecuencia te das un baño',
            opciones: [
                { texto: 'Una vez al día', puntos: { 'crema-humectante': 1, 'vitamina-e': 1 } },
                { texto: 'Dos veces al día', puntos: { 'frescura-extrema': 2, sabila: 1 } },
                { texto: '4 veces por semana', puntos: { avena: 2, coco: 1 } },
                { texto: 'Solo cuando hace falta', puntos: { avena: 2, 'crema-humectante': 1 } },
            ],
        },
    ];

    const state = {
        pasoActual: 0,
        respuestas: {},
    };

    const app = document.getElementById('quiz-app');
    const stepsEl = document.getElementById('quiz-steps');
    const resultEl = document.getElementById('quiz-result');
    const progressBar = document.getElementById('quiz-progress-bar');
    const currentStepEl = document.getElementById('quiz-current-step');
    const restartBtn = document.getElementById('quiz-restart');

    if (!app || !stepsEl || !resultEl) return;

    function init() {
        PASOS.forEach((paso, i) => {
            stepsEl.appendChild(renderStep(paso, i));
        });

        mostrarPaso(0);

        if (restartBtn) {
            restartBtn.addEventListener('click', () => {
                state.pasoActual = 0;
                state.respuestas = {};
                resetSelections();
                resultEl.hidden = true;
                stepsEl.style.display = '';
                toggleProgress(false);
                mostrarPaso(0);
            });
        }
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
            back.textContent = 'Atrás';
            back.addEventListener('click', () => mostrarPaso(index - 1));
            nav.appendChild(back);
        }

        const next = document.createElement('button');
        next.className = 'btn btn--primary quiz-btn-next';
        next.type = 'button';
        next.textContent = index < PASOS.length - 1 ? 'Siguiente' : 'Ver mi resultado';
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

    function mostrarPaso(index) {
        state.pasoActual = index;
        document.querySelectorAll('.quiz-step').forEach((el, i) => {
            el.classList.toggle('is-active', i === index);
        });

        const pct = Math.round((index / PASOS.length) * 100);
        if (progressBar) progressBar.style.width = pct + '%';
        if (currentStepEl) currentStepEl.textContent = index + 1;

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

        app.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function mostrarResultado() {
        const puntajes = calcularPuntajes();
        const ganador = Object.entries(puntajes).sort((a, b) => b[1] - a[1])[0][0];
        const producto = PRODUCTOS[ganador];

        stepsEl.style.display = 'none';
        toggleProgress(true);
        resultEl.hidden = false;

        const contenido = document.getElementById('quiz-result-producto');
        contenido.innerHTML = `
            <img src="${producto.imagen}" alt="${producto.nombre}" loading="lazy">
            <h3>${producto.nombre}</h3>
            <p>${producto.descripcion}</p>
            <a href="${producto.url}" class="btn btn--primary" style="margin-top:1rem">Conoce más</a>
        `;

        if (progressBar) progressBar.style.width = '100%';
        resultEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
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
