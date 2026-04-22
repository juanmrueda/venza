<?php
/*
 * Template Name: Descubre Venza
 */
get_header(); ?>
<main class="descubre-page">

    <section class="descubre-hero">
        <div class="descubre-hero__overlay">
            <div class="container">
                <h1><?php echo wp_kses_post(venza_field('descubre_titulo')); ?></h1>
                <p><?php echo esc_html(venza_field('descubre_subtitulo')); ?></p>
            </div>
        </div>
        <?php
        $video_id = venza_field('descubre_video_youtube');
        if ($video_id) : ?>
            <div class="descubre-hero__video">
                <button class="video-play-btn" data-video="<?php echo esc_attr($video_id); ?>" aria-label="Reproducir video">
                    <svg viewBox="0 0 60 60" aria-hidden="true"><circle cx="30" cy="30" r="30" fill="rgba(255,255,255,0.9)"/><polygon points="24,18 46,30 24,42" fill="#1B1464"/></svg>
                </button>
                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('producto-hero', ['class' => 'video-poster']); ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </section>

    <section class="descubre-videos">
        <div class="container">
            <h2 class="section-title">
                <svg viewBox="0 0 24 24" width="32" aria-hidden="true"><path d="M8 5v14l11-7z" fill="currentColor"/></svg>
                Videos Venza
            </h2>
            <?php $channel = venza_field('youtube_channel_url'); ?>
            <?php if ($channel) : ?>
                <a href="<?php echo esc_url($channel); ?>" class="btn btn--primary" target="_blank" rel="noopener">
                    Visita nuestro canal de Youtube
                </a>
            <?php endif; ?>

            <?php
            $playlist_id = venza_field('youtube_playlist_id');
            if ($playlist_id) : ?>
                <div class="youtube-carousel" data-playlist="<?php echo esc_attr($playlist_id); ?>">
                    <div class="youtube-carousel__track" id="yt-track"></div>
                    <button class="carousel-btn carousel-btn--prev" aria-label="Anterior">&#8592;</button>
                    <button class="carousel-btn carousel-btn--next" aria-label="Siguiente">&#8594;</button>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="descubre-quiz-cta">
        <div class="container">
            <a href="<?php echo home_url('/descubre-venza/quiz/'); ?>" class="btn btn--secondary">
                Descubre qué jabón es ideal para tu piel
            </a>
        </div>
    </section>

</main>
<?php get_footer(); ?>
