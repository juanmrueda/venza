<?php
$home_video_rel = '/assets/videos/venza_video_home.mp4';
$home_video_file = VENZA_DIR . $home_video_rel;
$home_video_src = VENZA_URI . $home_video_rel;
$home_video_available = file_exists($home_video_file);

$slides = [
    $home_video_available
        ? [
            'type'   => 'video',
            'src'    => $home_video_src,
            'poster' => VENZA_URI . '/assets/images/banners/bannerhomedemo.svg',
            'alt'    => 'Video Home Venza',
            'wait_end' => true,
            'loop'   => false,
        ]
        : [
            'type' => 'image',
            'src'  => VENZA_URI . '/assets/images/banners/bannerhomedemo.svg',
            'alt'  => 'Banner Home Demo',
        ],
    [
        'type' => 'image',
        'src'  => VENZA_URI . '/assets/images/banners/frescura-extrema.jpg',
        'alt'  => 'Frescura Extrema',
    ],
    [
        'type' => 'image',
        'src'  => VENZA_URI . '/assets/images/banners/vitamina-e.jpg',
        'alt'  => 'Vitamina E',
    ],
    [
        'type' => 'image',
        'src'  => VENZA_URI . '/assets/images/banners/sabila.jpg',
        'alt'  => 'Sabila',
    ],
];
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
                            poster="<?php echo esc_url($slide['poster']); ?>"
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
            <p>
                Cada uno de nuestros productos exalta una <strong>sensacion y emocion especial</strong> para los diferentes momentos del dia, ayudandote a ti y a los tuyos a vivir <strong>cada instante plenamente</strong>.
            </p>
        </div>
    </div>
</section>
