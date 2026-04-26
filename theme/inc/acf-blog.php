<?php
defined('ABSPATH') || exit;

add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    $image_field = static function ($key, $label, $name, $instructions = '') {
        return [
            'key'           => $key,
            'label'         => $label,
            'name'          => $name,
            'type'          => 'image',
            'return_format' => 'id',
            'preview_size'  => 'medium',
            'library'       => 'all',
            'instructions'  => $instructions,
        ];
    };

    $textarea_field = static function ($key, $label, $name, $rows = 4, $instructions = '') {
        return [
            'key'          => $key,
            'label'        => $label,
            'name'         => $name,
            'type'         => 'textarea',
            'rows'         => $rows,
            'instructions' => $instructions,
        ];
    };

    $type_one_fields = [];
    for ($i = 1; $i <= 4; $i++) {
        $type_one_fields[] = $image_field(
            'field_venza_blog_t1_block_' . $i . '_image',
            'Interna Tipo 1 - Bloque ' . $i . ' imagen',
            'blog_t1_block_' . $i . '_image_id',
            'Imagen del bloque editorial ' . $i . '.'
        );

        $type_one_fields[] = $textarea_field(
            'field_venza_blog_t1_block_' . $i . '_text',
            'Interna Tipo 1 - Bloque ' . $i . ' texto',
            'blog_t1_block_' . $i . '_text',
            5,
            'Acepta HTML basico como <strong> para resaltar texto.'
        );

        $type_one_fields[] = [
            'key'           => 'field_venza_blog_t1_block_' . $i . '_style',
            'label'         => 'Interna Tipo 1 - Bloque ' . $i . ' estilo texto',
            'name'          => 'blog_t1_block_' . $i . '_style',
            'type'          => 'select',
            'choices'       => [
                'light' => 'Fondo claro',
                'blue'  => 'Fondo azul',
            ],
            'default_value' => in_array($i, [1, 3], true) ? 'blue' : 'light',
            'ui'            => 1,
        ];

        $type_one_fields[] = $image_field(
            'field_venza_blog_t1_block_' . $i . '_overlay_image',
            'Interna Tipo 1 - Bloque ' . $i . ' imagen encima del texto',
            'blog_t1_block_' . $i . '_overlay_image_id',
            'Opcional. Si queda vacia no se muestra ninguna imagen encima del texto.'
        );

        $type_one_fields[] = [
            'key'           => 'field_venza_blog_t1_block_' . $i . '_overlay_position',
            'label'         => 'Interna Tipo 1 - Bloque ' . $i . ' posicion imagen encima',
            'name'          => 'blog_t1_block_' . $i . '_overlay_position',
            'type'          => 'select',
            'choices'       => [
                'top-left'      => 'Arriba izquierda',
                'top-center'    => 'Arriba centro',
                'top-right'     => 'Arriba derecha',
                'center-left'   => 'Centro izquierda',
                'center-right'  => 'Centro derecha',
                'bottom-left'   => 'Abajo izquierda',
                'bottom-center' => 'Abajo centro',
                'bottom-right'  => 'Abajo derecha',
            ],
            'default_value' => in_array($i, [1, 3], true) ? 'bottom-left' : 'top-right',
            'ui'            => 1,
        ];
    }

    acf_add_local_field_group([
        'key'    => 'group_venza_blog_home',
        'title'  => 'Blog - Home editable',
        'fields' => [
            [
                'key'           => 'field_venza_blog_home_use_background_image',
                'label'         => 'Blog Home - Usar imagen de fondo',
                'name'          => 'blog_home_use_background_image',
                'type'          => 'true_false',
                'ui'            => 1,
                'default_value' => 0,
                'instructions'  => 'Apagado por defecto para mejorar rendimiento. Enciendelo solo si necesitas una imagen de fondo.',
            ],
            $image_field(
                'field_venza_blog_home_background_image',
                'Blog Home - Background',
                'blog_home_background_image_id',
                'Imagen de fondo para el home del blog. Solo carga si el switch anterior esta encendido.'
            ),
            [
                'key'           => 'field_venza_blog_home_background_color',
                'label'         => 'Blog Home - Color base',
                'name'          => 'blog_home_background_color',
                'type'          => 'color_picker',
                'default_value' => '#eaf3fb',
            ],
            [
                'key'           => 'field_venza_blog_home_button_text',
                'label'         => 'Blog Home - Texto boton tarjetas',
                'name'          => 'blog_home_button_text',
                'type'          => 'text',
                'default_value' => 'Conoce mas',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'page_type',
                    'operator' => '==',
                    'value'    => 'posts_page',
                ],
            ],
        ],
        'position' => 'normal',
        'style'    => 'default',
    ]);

    acf_add_local_field_group([
        'key'    => 'group_venza_blog_post',
        'title'  => 'Blog - Campos visuales',
        'fields' => array_merge(
            [
                [
                    'key'   => 'field_venza_blog_tab_general',
                    'label' => 'General',
                    'type'  => 'tab',
                ],
                $image_field(
                    'field_venza_blog_card_image',
                    'Home Blog - Imagen tarjeta',
                    'blog_card_image_id',
                    'Opcional. Se usa solo si la entrada no tiene imagen destacada.'
                ),
                $textarea_field(
                    'field_venza_blog_card_excerpt',
                    'Home Blog - Resumen tarjeta',
                    'blog_card_excerpt',
                    3,
                    'Opcional. Si queda vacio usa el extracto o el contenido.'
                ),
                [
                    'key'   => 'field_venza_blog_card_button_text',
                    'label' => 'Home Blog - Texto boton',
                    'name'  => 'blog_card_button_text',
                    'type'  => 'text',
                ],
                [
                    'key'   => 'field_venza_blog_tab_hero',
                    'label' => 'Hero interna',
                    'type'  => 'tab',
                ],
                $image_field(
                    'field_venza_blog_hero_image',
                    'Hero - Imagen principal',
                    'blog_hero_image_id',
                    'Opcional. Se usa solo si la entrada no tiene imagen destacada.'
                ),
                $textarea_field(
                    'field_venza_blog_hero_intro',
                    'Hero - Texto destacado',
                    'blog_hero_intro',
                    3,
                    'Texto principal debajo del titulo. Acepta <strong>.'
                ),
                $textarea_field(
                    'field_venza_blog_hero_body',
                    'Hero - Texto secundario',
                    'blog_hero_body',
                    4,
                    'Texto complementario debajo del destacado. Acepta <strong>.'
                ),
                [
                    'key'   => 'field_venza_blog_tab_type_1',
                    'label' => 'Interna tipo 1',
                    'type'  => 'tab',
                ],
            ],
            $type_one_fields
        ),
        'location' => [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'post',
                ],
            ],
        ],
        'position' => 'normal',
        'style'    => 'default',
    ]);
});
