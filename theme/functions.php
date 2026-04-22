<?php
defined('ABSPATH') || exit;

define('VENZA_VERSION', '1.0.0');
define('VENZA_DIR', get_template_directory());
define('VENZA_URI', get_template_directory_uri());

// Cargar módulos
require_once VENZA_DIR . '/inc/cpt.php';
require_once VENZA_DIR . '/inc/helpers.php';

// Soporte del tema
add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('custom-logo');

    register_nav_menus([
        'primary' => __('Menú Principal', 'venza'),
        'footer'  => __('Menú Footer', 'venza'),
    ]);
});

// Encolar estilos y scripts
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('venza-main', VENZA_URI . '/assets/css/main.css', [], VENZA_VERSION);
    wp_enqueue_script('venza-main', VENZA_URI . '/assets/js/main.js', [], VENZA_VERSION, true);

    if (is_page_template('page-quiz.php')) {
        wp_enqueue_script('venza-quiz', VENZA_URI . '/assets/js/quiz.js', [], VENZA_VERSION, true);
    }
});

// Tamaños de imagen
add_action('after_setup_theme', function () {
    add_image_size('producto-hero',    1440, 700, true);
    add_image_size('producto-thumb',   400,  400, true);
    add_image_size('noticia-card',     600,  400, true);
    add_image_size('blog-card',        300,  300, true);
});

// ACF: cargar campos desde JSON
add_filter('acf/settings/load_json', function ($paths) {
    $paths[] = VENZA_DIR . '/inc/acf-fields';
    return $paths;
});
add_filter('acf/settings/save_json', function () {
    return VENZA_DIR . '/inc/acf-fields';
});
