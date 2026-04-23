<?php
$get_image_url = static function ($meta_key, $fallback_path) {
    $value = venza_get_meta_value($meta_key);

    if (is_array($value)) {
        if (!empty($value['url'])) {
            return $value['url'];
        }
        if (!empty($value['ID'])) {
            $url = wp_get_attachment_image_url((int) $value['ID'], 'large');
            if ($url) {
                return $url;
            }
        }
    }

    if (is_numeric($value)) {
        $url = wp_get_attachment_image_url((int) $value, 'large');
        if ($url) {
            return $url;
        }
    }

    if (is_string($value) && filter_var($value, FILTER_VALIDATE_URL)) {
        return $value;
    }

    return get_theme_file_uri($fallback_path);
};

$beneficios = [
    [
        'titulo' => venza_get_meta_value('producto_home_beneficio_1') ?: 'Fórmula más cremosa',
        'imagen' => $get_image_url('producto_home_beneficio_1_imagen', 'assets/images/productos/home/formula.png'),
        'texto'  => venza_get_meta_value('producto_home_beneficio_1_texto') ?: 'Humectante natural para todo tipo de piel',
    ],
    [
        'titulo' => venza_get_meta_value('producto_home_beneficio_2') ?: 'Barra de alto rendimiento',
        'imagen' => $get_image_url('producto_home_beneficio_2_imagen', 'assets/images/productos/home/barra.png'),
        'texto'  => venza_get_meta_value('producto_home_beneficio_2_texto'),
    ],
    [
        'titulo' => venza_get_meta_value('producto_home_beneficio_3') ?: 'Fragancia de alta duración',
        'imagen' => $get_image_url('producto_home_beneficio_3_imagen', 'assets/images/productos/home/fragancia.png'),
        'texto'  => venza_get_meta_value('producto_home_beneficio_3_texto') ?: 'Abundante espuma',
    ],
];
?>
<section class="producto-home-beneficios">
    <div class="container">
        <h2 class="section-title">Beneficios principales:</h2>

        <div class="producto-home-beneficios__grid">
            <?php foreach ($beneficios as $i => $beneficio) : ?>
                <article class="producto-home-beneficios__item producto-home-beneficios__item--<?php echo (int) $i + 1; ?>">
                    <div class="producto-home-beneficios__chip producto-home-beneficios__chip--<?php echo (int) $i + 1; ?>">
                        <?php echo esc_html($beneficio['titulo']); ?>
                    </div>

                    <div class="producto-home-beneficios__media">
                        <img src="<?php echo esc_url($beneficio['imagen']); ?>" alt="<?php echo esc_attr($beneficio['titulo']); ?>" />
                    </div>

                    <?php if (!empty($beneficio['texto'])) : ?>
                        <div class="producto-home-beneficios__caption">
                            <?php echo esc_html($beneficio['texto']); ?>
                        </div>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
