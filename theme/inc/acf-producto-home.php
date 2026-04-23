<?php
defined('ABSPATH') || exit;

add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group([
        'key'    => 'group_venza_producto_home',
        'title'  => 'Producto - Home de Productos',
        'fields' => [
            [
                'key'           => 'field_venza_producto_destacado_home',
                'label'         => 'Producto destacado en /productos/',
                'name'          => 'producto_destacado_home',
                'type'          => 'true_false',
                'ui'            => 1,
                'default_value' => 0,
            ],
            [
                'key'           => 'field_venza_producto_home_subtitulo',
                'label'         => 'Subtítulo principal',
                'name'          => 'producto_home_subtitulo',
                'type'          => 'text',
                'instructions'  => 'Ejemplo: Crema Humectante',
            ],
            [
                'key'           => 'field_venza_producto_home_banner_imagen',
                'label'         => 'Banner principal de /productos/',
                'name'          => 'producto_home_banner_imagen',
                'type'          => 'image',
                'return_format' => 'id',
                'preview_size'  => 'medium',
                'library'       => 'all',
            ],
            [
                'key'           => 'field_venza_producto_home_beneficio_1',
                'label'         => 'Beneficio 1 (título)',
                'name'          => 'producto_home_beneficio_1',
                'type'          => 'text',
            ],
            [
                'key'           => 'field_venza_producto_home_beneficio_1_imagen',
                'label'         => 'Beneficio 1 (imagen)',
                'name'          => 'producto_home_beneficio_1_imagen',
                'type'          => 'image',
                'return_format' => 'id',
                'preview_size'  => 'medium',
                'library'       => 'all',
            ],
            [
                'key'           => 'field_venza_producto_home_beneficio_1_texto',
                'label'         => 'Beneficio 1 (texto inferior)',
                'name'          => 'producto_home_beneficio_1_texto',
                'type'          => 'text',
            ],
            [
                'key'           => 'field_venza_producto_home_beneficio_2',
                'label'         => 'Beneficio 2 (título)',
                'name'          => 'producto_home_beneficio_2',
                'type'          => 'text',
            ],
            [
                'key'           => 'field_venza_producto_home_beneficio_2_imagen',
                'label'         => 'Beneficio 2 (imagen)',
                'name'          => 'producto_home_beneficio_2_imagen',
                'type'          => 'image',
                'return_format' => 'id',
                'preview_size'  => 'medium',
                'library'       => 'all',
            ],
            [
                'key'           => 'field_venza_producto_home_beneficio_2_texto',
                'label'         => 'Beneficio 2 (texto inferior)',
                'name'          => 'producto_home_beneficio_2_texto',
                'type'          => 'text',
            ],
            [
                'key'           => 'field_venza_producto_home_beneficio_3',
                'label'         => 'Beneficio 3 (título)',
                'name'          => 'producto_home_beneficio_3',
                'type'          => 'text',
            ],
            [
                'key'           => 'field_venza_producto_home_beneficio_3_imagen',
                'label'         => 'Beneficio 3 (imagen)',
                'name'          => 'producto_home_beneficio_3_imagen',
                'type'          => 'image',
                'return_format' => 'id',
                'preview_size'  => 'medium',
                'library'       => 'all',
            ],
            [
                'key'           => 'field_venza_producto_home_beneficio_3_texto',
                'label'         => 'Beneficio 3 (texto inferior)',
                'name'          => 'producto_home_beneficio_3_texto',
                'type'          => 'text',
            ],
            [
                'key'           => 'field_venza_producto_home_desc_texto',
                'label'         => 'Texto sección descripción',
                'name'          => 'producto_home_descripcion_texto',
                'type'          => 'wysiwyg',
                'tabs'          => 'visual',
                'toolbar'       => 'basic',
                'media_upload'  => 0,
            ],
            [
                'key'           => 'field_venza_producto_home_desc_imagen',
                'label'         => 'Imagen sección descripción',
                'name'          => 'producto_home_descripcion_imagen',
                'type'          => 'image',
                'return_format' => 'id',
                'preview_size'  => 'medium',
                'library'       => 'all',
            ],
            [
                'key'           => 'field_venza_producto_home_claim_texto',
                'label'         => 'Texto caja destacada',
                'name'          => 'producto_home_claim_texto',
                'type'          => 'textarea',
                'rows'          => 3,
                'instructions'  => 'Texto descriptivo de la caja redondeada.',
            ],
            [
                'key'           => 'field_venza_producto_home_claim_cta',
                'label'         => 'Texto fuerte caja destacada',
                'name'          => 'producto_home_claim_cta',
                'type'          => 'text',
                'instructions'  => 'Ejemplo: ¡Pruébalo hoy mismo!',
            ],
            [
                'key'           => 'field_venza_producto_home_disponibilidad',
                'label'         => 'Disponible en (override)',
                'name'          => 'producto_home_disponibilidad_override',
                'type'          => 'text',
                'instructions'  => 'Opcional. Si se deja vacío, usa los países por defecto.',
            ],
            [
                'key'           => 'field_venza_producto_home_mas_subtitulo',
                'label'         => 'Subtítulo de Más productos',
                'name'          => 'producto_home_mas_productos_subtitulo',
                'type'          => 'text',
                'instructions'  => 'Ejemplo: Jabón antibacterial',
            ],
            [
                'key'           => 'field_venza_producto_single_gradient_color',
                'label'         => 'Color del degradé (página producto)',
                'name'          => 'producto_single_gradient_color',
                'type'          => 'color_picker',
                'default_value' => '#acdcef',
                'instructions'  => 'Color inicial del degradé horizontal en las secciones "descripción" y "tamaños" de la página del producto. Siempre termina en blanco.',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'producto',
                ],
            ],
        ],
        'position' => 'normal',
        'style'    => 'default',
    ]);
});
