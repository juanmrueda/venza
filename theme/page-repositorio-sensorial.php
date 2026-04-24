<?php
/*
 * Template Name: Repositorio Sensorial
 */
get_header();

$repo_term = get_term_by('slug', 'repositorio-sensorial', 'noticia_cat');
$repo_term_id = $repo_term instanceof WP_Term ? (int) $repo_term->term_id : 0;

$repo_posts = [];
if ($repo_term_id > 0) {
    $repo_posts = get_posts([
        'post_type'      => 'noticia',
        'post_status'    => 'publish',
        'posts_per_page' => 12,
        'orderby'        => ['date' => 'DESC'],
        'tax_query'      => [
            [
                'taxonomy' => 'noticia_cat',
                'field'    => 'term_id',
                'terms'    => [$repo_term_id],
            ],
        ],
    ]);
}

$beneficios_base = trailingslashit(get_template_directory_uri() . '/assets/images/beneficios');
$home_video_uri = get_theme_file_uri('assets/videos/venza_video_home.mp4');

$demo_media = [
    [
        'type'  => 'video',
        'title' => 'Rutina sensorial de bienvenida',
        'text'  => 'Demo: recorrido visual del universo Venza para redes y sitio web.',
        'image' => $beneficios_base . 'beneficio-05-radiante.jpg',
        'video' => $home_video_uri,
    ],
    [
        'type'  => 'foto',
        'title' => 'Sesion lifestyle de marca',
        'text'  => 'Demo: contenido fotografico para temporadas y lanzamientos.',
        'image' => $beneficios_base . 'beneficio-06-uso-diario.jpg',
    ],
    [
        'type'  => 'foto',
        'title' => 'Texturas y aromas en detalle',
        'text'  => 'Demo: galeria de producto para piezas editoriales.',
        'image' => $beneficios_base . 'beneficio-03-aromas.jpg',
    ],
    [
        'type'  => 'video',
        'title' => 'Experiencia de activacion en tienda',
        'text'  => 'Demo: clips de eventos, sampling y activaciones Venza.',
        'image' => $beneficios_base . 'beneficio-04-rendimiento.jpg',
        'video' => $home_video_uri,
    ],
    [
        'type'  => 'foto',
        'title' => 'Momentos de cuidado diario',
        'text'  => 'Demo: biblioteca visual para blog y noticias.',
        'image' => $beneficios_base . 'beneficio-08-limpieza.jpg',
    ],
    [
        'type'  => 'foto',
        'title' => 'Coleccion piel radiante',
        'text'  => 'Demo: piezas de apoyo para campañas digitales.',
        'image' => $beneficios_base . 'beneficio-07-nutre.jpg',
    ],
];
?>
<main class="noticias-page repositorio-sensorial-page">
    <section class="noticias-tax__hero repositorio-sensorial-page__hero">
        <div class="container">
            <h1>Repositorio Sensorial</h1>
            <p>Videos y fotos de activaciones, lanzamientos y experiencias Venza.</p>
        </div>
    </section>

    <section class="noticias-tax__content repositorio-sensorial-page__content">
        <div class="container">
            <div class="noticias-repo__toolbar">
                <span class="noticias-repo__pill is-active">Todo</span>
                <span class="noticias-repo__pill">Videos</span>
                <span class="noticias-repo__pill">Fotos</span>
            </div>

            <div class="noticias-repo__grid repositorio-sensorial-page__grid">
                <?php if (!empty($repo_posts)) : ?>
                    <?php foreach ($repo_posts as $repo_post) : ?>
                        <?php
                        $video_embed = venza_get_noticia_video_embed($repo_post->ID);
                        $is_video_card = ($video_embed !== '');
                        $preview_text = venza_get_post_preview_text($repo_post->ID, 20);
                        $thumbnail_html = get_the_post_thumbnail($repo_post->ID, 'large');
                        $permalink = get_permalink($repo_post);
                        ?>
                        <article class="noticias-repo-card">
                            <?php if ($is_video_card) : ?>
                                <div class="noticias-repo-card__media noticias-repo-card__media--video">
                                    <div class="noticias-repo-card__embed">
                                        <?php echo wp_kses_post($video_embed); ?>
                                    </div>
                                    <span class="noticias-repo-card__type">Video</span>
                                </div>
                            <?php else : ?>
                                <a class="noticias-repo-card__media" href="<?php echo esc_url($permalink); ?>">
                                    <?php if ($thumbnail_html !== '') : ?>
                                        <?php echo $thumbnail_html; ?>
                                    <?php else : ?>
                                        <div class="noticias-repo-card__placeholder"></div>
                                    <?php endif; ?>
                                    <span class="noticias-repo-card__type">Foto</span>
                                </a>
                            <?php endif; ?>

                            <div class="noticias-repo-card__body">
                                <h2><a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html(get_the_title($repo_post)); ?></a></h2>
                                <?php if ($preview_text !== '') : ?>
                                    <p><?php echo esc_html($preview_text); ?></p>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else : ?>
                    <?php foreach ($demo_media as $item) : ?>
                        <?php
                        $item_type = isset($item['type']) ? (string) $item['type'] : 'foto';
                        $item_title = isset($item['title']) ? (string) $item['title'] : '';
                        $item_text = isset($item['text']) ? (string) $item['text'] : '';
                        $item_image = isset($item['image']) ? (string) $item['image'] : '';
                        $item_video = isset($item['video']) ? (string) $item['video'] : '';
                        $is_video_item = ($item_type === 'video' && $item_video !== '');
                        ?>
                        <article class="noticias-repo-card noticias-repo-card--demo">
                            <div class="noticias-repo-card__media <?php echo $is_video_item ? 'noticias-repo-card__media--video' : ''; ?>">
                                <?php if ($is_video_item) : ?>
                                    <video controls muted loop playsinline preload="metadata" poster="<?php echo esc_url($item_image); ?>">
                                        <source src="<?php echo esc_url($item_video); ?>" type="video/mp4">
                                    </video>
                                <?php elseif ($item_image !== '') : ?>
                                    <img src="<?php echo esc_url($item_image); ?>" alt="<?php echo esc_attr($item_title); ?>" loading="lazy">
                                <?php else : ?>
                                    <div class="noticias-repo-card__placeholder"></div>
                                <?php endif; ?>
                                <span class="noticias-repo-card__type"><?php echo $is_video_item ? 'Video' : 'Foto'; ?></span>
                            </div>

                            <div class="noticias-repo-card__body">
                                <h2><?php echo esc_html($item_title); ?></h2>
                                <?php if ($item_text !== '') : ?>
                                    <p><?php echo esc_html($item_text); ?></p>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>
