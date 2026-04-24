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

$build_fallback_product_slides = static function (array $slugs, array $asset_fallback = []) {
    $slides = [];

    foreach ($slugs as $slug) {
        $product = get_page_by_path($slug, OBJECT, 'producto');
        if (!$product instanceof WP_Post || $product->post_status !== 'publish') {
            continue;
        }

        $image_url = get_the_post_thumbnail_url($product->ID, 'large');
        if (!$image_url) {
            continue;
        }

        $slides[] = [
            'name'  => get_the_title($product->ID),
            'image' => $image_url,
        ];
    }

    if (!empty($slides)) {
        return $slides;
    }

    foreach ($asset_fallback as $item) {
        $name = isset($item['name']) ? trim((string) $item['name']) : '';
        $image = isset($item['image']) ? trim((string) $item['image']) : '';

        if ($name === '' || $image === '') {
            continue;
        }

        $slides[] = [
            'name'  => $name,
            'image' => $image,
        ];
    }

    return $slides;
};

$build_line_slides = static function ($prefix, array $fallback_slides) use ($get_home_field) {
    $slides = [];

    for ($i = 1; $i <= 5; $i++) {
        $image_id = $get_home_field($prefix . '_producto_' . $i . '_imagen');
        $name = trim((string) $get_home_field($prefix . '_producto_' . $i . '_nombre', ''));

        if (!$image_id) {
            continue;
        }

        $image_url = wp_get_attachment_image_url((int) $image_id, 'large');
        if (!$image_url) {
            continue;
        }

        $slides[] = [
            'name'  => $name !== '' ? $name : 'Producto',
            'image' => $image_url,
        ];
    }

    return !empty($slides) ? $slides : $fallback_slides;
};

$productos_title = trim((string) $get_home_field('home_productos_titulo', 'Productos'));
if ($productos_title === '') {
    $productos_title = 'Productos';
}

$default_antibacterial = $build_fallback_product_slides(
    ['frescura-extrema', 'vitamina-e', 'sabila', 'coco', 'avena'],
    [
        [
            'name'  => 'Frescura Extrema',
            'image' => get_theme_file_uri('assets/images/productos/frescura-extrema.png'),
        ],
    ]
);

$default_hidratacion = $build_fallback_product_slides(
    ['crema-humectante'],
    [
        [
            'name'  => 'Crema Humectante',
            'image' => get_theme_file_uri('assets/images/productos/crema-humectante.png'),
        ],
    ]
);

$lineas = [
    [
        'prefix'       => 'home_linea_antibacterial',
        'is_alt'       => true,
        'title'        => (string) $get_home_field('home_linea_antibacterial_titulo', 'Línea Antibacterial'),
        'description'  => (string) $get_home_field('home_linea_antibacterial_descripcion', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam'),
        'cta_text'     => (string) $get_home_field('home_linea_antibacterial_cta_texto', 'Conoce más'),
        'cta_url'      => (string) $get_home_field('home_linea_antibacterial_cta_url', home_url('/productos/')),
        'background'   => (int) $get_home_field('home_linea_antibacterial_background', 0),
        'slides'       => $build_line_slides('home_linea_antibacterial', $default_antibacterial),
    ],
    [
        'prefix'       => 'home_linea_hidratacion',
        'is_alt'       => false,
        'title'        => (string) $get_home_field('home_linea_hidratacion_titulo', 'Línea Hidratación Profunda'),
        'description'  => (string) $get_home_field('home_linea_hidratacion_descripcion', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam'),
        'cta_text'     => (string) $get_home_field('home_linea_hidratacion_cta_texto', 'Conoce más'),
        'cta_url'      => (string) $get_home_field('home_linea_hidratacion_cta_url', home_url('/productos/')),
        'background'   => (int) $get_home_field('home_linea_hidratacion_background', 0),
        'slides'       => $build_line_slides('home_linea_hidratacion', $default_hidratacion),
    ],
];
?>

<section class="home-productos">
    <div class="container">
        <h2 class="section-title section-title--lined"><?php echo esc_html($productos_title); ?></h2>

        <?php foreach ($lineas as $linea) :
            $slides = is_array($linea['slides']) ? array_values($linea['slides']) : [];
            if (empty($slides)) {
                continue;
            }

            $first = $slides[0];
            $first_image = isset($first['image']) ? trim((string) $first['image']) : '';
            if ($first_image === '') {
                continue;
            }

            $first_name = isset($first['name']) && trim((string) $first['name']) !== ''
                ? trim((string) $first['name'])
                : 'Producto';

            $background_url = $linea['background'] ? wp_get_attachment_image_url((int) $linea['background'], 'full') : '';
            $row_style = $background_url ? '--home-producto-bg-image: url(' . esc_url($background_url) . ');' : '';

            $row_classes = ['home-producto-row'];
            if (!empty($linea['is_alt'])) {
                $row_classes[] = 'home-producto-row--alt';
            }
            if ($background_url) {
                $row_classes[] = 'home-producto-row--has-bg';
            }

            $safe_slides = array_map(static function ($slide) {
                return [
                    'name'  => isset($slide['name']) ? (string) $slide['name'] : '',
                    'image' => isset($slide['image']) ? (string) $slide['image'] : '',
                ];
            }, $slides);

            $slides_json = wp_json_encode($safe_slides, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            ?>
            <article class="<?php echo esc_attr(implode(' ', $row_classes)); ?>" <?php echo $row_style ? 'style="' . esc_attr($row_style) . '"' : ''; ?>>
                <div class="home-producto-row__image">
                    <div class="home-producto-row__rotator" data-home-product-rotator="<?php echo esc_attr($slides_json); ?>" data-rotate-interval="4500">
                        <img class="home-producto-row__img js-home-producto-img" src="<?php echo esc_url($first_image); ?>" alt="<?php echo esc_attr($first_name); ?>">
                        <p class="home-producto-row__caption js-home-producto-caption"><?php echo esc_html($first_name); ?></p>
                    </div>
                </div>

                <div class="home-producto-row__content">
                    <h3 class="home-producto-nombre"><?php echo esc_html((string) $linea['title']); ?></h3>
                    <p class="home-producto-desc"><?php echo nl2br(esc_html((string) $linea['description'])); ?></p>
                    <a href="<?php echo esc_url((string) $linea['cta_url']); ?>" class="btn btn--primary"><?php echo esc_html((string) $linea['cta_text']); ?></a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
