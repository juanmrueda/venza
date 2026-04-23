<?php
defined('ABSPATH') || exit;

// Obtener valor desde ACF o meta nativa de WordPress
function venza_get_meta_value($key, $post_id = null) {
    $post_id = $post_id ?: get_the_ID();

    $acf_value = venza_field($key, $post_id);
    if ($acf_value !== null && $acf_value !== '' && $acf_value !== []) {
        return $acf_value;
    }

    $meta_value = get_post_meta($post_id, $key, true);
    if ($meta_value !== '' && $meta_value !== null) {
        return $meta_value;
    }

    return null;
}

// Obtener todos los productos excepto el actual
function venza_get_otros_productos($exclude_id = null, $limit = 6) {
    $args = [
        'post_type'      => 'producto',
        'posts_per_page' => $limit,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ];
    if ($exclude_id) {
        $args['post__not_in'] = [$exclude_id];
    }
    return get_posts($args);
}

// Obtener producto destacado para la home de /productos/
function venza_get_producto_destacado_home() {
    $destacado = get_posts([
        'post_type'      => 'producto',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'meta_key'       => 'producto_destacado_home',
        'meta_value'     => '1',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ]);

    if (!empty($destacado)) {
        return $destacado[0];
    }

    $crema = get_page_by_path('crema-humectante', OBJECT, 'producto');
    if ($crema instanceof WP_Post && $crema->post_status === 'publish') {
        return $crema;
    }

    $fallback = get_posts([
        'post_type'      => 'producto',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'orderby'        => ['menu_order' => 'ASC', 'date' => 'ASC'],
    ]);

    return !empty($fallback) ? $fallback[0] : null;
}

// Disponibilidad con fallback para mostrar siempre el bloque en archivo/single
function venza_get_producto_disponibilidad($post_id = null) {
    $post_id = $post_id ?: get_the_ID();

    $paises = venza_get_meta_value('producto_paises_disponibles', $post_id);
    if (is_array($paises) && !empty($paises)) {
        return implode(', ', array_map('trim', $paises));
    }

    $texto = venza_get_meta_value('producto_home_disponibilidad_override', $post_id);
    if (is_string($texto) && trim($texto) !== '') {
        return trim($texto);
    }

    return 'Guatemala, El Salvador, Honduras, Nicaragua, Costa Rica, República Dominicana.';
}

// Color de media luna para tarjetas de "Más productos" (archivo y single)
function venza_get_producto_medialuna_color($post_id = null) {
    $post_id = $post_id ?: get_the_ID();

    $color = venza_get_meta_value('producto_media_luna_color', $post_id);
    if (is_string($color) && trim($color) !== '') {
        return trim($color);
    }

    $acento = venza_get_meta_value('producto_color_acento', $post_id);
    if (is_string($acento) && trim($acento) !== '') {
        return trim($acento);
    }

    $slug = get_post_field('post_name', $post_id);
    $mapa = [
        'frescura-extrema' => '#BEE1E8',
        'vitamina-e'       => '#E9DF88',
        'avena'            => '#E7DCAA',
        'sabila'           => '#BFD9A7',
        'coco'             => '#C7D8DD',
        'crema-humectante' => '#C6DDEA',
    ];

    return $mapa[$slug] ?? '#C6DDEA';
}

// SVG inline seguro
function venza_svg($filename) {
    $path = VENZA_DIR . '/assets/images/icons/' . $filename . '.svg';
    if (file_exists($path)) {
        echo file_get_contents($path);
    }
}

// Campo ACF con fallback
function venza_field($key, $post_id = null) {
    if (function_exists('get_field')) {
        return get_field($key, $post_id);
    }
    return null;
}

// Clase body para página actual
function venza_body_class_page() {
    $slug = get_post_field('post_name', get_post());
    return 'page-' . $slug;
}
