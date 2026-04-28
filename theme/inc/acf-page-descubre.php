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

    $file_field = static function ($key, $label, $name, $instructions = '') {
        return [
            'key'           => $key,
            'label'         => $label,
            'name'          => $name,
            'type'          => 'file',
            'return_format' => 'id',
            'library'       => 'all',
            'mime_types'    => 'mp4,webm,mov',
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

    $video_card_fields = [];
    for ($i = 1; $i <= 6; $i++) {
        $video_card_fields[] = [
            'key'           => 'field_venza_descubre_video_' . $i . '_enabled',
            'label'         => 'Video card ' . $i . ' - Mostrar',
            'name'          => 'descubre_video_' . $i . '_enabled',
            'type'          => 'true_false',
            'ui'            => 1,
            'default_value' => $i <= 4 ? 1 : 0,
            'instructions'  => 'Activa o desactiva esta tarjeta del carrusel.',
        ];

        $video_card_fields[] = $image_field(
            'field_venza_descubre_video_' . $i . '_image',
            'Video card ' . $i . ' - Poster',
            'descubre_video_' . $i . '_image_id',
            'Imagen previa del video. Recomendado si el video se sube como archivo pesado.'
        );

        $video_card_fields[] = $file_field(
            'field_venza_descubre_video_' . $i . '_file',
            'Video card ' . $i . ' - Archivo video',
            'descubre_video_' . $i . '_file_id',
            'Opcional. Para videos pesados, idealmente optimizar a menos de 80 MB o usar la URL externa.'
        );

        $video_card_fields[] = [
            'key'   => 'field_venza_descubre_video_' . $i . '_title',
            'label' => 'Video card ' . $i . ' - Titulo',
            'name'  => 'descubre_video_' . $i . '_title',
            'type'  => 'text',
        ];

        $video_card_fields[] = [
            'key'          => 'field_venza_descubre_video_' . $i . '_meta',
            'label'        => 'Video card ' . $i . ' - Meta',
            'name'         => 'descubre_video_' . $i . '_meta',
            'type'         => 'text',
            'instructions' => 'Ejemplo: 36 K visualizaciones - hace 2 semanas.',
        ];

        $video_card_fields[] = [
            'key'   => 'field_venza_descubre_video_' . $i . '_duration',
            'label' => 'Video card ' . $i . ' - Duracion',
            'name'  => 'descubre_video_' . $i . '_duration',
            'type'  => 'text',
        ];

        $video_card_fields[] = [
            'key'   => 'field_venza_descubre_video_' . $i . '_url',
            'label' => 'Video card ' . $i . ' - URL',
            'name'  => 'descubre_video_' . $i . '_url',
            'type'  => 'url',
        ];
    }

    $quiz_steps_defaults = [
        'piel' => [
            'label' => 'Pregunta 1 - Tipo de piel',
            'title' => '1. Como describes tu tipo de piel?',
            'options' => [
                'piel_normal'   => 'Normal',
                'piel_seca'     => 'Seca',
                'piel_grasa'    => 'Grasa',
                'piel_sensible' => 'Sensible',
                'piel_mixta'    => 'Mixta',
            ],
        ],
        'cabello' => [
            'label' => 'Pregunta 2 - Color de cabello',
            'title' => '2. Color de cabello',
            'options' => [
                'cabello_negro'          => 'Negro',
                'cabello_rubio'          => 'Rubio',
                'cabello_castano_claro'  => 'Castano claro',
                'cabello_pelirrojo'      => 'Pelirrojo',
                'cabello_castano_oscuro' => 'Castano oscuro',
                'cabello_gris'           => 'Gris',
            ],
        ],
        'aroma' => [
            'label' => 'Pregunta 3 - Aroma favorito',
            'title' => '3. Cual es tu aroma favorito?',
            'options' => [
                'aroma_eucalipto'       => 'Eucalipto',
                'aroma_manzana'         => 'Manzana',
                'aroma_coco'            => 'Coco',
                'aroma_menta'           => 'Menta',
                'aroma_sabila'          => 'Sabila',
                'aroma_frutas_citricas' => 'Frutas citricas',
            ],
        ],
        'sensacion' => [
            'label' => 'Pregunta 4 - Sensacion',
            'title' => '4. Despues de banarte, quieres sentir tu piel...',
            'options' => [
                'sensacion_hidratada'    => 'Muy hidratada y protegida',
                'sensacion_refrescada'   => 'Refrescada y ligera',
                'sensacion_calmante'     => 'Calmante y cuidada',
                'sensacion_nutritiva'    => 'Nutritiva y revitalizada',
                'sensacion_tropical'     => 'Suave y tropical',
            ],
        ],
        'paisaje' => [
            'label' => 'Pregunta 5 - Paisaje',
            'title' => '5. Elige el paisaje que mas te relaja',
            'options' => [
                'paisaje_playa_tropical'  => 'Playa tropical',
                'paisaje_huerto_manzanas' => 'Huerto de manzanas',
                'paisaje_bosque_verde'    => 'Bosque verde',
                'paisaje_jardin_aloe'     => 'Jardin de aloe',
                'paisaje_campo_avena'     => 'Campo de avena',
                'paisaje_montana'         => 'Montana',
            ],
        ],
        'frecuencia' => [
            'label' => 'Pregunta 6 - Frecuencia',
            'title' => '6. Con que frecuencia te das un bano',
            'options' => [
                'frecuencia_una_vez'    => 'Una vez al dia',
                'frecuencia_dos_veces'  => 'Dos veces al dia',
                'frecuencia_cuatro'     => '4 veces por semana',
                'frecuencia_necesario'  => 'Solo cuando hace falta',
            ],
        ],
    ];

    $quiz_result_defaults = [
        'crema_humectante' => [
            'label'       => 'Crema Humectante',
            'title'       => 'Crema Humectante',
            'description' => 'Tu piel pide nutricion constante. El jabon Crema Humectante es tu aliado diario para mantenerla hidratada, suave y protegida.',
            'url'         => '/productos/crema-humectante/',
        ],
        'frescura_extrema' => [
            'label'       => 'Frescura Extrema',
            'title'       => 'Eucalipto',
            'description' => 'Tu piel pide frescura y energia. El jabon Eucalipto es tu match: ligero, herbal y perfecto para sentirte renovado cada dia.',
            'url'         => '/productos/frescura-extrema/',
        ],
        'vitamina_e' => [
            'label'       => 'Vitamina E',
            'title'       => 'Vitamina E',
            'description' => 'Tu energia necesita un boost de vitalidad. El jabon Vitamina E nutre tu piel y la deja luminosa, lista para brillar cada dia.',
            'url'         => '/productos/vitamina-e/',
        ],
        'sabila' => [
            'label'       => 'Sabila',
            'title'       => 'Sabila',
            'description' => 'Frescura calmante, asi eres tu. El jabon Sabila refresca tu piel, la cuida y la mantiene en equilibrio con un toque natural.',
            'url'         => '/productos/sabila/',
        ],
        'coco' => [
            'label'       => 'Coco',
            'title'       => 'Coco',
            'description' => 'Eres tropical y lleno de vida. Tu piel merece el jabon Coco: hidratacion profunda con aroma dulce que te transporta al paraiso.',
            'url'         => '/productos/coco/',
        ],
        'avena' => [
            'label'       => 'Avena',
            'title'       => 'Avena',
            'description' => 'Tu match es el jabon Avena: suave, natural y perfecto para piel sensible. Te cuida con delicadeza mientras te da bienestar diario.',
            'url'         => '/productos/avena/',
        ],
    ];

    $quiz_text_fields = [
        [
            'key'   => 'field_venza_descubre_tab_quiz_texts',
            'label' => 'Quiz - Textos',
            'type'  => 'tab',
        ],
        [
            'key'           => 'field_venza_descubre_quiz_title',
            'label'         => 'Quiz - Titulo principal',
            'name'          => 'descubre_quiz_title',
            'type'          => 'text',
            'default_value' => 'Descubre que jabon Venza es ideal para tu piel',
        ],
        [
            'key'           => 'field_venza_descubre_quiz_intro',
            'label'         => 'Quiz - Texto bajo titulo',
            'name'          => 'descubre_quiz_intro',
            'type'          => 'textarea',
            'rows'          => 3,
            'default_value' => 'Responde con imagenes y descubre que jabon Venza te hace match.',
            'instructions'  => 'Caja con borde debajo del titulo principal.',
        ],
        [
            'key'           => 'field_venza_descubre_quiz_progress_label',
            'label'         => 'Quiz - Texto progreso',
            'name'          => 'descubre_quiz_progress_label',
            'type'          => 'text',
            'default_value' => 'Pregunta {current} de {total}',
            'instructions'  => 'Usa {current} y {total} para mantener el contador dinamico.',
        ],
        [
            'key'           => 'field_venza_descubre_quiz_back_text',
            'label'         => 'Boton - Atras',
            'name'          => 'descubre_quiz_back_text',
            'type'          => 'text',
            'default_value' => 'Atras',
        ],
        [
            'key'           => 'field_venza_descubre_quiz_next_text',
            'label'         => 'Boton - Siguiente',
            'name'          => 'descubre_quiz_next_text',
            'type'          => 'text',
            'default_value' => 'Siguiente',
        ],
        [
            'key'           => 'field_venza_descubre_quiz_result_step_text',
            'label'         => 'Boton - Ver resultado',
            'name'          => 'descubre_quiz_result_step_text',
            'type'          => 'text',
            'default_value' => 'Ver mi resultado',
        ],
        [
            'key'           => 'field_venza_descubre_quiz_result_heading',
            'label'         => 'Resultado - Encabezado',
            'name'          => 'descubre_quiz_result_heading',
            'type'          => 'text',
            'default_value' => '',
            'instructions'  => 'Opcional. Si queda vacio, el resultado inicia directamente con la tarjeta visual.',
        ],
        [
            'key'           => 'field_venza_descubre_quiz_know_more_text',
            'label'         => 'Resultado - Boton conoce mas',
            'name'          => 'descubre_quiz_know_more_text',
            'type'          => 'text',
            'default_value' => 'Conoce mas',
        ],
        [
            'key'           => 'field_venza_descubre_quiz_all_products_text',
            'label'         => 'Resultado - Boton ver todos',
            'name'          => 'descubre_quiz_all_products_text',
            'type'          => 'text',
            'default_value' => 'Ver todos los productos',
        ],
        [
            'key'           => 'field_venza_descubre_quiz_all_products_url',
            'label'         => 'Resultado - URL ver todos',
            'name'          => 'descubre_quiz_all_products_url',
            'type'          => 'text',
            'default_value' => '/productos/',
            'instructions'  => 'Permite URL relativa o absoluta.',
        ],
        [
            'key'           => 'field_venza_descubre_quiz_restart_text',
            'label'         => 'Resultado - Boton intentar de nuevo',
            'name'          => 'descubre_quiz_restart_text',
            'type'          => 'text',
            'default_value' => 'Intentar de nuevo',
        ],
    ];

    foreach ($quiz_steps_defaults as $step_id => $step) {
        $quiz_text_fields[] = [
            'key'     => 'field_venza_descubre_quiz_text_' . $step_id . '_message',
            'label'   => $step['label'],
            'name'    => '',
            'type'    => 'message',
            'message' => 'Edita el titulo y los textos de opciones de esta pregunta.',
        ];

        $quiz_text_fields[] = [
            'key'           => 'field_venza_descubre_quiz_question_' . $step_id,
            'label'         => $step['label'] . ' - Titulo',
            'name'          => 'descubre_quiz_question_' . $step_id,
            'type'          => 'text',
            'default_value' => $step['title'],
        ];

        foreach ($step['options'] as $option_key => $option_label) {
            $quiz_text_fields[] = [
                'key'           => 'field_venza_descubre_quiz_option_' . $option_key,
                'label'         => $step['label'] . ' - Opcion: ' . $option_label,
                'name'          => 'descubre_quiz_option_' . $option_key,
                'type'          => 'text',
                'default_value' => $option_label,
            ];
        }
    }

    $quiz_text_fields[] = [
        'key'     => 'field_venza_descubre_quiz_result_texts_message',
        'label'   => 'Resultados - Textos por producto',
        'name'    => '',
        'type'    => 'message',
        'message' => 'Estos textos se muestran dentro de la tarjeta final del quiz.',
    ];

    foreach ($quiz_result_defaults as $result_key => $result) {
        $quiz_text_fields[] = [
            'key'           => 'field_venza_descubre_quiz_result_title_' . $result_key,
            'label'         => 'Resultado ' . $result['label'] . ' - Titulo',
            'name'          => 'descubre_quiz_result_title_' . $result_key,
            'type'          => 'text',
            'default_value' => $result['title'],
        ];

        $quiz_text_fields[] = [
            'key'           => 'field_venza_descubre_quiz_result_description_' . $result_key,
            'label'         => 'Resultado ' . $result['label'] . ' - Descripcion',
            'name'          => 'descubre_quiz_result_description_' . $result_key,
            'type'          => 'textarea',
            'rows'          => 4,
            'default_value' => $result['description'],
        ];

        $quiz_text_fields[] = [
            'key'           => 'field_venza_descubre_quiz_result_url_' . $result_key,
            'label'         => 'Resultado ' . $result['label'] . ' - URL conoce mas',
            'name'          => 'descubre_quiz_result_url_' . $result_key,
            'type'          => 'text',
            'default_value' => $result['url'],
            'instructions'  => 'Permite URL relativa o absoluta.',
        ];
    }

    $quiz_image_groups = [
        'Pregunta 1 - Tipo de piel' => [
            'quiz_image_piel_normal'   => 'Normal',
            'quiz_image_piel_seca'     => 'Seca',
            'quiz_image_piel_grasa'    => 'Grasa',
            'quiz_image_piel_sensible' => 'Sensible',
            'quiz_image_piel_mixta'    => 'Mixta',
        ],
        'Pregunta 2 - Color de cabello' => [
            'quiz_image_cabello_negro'          => 'Negro',
            'quiz_image_cabello_rubio'          => 'Rubio',
            'quiz_image_cabello_castano_claro'  => 'Castano claro',
            'quiz_image_cabello_pelirrojo'      => 'Pelirrojo',
            'quiz_image_cabello_castano_oscuro' => 'Castano oscuro',
            'quiz_image_cabello_gris'           => 'Gris',
        ],
        'Pregunta 3 - Aroma favorito' => [
            'quiz_image_aroma_eucalipto'       => 'Eucalipto',
            'quiz_image_aroma_manzana'         => 'Manzana',
            'quiz_image_aroma_coco'            => 'Coco',
            'quiz_image_aroma_menta'           => 'Menta',
            'quiz_image_aroma_sabila'          => 'Sabila',
            'quiz_image_aroma_frutas_citricas' => 'Frutas citricas',
        ],
        'Pregunta 5 - Paisaje' => [
            'quiz_image_paisaje_playa_tropical'  => 'Playa tropical',
            'quiz_image_paisaje_huerto_manzanas' => 'Huerto de manzanas',
            'quiz_image_paisaje_bosque_verde'    => 'Bosque verde',
            'quiz_image_paisaje_jardin_aloe'     => 'Jardin de aloe',
            'quiz_image_paisaje_campo_avena'     => 'Campo de avena',
            'quiz_image_paisaje_montana'         => 'Montana',
        ],
    ];

    $quiz_image_fields = [
        [
            'key'   => 'field_venza_descubre_tab_quiz_images',
            'label' => 'Quiz - Imagenes',
            'type'  => 'tab',
        ],
        [
            'key'     => 'field_venza_descubre_quiz_images_help',
            'label'   => 'Imagenes del quiz',
            'name'    => '',
            'type'    => 'message',
            'message' => 'Estas imagenes alimentan las opciones visuales del quiz que vive en /descubre-venza/quiz/. Si un campo queda vacio, el frontend muestra una opcion de texto sin imagen rota.',
        ],
    ];

    foreach ($quiz_image_groups as $group_label => $items) {
        $group_key = str_replace('-', '_', sanitize_key($group_label));

        $quiz_image_fields[] = [
            'key'   => 'field_venza_descubre_' . $group_key . '_message',
            'label' => $group_label,
            'name'  => '',
            'type'  => 'message',
            'message' => 'Sube las imagenes para esta pregunta.',
        ];

        foreach ($items as $name => $label) {
            $quiz_image_fields[] = $image_field(
                'field_venza_descubre_' . $name,
                $group_label . ' - ' . $label,
                'descubre_' . $name,
                'Imagen usada en la opcion "' . $label . '".'
            );
        }
    }

    $quiz_image_fields[] = [
        'key'   => 'field_venza_descubre_quiz_results_message',
        'label' => 'Resultados - Imagenes',
        'name'  => '',
        'type'  => 'message',
        'message' => 'Opcional. Permite reemplazar la imagen del producto recomendado en el resultado del quiz.',
    ];

    foreach ([
        'frescura_extrema' => 'Frescura Extrema',
        'crema_humectante' => 'Crema Humectante',
        'vitamina_e'       => 'Vitamina E',
        'sabila'           => 'Sabila',
        'coco'             => 'Coco',
        'avena'            => 'Avena',
    ] as $slug => $label) {
        $quiz_image_fields[] = $image_field(
            'field_venza_descubre_quiz_result_image_' . $slug,
            'Resultado - ' . $label,
            'descubre_quiz_result_image_' . $slug,
            'Imagen opcional para el resultado "' . $label . '".'
        );
    }

    acf_add_local_field_group([
        'key'    => 'group_venza_page_descubre',
        'title'  => 'Pagina - Descubre Venza',
        'fields' => array_merge(
            [
                [
                    'key'   => 'field_venza_descubre_tab_hero',
                    'label' => 'Hero',
                    'type'  => 'tab',
                ],
                [
                    'key'           => 'field_venza_descubre_title',
                    'label'         => 'Hero - Titulo',
                    'name'          => 'descubre_titulo',
                    'type'          => 'text',
                    'default_value' => 'Venza, el jabon que cuida tu salud y protege a tu familia',
                ],
                $textarea_field(
                    'field_venza_descubre_callout',
                    'Hero - Caja de texto',
                    'descubre_callout',
                    5,
                    'Texto dentro de la caja con borde. Acepta HTML basico como <strong>.'
                ),
                [
                    'key'           => 'field_venza_descubre_use_background_image',
                    'label'         => 'Hero - Usar background superior',
                    'name'          => 'descubre_use_background_image',
                    'type'          => 'true_false',
                    'ui'            => 1,
                    'default_value' => 0,
                    'instructions'  => 'Apagado por defecto para mejorar rendimiento.',
                ],
                $image_field(
                    'field_venza_descubre_background_image',
                    'Hero - Background superior',
                    'descubre_background_image_id',
                    'Opcional. Solo carga si el switch anterior esta encendido.'
                ),
                [
                    'key'   => 'field_venza_descubre_tab_quiz_cta',
                    'label' => 'Quiz flotante',
                    'type'  => 'tab',
                ],
                [
                    'key'           => 'field_venza_descubre_quiz_cta_enabled',
                    'label'         => 'Quiz flotante - Mostrar',
                    'name'          => 'descubre_quiz_cta_enabled',
                    'type'          => 'true_false',
                    'ui'            => 1,
                    'default_value' => 1,
                    'instructions'  => 'Muestra el acceso flotante al quiz de recomendacion de jabon.',
                ],
                $image_field(
                    'field_venza_descubre_quiz_cta_image',
                    'Quiz flotante - Icono / jabon',
                    'descubre_quiz_cta_image_id',
                    'Opcional. Si esta vacio se usa el jabon Frescura Extrema del tema.'
                ),
                [
                    'key'           => 'field_venza_descubre_quiz_cta_text',
                    'label'         => 'Quiz flotante - Texto',
                    'name'          => 'descubre_quiz_cta_text',
                    'type'          => 'text',
                    'default_value' => '¿Ya sabes cuál jabón va contigo?',
                ],
                [
                    'key'           => 'field_venza_descubre_quiz_cta_url',
                    'label'         => 'Quiz flotante - URL',
                    'name'          => 'descubre_quiz_cta_url',
                    'type'          => 'url',
                    'default_value' => home_url('/descubre-venza/quiz/'),
                    'instructions'  => 'Por defecto abre la vista del quiz dentro de Descubre Venza.',
                ],
                ...$quiz_text_fields,
                ...$quiz_image_fields,
                [
                    'key'   => 'field_venza_descubre_tab_video',
                    'label' => 'Video principal',
                    'type'  => 'tab',
                ],
                $image_field(
                    'field_venza_descubre_video_poster',
                    'Video principal - Poster',
                    'descubre_video_poster_id',
                    'Opcional. No se usa como cover del video principal; queda disponible como fallback si no hay archivo/URL.'
                ),
                $file_field(
                    'field_venza_descubre_video_file',
                    'Video principal - Archivo video',
                    'descubre_video_file_id',
                    'Sube un MP4/WebM/MOV o usa la URL externa del campo siguiente.'
                ),
                [
                    'key'          => 'field_venza_descubre_video_url',
                    'label'        => 'Video principal - URL externa',
                    'name'         => 'descubre_video_url',
                    'type'         => 'url',
                    'instructions' => 'Alternativa recomendada para videos pesados: YouTube, Vimeo u otro destino.',
                ],
                [
                    'key'   => 'field_venza_descubre_tab_videos',
                    'label' => 'Videos',
                    'type'  => 'tab',
                ],
                [
                    'key'           => 'field_venza_descubre_videos_title',
                    'label'         => 'Videos - Titulo',
                    'name'          => 'descubre_videos_title',
                    'type'          => 'text',
                    'default_value' => 'Videos Venza',
                ],
                [
                    'key'           => 'field_venza_descubre_cta_text',
                    'label'         => 'Videos - Texto CTA YouTube',
                    'name'          => 'descubre_cta_text',
                    'type'          => 'text',
                    'default_value' => 'Visita nuestro canal de Youtube',
                ],
                [
                    'key'           => 'field_venza_descubre_cta_url',
                    'label'         => 'Videos - URL CTA YouTube',
                    'name'          => 'descubre_cta_url',
                    'type'          => 'url',
                    'default_value' => 'https://www.youtube.com/@jabonvenza',
                ],
            ],
            $video_card_fields
        ),
        'location' => [
            [
                [
                    'param'    => 'page_template',
                    'operator' => '==',
                    'value'    => 'page-descubre-venza.php',
                ],
            ],
        ],
        'position' => 'normal',
        'style'    => 'default',
    ]);
});
