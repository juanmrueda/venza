<?php
defined('ABSPATH') || exit;

add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group([
        'key'    => 'group_venza_noticia',
        'title'  => 'Noticia - Campos visuales',
        'fields' => [
            [
                'key'          => 'field_venza_noticia_intro_line',
                'label'        => 'Linea introductoria (interna)',
                'name'         => 'noticia_intro_line',
                'type'         => 'text',
                'instructions' => 'Ejemplo: Descubre el nuevo jabon',
            ],
            [
                'key'          => 'field_venza_noticia_badge_1_text',
                'label'        => 'Badge 1 - Texto',
                'name'         => 'noticia_badge_1_text',
                'type'         => 'text',
                'instructions' => 'Ejemplo: Equilibrio para la piel.',
            ],
            [
                'key'           => 'field_venza_noticia_badge_1_icon_id',
                'label'         => 'Badge 1 - Icono',
                'name'          => 'noticia_badge_1_icon_id',
                'type'          => 'image',
                'return_format' => 'id',
                'preview_size'  => 'thumbnail',
                'library'       => 'all',
            ],
            [
                'key'           => 'field_venza_noticia_badge_1_position',
                'label'         => 'Badge 1 - Posicion',
                'name'          => 'noticia_badge_1_position',
                'type'          => 'select',
                'choices'       => [
                    'top-right'    => 'Arriba derecha',
                    'top-left'     => 'Arriba izquierda',
                    'bottom-left'  => 'Abajo izquierda',
                    'bottom-right' => 'Abajo derecha',
                ],
                'default_value' => 'top-right',
                'ui'            => 1,
            ],
            [
                'key'          => 'field_venza_noticia_badge_2_text',
                'label'        => 'Badge 2 - Texto',
                'name'         => 'noticia_badge_2_text',
                'type'         => 'text',
                'instructions' => 'Ejemplo: Para toda la familia.',
            ],
            [
                'key'           => 'field_venza_noticia_badge_2_icon_id',
                'label'         => 'Badge 2 - Icono',
                'name'          => 'noticia_badge_2_icon_id',
                'type'          => 'image',
                'return_format' => 'id',
                'preview_size'  => 'thumbnail',
                'library'       => 'all',
            ],
            [
                'key'           => 'field_venza_noticia_badge_2_position',
                'label'         => 'Badge 2 - Posicion',
                'name'          => 'noticia_badge_2_position',
                'type'          => 'select',
                'choices'       => [
                    'bottom-left'  => 'Abajo izquierda',
                    'bottom-right' => 'Abajo derecha',
                    'top-right'    => 'Arriba derecha',
                    'top-left'     => 'Arriba izquierda',
                ],
                'default_value' => 'bottom-left',
                'ui'            => 1,
            ],
            [
                'key'          => 'field_venza_noticia_video_url',
                'label'        => 'Video URL (Repositorio Sensorial)',
                'name'         => 'noticia_video_url',
                'type'         => 'url',
                'instructions' => 'URL de YouTube, Vimeo u otra plataforma compatible para mostrar video en repositorio.',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'noticia',
                ],
            ],
        ],
        'position' => 'normal',
        'style'    => 'default',
    ]);

    acf_add_local_field_group([
        'key'    => 'group_venza_noticia_categoria',
        'title'  => 'Categoria de noticia - Home y hero',
        'fields' => [
            [
                'key'          => 'field_venza_noticia_home_label_light',
                'label'        => 'Home Noticias - Pestana linea light',
                'name'         => 'venza_noticia_home_label_light',
                'type'         => 'text',
                'instructions' => 'Primera linea de la pestana del card. Ejemplo: Nuevos, Activaciones, Repositorio.',
            ],
            [
                'key'          => 'field_venza_noticia_home_label_strong',
                'label'        => 'Home Noticias - Pestana linea bold',
                'name'         => 'venza_noticia_home_label_strong',
                'type'         => 'text',
                'instructions' => 'Segunda linea de la pestana del card. Ejemplo: Lanzamientos, Venza, Sensorial.',
            ],
            [
                'key'          => 'field_venza_noticia_home_title',
                'label'        => 'Home Noticias - Titulo del card',
                'name'         => 'venza_noticia_home_title',
                'type'         => 'text',
                'instructions' => 'Opcional. Si se deja vacio, toma el titulo de la ultima noticia de la categoria.',
            ],
            [
                'key'          => 'field_venza_noticia_home_summary',
                'label'        => 'Home Noticias - Resumen del card',
                'name'         => 'venza_noticia_home_summary',
                'type'         => 'textarea',
                'rows'         => 3,
                'instructions' => 'Opcional. Si se deja vacio, toma la descripcion de la categoria o extracto de la ultima noticia.',
            ],
            [
                'key'           => 'field_venza_noticia_home_image_id',
                'label'         => 'Home Noticias - Imagen del card',
                'name'          => 'venza_noticia_home_image_id',
                'type'          => 'image',
                'return_format' => 'id',
                'preview_size'  => 'medium',
                'library'       => 'all',
                'instructions'  => 'Opcional. Si se deja vacio, usa la imagen destacada de la ultima noticia de la categoria.',
            ],
            [
                'key'          => 'field_venza_noticia_home_button_text',
                'label'        => 'Home Noticias - Texto del boton',
                'name'         => 'venza_noticia_home_button_text',
                'type'         => 'text',
                'instructions' => 'Opcional. Si se deja vacio, usa: Conoce mas.',
            ],
            [
                'key'          => 'field_venza_noticia_home_button_url',
                'label'        => 'Home Noticias - URL personalizada',
                'name'         => 'venza_noticia_home_button_url',
                'type'         => 'url',
                'instructions' => 'Opcional. Si se deja vacio, usa la categoria o la pagina de Repositorio Sensorial.',
            ],
            [
                'key'          => 'field_venza_noticia_hero_title',
                'label'        => 'Interna categoria - Titulo hero',
                'name'         => 'venza_noticia_hero_title',
                'type'         => 'text',
                'instructions' => 'Opcional. Si se deja vacio, usa el nombre de la categoria.',
            ],
            [
                'key'          => 'field_venza_noticia_hero_subtitle',
                'label'        => 'Interna categoria - Subtitulo hero',
                'name'         => 'venza_noticia_hero_subtitle',
                'type'         => 'text',
                'instructions' => 'Opcional. Si se deja vacio, usa la descripcion de la categoria.',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'taxonomy',
                    'operator' => '==',
                    'value'    => 'noticia_cat',
                ],
            ],
        ],
        'position' => 'normal',
        'style'    => 'default',
    ]);
});
