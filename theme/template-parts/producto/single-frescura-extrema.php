<?php
$get_image_url = static function ($meta_key, $fallback_path) {
    $value = venza_get_meta_value($meta_key);

    if (is_array($value)) {
        if (!empty($value['url'])) {
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

    return get_theme_file_uri($fallback_path);
};

$hero_banner = $get_image_url('producto_single_banner_imagen', 'assets/images/banners/frescura-extrema.jpg');
$hero_claim = venza_get_meta_value('producto_single_claim_texto') ?: 'Más fresco, imposible.';

$gradient_color = venza_get_meta_value('producto_single_gradient_color') ?: '#acdcef';
$gradient_style = '--producto-gradient: ' . esc_attr($gradient_color) . ';';

$intro_linea = venza_get_meta_value('producto_nombre_linea') ?: 'Jabón Antibacterial';
$intro_imagen = get_theme_file_uri('assets/images/productos/prod-frescura-extrema.png');

$descripcion = venza_get_meta_value('producto_descripcion_larga');
if (!$descripcion) {
    $descripcion = '
        <p>Venza Frescura Extrema refresca, tonifica y mejora la microcirculación sanguínea.</p>
        <p>Por su fórmula enriquecida con extractos de eucalipto y menta, este jabón se convierte en un poderoso estimulante que entrega una sensación de alivio refrescante y relajante.</p>
    ';
}
$descripcion_imagen = get_theme_file_uri('assets/images/banners/foto-frescura-extrema.jpg');

$tamanos = [
    [
        'nombre' => 'Individual',
        'descripcion' => '110g',
        'imagen' => get_theme_file_uri('assets/images/packs/frescura-extrema-individual.png'),
        'nota' => '',
    ],
    [
        'nombre' => '3 pack 330g',
        'descripcion' => '3 barras de 110g',
        'imagen' => get_theme_file_uri('assets/images/packs/frescura-extrema-3pack.png'),
        'nota' => '',
    ],
    [
        'nombre' => '4 pack 440g',
        'descripcion' => '4 barras de 110g',
        'imagen' => get_theme_file_uri('assets/images/packs/frescura-extrema-4pack.png'),
        'nota' => 'Presentación exclusiva de supermercados',
    ],
];
?>

<section class="producto-frescura-hero">
    <img src="<?php echo esc_url($hero_banner); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
    <div class="producto-frescura-hero__claim"><?php echo esc_html($hero_claim); ?></div>
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

<section class="producto-frescura-descripcion" style="<?php echo $gradient_style; ?>">
    <div class="producto-frescura-descripcion__media">
        <img src="<?php echo esc_url($descripcion_imagen); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
    </div>
    <div class="producto-frescura-descripcion__texto">
        <div class="producto-frescura-descripcion__texto-inner">
            <?php echo wp_kses_post($descripcion); ?>
        </div>
    </div>
</section>

<section class="producto-frescura-tamanos" style="<?php echo $gradient_style; ?>">
    <div class="container">
        <h2 class="producto-frescura-tamanos__titulo">Tamaños</h2>
        <div class="producto-frescura-tamanos__grid">
            <?php foreach ($tamanos as $tamano) : ?>
                <article class="producto-frescura-tamanos__item">
                    <h3><?php echo esc_html($tamano['nombre']); ?></h3>
                    <p class="producto-frescura-tamanos__desc"><?php echo esc_html($tamano['descripcion']); ?></p>
                    <img src="<?php echo esc_url($tamano['imagen']); ?>" alt="<?php echo esc_attr($tamano['nombre']); ?>">
                    <?php if (!empty($tamano['nota'])) : ?>
                        <p class="producto-frescura-tamanos__nota"><?php echo esc_html($tamano['nota']); ?></p>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
