<?php
/*
 * Template Name: Quiz de Piel
 */
get_header(); ?>
<main class="quiz-page">
    <div class="container">

        <header class="quiz-header">
            <h1>Descubre qué jabón Venza<br>es ideal para tu piel</h1>
            <p>Responde con imágenes y figuras que mejor te representen</p>
        </header>

        <div class="quiz-wrapper" id="quiz-app" role="form" aria-label="Quiz de tipo de piel">

            <!-- Barra de progreso -->
            <div class="quiz-progress" aria-hidden="true">
                <div class="quiz-progress__bar" id="quiz-progress-bar" style="width: 0%"></div>
            </div>
            <p class="quiz-progress__label">Pregunta <span id="quiz-current-step">1</span> de 6</p>

            <!-- Los 6 steps se renderizan vía JS -->
            <div class="quiz-steps" id="quiz-steps"></div>

            <!-- Resultado (oculto hasta completar) -->
            <div class="quiz-result" id="quiz-result" hidden>
                <h2>Tu jabón ideal es</h2>
                <div class="quiz-result__producto" id="quiz-result-producto"></div>
                <a href="<?php echo home_url('/productos/'); ?>" class="btn btn--primary">Ver todos los productos</a>
                <button class="btn btn--ghost" id="quiz-restart">Intentar de nuevo</button>
            </div>

        </div>

    </div>
</main>
<?php get_footer(); ?>
