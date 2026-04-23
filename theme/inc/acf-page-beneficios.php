<?php
defined('ABSPATH') || exit;

add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    $fields = [
        [
            'key'          => 'field_venza_beneficios_quote',
            'label'        => 'Quote principal',
            'name'         => 'beneficios_quote',
            'type'         => 'wysiwyg',
            'tabs'         => 'visual',
            'toolbar'      => 'basic',
            'media_upload' => 0,
            'instructions' => 'Texto principal del recuadro superior.',
        ],
        [
            'key'           => 'field_venza_beneficios_bg_type',
            'label'         => 'Fondo animado - Tipo',
            'name'          => 'beneficios_bg_type',
            'type'          => 'select',
            'choices'       => [
                'default' => 'Degradado base',
                'image'   => 'Imagen',
                'video'   => 'Video (animado)',
            ],
            'default_value' => 'default',
            'allow_null'    => 0,
            'ui'            => 1,
        ],
        [
            'key'               => 'field_venza_beneficios_bg_image',
            'label'             => 'Fondo animado - Imagen',
            'name'              => 'beneficios_bg_image',
            'type'              => 'image',
            'return_format'     => 'id',
            'preview_size'      => 'medium',
            'library'           => 'all',
            'conditional_logic' => [
                [
                    [
                        'field'    => 'field_venza_beneficios_bg_type',
                        'operator' => '==',
                        'value'    => 'image',
                    ],
                ],
            ],
        ],
        [
            'key'               => 'field_venza_beneficios_bg_video',
            'label'             => 'Fondo animado - Video (mp4/webm)',
            'name'              => 'beneficios_bg_video',
            'type'              => 'file',
            'return_format'     => 'url',
            'library'           => 'all',
            'mime_types'        => 'mp4,webm',
            'conditional_logic' => [
                [
                    [
                        'field'    => 'field_venza_beneficios_bg_type',
                        'operator' => '==',
                        'value'    => 'video',
                    ],
                ],
            ],
            'instructions'      => 'Recomendado: mp4 liviano en loop.',
        ],
        [
            'key'           => 'field_venza_beneficios_bg_strength',
            'label'         => 'Fondo animado - Opacidad de capa',
            'name'          => 'beneficios_bg_strength',
            'type'          => 'range',
            'default_value' => 35,
            'min'           => 0,
            'max'           => 100,
            'step'          => 1,
            'instructions'  => '0 = se ve fuerte el fondo, 100 = casi oculto.',
        ],
    ];

    for ($i = 1; $i <= 8; $i++) {
        $fields[] = [
            'key'       => 'field_venza_beneficios_sep_' . $i,
            'label'     => 'Beneficio ' . $i,
            'name'      => '',
            'type'      => 'message',
            'message'   => '<strong>Beneficio ' . $i . '</strong>',
            'new_lines' => 'wpautop',
        ];

        $fields[] = [
            'key'   => 'field_venza_beneficios_item_' . $i . '_titulo',
            'label' => 'Beneficio ' . $i . ' - Titulo',
            'name'  => 'beneficios_item_' . $i . '_titulo',
            'type'  => 'text',
        ];

        $fields[] = [
            'key'          => 'field_venza_beneficios_item_' . $i . '_descripcion',
            'label'        => 'Beneficio ' . $i . ' - Descripcion',
            'name'         => 'beneficios_item_' . $i . '_descripcion',
            'type'         => 'textarea',
            'rows'         => 3,
            'new_lines'    => 'wpautop',
            'instructions' => 'Texto descriptivo del bloque.',
        ];

        $fields[] = [
            'key'           => 'field_venza_beneficios_item_' . $i . '_imagen',
            'label'         => 'Beneficio ' . $i . ' - Imagen',
            'name'          => 'beneficios_item_' . $i . '_imagen',
            'type'          => 'image',
            'return_format' => 'id',
            'preview_size'  => 'medium',
            'library'       => 'all',
        ];
    }

    acf_add_local_field_group([
        'key'      => 'group_venza_page_beneficios',
        'title'    => 'Pagina - Beneficios',
        'fields'   => $fields,
        'location' => [
            [
                [
                    'param'    => 'page_template',
                    'operator' => '==',
                    'value'    => 'page-beneficios.php',
                ],
            ],
        ],
        'position' => 'normal',
        'style'    => 'default',
    ]);
});

