<?php
$producto_slug = get_post_field('post_name', get_the_ID());

$get_media_url = static function ($value) {
    if (is_array($value)) {
        if (!empty($value['url']) && is_string($value['url'])) {
            return $value['url'];
        }
        if (!empty($value['ID'])) {
            $url = wp_get_attachment_image_url((int) $value['ID'], 'full');
            if ($url) {
                return $url;
            }
        }
    }

    if (is_numeric($value)) {
        $url = wp_get_attachment_image_url((int) $value, 'full');
        if ($url) {
            return $url;
        }
    }

    if (is_string($value) && filter_var($value, FILTER_VALIDATE_URL)) {
        return $value;
    }

    return '';
};

$get_theme_asset_url = static function ($relative_path) {
    if (!is_string($relative_path) || $relative_path === '') {
        return '';
    }

    $absolute_path = get_theme_file_path($relative_path);
    if ($absolute_path && file_exists($absolute_path)) {
        return get_theme_file_uri($relative_path);
    }

    return '';
};

$get_meta_image_url = static function ($meta_key, $fallback_url = '') use ($get_media_url) {
    $url = $get_media_url(venza_get_meta_value($meta_key));
    if ($url) {
        return $url;
    }

    return is_string($fallback_url) ? $fallback_url : '';
};

$hero_banner_fallbacks = [
    'frescura-extrema' => 'assets/images/banners/frescura-extrema.jpg',
    'vitamina-e'       => 'assets/images/banners/vitamina-e.jpg',
    'sabila'           => 'assets/images/banners/sabila.jpg',
    'coco'             => 'assets/images/banners/coco.jpg',
    'avena'            => 'assets/images/banners/avena.jpg',
    'crema-humectante' => 'assets/images/banners/productos-home-crema-body.jpg',
];
$hero_banner_fallback = $get_theme_asset_url($hero_banner_fallbacks[$producto_slug] ?? '');
if (!$hero_banner_fallback) {
    $hero_banner_fallback = $get_theme_asset_url('assets/images/banners/frescura-extrema.jpg');
}
$hero_banner = $get_meta_image_url('producto_single_banner_imagen', $hero_banner_fallback);

$hero_claim = venza_get_meta_value('producto_single_claim_texto');
if (!$hero_claim) {
    $hero_claim = venza_get_meta_value('producto_home_subtitulo');
}
if (!$hero_claim) {
    $hero_claim = venza_get_meta_value('producto_hero_subtitulo');
}
if (!$hero_claim) {
    $hero_claim = get_the_excerpt();
}

$gradient_color = venza_get_meta_value('producto_single_gradient_color')
    ?: venza_get_meta_value('producto_color_acento')
    ?: '#acdcef';
$tamanos_gradient_color = venza_get_meta_value('producto_single_tamanos_gradient_color')
    ?: $gradient_color;
$descripcion_gradient_style = '--producto-gradient: ' . $gradient_color . ';';
$tamanos_gradient_style = '--producto-gradient: ' . $tamanos_gradient_color . ';';

$intro_linea = venza_get_meta_value('producto_nombre_linea') ?: 'Jabon antibacterial';
$intro_image_fallbacks = [
    'frescura-extrema' => 'assets/images/productos/prod-frescura-extrema.png',
];
$intro_image_fallback_rel = $intro_image_fallbacks[$producto_slug] ?? ('assets/images/productos/' . $producto_slug . '.png');
$intro_image_fallback = $get_theme_asset_url($intro_image_fallback_rel);
if (!$intro_image_fallback) {
    $intro_image_fallback = get_the_post_thumbnail_url(get_the_ID(), 'full') ?: '';
}
$intro_imagen = $get_meta_image_url('producto_single_intro_imagen', $intro_image_fallback);

$descripcion = venza_get_meta_value('producto_single_descripcion_texto');
if (!$descripcion) {
    $descripcion = venza_get_meta_value('producto_descripcion_larga');
}
if (!$descripcion) {
    $descripcion = venza_get_meta_value('producto_home_descripcion_texto');
}
if (!$descripcion) {
    $content = get_the_content(null, false, get_the_ID());
    if (is_string($content) && trim(wp_strip_all_tags($content)) !== '') {
        $descripcion = apply_filters('the_content', $content);
    }
}
if (!$descripcion) {
    $descripcion = '<p>' . esc_html('Conoce los beneficios de ' . get_the_title() . ' para el cuidado diario de tu piel.') . '</p>';
}

$descripcion_image_fallbacks = [
    'frescura-extrema' => 'assets/images/banners/foto-frescura-extrema.jpg',
];
$descripcion_image_fallback_rel = $descripcion_image_fallbacks[$producto_slug] ?? ($hero_banner_fallbacks[$producto_slug] ?? '');
$descripcion_image_fallback = $get_theme_asset_url($descripcion_image_fallback_rel);
if (!$descripcion_image_fallback) {
    $descripcion_image_fallback = $hero_banner ?: $intro_imagen;
}
$descripcion_imagen = $get_meta_image_url('producto_single_descripcion_imagen', $descripcion_image_fallback);

$build_default_tamanos = static function ($slug, $fallback_image = '') use ($get_theme_asset_url) {
    $defaults = [];

    $individual = $get_theme_asset_url('assets/images/packs/' . $slug . '-individual.png');
    if (!$individual) {
        $individual = $get_theme_asset_url('assets/images/productos/' . $slug . '.png');
    }
    if (!$individual && $fallback_image) {
        $individual = $fallback_image;
    }
    if ($individual) {
        $defaults[] = [
            'nombre'      => 'Individual',
            'descripcion' => '110g',
            'imagen'      => $individual,
            'nota'        => '',
        ];
    }

    $pack3 = $get_theme_asset_url('assets/images/packs/' . $slug . '-3pack.png');
    if ($pack3) {
        $defaults[] = [
            'nombre'      => '3 pack 330g',
            'descripcion' => '3 barras de 110g',
            'imagen'      => $pack3,
            'nota'        => '',
        ];
    }

    $pack4 = $get_theme_asset_url('assets/images/packs/' . $slug . '-4pack.png');
    if ($pack4) {
        $defaults[] = [
            'nombre'      => '4 pack 440g',
            'descripcion' => '4 barras de 110g',
            'imagen'      => $pack4,
            'nota'        => '',
        ];
    }

    return $defaults;
};

$normalize_tamano = static function ($item) use ($get_media_url) {
    if (!is_array($item)) {
        return null;
    }

    $nombre = isset($item['nombre']) ? trim((string) $item['nombre']) : '';
    $descripcion = isset($item['descripcion']) ? trim((string) $item['descripcion']) : '';
    $nota = isset($item['nota']) ? trim((string) $item['nota']) : '';
    $imagen = isset($item['imagen']) ? $get_media_url($item['imagen']) : '';

    if ($nombre === '' && $descripcion === '' && $imagen === '') {
        return null;
    }

    return [
        'nombre'      => $nombre,
        'descripcion' => $descripcion,
        'imagen'      => $imagen,
        'nota'        => $nota,
    ];
};

$tamanos_defaults = $build_default_tamanos($producto_slug, $intro_imagen);
$tamanos_raw = venza_get_meta_value('producto_tamanos');
$tamanos = [];

if (is_array($tamanos_raw)) {
    foreach ($tamanos_raw as $item) {
        $tamano = $normalize_tamano($item);
        if ($tamano) {
            $tamanos[] = $tamano;
        }
    }
}

if (!empty($tamanos) && !empty($tamanos_defaults)) {
    foreach ($tamanos as $index => &$tamano) {
        $fallback = $tamanos_defaults[$index] ?? null;
        if (!$fallback) {
            continue;
        }

        foreach (['nombre', 'descripcion', 'imagen', 'nota'] as $field) {
            if (empty($tamano[$field]) && !empty($fallback[$field])) {
                $tamano[$field] = $fallback[$field];
            }
        }
    }
    unset($tamano);
}

if (empty($tamanos)) {
    $tamanos = $tamanos_defaults;
}

if (empty($tamanos) && $intro_imagen) {
    $tamanos[] = [
        'nombre'      => 'Individual',
        'descripcion' => '',
        'imagen'      => $intro_imagen,
        'nota'        => '',
    ];
}

$tamano_slot_defaults = [
    ['nombre' => 'Individual',   'descripcion' => '110g',              'nota' => ''],
    ['nombre' => '3 pack 330g',  'descripcion' => '3 barras de 110g',  'nota' => ''],
    ['nombre' => '4 pack 440g',  'descripcion' => '4 barras de 110g',  'nota' => ''],
];

$tamano_image_overrides = [
    $get_media_url(venza_get_meta_value('producto_single_tamano_1_imagen')),
    $get_media_url(venza_get_meta_value('producto_single_tamano_2_imagen')),
    $get_media_url(venza_get_meta_value('producto_single_tamano_3_imagen')),
];

$tamano_text_overrides = [
    [
        'nombre'      => trim((string) (venza_get_meta_value('producto_single_tamano_1_nombre') ?? '')),
        'descripcion' => trim((string) (venza_get_meta_value('producto_single_tamano_1_descripcion') ?? '')),
        'nota'        => trim((string) (venza_get_meta_value('producto_single_tamano_1_nota') ?? '')),
    ],
    [
        'nombre'      => trim((string) (venza_get_meta_value('producto_single_tamano_2_nombre') ?? '')),
        'descripcion' => trim((string) (venza_get_meta_value('producto_single_tamano_2_descripcion') ?? '')),
        'nota'        => trim((string) (venza_get_meta_value('producto_single_tamano_2_nota') ?? '')),
    ],
    [
        'nombre'      => trim((string) (venza_get_meta_value('producto_single_tamano_3_nombre') ?? '')),
        'descripcion' => trim((string) (venza_get_meta_value('producto_single_tamano_3_descripcion') ?? '')),
        'nota'        => trim((string) (venza_get_meta_value('producto_single_tamano_3_nota') ?? '')),
    ],
];

$tamanos_finales = [];
for ($i = 0; $i < 3; $i++) {
    $slot = $tamano_slot_defaults[$i];
    $actual = isset($tamanos[$i]) && is_array($tamanos[$i]) ? $tamanos[$i] : [];
    $defecto = isset($tamanos_defaults[$i]) && is_array($tamanos_defaults[$i]) ? $tamanos_defaults[$i] : [];
    $override = isset($tamano_text_overrides[$i]) && is_array($tamano_text_overrides[$i]) ? $tamano_text_overrides[$i] : [];

    $nombre = trim((string) ($override['nombre'] ?? ''));
    if ($nombre === '') {
        $nombre = trim((string) ($actual['nombre'] ?? ''));
    }
    if ($nombre === '' && !empty($defecto['nombre'])) {
        $nombre = trim((string) $defecto['nombre']);
    }
    if ($nombre === '') {
        $nombre = $slot['nombre'];
    }

    $tamano_descripcion = trim((string) ($override['descripcion'] ?? ''));
    if ($tamano_descripcion === '') {
        $tamano_descripcion = trim((string) ($actual['descripcion'] ?? ''));
    }
    if ($tamano_descripcion === '' && !empty($defecto['descripcion'])) {
        $tamano_descripcion = trim((string) $defecto['descripcion']);
    }
    if ($tamano_descripcion === '') {
        $tamano_descripcion = $slot['descripcion'];
    }

    $nota = trim((string) ($override['nota'] ?? ''));
    if ($nota === '') {
        $nota = trim((string) ($actual['nota'] ?? ''));
    }
    if ($nota === '' && !empty($defecto['nota'])) {
        $nota = trim((string) $defecto['nota']);
    }
    if ($nota === '') {
        $nota = $slot['nota'];
    }

    $imagen = $tamano_image_overrides[$i] ?: '';
    if ($imagen === '' && !empty($actual['imagen'])) {
        $imagen = (string) $actual['imagen'];
    }
    if ($imagen === '' && !empty($defecto['imagen'])) {
        $imagen = (string) $defecto['imagen'];
    }
    if ($imagen === '' && $intro_imagen) {
        $imagen = $intro_imagen;
    }

    if ($nombre === '' && $tamano_descripcion === '' && $nota === '' && $imagen === '') {
        continue;
    }

    $tamanos_finales[] = [
        'nombre'      => $nombre,
        'descripcion' => $tamano_descripcion,
        'imagen'      => $imagen,
        'nota'        => $nota,
    ];
}

if (!empty($tamanos_finales)) {
    $tamanos = $tamanos_finales;
}
?>

<section class="producto-frescura-hero">
    <img src="<?php echo esc_url($hero_banner); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
    <?php if ($hero_claim) : ?>
        <div class="producto-frescura-hero__claim"><?php echo esc_html($hero_claim); ?></div>
    <?php endif; ?>
</section>

<section class="producto-frescura-identidad">
    <div class="container">
        <div class="producto-frescura-identidad__producto-wrap">
            <span class="producto-frescura-identidad__halo" aria-hidden="true"></span>
            <img class="producto-frescura-identidad__producto" src="<?php echo esc_url($intro_imagen); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
        </div>
        <div class="producto-frescura-identidad__titulo-pill">
            <p class="producto-frescura-identidad__linea"><?php echo esc_html($intro_linea); ?></p>
            <h1><?php the_title(); ?></h1>
        </div>
    </div>
</section>

<section class="producto-frescura-descripcion" style="<?php echo esc_attr($descripcion_gradient_style); ?>">
    <div class="producto-frescura-descripcion__media">
        <img src="<?php echo esc_url($descripcion_imagen); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
    </div>
    <div class="producto-frescura-descripcion__texto">
        <div class="producto-frescura-descripcion__texto-inner">
            <?php echo wp_kses_post($descripcion); ?>
        </div>
    </div>
</section>

<section class="producto-frescura-tamanos" style="<?php echo esc_attr($tamanos_gradient_style); ?>">
    <div class="container">
        <h2 class="producto-frescura-tamanos__titulo">Tama&ntilde;os</h2>
        <div class="producto-frescura-tamanos__grid">
            <?php foreach ($tamanos as $tamano) : ?>
                <article class="producto-frescura-tamanos__item">
                    <?php if (!empty($tamano['nombre'])) : ?>
                        <h3><?php echo esc_html($tamano['nombre']); ?></h3>
                    <?php endif; ?>
                    <?php if (!empty($tamano['descripcion'])) : ?>
                        <p class="producto-frescura-tamanos__desc"><?php echo esc_html($tamano['descripcion']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($tamano['imagen'])) : ?>
                        <img src="<?php echo esc_url($tamano['imagen']); ?>" alt="<?php echo esc_attr($tamano['nombre'] ?: get_the_title()); ?>">
                    <?php endif; ?>
                    <?php if (!empty($tamano['nota'])) : ?>
                        <p class="producto-frescura-tamanos__nota"><?php echo esc_html($tamano['nota']); ?></p>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
