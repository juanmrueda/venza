<?php
defined('ABSPATH') || exit;

add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    $build_hero_image_slide_fields = static function ($index, $default_alt = '') {
        return [
            [
                'key'           => 'field_venza_home_hero_slide_' . $index . '_image',
                'label'         => 'Home Hero - Slide ' . $index . ' (imagen)',
                'name'          => 'home_hero_slide_' . $index . '_image',
                'type'          => 'image',
                'return_format' => 'id',
                'preview_size'  => 'medium',
                'library'       => 'all',
                'instructions'  => 'Imagen del slide ' . $index . ' para el hero.',
            ],
            [
                'key'           => 'field_venza_home_hero_slide_' . $index . '_alt',
                'label'         => 'Home Hero - Slide ' . $index . ' (texto alterno)',
                'name'          => 'home_hero_slide_' . $index . '_alt',
                'type'          => 'text',
                'default_value' => $default_alt,
            ],
        ];
    };

    $build_line_fields = static function ($prefix, $label, array $defaults = []) {
        $title_default = isset($defaults['title']) ? (string) $defaults['title'] : '';
        $desc_default = isset($defaults['description']) ? (string) $defaults['description'] : '';
        $cta_default = isset($defaults['cta_text']) ? (string) $defaults['cta_text'] : 'Conoce mas';
        $fallback_name = isset($defaults['product_name']) ? (string) $defaults['product_name'] : '';

        $fields = [
            [
                'key'           => 'field_venza_' . $prefix . '_titulo',
                'label'         => $label . ' - Titulo',
                'name'          => $prefix . '_titulo',
                'type'          => 'text',
                'default_value' => $title_default,
            ],
            [
                'key'           => 'field_venza_' . $prefix . '_descripcion',
                'label'         => $label . ' - Descripcion',
                'name'          => $prefix . '_descripcion',
                'type'          => 'textarea',
                'rows'          => 4,
                'default_value' => $desc_default,
            ],
            [
                'key'           => 'field_venza_' . $prefix . '_cta_texto',
                'label'         => $label . ' - Texto boton',
                'name'          => $prefix . '_cta_texto',
                'type'          => 'text',
                'default_value' => $cta_default,
            ],
            [
                'key'          => 'field_venza_' . $prefix . '_cta_url',
                'label'        => $label . ' - URL boton',
                'name'         => $prefix . '_cta_url',
                'type'         => 'url',
                'instructions' => 'Opcional. Si queda vacio usa /productos/.',
            ],
            [
                'key'           => 'field_venza_' . $prefix . '_background',
                'label'         => $label . ' - Background del bloque',
                'name'          => $prefix . '_background',
                'type'          => 'image',
                'return_format' => 'id',
                'preview_size'  => 'medium',
                'library'       => 'all',
                'instructions'  => 'Imagen de fondo para este bloque de linea.',
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
                'instructions'  => 'Sube la imagen del producto para la rotacion. Si esta vacio, ese slot no rota.',
            ];
        }

        return $fields;
    };

    $build_home_benefit_fields = static function ($prefix, $label, array $defaults = []) {
        $fields = [];

        for ($i = 1; $i <= 4; $i++) {
            $row_default = isset($defaults[$i - 1]) && is_array($defaults[$i - 1]) ? $defaults[$i - 1] : [];
            $title_default = isset($row_default['title']) ? (string) $row_default['title'] : '';
            $text_default = isset($row_default['text']) ? (string) $row_default['text'] : '';

            $fields[] = [
                'key'           => 'field_venza_' . $prefix . '_' . $i . '_title',
                'label'         => $label . ' - Item ' . $i . ' (titulo)',
                'name'          => $prefix . '_' . $i . '_title',
                'type'          => 'text',
                'default_value' => $title_default,
            ];

            $fields[] = [
                'key'           => 'field_venza_' . $prefix . '_' . $i . '_text',
                'label'         => $label . ' - Item ' . $i . ' (texto)',
                'name'          => $prefix . '_' . $i . '_text',
                'type'          => 'textarea',
                'rows'          => 3,
                'default_value' => $text_default,
            ];
        }

        return $fields;
    };

    $fields = array_merge(
        [
            [
                'key'   => 'field_venza_home_tab_general',
                'label' => 'General',
                'type'  => 'tab',
            ],
            [
                'key'           => 'field_venza_home_background_image',
                'label'         => 'Home - Background general',
                'name'          => 'home_background_image',
                'type'          => 'image',
                'return_format' => 'id',
                'preview_size'  => 'medium',
                'library'       => 'all',
                'instructions'  => 'Imagen de fondo que aparece debajo del hero y acompana las secciones del home. Si queda vacio usa backgroundhome.png del tema.',
            ],
            [
                'key'           => 'field_venza_home_background_color',
                'label'         => 'Home - Color base del background',
                'name'          => 'home_background_color',
                'type'          => 'color_picker',
                'default_value' => '#f8fbff',
                'instructions'  => 'Color de respaldo debajo de la imagen de fondo.',
            ],
            [
                'key'   => 'field_venza_home_tab_hero',
                'label' => 'Hero',
                'type'  => 'tab',
            ],
            [
                'key'           => 'field_venza_home_hero_slide_1_video',
                'label'         => 'Home Hero - Slide 1 (video principal)',
                'name'          => 'home_hero_slide_1_video',
                'type'          => 'file',
                'return_format' => 'id',
                'library'       => 'all',
                'mime_types'    => 'mp4,webm,ogg',
                'instructions'  => 'Video principal del hero. Si queda vacio, usa el archivo local por defecto del tema.',
            ],
            [
                'key'           => 'field_venza_home_hero_slide_1_poster',
                'label'         => 'Home Hero - Slide 1 (poster)',
                'name'          => 'home_hero_slide_1_poster',
                'type'          => 'image',
                'return_format' => 'id',
                'preview_size'  => 'medium',
                'library'       => 'all',
            ],
            [
                'key'           => 'field_venza_home_hero_slide_1_alt',
                'label'         => 'Home Hero - Slide 1 (texto alterno)',
                'name'          => 'home_hero_slide_1_alt',
                'type'          => 'text',
                'default_value' => 'Video Home Venza',
            ],
            [
                'key'           => 'field_venza_home_hero_slide_1_wait_end',
                'label'         => 'Home Hero - Esperar fin del video antes de cambiar',
                'name'          => 'home_hero_slide_1_wait_end',
                'type'          => 'true_false',
                'ui'            => 1,
                'default_value' => 1,
            ],
        ],
        $build_hero_image_slide_fields(2, 'Frescura Extrema'),
        $build_hero_image_slide_fields(3, 'Vitamina E'),
        $build_hero_image_slide_fields(4, 'Sabila'),
        [
            [
                'key'           => 'field_venza_home_claim_text',
                'label'         => 'Home Hero - Texto del claim',
                'name'          => 'home_claim_text',
                'type'          => 'textarea',
                'rows'          => 4,
                'new_lines'     => 'br',
                'default_value' => 'Cada uno de nuestros productos exalta una <strong>sensacion y emocion especial</strong> para los diferentes momentos del dia, ayudandote a ti y a los tuyos a vivir <strong>cada instante plenamente</strong>.',
                'instructions'  => 'Acepta etiquetas basicas como <strong> para resaltar texto.',
            ],
            [
                'key'   => 'field_venza_home_tab_productos',
                'label' => 'Productos',
                'type'  => 'tab',
            ],
            [
                'key'           => 'field_venza_home_productos_titulo',
                'label'         => 'Home - Productos titulo',
                'name'          => 'home_productos_titulo',
                'type'          => 'text',
                'default_value' => 'Productos',
            ],
        ],
        $build_line_fields('home_linea_antibacterial', 'Linea Antibacterial', [
            'title'        => 'Linea Antibacterial',
            'description'  => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam',
            'cta_text'     => 'Conoce mas',
            'product_name' => 'Frescura Extrema',
        ]),
        $build_line_fields('home_linea_hidratacion', 'Linea Hidratacion Profunda', [
            'title'        => 'Linea Hidratacion Profunda',
            'description'  => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam',
            'cta_text'     => 'Conoce mas',
            'product_name' => 'Crema Humectante',
        ]),
        [
            [
                'key'   => 'field_venza_home_tab_beneficios',
                'label' => 'Beneficios',
                'type'  => 'tab',
            ],
            [
                'key'           => 'field_venza_home_beneficios_titulo',
                'label'         => 'Home - Beneficios titulo',
                'name'          => 'home_beneficios_titulo',
                'type'          => 'text',
                'default_value' => 'Beneficios',
            ],
        ],
        $build_home_benefit_fields('home_beneficios_left', 'Home Beneficios - Columna izquierda', [
            [
                'title' => 'Proteccion antibacterial',
                'text'  => 'Elimina eficazmente bacterias y germenes, brindando una limpieza profunda que protege tu piel en cada uso.',
            ],
            [
                'title' => 'Formula humectante',
                'text'  => 'Disenada para mantener la piel hidratada, evitando la resequedad y proporcionando suavidad natural.',
            ],
            [
                'title' => 'Aromas agradables',
                'text'  => 'Cada jabon deja una fragancia fresca y duradera que acompana tus momentos de cuidado diario.',
            ],
            [
                'title' => 'Nutre la piel seca',
                'text'  => 'Enriquecido con componentes que aportan nutricion y alivio a la piel mas reseca.',
            ],
        ]),
        $build_home_benefit_fields('home_beneficios_right', 'Home Beneficios - Columna derecha', [
            [
                'title' => 'Deja la piel suave y radiante',
                'text'  => 'Gracias a sus ingredientes especiales, tu piel se siente tersa y con un brillo saludable.',
            ],
            [
                'title' => 'Limpieza efectiva',
                'text'  => 'Elimina impurezas y suciedad facilmente, dejando tu piel limpia, fresca y revitalizada.',
            ],
            [
                'title' => 'Apto para uso diario',
                'text'  => 'Suavidad y frescura que podes disfrutar todos los dias sin irritar ni maltratar la piel.',
            ],
            [
                'title' => 'Alto rendimiento',
                'text'  => 'Su formula concentrada rinde mas, ofreciendo calidad y duracion en cada barra de jabon.',
            ],
        ]),
        [
            [
                'key'           => 'field_venza_home_beneficios_soap_green_text',
                'label'         => 'Home Beneficios - texto jabon verde',
                'name'          => 'home_beneficios_soap_green_text',
                'type'          => 'text',
                'default_value' => 'venza',
            ],
            [
                'key'           => 'field_venza_home_beneficios_soap_cream_text',
                'label'         => 'Home Beneficios - texto jabon crema',
                'name'          => 'home_beneficios_soap_cream_text',
                'type'          => 'text',
                'default_value' => 'venza',
            ],
            [
                'key'   => 'field_venza_home_tab_venza_hoy',
                'label' => 'Venza hoy',
                'type'  => 'tab',
            ],
            [
                'key'           => 'field_venza_home_venza_hoy_titulo',
                'label'         => 'Venza hoy - Titulo',
                'name'          => 'home_venza_hoy_titulo',
                'type'          => 'text',
                'default_value' => 'Venza hoy',
            ],
            [
                'key'           => 'field_venza_home_venza_hoy_pill',
                'label'         => 'Venza hoy - Texto introductorio',
                'name'          => 'home_venza_hoy_pill',
                'type'          => 'textarea',
                'rows'          => 2,
                'new_lines'     => 'br',
                'default_value' => 'Mira todas las novedades que Venza tiene para ti',
            ],
            [
                'key'           => 'field_venza_home_venza_hoy_cta_texto',
                'label'         => 'Venza hoy - Texto boton tarjetas',
                'name'          => 'home_venza_hoy_cta_texto',
                'type'          => 'text',
                'default_value' => 'Conoce mas',
            ],
            [
                'key'           => 'field_venza_home_venza_hoy_video',
                'label'         => 'Venza hoy - Video principal',
                'name'          => 'home_venza_hoy_video',
                'type'          => 'file',
                'return_format' => 'id',
                'library'       => 'all',
                'mime_types'    => 'mp4,webm,ogg',
                'instructions'  => 'Opcional. Si queda vacio usa el video por defecto del hero.',
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
        'title'  => 'Home - Secciones editables',
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
