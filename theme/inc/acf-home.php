<?php
defined('ABSPATH') || exit;

add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    $build_line_fields = static function ($prefix, $label, array $defaults = []) {
        $title_default = isset($defaults['title']) ? (string) $defaults['title'] : '';
        $desc_default = isset($defaults['description']) ? (string) $defaults['description'] : '';
        $cta_default = isset($defaults['cta_text']) ? (string) $defaults['cta_text'] : 'Conoce más';
        $fallback_name = isset($defaults['product_name']) ? (string) $defaults['product_name'] : '';

        $fields = [
            [
                'key'           => 'field_venza_' . $prefix . '_titulo',
                'label'         => $label . ' - Título',
                'name'          => $prefix . '_titulo',
                'type'          => 'text',
                'default_value' => $title_default,
            ],
            [
                'key'           => 'field_venza_' . $prefix . '_descripcion',
                'label'         => $label . ' - Descripción',
                'name'          => $prefix . '_descripcion',
                'type'          => 'textarea',
                'rows'          => 4,
                'default_value' => $desc_default,
            ],
            [
                'key'           => 'field_venza_' . $prefix . '_cta_texto',
                'label'         => $label . ' - Texto botón',
                'name'          => $prefix . '_cta_texto',
                'type'          => 'text',
                'default_value' => $cta_default,
            ],
            [
                'key'          => 'field_venza_' . $prefix . '_cta_url',
                'label'        => $label . ' - URL botón',
                'name'         => $prefix . '_cta_url',
                'type'         => 'url',
                'instructions' => 'Opcional. Si queda vacío usa /productos/.',
            ],
            [
                'key'           => 'field_venza_' . $prefix . '_background',
                'label'         => $label . ' - Background del bloque',
                'name'          => $prefix . '_background',
                'type'          => 'image',
                'return_format' => 'id',
                'preview_size'  => 'medium',
                'library'       => 'all',
                'instructions'  => 'Imagen de fondo para este bloque de línea.',
            ],
        ];

        for ($i = 1; $i <= 5; $i++) {
            $fields[] = [
                'key'           => 'field_venza_' . $prefix . '_producto_' . $i . '_nombre',
                'label'         => $label . ' - Producto rotador ' . $i . ' (nombre)',
                'name'          => $prefix . '_producto_' . $i . '_nombre',
                'type'          => 'text',
                'default_value' => $i === 1 ? $fallback_name : '',
            ];

            $fields[] = [
                'key'           => 'field_venza_' . $prefix . '_producto_' . $i . '_imagen',
                'label'         => $label . ' - Producto rotador ' . $i . ' (imagen)',
                'name'          => $prefix . '_producto_' . $i . '_imagen',
                'type'          => 'image',
                'return_format' => 'id',
                'preview_size'  => 'medium',
                'library'       => 'all',
                'instructions'  => 'Sube la imagen del producto para la rotación. Si está vacío, ese slot no rota.',
            ];
        }

        return $fields;
    };

    $fields = array_merge(
        $build_line_fields('home_linea_antibacterial', 'Línea Antibacterial', [
            'title'       => 'Línea Antibacterial',
            'description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam',
            'cta_text'    => 'Conoce más',
            'product_name'=> 'Frescura Extrema',
        ]),
        $build_line_fields('home_linea_hidratacion', 'Línea Hidratación Profunda', [
            'title'       => 'Línea Hidratación Profunda',
            'description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam',
            'cta_text'    => 'Conoce más',
            'product_name'=> 'Crema Humectante',
        ]),
        [
            [
                'key'           => 'field_venza_home_venza_hoy_video',
                'label'         => 'Venza hoy - Video principal',
                'name'          => 'home_venza_hoy_video',
                'type'          => 'file',
                'return_format' => 'id',
                'library'       => 'all',
                'mime_types'    => 'mp4,webm,ogg',
                'instructions'  => 'Opcional. Si queda vacío usa el video por defecto del hero.',
            ],
            [
                'key'           => 'field_venza_home_venza_hoy_video_poster',
                'label'         => 'Venza hoy - Poster de video',
                'name'          => 'home_venza_hoy_video_poster',
                'type'          => 'image',
                'return_format' => 'id',
                'preview_size'  => 'medium',
                'library'       => 'all',
                'instructions'  => 'Imagen de respaldo mientras carga el video.',
            ],
        ]
    );

    acf_add_local_field_group([
        'key'    => 'group_venza_home_sections',
        'title'  => 'Home - Productos y Venza hoy',
        'fields' => $fields,
        'location' => [
            [
                [
                    'param'    => 'page_type',
                    'operator' => '==',
                    'value'    => 'front_page',
                ],
            ],
        ],
        'position' => 'normal',
        'style'    => 'default',
    ]);
});
