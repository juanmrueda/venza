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

function venza_get_noticia_home_terms($limit = 3) {
    $terms = get_terms([
        'taxonomy'   => 'noticia_cat',
        'hide_empty' => false,
    ]);

    if (is_wp_error($terms) || empty($terms)) {
        return [];
    }

    $preferred_order = [
        'nuevos-lanzamientos',
        'activaciones-venza',
        'repositorio-sensorial',
    ];

    $terms_by_slug = [];
    foreach ($terms as $term) {
        $terms_by_slug[$term->slug] = $term;
    }

    $ordered = [];
    foreach ($preferred_order as $slug) {
        if (isset($terms_by_slug[$slug])) {
            $ordered[] = $terms_by_slug[$slug];
            unset($terms_by_slug[$slug]);
        }
    }

    if (!empty($terms_by_slug)) {
        foreach ($terms_by_slug as $term) {
            $ordered[] = $term;
        }
    }

    return array_slice($ordered, 0, max(1, (int) $limit));
}

function venza_get_noticia_term_latest_post($term_id) {
    static $cache = [];

    $term_id = (int) $term_id;
    if ($term_id <= 0) {
        return null;
    }

    if (array_key_exists($term_id, $cache)) {
        return $cache[$term_id];
    }

    $posts = get_posts([
        'post_type'      => 'noticia',
        'post_status'    => 'publish',
        'posts_per_page' => 1,
        'tax_query'      => [
            [
                'taxonomy' => 'noticia_cat',
                'field'    => 'term_id',
                'terms'    => [$term_id],
            ],
        ],
    ]);

    $cache[$term_id] = !empty($posts) ? $posts[0] : null;
    return $cache[$term_id];
}

function venza_get_post_preview_text($post_id, $length = 22) {
    $post = get_post($post_id);
    if (!$post instanceof WP_Post) {
        return '';
    }

    $excerpt = has_excerpt($post) ? $post->post_excerpt : $post->post_content;
    $excerpt = wp_strip_all_tags((string) $excerpt);

    if ($excerpt === '') {
        return '';
    }

    return wp_trim_words($excerpt, max(8, (int) $length), '...');
}

function venza_format_term_name_label($name) {
    $name = trim(wp_strip_all_tags((string) $name));
    if ($name === '') {
        return '';
    }

    $words = preg_split('/\s+/', $name);
    $words = is_array($words) ? array_values(array_filter($words)) : [];

    $to_upper = static function ($value) {
        return function_exists('mb_strtoupper') ? mb_strtoupper($value, 'UTF-8') : strtoupper($value);
    };

    if (count($words) < 2) {
        return $to_upper($name);
    }

    $break_index = (int) ceil(count($words) / 2);
    $line_one = implode(' ', array_slice($words, 0, $break_index));
    $line_two = implode(' ', array_slice($words, $break_index));

    if ($line_two === '') {
        return '<span class="noticias-home-card__title-strong">' . esc_html($to_upper($line_one)) . '</span>';
    }

    return '<span class="noticias-home-card__title-light">' . esc_html($to_upper($line_one)) . '</span>'
        . '<span class="noticias-home-card__title-strong">' . esc_html($to_upper($line_two)) . '</span>';
}

function venza_format_noticia_home_label($fallback_name, $line_light = '', $line_strong = '') {
    $line_light = trim(wp_strip_all_tags((string) $line_light));
    $line_strong = trim(wp_strip_all_tags((string) $line_strong));

    if ($line_light === '' && $line_strong === '') {
        return venza_format_term_name_label($fallback_name);
    }

    $to_upper = static function ($value) {
        return function_exists('mb_strtoupper') ? mb_strtoupper($value, 'UTF-8') : strtoupper($value);
    };

    $html = '';
    if ($line_light !== '') {
        $html .= '<span class="noticias-home-card__title-light">' . esc_html($to_upper($line_light)) . '</span>';
    }
    if ($line_strong !== '') {
        $html .= '<span class="noticias-home-card__title-strong">' . esc_html($to_upper($line_strong)) . '</span>';
    }

    return $html;
}

function venza_get_noticia_video_embed($post_id) {
    $video_url = trim((string) venza_get_meta_value('noticia_video_url', $post_id));

    if ($video_url !== '') {
        $embedded = wp_oembed_get($video_url, [
            'width'  => 880,
            'height' => 500,
        ]);

        if (is_string($embedded) && $embedded !== '') {
            return $embedded;
        }
    }

    $post = get_post($post_id);
    if (!$post instanceof WP_Post) {
        return '';
    }

    $content = apply_filters('the_content', (string) $post->post_content);
    $media = get_media_embedded_in_content($content, ['video', 'iframe', 'embed', 'object']);

    if (!empty($media) && is_array($media)) {
        return (string) $media[0];
    }

    return '';
}

function venza_get_noticia_badges($post_id, $limit = 3) {
    $raw = venza_get_meta_value('noticia_badges', $post_id);
    if (!is_string($raw) || trim($raw) === '') {
        return [];
    }

    $items = preg_split('/\r\n|\r|\n/', $raw);
    if (!is_array($items)) {
        return [];
    }

    $badges = [];
    foreach ($items as $item) {
        $item = trim(wp_strip_all_tags((string) $item));
        if ($item === '') {
            continue;
        }
        $badges[] = $item;
    }

    return array_slice($badges, 0, max(1, (int) $limit));
}
