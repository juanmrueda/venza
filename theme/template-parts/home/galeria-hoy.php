<?php
$home_id = get_queried_object_id();
if (!$home_id) {
    $home_id = (int) get_option('page_on_front');
}

$video_rel = '/assets/videos/venza_video_home.mp4';
$video_path = VENZA_DIR . $video_rel;
$video_src = file_exists($video_path) ? VENZA_URI . $video_rel : '';

$acf_video_id = venza_field('home_venza_hoy_video', $home_id);
if ($acf_video_id) {
    $acf_video_url = wp_get_attachment_url((int) $acf_video_id);
    if (is_string($acf_video_url) && $acf_video_url !== '') {
        $video_src = $acf_video_url;
    }
}

$poster = VENZA_URI . '/assets/images/banners/bannerhomedemo.svg';
$poster_id = venza_field('home_venza_hoy_video_poster', $home_id);
if ($poster_id) {
    $poster_url = wp_get_attachment_image_url((int) $poster_id, 'full');
    if (is_string($poster_url) && $poster_url !== '') {
        $poster = $poster_url;
    }
}
?>

<section class="home-venza-hoy">
    <div class="container">
        <h2 class="section-title section-title--lined">Venza hoy</h2>
    </div>

    <div class="home-venza-hoy__video-wrap">
        <?php if ($video_src) : ?>
            <video class="home-venza-hoy__video" autoplay muted loop playsinline preload="metadata" poster="<?php echo esc_url($poster); ?>">
                <source src="<?php echo esc_url($video_src); ?>" type="video/mp4">
            </video>
        <?php else : ?>
            <img class="home-venza-hoy__video" src="<?php echo esc_url($poster); ?>" alt="Banner Venza hoy">
        <?php endif; ?>
    </div>

    <div class="home-venza-hoy__news">
        <div class="container">
            <p class="home-venza-hoy__pill">Mira todas las novedades que Venza tiene para ti</p>

            <div class="venza-hoy-grid">
                <?php
                $items = get_posts([
                    'post_type'      => ['noticia', 'post'],
                    'posts_per_page' => 3,
                    'post_status'    => 'publish',
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                ]);

                if (empty($items)) :
                    $placeholders = [
                        ['titulo' => 'Descubre el nuevo jabon Venza Crema Humectante', 'desc' => 'Elimina eficazmente bacterias y germenes, brindando una limpieza profunda que protege tu piel en cada uso.'],
                        ['titulo' => 'Fuerza, Bienestar y Empoderamiento este dia de la Mujer Hondurena', 'desc' => 'Elimina eficazmente bacterias y germenes, brindando una limpieza profunda que protege tu piel en cada uso.'],
                        ['titulo' => 'Venza lanza su nuevo aroma Manzana Fresh', 'desc' => 'Elimina eficazmente bacterias y germenes, brindando una limpieza profunda que protege tu piel en cada uso.'],
                    ];

                    foreach ($placeholders as $ph) : ?>
                        <article class="venza-hoy-card">
                            <div class="venza-hoy-card__img-wrap">
                                <div class="venza-hoy-card__placeholder"></div>
                            </div>
                            <div class="venza-hoy-card__body">
                                <h3><?php echo esc_html($ph['titulo']); ?></h3>
                                <p><?php echo esc_html($ph['desc']); ?></p>
                                <a href="#" class="btn btn--primary">Conoce m&aacute;s</a>
                            </div>
                        </article>
                    <?php endforeach;
                else :
                    foreach ($items as $item) :
                        $desc = wp_strip_all_tags(wp_trim_words($item->post_excerpt ?: $item->post_content, 22));
                        ?>
                        <article class="venza-hoy-card">
                            <div class="venza-hoy-card__img-wrap">
                                <?php if (has_post_thumbnail($item->ID)) : ?>
                                    <?php echo get_the_post_thumbnail($item->ID, 'noticia-card', ['class' => 'venza-hoy-card__img']); ?>
                                <?php else : ?>
                                    <div class="venza-hoy-card__placeholder"></div>
                                <?php endif; ?>
                            </div>
                            <div class="venza-hoy-card__body">
                                <h3><?php echo esc_html($item->post_title); ?></h3>
                                <p><?php echo esc_html($desc); ?></p>
                                <a href="<?php echo esc_url(get_permalink($item->ID)); ?>" class="btn btn--primary">Conoce m&aacute;s</a>
                            </div>
                        </article>
                    <?php endforeach;
                endif; ?>
            </div>
        </div>
    </div>
</section>
