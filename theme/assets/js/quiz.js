/* Venza — Quiz de tipo de piel
 * Sin dependencias. Sin backend. Puntaje por respuesta → jabón recomendado.
 */
(function () {
    'use strict';

    // ── Datos del quiz ────────────────────────────────────────────────────────

    const PRODUCTOS = {
        'crema-humectante': {
            nombre:      'Crema Humectante',
            descripcion: 'Tu piel pide nutrición constante. El jabón Crema Humectante es tu aliado diario para mantenerla hidratada, suave y protegida.',
            imagen:      '/wp-content/themes/venza/assets/images/productos/crema-humectante.png',
            url:         '/productos/crema-humectante/',
        },
        'frescura-extrema': {
            nombre:      'Frescura Extrema',
            descripcion: 'Tu piel pide frescura y energía. El jabón Frescura Extrema refresca, tonifica y mejora la microcirculación sanguínea.',
            imagen:      '/wp-content/themes/venza/assets/images/productos/frescura-extrema.png',
            url:         '/productos/frescura-extrema/',
        },
        'vitamina-e': {
            nombre:      'Vitamina E',
            descripcion: 'Tu energía necesita un boost de vitalidad. El jabón Vitamina E nutre tu piel y la deja luminosa, lista para brillar cada día.',
            imagen:      '/wp-content/themes/venza/assets/images/productos/vitamina-e.png',
            url:         '/productos/vitamina-e/',
        },
        'sabila': {
            nombre:      'Sábila',
            descripcion: 'Tu piel es calmante y natural. El jabón Sábila refresca tu piel, la cuida y la mantiene en equilibrio con un toque natural.',
            imagen:      '/wp-content/themes/venza/assets/images/productos/sabila.png',
            url:         '/productos/sabila/',
        },
        'coco': {
            nombre:      'Coco',
            descripcion: 'Eres tropical y lleno de vida. Tu piel merece el jabón Coco: hidratación profunda con aroma dulce que te transporta al paraíso.',
            imagen:      '/wp-content/themes/venza/assets/images/productos/coco.png',
            url:         '/productos/coco/',
        },
        'avena': {
            nombre:      'Avena',
            descripcion: 'Tu match es el jabón Avena: suave, natural y perfecto para piel sensible. Te cuida con delicadeza mientras te da bienestar diario.',
            imagen:      '/wp-content/themes/venza/assets/images/productos/avena.png',
            url:         '/productos/avena/',
        },
    };

    // Preguntas. Cada opción tiene un array de puntos por producto.
    // Estructura de puntos: { 'producto-slug': puntaje }
    const PASOS = [
        {
            id:        'piel',
            titulo:    '1. ¿Cuál es tu tipo de piel?',
            tipo:      'swatch',
            opciones: [
                { texto: 'Normal',     color: '#D4A882', puntos: { 'avena': 2, 'coco': 1 } },
                { texto: 'Grasa',      color: '#C8925A', puntos: { 'frescura-extrema': 2, 'sabila': 1 } },
                { texto: 'Combinada',  color: '#B87B4A', puntos: { 'vitamina-e': 2, 'frescura-extrema': 1 } },
                { texto: 'Seca',       color: '#A0613A', puntos: { 'crema-humectante': 3, 'avena': 1 } },
            ],
        },
        {
            id:        'cabello',
            titulo:    '2. ¿Cómo describes tu color de cabello?',
            tipo:      'swatch',
            opciones: [
                { texto: 'Rubio',     color: '#E8CC8A', puntos: { 'vitamina-e': 1, 'crema-humectante': 1 } },
                { texto: 'Negro',     color: '#2A2A2A', puntos: { 'frescura-extrema': 1, 'coco': 1 } },
                { texto: 'Castaño',   color: '#7B4F2A', puntos: { 'avena': 1, 'sabila': 1 } },
                { texto: 'Canoso',    color: '#C8C8C8', puntos: { 'crema-humectante': 2, 'avena': 1 } },
            ],
        },
        {
            id:        'aroma',
            titulo:    '3. ¿Cuál es tu aroma favorito?',
            tipo:      'imagen',
            opciones: [
                { texto: 'Herbal / Menta', imagen: 'aroma-herbal.jpg',  puntos: { 'frescura-extrema': 3 } },
                { texto: 'Coco',           imagen: 'aroma-coco.jpg',    puntos: { 'coco': 3 } },
                { texto: 'Cítrico',        imagen: 'aroma-citrico.jpg', puntos: { 'vitamina-e': 2, 'frescura-extrema': 1 } },
                { texto: 'Sábila',         imagen: 'aroma-sabila.jpg',  puntos: { 'sabila': 3 } },
                { texto: 'Frutal',         imagen: 'aroma-frutal.jpg',  puntos: { 'vitamina-e': 2, 'avena': 1 } },
                { texto: 'Floral',         imagen: 'aroma-floral.jpg',  puntos: { 'crema-humectante': 2, 'avena': 1 } },
            ],
        },
        {
            id:        'sensacion',
            titulo:    '4. Después de bañarte, ¿cómo sientes tu piel?',
            tipo:      'texto',
            opciones: [
                { texto: 'Muy hidratada y protegida', puntos: { 'crema-humectante': 3 } },
                { texto: 'Brillante y ligera',        puntos: { 'vitamina-e': 3 } },
                { texto: 'Calmada y suavizada',       puntos: { 'avena': 3, 'sabila': 1 } },
                { texto: 'Fresca y revitalizada',     puntos: { 'frescura-extrema': 3 } },
            ],
        },
        {
            id:        'entorno',
            titulo:    '5. Elige el entorno natural que más te relaja',
            tipo:      'imagen',
            opciones: [
                { texto: 'Bosque',    imagen: 'entorno-bosque.jpg',    puntos: { 'sabila': 2, 'avena': 1 } },
                { texto: 'Playa',     imagen: 'entorno-playa.jpg',     puntos: { 'coco': 2, 'frescura-extrema': 1 } },
                { texto: 'Jardín',    imagen: 'entorno-jardin.jpg',    puntos: { 'crema-humectante': 2, 'avena': 1 } },
                { texto: 'Montaña',   imagen: 'entorno-montana.jpg',   puntos: { 'frescura-extrema': 2, 'vitamina-e': 1 } },
            ],
        },
        {
            id:        'frecuencia',
            titulo:    '6. ¿Con qué frecuencia usas un baño?',
            tipo:      'texto',
            opciones: [
                { texto: 'Más de 1 vez al día',            puntos: { 'frescura-extrema': 2, 'avena': 1 } },
                { texto: '1 vez al día',                   puntos: { 'crema-humectante': 1, 'vitamina-e': 1 } },
                { texto: 'Poco más de una vez a la semana',puntos: { 'coco': 2, 'sabila': 1 } },
                { texto: 'Solo cuando puedo',              puntos: { 'avena': 2, 'crema-humectante': 1 } },
            ],
        },
    ];

    // ── Estado ────────────────────────────────────────────────────────────────

    const state = {
        pasoActual:   0,
        respuestas:   {},   // { paso_id: indice_opcion }
        puntajes:     {},   // { producto_slug: total }
    };

    // ── DOM ───────────────────────────────────────────────────────────────────

    const app          = document.getElementById('quiz-app');
    const stepsEl      = document.getElementById('quiz-steps');
    const resultEl     = document.getElementById('quiz-result');
    const progressBar  = document.getElementById('quiz-progress-bar');
    const currentStepEl= document.getElementById('quiz-current-step');
    const restartBtn   = document.getElementById('quiz-restart');

    if (!app) return; // No estamos en la página del quiz

    // ── Inicializar ───────────────────────────────────────────────────────────

    function init() {
        // Inicializar puntajes
        Object.keys(PRODUCTOS).forEach(slug => { state.puntajes[slug] = 0; });

        // Renderizar todos los steps
        PASOS.forEach((paso, i) => {
            stepsEl.appendChild(renderStep(paso, i));
        });

        mostrarPaso(0);

        if (restartBtn) {
            restartBtn.addEventListener('click', () => {
                state.pasoActual = 0;
                state.respuestas = {};
                Object.keys(state.puntajes).forEach(s => { state.puntajes[s] = 0; });
                resultEl.hidden = true;
                stepsEl.style.display = '';
                app.querySelector('.quiz-progress').removeAttribute('hidden');
                app.querySelector('.quiz-progress__label').removeAttribute('hidden');
                mostrarPaso(0);
            });
        }
    }

    // ── Renderizar paso ───────────────────────────────────────────────────────

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
            btn.className = 'quiz-option' + (paso.tipo === 'swatch' ? ' is-swatch' : '');
            btn.setAttribute('type', 'button');
            btn.setAttribute('role', 'radio');
            btn.setAttribute('aria-selected', 'false');
            btn.dataset.paso  = paso.id;
            btn.dataset.index = opIndex;

            if (paso.tipo === 'swatch') {
                const swatch = document.createElement('span');
                swatch.className = 'quiz-option__swatch';
                swatch.style.background = op.color;
                swatch.setAttribute('aria-hidden', 'true');
                btn.appendChild(swatch);
            } else if (paso.tipo === 'imagen') {
                const img = document.createElement('img');
                const basePath = '/wp-content/themes/venza/assets/images/quiz/';
                img.src = basePath + op.imagen;
                img.alt = op.texto;
                img.loading = 'lazy';
                btn.appendChild(img);
            }

            const label = document.createElement('span');
            label.textContent = op.texto;
            btn.appendChild(label);

            btn.addEventListener('click', () => seleccionar(paso, index, opIndex, btn, grid));
            grid.appendChild(btn);
        });

        // Navegación
        const nav = document.createElement('div');
        nav.className = 'quiz-nav';

        if (index > 0) {
            const back = document.createElement('button');
            back.className = 'btn btn--ghost';
            back.type = 'button';
            back.textContent = '← Atrás';
            back.addEventListener('click', () => mostrarPaso(index - 1));
            nav.appendChild(back);
        }

        const next = document.createElement('button');
        next.className = 'btn btn--primary quiz-btn-next';
        next.type = 'button';
        next.textContent = index < PASOS.length - 1 ? 'Siguiente →' : 'Ver mi resultado';
        next.disabled = true;
        next.addEventListener('click', () => avanzar(paso, index));
        nav.appendChild(next);

        div.appendChild(nav);
        return div;
    }

    // ── Seleccionar opción ────────────────────────────────────────────────────

    function seleccionar(paso, pasoIndex, opIndex, btn, grid) {
        // Deseleccionar todas
        grid.querySelectorAll('.quiz-option').forEach(b => b.setAttribute('aria-selected', 'false'));
        // Seleccionar la elegida
        btn.setAttribute('aria-selected', 'true');
        // Guardar respuesta
        state.respuestas[paso.id] = opIndex;
        // Habilitar botón siguiente
        const nextBtn = document.querySelector('#quiz-step-' + pasoIndex + ' .quiz-btn-next');
        if (nextBtn) nextBtn.disabled = false;
    }

    // ── Avanzar ───────────────────────────────────────────────────────────────

    function avanzar(paso, index) {
        // Sumar puntajes de la respuesta seleccionada
        const opIndex = state.respuestas[paso.id];
        if (opIndex !== undefined) {
            const op = paso.opciones[opIndex];
            Object.entries(op.puntos).forEach(([slug, pts]) => {
                state.puntajes[slug] = (state.puntajes[slug] || 0) + pts;
            });
        }

        if (index < PASOS.length - 1) {
            mostrarPaso(index + 1);
        } else {
            mostrarResultado();
        }
    }

    // ── Mostrar paso ──────────────────────────────────────────────────────────

    function mostrarPaso(index) {
        state.pasoActual = index;
        document.querySelectorAll('.quiz-step').forEach((el, i) => {
            el.classList.toggle('is-active', i === index);
        });
        // Actualizar progreso
        const pct = Math.round((index / PASOS.length) * 100);
        if (progressBar)   progressBar.style.width = pct + '%';
        if (currentStepEl) currentStepEl.textContent = index + 1;

        // Restaurar selección previa si existe
        const paso = PASOS[index];
        const prevRespuesta = state.respuestas[paso.id];
        if (prevRespuesta !== undefined) {
            const stepEl = document.getElementById('quiz-step-' + index);
            const opts   = stepEl.querySelectorAll('.quiz-option');
            if (opts[prevRespuesta]) {
                opts[prevRespuesta].setAttribute('aria-selected', 'true');
                const nextBtn = stepEl.querySelector('.quiz-btn-next');
                if (nextBtn) nextBtn.disabled = false;
            }
        }

        // Scroll al top del quiz
        app.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // ── Mostrar resultado ─────────────────────────────────────────────────────

    function mostrarResultado() {
        // Encontrar el producto con mayor puntaje
        const ganador = Object.entries(state.puntajes).sort((a, b) => b[1] - a[1])[0][0];
        const producto = PRODUCTOS[ganador];

        stepsEl.style.display = 'none';
        app.querySelector('.quiz-progress').setAttribute('hidden', '');
        app.querySelector('.quiz-progress__label').setAttribute('hidden', '');
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

    // ── Arrancar ──────────────────────────────────────────────────────────────
    init();

})();
