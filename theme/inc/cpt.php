<?php
defined('ABSPATH') || exit;

add_action('init', function () {

    // CPT: Producto
    register_post_type('producto', [
        'labels' => [
            'name'          => 'Productos',
            'singular_name' => 'Producto',
            'add_new_item'  => 'Agregar Producto',
            'edit_item'     => 'Editar Producto',
        ],
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => ['slug' => 'productos'],
        'menu_icon'     => 'dashicons-archive',
        'supports'      => ['title', 'editor', 'thumbnail', 'excerpt'],
        'show_in_rest'  => true,
    ]);

    // CPT: Noticia
    register_post_type('noticia', [
        'labels' => [
            'name'          => 'Noticias',
            'singular_name' => 'Noticia',
            'add_new_item'  => 'Agregar Noticia',
            'edit_item'     => 'Editar Noticia',
        ],
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => ['slug' => 'noticias'],
        'menu_icon'     => 'dashicons-megaphone',
        'supports'      => ['title', 'editor', 'thumbnail', 'excerpt'],
        'show_in_rest'  => true,
    ]);

    // Taxonomía: Categoría de Noticia
    register_taxonomy('noticia_cat', 'noticia', [
        'labels' => [
            'name'          => 'Categorías de Noticia',
            'singular_name' => 'Categoría',
        ],
        'hierarchical'  => true,
        'rewrite'       => ['slug' => 'noticias/categoria'],
        'show_in_rest'  => true,
    ]);

    // Taxonomía: Línea de Producto
    register_taxonomy('linea_producto', 'producto', [
        'labels' => [
            'name'          => 'Líneas de Producto',
            'singular_name' => 'Línea',
        ],
        'hierarchical'  => true,
        'rewrite'       => ['slug' => 'productos/linea'],
        'show_in_rest'  => true,
    ]);
});
