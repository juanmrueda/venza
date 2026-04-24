<?php
get_header();

$term = get_queried_object();
$term_name = $term instanceof WP_Term ? $term->name : 'Noticias';
$term_slug = $term instanceof WP_Term ? $term->slug : '';
$is_repository = ($term_slug === 'repositorio-sensorial');
$description = $term instanceof WP_Term ? trim(wp_strip_all_tags((string) term_description((int) $term->term_id, 'noticia_cat'))) : '';

$hero_title = trim((string) get_term_meta((int) ($term->term_id ?? 0), 'venza_noticia_hero_title', true));
if ($hero_title === '') {
    $hero_title = $term_name;
}

$hero_subtitle = trim((string) get_term_meta((int) ($term->term_id ?? 0), 'venza_noticia_hero_subtitle', true));
if ($hero_subtitle === '') {
    $hero_subtitle_fallback_by_slug = [
        'nuevos-lanzamientos' => 'Conoce la nueva linea de cuidado personal',
        'activaciones-venza'  => 'Conoce nuestras actividades',
        'repositorio-sensorial' => 'Lleva la cotidianidad a otro nivel.',
    ];

    if ($description !== '') {
        $hero_subtitle = $description;
    } elseif (isset($hero_subtitle_fallback_by_slug[$term_slug])) {
        $hero_subtitle = $hero_subtitle_fallback_by_slug[$term_slug];
    } else {
        $hero_subtitle = 'Conoce la nueva linea de cuidado personal';
    }
}

$demo_media = [
    [
        'type'  => 'video',
        'title' => 'Rutina sensorial de bienvenida',
        'text'  => 'Demo: experiencia de ducha con sonido y espuma envolvente.',
        'image' => trailingslashit(get_template_directory_uri() . '/assets/images/beneficios') . 'beneficio-05-radiante.jpg',
    ],
    [
        'type'  => 'foto',
        'title' => 'Set de fotografia de producto',
        'text'  => 'Demo: nuevas texturas y composiciones para lanzamientos.',
        'image' => trailingslashit(get_template_directory_uri() . '/assets/images/beneficios') . 'beneficio-03-aromas.jpg',
    ],
    [
        'type'  => 'video',
        'title' => 'Activacion en punto de venta',
        'text'  => 'Demo: registro de actividades en retail y eventos de marca.',
        'image' => trailingslashit(get_template_directory_uri() . '/assets/images/beneficios') . 'beneficio-04-rendimiento.jpg',
    ],
    [
        'type'  => 'foto',
        'title' => 'Backstage de campana',
        'text'  => 'Demo: contenido visual para social media y web.',
        'image' => trailingslashit(get_template_directory_uri() . '/assets/images/beneficios') . 'beneficio-08-limpieza.jpg',
    ],
];
?>
<main class="noticias-page noticias-tax <?php echo $is_repository ? 'noticias-tax--repository' : ''; ?>">
    <section class="noticias-tax__hero">
        <div class="container">
            <h1><?php echo esc_html($hero_title); ?></h1>
            <?php if ($hero_subtitle !== '') : ?>
                <p><?php echo esc_html($hero_subtitle); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <section class="noticias-tax__content">
        <div class="container">
            <?php if ($is_repository) : ?>
                <div class="noticias-repo__toolbar">
                    <span class="noticias-repo__pill is-active">Todo</span>
                    <span class="noticias-repo__pill">Videos</span>
                    <span class="noticias-repo__pill">Fotos</span>
                </div>

                <div class="noticias-repo__grid">
                    <?php if (have_posts()) : ?>
                        <?php while (have_posts()) : the_post(); ?>
                            <?php
                            $video_embed = venza_get_noticia_video_embed(get_the_ID());
                            $is_video_card = ($video_embed !== '');
                            $preview_text = venza_get_post_preview_text(get_the_ID(), 20);
                            ?>
                            <article class="noticias-repo-card">
                                <?php if ($is_video_card) : ?>
                                    <div class="noticias-repo-card__media noticias-repo-card__media--video">
                                        <div class="noticias-repo-card__embed">
                                            <?php echo wp_kses_post($video_embed); ?>
                                        </div>
                                        <span class="noticias-repo-card__type"><?php echo $is_video_card ? 'Video' : 'Foto'; ?></span>
                                    </div>
                                <?php else : ?>
                                    <a class="noticias-repo-card__media" href="<?php the_permalink(); ?>">
                                        <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('large'); ?>
                                        <?php else : ?>
                                        <div class="noticias-repo-card__placeholder"></div>
                                        <?php endif; ?>
                                        <span class="noticias-repo-card__type">Foto</span>
                                    </a>
                                <?php endif; ?>
                                <div class="noticias-repo-card__body">
                                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                    <?php if ($preview_text !== '') : ?>
                                        <p><?php echo esc_html($preview_text); ?></p>
                                    <?php endif; ?>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <?php foreach ($demo_media as $item) : ?>
                            <article class="noticias-repo-card noticias-repo-card--demo">
                                <div class="noticias-repo-card__media">
                                    <img src="<?php echo esc_url($item['image']); ?>" alt="<?php echo esc_attr($item['title']); ?>" loading="lazy">
                                    <span class="noticias-repo-card__type"><?php echo esc_html(ucfirst($item['type'])); ?></span>
                                </div>
                                <div class="noticias-repo-card__body">
                                    <h2><?php echo esc_html($item['title']); ?></h2>
                                    <p><?php echo esc_html($item['text']); ?></p>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php else : ?>
                <div class="noticias-list">
                    <?php if (have_posts()) : ?>
                        <?php while (have_posts()) : the_post(); ?>
                            <?php $preview_text = venza_get_post_preview_text(get_the_ID(), 26); ?>
                            <article class="noticias-story">
                                <a class="noticias-story__media" href="<?php the_permalink(); ?>">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('noticia-card'); ?>
                                    <?php else : ?>
                                        <div class="noticias-story__placeholder"></div>
                                    <?php endif; ?>
                                </a>
                                <div class="noticias-story__content">
                                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                    <?php if ($preview_text !== '') : ?>
                                        <p><?php echo esc_html($preview_text); ?></p>
                                    <?php endif; ?>
                                    <a class="btn noticias-btn" href="<?php the_permalink(); ?>">Conoce mas</a>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <article class="noticias-story noticias-story--empty">
                            <div class="noticias-story__content">
                                <h2>Sin noticias publicadas</h2>
                                <p>Esta categoria todavia no tiene contenido.</p>
                            </div>
                        </article>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="noticias-tax__pagination">
                <?php
                the_posts_pagination([
                    'mid_size'  => 1,
                    'prev_text' => 'Anterior',
                    'next_text' => 'Siguiente',
                ]);
                ?>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>
