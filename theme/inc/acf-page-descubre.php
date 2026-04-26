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
