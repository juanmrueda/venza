<?php
get_header();

$terms = venza_get_noticia_home_terms(3);
$base_image_uri = trailingslashit(get_template_directory_uri() . '/assets/images');

$fallback_by_slug = [
    'nuevos-lanzamientos'  => $base_image_uri . 'banners/productos-home-crema-body.jpg',
    'activaciones-venza'   => $base_image_uri . 'beneficios/beneficio-04-rendimiento.jpg',
    'repositorio-sensorial'=> $base_image_uri . 'beneficios/beneficio-06-uso-diario.jpg',
];

$copy_fallback_by_slug = [
    'nuevos-lanzamientos' => [
        'title'   => 'Descubre el nuevo jabon crema humectante',
        'summary' => 'Conoce la nueva linea de cuidado personal',
    ],
    'activaciones-venza' => [
        'title'   => 'Descubriendo el lado Venza del deporte',
        'summary' => 'Conoce nuestras actividades',
    ],
    'repositorio-sensorial' => [
        'title'   => 'Descubre el lado Venza de la vida',
        'summary' => 'Lleva la cotidianidad a otro nivel.',
    ],
];
?>
<main class="noticias-page noticias-home">
    <section class="noticias-home__stage">
        <div class="container">
            <div class="noticias-home__grid">
                <?php if (!empty($terms)) : ?>
                    <?php foreach ($terms as $term) : ?>
                        <?php
                        $term_id = (int) $term->term_id;
                        $latest_post = venza_get_noticia_term_latest_post($term_id);
                        $term_link = get_term_link($term);
                        if (is_wp_error($term_link)) {
                            $term_link = '#';
                        }

                        if ($term->slug === 'repositorio-sensorial') {
                            $repositorio_page = get_page_by_path('repositorio-sensorial');
                            if ($repositorio_page instanceof WP_Post && $repositorio_page->post_status === 'publish') {
                                $term_link = get_permalink($repositorio_page);
                            } else {
                                $term_link = home_url('/repositorio-sensorial/');
                            }
                        }

                        $custom_link = trim((string) get_term_meta($term_id, 'venza_noticia_home_button_url', true));
                        if ($custom_link !== '') {
                            $term_link = $custom_link;
                        }

                        $copy_fallback = $copy_fallback_by_slug[$term->slug] ?? [];
                        $title = trim((string) get_term_meta($term_id, 'venza_noticia_home_title', true));
                        if ($title === '' && $latest_post instanceof WP_Post) {
                            $title = get_the_title($latest_post);
                        }
                        if ($title === '' && !empty($copy_fallback['title'])) {
                            $title = (string) $copy_fallback['title'];
                        }
                        if ($title === '') {
                            $title = $term->name;
                        }

                        $summary = trim((string) get_term_meta($term_id, 'venza_noticia_home_summary', true));
                        if ($summary === '' && $latest_post instanceof WP_Post) {
                            $summary = venza_get_post_preview_text($latest_post->ID, 14);
                        }
                        if ($summary === '') {
                            $summary = trim(wp_strip_all_tags((string) term_description($term_id, 'noticia_cat')));
                        }
                        if ($summary === '' && !empty($copy_fallback['summary'])) {
                            $summary = (string) $copy_fallback['summary'];
                        }
                        if ($summary === '') {
                            $summary = 'Conoce las historias y contenidos mas recientes de Venza.';
                        }

                        $image_id = (int) get_term_meta($term_id, 'venza_noticia_home_image_id', true);
                        if ($image_id <= 0 && $latest_post instanceof WP_Post && has_post_thumbnail($latest_post->ID)) {
                            $image_id = (int) get_post_thumbnail_id($latest_post->ID);
                        }

                        $fallback_image = $fallback_by_slug[$term->slug] ?? ($base_image_uri . 'beneficios/beneficio-03-aromas.jpg');
                        $label_light = get_term_meta($term_id, 'venza_noticia_home_label_light', true);
                        $label_strong = get_term_meta($term_id, 'venza_noticia_home_label_strong', true);
                        $label_html = venza_format_noticia_home_label($term->name, $label_light, $label_strong);
                        $button_text = trim((string) get_term_meta($term_id, 'venza_noticia_home_button_text', true));
                        if ($button_text === '') {
                            $button_text = 'Conoce más';
                        }
                        ?>
                        <article class="noticias-home-card">
                            <a class="noticias-home-card__title-tag" href="<?php echo esc_url($term_link); ?>">
                                <?php echo wp_kses($label_html, ['span' => ['class' => []]]); ?>
                            </a>

                            <a class="noticias-home-card__frame" href="<?php echo esc_url($term_link); ?>">
                                <div class="noticias-home-card__media">
                                    <?php if ($image_id > 0) : ?>
                                        <?php echo wp_get_attachment_image($image_id, 'large', false, ['loading' => 'lazy']); ?>
                                    <?php else : ?>
                                        <img src="<?php echo esc_url($fallback_image); ?>" alt="<?php echo esc_attr($term->name); ?>" loading="lazy">
                                    <?php endif; ?>
                                </div>

                                <div class="noticias-home-card__body">
                                    <h2><?php echo esc_html($title); ?></h2>
                                    <p><?php echo esc_html($summary); ?></p>
                                </div>
                            </a>

                            <a class="btn noticias-btn" href="<?php echo esc_url($term_link); ?>">
                                <?php echo esc_html($button_text); ?>
                            </a>
                        </article>
                    <?php endforeach; ?>
                <?php else : ?>
                    <article class="noticias-home-card noticias-home-card--empty">
                        <div class="noticias-home-card__title-tag">PROXIMAMENTE</div>
                        <div class="noticias-home-card__frame">
                            <div class="noticias-home-card__body">
                                <h2>Noticias Venza</h2>
                                <p>Agrega categorias de noticia para mostrar esta seccion.</p>
                            </div>
                        </div>
                    </article>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>
