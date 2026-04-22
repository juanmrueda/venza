<?php
defined('ABSPATH') || exit;

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
