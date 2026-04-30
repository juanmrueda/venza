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
                [
                    'key'     => 'field_venza_descubre_videos_dynamic_message',
                    'label'   => 'Videos del carrusel',
                    'name'    => '',
                    'type'    => 'message',
                    'message' => 'Agrega, quita y ordena videos desde la caja "Descubre Venza - Videos dinamicos". El boton "Agregar video" lo coloca de primero automaticamente.',
                ],
            ]
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

function venza_descubre_default_video_titles() {
    return [
        'Manos limpias, piel protegida',
        'Deja que creen libremente, mientras Venza cuida su piel',
        'Tu piel tambien necesita su momento',
        'Entrena duro y limpia tu piel con jabones Venza',
        'Respira, renueva y vuelve a empezar',
        'Rutinas de cuidado para cada dia',
    ];
}

function venza_descubre_resolve_attachment_id($value) {
    if (is_numeric($value)) {
        return absint($value);
    }

    if (is_array($value)) {
        foreach (['ID', 'id', 'attachment_id'] as $key) {
            if (isset($value[$key]) && is_numeric($value[$key])) {
                return absint($value[$key]);
            }
        }
    }

    if (is_object($value) && isset($value->ID) && is_numeric($value->ID)) {
        return absint($value->ID);
    }

    return 0;
}

function venza_descubre_sanitize_video_card($video) {
    if (!is_array($video)) {
        return null;
    }

    $clean = [
        'enabled'  => isset($video['enabled']) && (string) $video['enabled'] === '1' ? 1 : 0,
        'image_id' => isset($video['image_id']) ? venza_descubre_resolve_attachment_id($video['image_id']) : 0,
        'file_id'  => isset($video['file_id']) ? venza_descubre_resolve_attachment_id($video['file_id']) : 0,
        'title'    => isset($video['title']) ? sanitize_text_field((string) $video['title']) : '',
        'meta'     => isset($video['meta']) ? sanitize_text_field((string) $video['meta']) : '',
        'duration' => isset($video['duration']) ? sanitize_text_field((string) $video['duration']) : '',
        'url'      => isset($video['url']) ? esc_url_raw((string) $video['url']) : '',
    ];

    $has_content = $clean['image_id'] > 0
        || $clean['file_id'] > 0
        || $clean['title'] !== ''
        || $clean['meta'] !== ''
        || $clean['duration'] !== ''
        || $clean['url'] !== '';

    return $has_content ? $clean : null;
}

function venza_descubre_get_legacy_videos($page_id) {
    $videos = [];
    $fallback_titles = venza_descubre_default_video_titles();

    for ($i = 1; $i <= 6; $i++) {
        $enabled_raw = get_post_meta($page_id, 'descubre_video_' . $i . '_enabled', true);
        $is_enabled = $enabled_raw === '' ? $i <= 4 : (bool) $enabled_raw;

        $video = [
            'enabled'  => $is_enabled ? 1 : 0,
            'image_id' => venza_descubre_resolve_attachment_id(venza_get_meta_value('descubre_video_' . $i . '_image_id', $page_id)),
            'file_id'  => venza_descubre_resolve_attachment_id(venza_get_meta_value('descubre_video_' . $i . '_file_id', $page_id)),
            'title'    => trim((string) venza_get_meta_value('descubre_video_' . $i . '_title', $page_id)),
            'meta'     => trim((string) venza_get_meta_value('descubre_video_' . $i . '_meta', $page_id)),
            'duration' => trim((string) venza_get_meta_value('descubre_video_' . $i . '_duration', $page_id)),
            'url'      => trim((string) venza_get_meta_value('descubre_video_' . $i . '_url', $page_id)),
        ];

        if ($video['title'] === '') {
            $video['title'] = $fallback_titles[$i - 1] ?? 'Video Venza';
        }

        if (!$is_enabled && $video['image_id'] <= 0 && $video['file_id'] <= 0 && $video['url'] === '') {
            continue;
        }

        $videos[] = $video;
    }

    return $videos;
}

function venza_descubre_get_videos($page_id) {
    $is_dynamic = get_post_meta($page_id, 'descubre_videos_dynamic_enabled', true) === '1';
    $saved = get_post_meta($page_id, 'descubre_videos', true);

    if (is_array($saved)) {
        $videos = [];
        foreach ($saved as $video) {
            $clean = venza_descubre_sanitize_video_card($video);
            if ($clean) {
                $videos[] = $clean;
            }
        }

        if (!empty($videos) || $is_dynamic) {
            return $videos;
        }
    }

    if ($is_dynamic) {
        return [];
    }

    return venza_descubre_get_legacy_videos($page_id);
}

add_action('add_meta_boxes_page', function ($post) {
    if (!$post instanceof WP_Post || get_page_template_slug($post) !== 'page-descubre-venza.php') {
        return;
    }

    add_meta_box(
        'venza_descubre_dynamic_videos',
        'Descubre Venza - Videos dinamicos',
        'venza_descubre_render_dynamic_videos_metabox',
        'page',
        'normal',
        'high'
    );
});

function venza_descubre_render_dynamic_videos_metabox($post) {
    wp_nonce_field('venza_descubre_videos_save', 'venza_descubre_videos_nonce');
    wp_enqueue_media();

    $videos = venza_descubre_get_videos($post->ID);
    ?>
    <div class="venza-descubre-videos" data-next-index="<?php echo esc_attr((string) max(0, count($videos))); ?>">
        <p class="description">Agrega todos los videos que necesites. El boton "Agregar video" coloca el nuevo item de primero y empuja los anteriores hacia abajo.</p>
        <div class="venza-descubre-videos__actions">
            <button type="button" class="button button-primary" data-venza-add-descubre-video>Agregar video</button>
        </div>
        <div class="venza-descubre-videos__list">
            <?php foreach ($videos as $index => $video) : ?>
                <?php venza_descubre_render_dynamic_video_row($index, $video); ?>
            <?php endforeach; ?>
        </div>
    </div>
    <template id="venza-descubre-video-template">
        <?php
        venza_descubre_render_dynamic_video_row('__INDEX__', [
            'enabled'  => 1,
            'image_id' => 0,
            'file_id'  => 0,
            'title'    => '',
            'meta'     => '',
            'duration' => '',
            'url'      => '',
        ]);
        ?>
    </template>
    <style>
        .venza-descubre-videos__actions { margin: 12px 0; }
        .venza-descubre-videos__list { display: grid; gap: 12px; }
        .venza-descubre-video { border: 1px solid #dcdcde; background: #fff; padding: 12px; border-radius: 4px; }
        .venza-descubre-video__head { display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-bottom: 12px; }
        .venza-descubre-video__title { font-weight: 700; color: #1d2327; }
        .venza-descubre-video__move { display: inline-flex; gap: 4px; align-items: center; }
        .venza-descubre-video__grid { display: grid; grid-template-columns: minmax(180px, 260px) 1fr; gap: 14px; align-items: start; }
        .venza-descubre-video__field { display: grid; gap: 5px; margin-bottom: 10px; }
        .venza-descubre-video__field label { font-weight: 600; }
        .venza-descubre-video input[type="text"],
        .venza-descubre-video input[type="url"] { width: 100%; }
        .venza-descubre-video__preview { width: 100%; min-height: 120px; display: grid; place-items: center; background: #f0f0f1; border: 1px dashed #c3c4c7; margin-bottom: 8px; overflow: hidden; }
        .venza-descubre-video__preview img { width: 100%; height: auto; display: block; }
        @media (max-width: 782px) { .venza-descubre-video__grid { grid-template-columns: 1fr; } }
    </style>
    <script>
    (function () {
        const root = document.currentScript.closest('.inside').querySelector('.venza-descubre-videos');
        if (!root || root.dataset.bound === '1') return;
        root.dataset.bound = '1';

        const list = root.querySelector('.venza-descubre-videos__list');
        const template = document.getElementById('venza-descubre-video-template');

        const refreshIndexes = () => {
            list.querySelectorAll('.venza-descubre-video').forEach((video, index) => {
                video.querySelector('.venza-descubre-video__title').textContent = 'Video ' + (index + 1);
            });
        };

        const setPreview = (field, id, url, label) => {
            field.querySelector('input[type="hidden"]').value = id || '';
            const preview = field.querySelector('[data-venza-media-preview]');
            if (url) {
                preview.innerHTML = field.dataset.venzaMediaType === 'video'
                    ? '<span>' + (label || url) + '</span>'
                    : '<img src="' + url + '" alt="">';
                return;
            }
            preview.innerHTML = '<span>Sin archivo</span>';
        };

        root.addEventListener('click', (event) => {
            const addButton = event.target.closest('[data-venza-add-descubre-video]');
            if (addButton) {
                const index = Number(root.dataset.nextIndex || 0);
                root.dataset.nextIndex = String(index + 1);
                const wrapper = document.createElement('div');
                wrapper.innerHTML = template.innerHTML.replaceAll('__INDEX__', String(index)).trim();
                list.prepend(wrapper.firstElementChild);
                refreshIndexes();
                return;
            }

            const removeButton = event.target.closest('[data-venza-remove-descubre-video]');
            if (removeButton) {
                removeButton.closest('.venza-descubre-video').remove();
                refreshIndexes();
                return;
            }

            const moveButton = event.target.closest('[data-venza-move-descubre-video]');
            if (moveButton) {
                const video = moveButton.closest('.venza-descubre-video');
                if (moveButton.dataset.venzaMoveDescubreVideo === 'up' && video.previousElementSibling) {
                    list.insertBefore(video, video.previousElementSibling);
                }
                if (moveButton.dataset.venzaMoveDescubreVideo === 'down' && video.nextElementSibling) {
                    list.insertBefore(video.nextElementSibling, video);
                }
                refreshIndexes();
                return;
            }

            const pickButton = event.target.closest('[data-venza-pick-media]');
            if (pickButton && window.wp && wp.media) {
                const field = pickButton.closest('[data-venza-media-field]');
                const mediaType = field.dataset.venzaMediaType === 'video' ? 'video' : 'image';
                const frame = wp.media({ title: 'Selecciona archivo', multiple: false, library: { type: mediaType } });
                frame.on('select', () => {
                    const attachment = frame.state().get('selection').first().toJSON();
                    const thumb = mediaType === 'image' && attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
                    setPreview(field, attachment.id, thumb, attachment.filename || attachment.title);
                });
                frame.open();
                return;
            }

            const clearButton = event.target.closest('[data-venza-clear-media]');
            if (clearButton) {
                setPreview(clearButton.closest('[data-venza-media-field]'), '', '', '');
            }
        });

        refreshIndexes();
    }());
    </script>
    <?php
}

function venza_descubre_render_dynamic_video_row($index, $video) {
    $index_attr = (string) $index;
    $enabled = isset($video['enabled']) ? (int) $video['enabled'] : 1;
    $image_id = isset($video['image_id']) ? (int) $video['image_id'] : 0;
    $file_id = isset($video['file_id']) ? (int) $video['file_id'] : 0;
    $title = isset($video['title']) ? (string) $video['title'] : '';
    $meta = isset($video['meta']) ? (string) $video['meta'] : '';
    $duration = isset($video['duration']) ? (string) $video['duration'] : '';
    $url = isset($video['url']) ? (string) $video['url'] : '';
    $image_url = $image_id > 0 ? wp_get_attachment_image_url($image_id, 'thumbnail') : '';
    $file_label = $file_id > 0 ? get_the_title($file_id) : '';
    ?>
    <div class="venza-descubre-video">
        <div class="venza-descubre-video__head">
            <span class="venza-descubre-video__title">Video</span>
            <span class="venza-descubre-video__move">
                <button type="button" class="button" data-venza-move-descubre-video="up">Subir</button>
                <button type="button" class="button" data-venza-move-descubre-video="down">Bajar</button>
                <button type="button" class="button-link-delete" data-venza-remove-descubre-video>Eliminar</button>
            </span>
        </div>
        <div class="venza-descubre-video__grid">
            <div>
                <div class="venza-descubre-video__field">
                    <label>
                        <input type="hidden" name="venza_descubre_videos[<?php echo esc_attr($index_attr); ?>][enabled]" value="0">
                        <input type="checkbox" name="venza_descubre_videos[<?php echo esc_attr($index_attr); ?>][enabled]" value="1" <?php checked($enabled, 1); ?>>
                        Mostrar video
                    </label>
                </div>
                <div class="venza-descubre-video__field" data-venza-media-field data-venza-media-type="image">
                    <label>Poster</label>
                    <input type="hidden" name="venza_descubre_videos[<?php echo esc_attr($index_attr); ?>][image_id]" value="<?php echo esc_attr((string) $image_id); ?>">
                    <div class="venza-descubre-video__preview" data-venza-media-preview>
                        <?php if ($image_url) : ?>
                            <img src="<?php echo esc_url($image_url); ?>" alt="">
                        <?php else : ?>
                            <span>Sin archivo</span>
                        <?php endif; ?>
                    </div>
                    <button type="button" class="button" data-venza-pick-media>Seleccionar poster</button>
                    <button type="button" class="button-link-delete" data-venza-clear-media>Quitar</button>
                </div>
                <div class="venza-descubre-video__field" data-venza-media-field data-venza-media-type="video">
                    <label>Archivo video</label>
                    <input type="hidden" name="venza_descubre_videos[<?php echo esc_attr($index_attr); ?>][file_id]" value="<?php echo esc_attr((string) $file_id); ?>">
                    <div class="venza-descubre-video__preview" data-venza-media-preview>
                        <?php if ($file_label !== '') : ?>
                            <span><?php echo esc_html($file_label); ?></span>
                        <?php else : ?>
                            <span>Sin archivo</span>
                        <?php endif; ?>
                    </div>
                    <button type="button" class="button" data-venza-pick-media>Seleccionar video</button>
                    <button type="button" class="button-link-delete" data-venza-clear-media>Quitar</button>
                </div>
            </div>
            <div>
                <div class="venza-descubre-video__field">
                    <label>Titulo</label>
                    <input type="text" name="venza_descubre_videos[<?php echo esc_attr($index_attr); ?>][title]" value="<?php echo esc_attr($title); ?>">
                </div>
                <div class="venza-descubre-video__field">
                    <label>URL externa</label>
                    <input type="url" name="venza_descubre_videos[<?php echo esc_attr($index_attr); ?>][url]" value="<?php echo esc_url($url); ?>" placeholder="https://youtu.be/...">
                </div>
                <div class="venza-descubre-video__field">
                    <label>Meta</label>
                    <input type="text" name="venza_descubre_videos[<?php echo esc_attr($index_attr); ?>][meta]" value="<?php echo esc_attr($meta); ?>" placeholder="36 K visualizaciones - hace 2 semanas">
                </div>
                <div class="venza-descubre-video__field">
                    <label>Duracion</label>
                    <input type="text" name="venza_descubre_videos[<?php echo esc_attr($index_attr); ?>][duration]" value="<?php echo esc_attr($duration); ?>" placeholder="0:30">
                </div>
            </div>
        </div>
    </div>
    <?php
}

add_action('save_post_page', function ($post_id) {
    if (!isset($_POST['venza_descubre_videos_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['venza_descubre_videos_nonce'])), 'venza_descubre_videos_save')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $incoming = isset($_POST['venza_descubre_videos']) && is_array($_POST['venza_descubre_videos'])
        ? wp_unslash($_POST['venza_descubre_videos'])
        : [];

    $videos = [];
    foreach ($incoming as $video) {
        $clean = venza_descubre_sanitize_video_card($video);
        if ($clean) {
            $videos[] = $clean;
        }
    }

    update_post_meta($post_id, 'descubre_videos_dynamic_enabled', '1');

    if (!empty($videos)) {
        update_post_meta($post_id, 'descubre_videos', $videos);
    } else {
        delete_post_meta($post_id, 'descubre_videos');
    }
});
