<?php
defined('ABSPATH') || exit;

define('VENZA_VERSION', '1.0.2');
define('VENZA_DIR', get_template_directory());
define('VENZA_URI', get_template_directory_uri());

// Cargar mÃ³dulos
require_once VENZA_DIR . '/inc/cpt.php';
require_once VENZA_DIR . '/inc/helpers.php';
require_once VENZA_DIR . '/inc/acf-producto-home.php';
require_once VENZA_DIR . '/inc/acf-page-beneficios.php';
require_once VENZA_DIR . '/inc/acf-noticia.php';
require_once VENZA_DIR . '/inc/acf-home.php';
require_once VENZA_DIR . '/inc/acf-blog.php';
require_once VENZA_DIR . '/inc/acf-page-descubre.php';

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

// Evitar glitches visuales intermitentes de campos ACF (meta boxes/WYSIWYG)
// en pantallas con alta edicion de campos personalizados.
add_filter('use_block_editor_for_post_type', function ($use_block_editor, $post_type) {
    if ($post_type === 'producto' || $post_type === 'post') {
        return false;
    }

    return $use_block_editor;
}, 10, 2);

add_filter('use_block_editor_for_post', function ($use_block_editor, $post) {
    if (!$post instanceof WP_Post) {
        return $use_block_editor;
    }

    if ($post->post_type === 'producto' || $post->post_type === 'post') {
        return false;
    }

    // Front Page: forzar editor clasico para estabilidad de campos ACF del Home.
    if ($post->post_type === 'page') {
        $front_page_id = (int) get_option('page_on_front');
        if ($front_page_id > 0 && (int) $post->ID === $front_page_id) {
            return false;
        }

        if (get_page_template_slug($post) === 'page-descubre-venza.php') {
            return false;
        }
    }

    if ($post->post_type === 'noticia') {
        return false;
    }

    return $use_block_editor;
}, 10, 2);

function venza_is_descubre_quiz_route() {
    $request = trim((string) ($GLOBALS['wp']->request ?? ''), '/');

    return $request === 'descubre-venza/quiz' || (string) get_query_var('venza_descubre_quiz') === '1';
}

function venza_get_descubre_page_id() {
    static $page_id = null;

    if ($page_id !== null) {
        return $page_id;
    }

    $page_id = 0;
    $page = get_page_by_path('descubre-venza');
    if ($page instanceof WP_Post) {
        $page_id = (int) $page->ID;
        return $page_id;
    }

    $pages = get_posts([
        'post_type'   => 'page',
        'meta_key'    => '_wp_page_template',
        'meta_value'  => 'page-descubre-venza.php',
        'posts_per_page' => 1,
        'post_status' => ['publish', 'draft', 'private'],
    ]);

    if (!empty($pages) && $pages[0] instanceof WP_Post) {
        $page_id = (int) $pages[0]->ID;
    }

    return $page_id;
}

function venza_is_descubre_context() {
    $request = trim((string) ($GLOBALS['wp']->request ?? ''), '/');

    return venza_is_descubre_quiz_route()
        || $request === 'descubre-venza'
        || is_page_template('page-descubre-venza.php')
        || is_page_template('page-quiz.php');
}

add_action('init', function () {
    add_rewrite_rule('^descubre-venza/quiz/?$', 'index.php?venza_descubre_quiz=1', 'top');
});

add_filter('query_vars', function ($vars) {
    $vars[] = 'venza_descubre_quiz';
    return $vars;
});

add_action('template_redirect', function () {
    if (!venza_is_descubre_quiz_route()) {
        return;
    }

    global $wp_query;
    if ($wp_query instanceof WP_Query) {
        $wp_query->is_404 = false;
    }

    status_header(200);
    include VENZA_DIR . '/page-quiz.php';
    exit;
});

// Fallback explÃ­cito para que el header no quede sin navegaciÃ³n
function venza_primary_menu_fallback($args = []) {
    if (!isset($args['theme_location']) || $args['theme_location'] !== 'primary') {
        return;
    }

    $productos_menu = get_posts([
        'post_type'      => 'producto',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => ['menu_order' => 'ASC', 'title' => 'ASC'],
        'order'          => 'ASC',
    ]);

    $menu_class = isset($args['menu_class']) && is_string($args['menu_class']) && $args['menu_class'] !== ''
        ? $args['menu_class']
        : 'nav-menu';

    $items = [
        ['label' => 'Inicio',         'url' => home_url('/')],
        [
            'label'    => 'Productos',
            'url'      => home_url('/productos/'),
            'children' => array_map(static function ($producto) {
                return [
                    'label' => get_the_title($producto),
                    'url'   => get_permalink($producto),
                    'id'    => (int) $producto->ID,
                ];
            }, $productos_menu),
        ],
        ['label' => 'Beneficios',     'url' => home_url('/beneficios/')],
        ['label' => 'Noticias',       'url' => home_url('/noticias/')],
        ['label' => 'Blog',           'url' => home_url('/blog/')],
        ['label' => 'Descubre Venza', 'url' => home_url('/descubre-venza/')],
        ['label' => 'Contacto',       'url' => home_url('/contacto/')],
    ];

    $current_url = trailingslashit(home_url(add_query_arg([], $GLOBALS['wp']->request ?? '')));
    $is_producto_context = is_post_type_archive('producto') || is_singular('producto') || is_tax('linea_producto');
    $is_noticias_context = is_post_type_archive('noticia') || is_singular('noticia') || is_tax('noticia_cat');
    $is_blog_context = is_home() || is_singular('post') || is_category() || is_tag() || is_date() || is_author();
    $is_descubre_context = venza_is_descubre_context();

    echo '<ul class="' . esc_attr($menu_class) . '">';
    foreach ($items as $item) {
        $children = isset($item['children']) && is_array($item['children']) ? $item['children'] : [];
        $is_current = trailingslashit($item['url']) === $current_url;
        if ($is_noticias_context && isset($item['label']) && strtolower((string) $item['label']) === 'noticias') {
            $is_current = true;
        }
        if ($is_blog_context && isset($item['label']) && strtolower((string) $item['label']) === 'blog') {
            $is_current = true;
        }
        if ($is_descubre_context && isset($item['label']) && strtolower((string) $item['label']) === 'descubre venza') {
            $is_current = true;
        }
        $has_current_child = false;

        if (!empty($children)) {
            foreach ($children as $child) {
                $child_url = isset($child['url']) ? trailingslashit($child['url']) : '';
                $child_id = isset($child['id']) ? (int) $child['id'] : 0;
                if ($child_url === $current_url || (is_singular('producto') && $child_id === get_the_ID())) {
                    $has_current_child = true;
                    break;
                }
            }
        }

        $classes = [];
        if (!empty($children)) {
            $classes[] = 'menu-item-has-children';
        }
        if ($is_current) {
            $classes[] = 'current-menu-item';
        }
        if ($has_current_child || (!empty($children) && $is_producto_context)) {
            $classes[] = 'current-menu-ancestor';
        }

        $class_attr = !empty($classes) ? ' class="' . esc_attr(implode(' ', $classes)) . '"' : '';

        echo '<li' . $class_attr . '>';
        echo '<a href="' . esc_url($item['url']) . '">' . esc_html($item['label']) . '</a>';

        if (!empty($children)) {
            echo '<ul class="sub-menu">';
            foreach ($children as $child) {
                $child_url = isset($child['url']) ? trailingslashit($child['url']) : '';
                $child_id = isset($child['id']) ? (int) $child['id'] : 0;
                $child_is_current = $child_url === $current_url || (is_singular('producto') && $child_id === get_the_ID());
                $child_class_attr = $child_is_current ? ' class="current-menu-item"' : '';
                echo '<li' . $child_class_attr . '>';
                echo '<a href="' . esc_url($child['url']) . '">' . esc_html($child['label']) . '</a>';
                echo '</li>';
            }
            echo '</ul>';
        }

        echo '</li>';
    }
    echo '</ul>';
}

// Inyectar subproductos en "Productos" del menu principal cuando exista menu en WP
add_filter('wp_nav_menu_objects', function ($items, $args) {
    if (!isset($args->theme_location) || $args->theme_location !== 'primary' || empty($items) || !is_array($items)) {
        return $items;
    }

    $productos_parent = null;
    $productos_url = untrailingslashit(home_url('/productos/'));

    foreach ($items as $item) {
        $is_top_level = isset($item->menu_item_parent) && (int) $item->menu_item_parent === 0;
        $item_url = isset($item->url) ? untrailingslashit($item->url) : '';
        $item_title = isset($item->title) ? strtolower(trim((string) $item->title)) : '';

        if ($is_top_level && ($item_url === $productos_url || $item_title === 'productos')) {
            $productos_parent = $item;
            break;
        }
    }

    if (!$productos_parent || !isset($productos_parent->ID)) {
        return $items;
    }

    $productos = get_posts([
        'post_type'      => 'producto',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => ['menu_order' => 'ASC', 'title' => 'ASC'],
        'order'          => 'ASC',
    ]);

    if (empty($productos)) {
        return $items;
    }

    $parent_id = (int) $productos_parent->ID;
    $is_producto_context = is_post_type_archive('producto') || is_singular('producto') || is_tax('linea_producto');

    $filtered_items = [];
    foreach ($items as $item) {
        if (isset($item->menu_item_parent) && (int) $item->menu_item_parent === $parent_id) {
            continue;
        }
        $filtered_items[] = $item;
    }

    $virtual_id = -1000;
    $result = [];
    foreach ($filtered_items as $item) {
        if (isset($item->ID) && (int) $item->ID === $parent_id) {
            $classes = isset($item->classes) && is_array($item->classes) ? $item->classes : [];
            if (!in_array('menu-item-has-children', $classes, true)) {
                $classes[] = 'menu-item-has-children';
            }
            if ($is_producto_context && !in_array('current-menu-ancestor', $classes, true)) {
                $classes[] = 'current-menu-ancestor';
            }
            $item->classes = $classes;
            $result[] = $item;

            foreach ($productos as $producto) {
                $permalink = get_permalink($producto);
                if (!$permalink) {
                    continue;
                }

                $child = clone $item;
                $child->ID = $virtual_id--;
                $child->db_id = 0;
                $child->menu_item_parent = (string) $parent_id;
                $child->object_id = (string) $producto->ID;
                $child->object = 'producto';
                $child->type = 'post_type';
                $child->type_label = 'Producto';
                $child->title = get_the_title($producto);
                $child->url = $permalink;
                $child->classes = ['menu-item', 'menu-item-type-post_type', 'menu-item-object-producto'];
                $child->current = is_singular('producto') && (int) get_the_ID() === (int) $producto->ID;
                $child->current_item_ancestor = false;
                $child->current_item_parent = false;
                $child->target = '';
                $child->attr_title = '';
                $child->description = '';
                $child->xfn = '';
                $child->menu_order = isset($item->menu_order) ? ((int) $item->menu_order + 1) : 0;
                $result[] = $child;
            }

            continue;
        }

        $result[] = $item;
    }

    return $result;
}, 20, 2);

// Mantener "Noticias" activo en archivo, categorias e internas de noticias.
add_filter('wp_nav_menu_objects', function ($items, $args) {
    if (!is_post_type_archive('noticia') && !is_singular('noticia') && !is_tax('noticia_cat')) {
        return $items;
    }

    if (empty($items) || !is_array($items)) {
        return $items;
    }

    $noticias_url = untrailingslashit(home_url('/noticias/'));

    foreach ($items as $item) {
        $item_url = isset($item->url) ? untrailingslashit($item->url) : '';
        $item_title = isset($item->title) ? strtolower(trim((string) $item->title)) : '';

        if ($item_url === $noticias_url || $item_title === 'noticias') {
            $classes = isset($item->classes) && is_array($item->classes) ? $item->classes : [];
            foreach (['current-menu-item', 'current_page_item'] as $active_class) {
                if (!in_array($active_class, $classes, true)) {
                    $classes[] = $active_class;
                }
            }

            $item->classes = $classes;
            $item->current = true;
        }
    }

    return $items;
}, 30, 2);

// Mantener "Blog" activo en archivo, categorias e internas del blog.
add_filter('wp_nav_menu_objects', function ($items, $args) {
    if (!is_home() && !is_singular('post') && !is_category() && !is_tag() && !is_date() && !is_author()) {
        return $items;
    }

    if (empty($items) || !is_array($items)) {
        return $items;
    }

    $blog_url = untrailingslashit(home_url('/blog/'));

    foreach ($items as $item) {
        $item_url = isset($item->url) ? untrailingslashit($item->url) : '';
        $item_title = isset($item->title) ? strtolower(trim((string) $item->title)) : '';

        if ($item_url === $blog_url || $item_title === 'blog') {
            $classes = isset($item->classes) && is_array($item->classes) ? $item->classes : [];
            foreach (['current-menu-item', 'current_page_item'] as $active_class) {
                if (!in_array($active_class, $classes, true)) {
                    $classes[] = $active_class;
                }
            }

            $item->classes = $classes;
            $item->current = true;
        }
    }

    return $items;
}, 35, 2);

// Mantener "Descubre Venza" activo en la pagina y en el quiz asociado.
add_filter('wp_nav_menu_objects', function ($items, $args) {
    if (!venza_is_descubre_context()) {
        return $items;
    }

    if (empty($items) || !is_array($items)) {
        return $items;
    }

    $descubre_url = untrailingslashit(home_url('/descubre-venza/'));

    foreach ($items as $item) {
        $item_url = isset($item->url) ? untrailingslashit($item->url) : '';
        $item_title = isset($item->title) ? strtolower(trim((string) $item->title)) : '';

        if ($item_url === $descubre_url || $item_title === 'descubre venza') {
            $classes = isset($item->classes) && is_array($item->classes) ? $item->classes : [];
            foreach (['current-menu-item', 'current_page_item'] as $active_class) {
                if (!in_array($active_class, $classes, true)) {
                    $classes[] = $active_class;
                }
            }

            $item->classes = $classes;
            $item->current = true;
        }
    }

    return $items;
}, 40, 2);

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

    if (is_page_template('page-quiz.php') || venza_is_descubre_quiz_route()) {
        wp_enqueue_script('venza-quiz', VENZA_URI . '/assets/js/quiz.js', [], $quiz_js_ver, true);
    }
});

// TamaÃ±os de imagen
add_action('after_setup_theme', function () {
    add_image_size('producto-hero',    1440, 700, true);
    add_image_size('producto-thumb',   400,  400, true);
    add_image_size('noticia-card',     600,  400, true);
    add_image_size('blog-card',        300,  300, true);
    add_image_size('blog-card-wide',   720,  520, true);
    add_image_size('blog-hero',        960,  960, true);
});

// ACF: cargar campos desde JSON
add_filter('acf/settings/load_json', function ($paths) {
    $paths[] = VENZA_DIR . '/inc/acf-fields';
    return $paths;
});
add_filter('acf/settings/save_json', function () {
    return VENZA_DIR . '/inc/acf-fields';
});

