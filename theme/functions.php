<?php
defined('ABSPATH') || exit;

define('VENZA_VERSION', '1.0.2');
define('VENZA_DIR', get_template_directory());
define('VENZA_URI', get_template_directory_uri());

// Cargar mÃ³dulos
require_once VENZA_DIR . '/inc/cpt.php';
require_once VENZA_DIR . '/inc/helpers.php';
require_once VENZA_DIR . '/inc/acf-producto-home.php';

// Soporte del tema
add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('custom-logo');

    register_nav_menus([
        'primary' => __('MenÃº Principal', 'venza'),
        'footer'  => __('MenÃº Footer', 'venza'),
    ]);
});

// Fallback explÃ­cito para que el header no quede sin navegaciÃ³n
function venza_primary_menu_fallback($args = []) {
    if (!isset($args['theme_location']) || $args['theme_location'] !== 'primary') {
        return;
    }

    $menu_class = isset($args['menu_class']) && is_string($args['menu_class']) && $args['menu_class'] !== ''
        ? $args['menu_class']
        : 'nav-menu';

    $items = [
        ['label' => 'Inicio',         'url' => home_url('/')],
        ['label' => 'Productos',      'url' => home_url('/productos/')],
        ['label' => 'Beneficios',     'url' => home_url('/beneficios/')],
        ['label' => 'Noticias',       'url' => home_url('/noticias/')],
        ['label' => 'Blog',           'url' => home_url('/blog/')],
        ['label' => 'Descubre Venza', 'url' => home_url('/descubre-venza/')],
        ['label' => 'Contacto',       'url' => home_url('/contacto/')],
    ];

    $current_url = trailingslashit(home_url(add_query_arg([], $GLOBALS['wp']->request ?? '')));

    echo '<ul class="' . esc_attr($menu_class) . '">';
    foreach ($items as $item) {
        $is_current = trailingslashit($item['url']) === $current_url;
        $class = $is_current ? ' class="current-menu-item"' : '';
        echo '<li' . $class . '><a href="' . esc_url($item['url']) . '">' . esc_html($item['label']) . '</a></li>';
    }
    echo '</ul>';
}

// Encolar estilos y scripts
add_action('wp_enqueue_scripts', function () {
    $main_css_path = VENZA_DIR . '/assets/css/main.css';
    $main_js_path  = VENZA_DIR . '/assets/js/main.js';
    $quiz_js_path  = VENZA_DIR . '/assets/js/quiz.js';

    $main_css_ver = file_exists($main_css_path) ? (string) filemtime($main_css_path) : VENZA_VERSION;
    $main_js_ver  = file_exists($main_js_path) ? (string) filemtime($main_js_path) : VENZA_VERSION;
    $quiz_js_ver  = file_exists($quiz_js_path) ? (string) filemtime($quiz_js_path) : VENZA_VERSION;

    wp_enqueue_style('venza-main', VENZA_URI . '/assets/css/main.css', [], $main_css_ver);
    wp_enqueue_script('venza-main', VENZA_URI . '/assets/js/main.js', [], $main_js_ver, true);

    if (is_page_template('page-quiz.php')) {
        wp_enqueue_script('venza-quiz', VENZA_URI . '/assets/js/quiz.js', [], $quiz_js_ver, true);
    }
});

// TamaÃ±os de imagen
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

