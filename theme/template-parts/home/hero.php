<?php
$home_id = get_queried_object_id();
if (!$home_id) {
    $home_id = (int) get_option('page_on_front');
}

$get_home_field = static function ($key, $default = null) use ($home_id) {
    $value = venza_field($key, $home_id);
    if ($value !== null && $value !== '' && $value !== []) {
        return $value;
    }

    return $default;
};

$default_video_rel = '/assets/videos/venza_video_home.mp4';
$default_video_file = VENZA_DIR . $default_video_rel;
$default_video_src = VENZA_URI . $default_video_rel;

$hero_video_src = '';
$hero_video_id = (int) $get_home_field('home_hero_slide_1_video', 0);
if ($hero_video_id > 0) {
    $hero_video_url = wp_get_attachment_url($hero_video_id);
    if (is_string($hero_video_url) && $hero_video_url !== '') {
        $hero_video_src = $hero_video_url;
    }
}

if ($hero_video_src === '' && file_exists($default_video_file)) {
    $hero_video_src = $default_video_src;
}

$poster = '';
$poster_id = (int) $get_home_field('home_hero_slide_1_poster', 0);
if ($poster_id > 0) {
    $poster_url = wp_get_attachment_image_url($poster_id, 'full');
    if (is_string($poster_url) && $poster_url !== '') {
        $poster = $poster_url;
    }
}

$hero_alt = trim((string) $get_home_field('home_hero_slide_1_alt', 'Video Home Venza'));
if ($hero_alt === '') {
    $hero_alt = 'Video Home Venza';
}

$wait_end = (bool) $get_home_field('home_hero_slide_1_wait_end', true);

$build_image_slide = static function ($index, $fallback_src, $fallback_alt) use ($get_home_field) {
    $src = $fallback_src;
    $image_id = (int) $get_home_field('home_hero_slide_' . $index . '_image', 0);
    if ($image_id > 0) {
        $image_url = wp_get_attachment_image_url($image_id, 'full');
        if (is_string($image_url) && $image_url !== '') {
            $src = $image_url;
        }
    }

    $alt = trim((string) $get_home_field('home_hero_slide_' . $index . '_alt', $fallback_alt));
    if ($alt === '') {
        $alt = $fallback_alt;
    }

    return [
        'type' => 'image',
        'src'  => $src,
        'alt'  => $alt,
    ];
};

$slides = [];

// ✅ CAMBIO: Solo agregar Slide 1 si tiene video configurado
if ($hero_video_src !== '') {
    $slides[] = [
        'type'     => 'video',
        'src'      => $hero_video_src,
        'poster'   => $poster,
        'alt'      => $hero_alt,
        'wait_end' => $wait_end,
        'loop'     => false,
    ];
}

// ✅ CAMBIO: Solo agregar slides 2, 3, 4 si existen en el admin
// Si el usuario no configura nada en el admin, NO se cargarán los fallbacks
for ($i = 2; $i <= 4; $i++) {
    $image_id = (int) $get_home_field('home_hero_slide_' . $i . '_image', 0);
    
    // Solo agregar el slide si tiene una imagen configurada en el admin
    if ($image_id > 0) {
        $slide = $build_image_slide($i, '', '');
        
        // Verificar que la imagen se cargó correctamente
        if (!empty($slide['src'])) {
            $slides[] = $slide;
        }
    }
}

$claim_text = (string) $get_home_field('home_claim_text', 'Cada uno de nuestros productos exalta una <strong>sensacion y emocion especial</strong> para los diferentes momentos del dia, ayudandote a ti y a los tuyos a vivir <strong>cada instante plenamente</strong>.');
if (trim(strip_tags($claim_text)) === '') {
    $claim_text = 'Cada uno de nuestros productos exalta una <strong>sensacion y emocion especial</strong> para los diferentes momentos del dia, ayudandote a ti y a los tuyos a vivir <strong>cada instante plenamente</strong>.';
}
$claim_html = wp_kses_post($claim_text);
?>

<section class="home-hero" aria-label="Hero principal">
    <div class="home-hero__carousel" id="home-hero-carousel">
        <button class="home-hero__control home-hero__control--prev" type="button" aria-label="Slide anterior">
            <span aria-hidden="true">&#8249;</span>
        </button>

        <div class="home-hero__slides">
            <?php foreach ($slides as $index => $slide) : ?>
                <article class="home-hero__slide <?php echo $index === 0 ? 'is-active' : ''; ?>" data-slide-index="<?php echo esc_attr((string) $index); ?>">
                    <?php if ($slide['type'] === 'video') : ?>
                        <video
                            class="home-hero__media"
                            autoplay
                            muted
                            <?php echo !empty($slide['loop']) ? 'loop' : ''; ?>
                            playsinline
                            preload="metadata"
                            <?php echo !empty($slide['poster']) ? 'poster="' . esc_url($slide['poster']) . '"' : ''; ?>
                            <?php echo !empty($slide['wait_end']) ? 'data-wait-end="1"' : ''; ?>
                        >
                            <source src="<?php echo esc_url($slide['src']); ?>" type="video/mp4">
                        </video>
                    <?php else : ?>
                        <img class="home-hero__media" src="<?php echo esc_url($slide['src']); ?>" alt="<?php echo esc_attr($slide['alt']); ?>">
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>

        <button class="home-hero__control home-hero__control--next" type="button" aria-label="Siguiente slide">
            <span aria-hidden="true">&#8250;</span>
        </button>
    </div>

    <div class="home-hero__dots" aria-label="Indicadores de slide">
        <?php foreach ($slides as $index => $slide) : ?>
            <button class="home-hero__dot <?php echo $index === 0 ? 'is-active' : ''; ?>" type="button" data-slide-to="<?php echo esc_attr((string) $index); ?>" aria-label="Ir al slide <?php echo esc_attr((string) ($index + 1)); ?>"></button>
        <?php endforeach; ?>
    </div>
</section>

<section class="home-claim">
    <div class="container">
        <div class="home-claim__box">
            <p><?php echo wp_kses_post($claim_html); ?></p>
        </div>
    </div>
</section>