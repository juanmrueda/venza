<?php
/*
 * Template Name: Quiz de Piel
 */
get_header();

$quiz_source_id = function_exists('venza_get_descubre_page_id') ? venza_get_descubre_page_id() : 0;
if ($quiz_source_id <= 0) {
    $quiz_source_id = (int) get_queried_object_id();
}

$get_image_url = static function ($field_name) use ($quiz_source_id) {
    if ($quiz_source_id <= 0) {
        return '';
    }

    $value = venza_get_meta_value($field_name, $quiz_source_id);
    $image_id = is_numeric($value) ? (int) $value : 0;
    if ($image_id <= 0 && is_array($value) && isset($value['ID'])) {
        $image_id = (int) $value['ID'];
    }
    if ($image_id <= 0) {
        return '';
    }

    $url = wp_get_attachment_image_url($image_id, 'large');
    return is_string($url) ? $url : '';
};

$get_text = static function ($field_name, $default = '') use ($quiz_source_id) {
    if ($quiz_source_id <= 0) {
        return $default;
    }

    $value = venza_get_meta_value($field_name, $quiz_source_id);
    if (is_string($value)) {
        $value = trim($value);
        if ($value !== '') {
            return $value;
        }
    }

    return $default;
};

$option_image_fields = [
    'piel_normal'             => 'descubre_quiz_image_piel_normal',
    'piel_seca'               => 'descubre_quiz_image_piel_seca',
    'piel_grasa'              => 'descubre_quiz_image_piel_grasa',
    'piel_sensible'           => 'descubre_quiz_image_piel_sensible',
    'piel_mixta'              => 'descubre_quiz_image_piel_mixta',
    'cabello_negro'           => 'descubre_quiz_image_cabello_negro',
    'cabello_rubio'           => 'descubre_quiz_image_cabello_rubio',
    'cabello_castano_claro'   => 'descubre_quiz_image_cabello_castano_claro',
    'cabello_pelirrojo'       => 'descubre_quiz_image_cabello_pelirrojo',
    'cabello_castano_oscuro'  => 'descubre_quiz_image_cabello_castano_oscuro',
    'cabello_gris'            => 'descubre_quiz_image_cabello_gris',
    'aroma_eucalipto'         => 'descubre_quiz_image_aroma_eucalipto',
    'aroma_manzana'           => 'descubre_quiz_image_aroma_manzana',
    'aroma_coco'              => 'descubre_quiz_image_aroma_coco',
    'aroma_menta'             => 'descubre_quiz_image_aroma_menta',
    'aroma_sabila'            => 'descubre_quiz_image_aroma_sabila',
    'aroma_frutas_citricas'   => 'descubre_quiz_image_aroma_frutas_citricas',
    'paisaje_playa_tropical'  => 'descubre_quiz_image_paisaje_playa_tropical',
    'paisaje_huerto_manzanas' => 'descubre_quiz_image_paisaje_huerto_manzanas',
    'paisaje_bosque_verde'    => 'descubre_quiz_image_paisaje_bosque_verde',
    'paisaje_jardin_aloe'     => 'descubre_quiz_image_paisaje_jardin_aloe',
    'paisaje_campo_avena'     => 'descubre_quiz_image_paisaje_campo_avena',
    'paisaje_montana'         => 'descubre_quiz_image_paisaje_montana',
];

$product_image_fields = [
    'frescura-extrema' => 'descubre_quiz_result_image_frescura_extrema',
    'crema-humectante' => 'descubre_quiz_result_image_crema_humectante',
    'vitamina-e'       => 'descubre_quiz_result_image_vitamina_e',
    'sabila'           => 'descubre_quiz_result_image_sabila',
    'coco'             => 'descubre_quiz_result_image_coco',
    'avena'            => 'descubre_quiz_result_image_avena',
];

$quiz_step_defaults = [
    'piel' => [
        'titulo' => '1. ¿Cómo describes tu tipo de piel?',
        'opciones' => [
            'piel_normal'   => 'Normal',
            'piel_seca'     => 'Seca',
            'piel_grasa'    => 'Grasa',
            'piel_sensible' => 'Sensible',
            'piel_mixta'    => 'Mixta',
        ],
    ],
    'cabello' => [
        'titulo' => '2. Color de cabello',
        'opciones' => [
            'cabello_negro'          => 'Negro',
            'cabello_rubio'          => 'Rubio',
            'cabello_castano_claro'  => 'Castaño claro',
            'cabello_pelirrojo'      => 'Pelirrojo',
            'cabello_castano_oscuro' => 'Castaño oscuro',
            'cabello_gris'           => 'Gris',
        ],
    ],
    'aroma' => [
        'titulo' => '3. ¿Cuál es tu aroma favorito?',
        'opciones' => [
            'aroma_eucalipto'       => 'Eucalipto',
            'aroma_manzana'         => 'Manzana',
            'aroma_coco'            => 'Coco',
            'aroma_menta'           => 'Menta',
            'aroma_sabila'          => 'Sábila',
            'aroma_frutas_citricas' => 'Frutas cítricas',
        ],
    ],
    'sensacion' => [
        'titulo' => '4. Después de bañarte, quieres sentir tu piel...',
        'opciones' => [
            'sensacion_hidratada'   => 'Muy hidratada y protegida',
            'sensacion_refrescada'  => 'Refrescada y ligera',
            'sensacion_calmante'    => 'Calmante y cuidada',
            'sensacion_nutritiva'   => 'Nutritiva y revitalizada',
            'sensacion_tropical'    => 'Suave y tropical',
        ],
    ],
    'paisaje' => [
        'titulo' => '5. Elige el paisaje que más te relaja',
        'opciones' => [
            'paisaje_playa_tropical'  => 'Playa tropical',
            'paisaje_huerto_manzanas' => 'Huerto de manzanas',
            'paisaje_bosque_verde'    => 'Bosque verde',
            'paisaje_jardin_aloe'     => 'Jardín de aloe',
            'paisaje_campo_avena'     => 'Campo de avena',
            'paisaje_montana'         => 'Montaña',
        ],
    ],
    'frecuencia' => [
        'titulo' => '6. Con qué frecuencia te das un baño',
        'opciones' => [
            'frecuencia_una_vez'   => 'Una vez al día',
            'frecuencia_dos_veces' => 'Dos veces al día',
            'frecuencia_cuatro'    => '4 veces por semana',
            'frecuencia_necesario' => 'Solo cuando hace falta',
        ],
    ],
];

$quiz_result_defaults = [
    'crema-humectante' => [
        'field'       => 'crema_humectante',
        'nombre'      => 'Crema Humectante',
        'descripcion' => 'Tu piel pide nutrición constante. El jabón Crema Humectante es tu aliado diario para mantenerla hidratada, suave y protegida.',
    ],
    'frescura-extrema' => [
        'field'       => 'frescura_extrema',
        'nombre'      => 'Eucalipto',
        'descripcion' => 'Tu piel pide frescura y energía. El jabón Eucalipto es tu match: ligero, herbal y perfecto para sentirte renovado cada día.',
    ],
    'vitamina-e' => [
        'field'       => 'vitamina_e',
        'nombre'      => 'Vitamina E',
        'descripcion' => 'Tu energía necesita un boost de vitalidad. El jabón Vitamina E nutre tu piel y la deja luminosa, lista para brillar cada día.',
    ],
    'sabila' => [
        'field'       => 'sabila',
        'nombre'      => 'Sábila',
        'descripcion' => 'Frescura calmante, así eres tú. El jabón Sábila refresca tu piel, la cuida y la mantiene en equilibrio con un toque natural.',
    ],
    'coco' => [
        'field'       => 'coco',
        'nombre'      => 'Coco',
        'descripcion' => 'Eres tropical y lleno de vida. Tu piel merece el jabón Coco: hidratación profunda con aroma dulce que te transporta al paraíso.',
    ],
    'avena' => [
        'field'       => 'avena',
        'nombre'      => 'Avena',
        'descripcion' => 'Tu match es el jabón Avena: suave, natural y perfecto para piel sensible. Te cuida con delicadeza mientras te da bienestar diario.',
    ],
];

$quiz_title = $get_text('descubre_quiz_title', 'Descubre qué jabón Venza es ideal para tu piel');
$quiz_intro = $get_text('descubre_quiz_intro', 'Responde con imágenes y descubre qué jabón Venza te hace match.');
$quiz_result_heading = $get_text('descubre_quiz_result_heading', '');

$quiz_config = [
    'optionImages'  => [],
    'productImages' => [],
    'texts'         => [
        'progressLabel' => $get_text('descubre_quiz_progress_label', 'Pregunta {current} de {total}'),
        'buttons'       => [
            'back'        => $get_text('descubre_quiz_back_text', 'Atrás'),
            'next'        => $get_text('descubre_quiz_next_text', 'Siguiente'),
            'result'      => $get_text('descubre_quiz_result_step_text', 'Ver mi resultado'),
            'knowMore'    => $get_text('descubre_quiz_know_more_text', 'Conoce más'),
            'allProducts' => $get_text('descubre_quiz_all_products_text', 'Ver todos los productos'),
            'restart'     => $get_text('descubre_quiz_restart_text', 'Intentar de nuevo'),
        ],
        'steps'         => [],
        'products'      => [],
    ],
];

foreach ($option_image_fields as $key => $field_name) {
    $url = $get_image_url($field_name);
    if ($url !== '') {
        $quiz_config['optionImages'][$key] = $url;
    }
}

foreach ($product_image_fields as $key => $field_name) {
    $url = $get_image_url($field_name);
    if ($url !== '') {
        $quiz_config['productImages'][$key] = $url;
    }
}

foreach ($quiz_step_defaults as $step_id => $step) {
    $quiz_config['texts']['steps'][$step_id] = [
        'titulo'   => $get_text('descubre_quiz_question_' . $step_id, $step['titulo']),
        'opciones' => [],
    ];

    foreach ($step['opciones'] as $option_key => $option_label) {
        $quiz_config['texts']['steps'][$step_id]['opciones'][$option_key] = $get_text(
            'descubre_quiz_option_' . $option_key,
            $option_label
        );
    }
}

foreach ($quiz_result_defaults as $slug => $result) {
    $field_key = $result['field'];
    $quiz_config['texts']['products'][$slug] = [
        'nombre'      => $get_text('descubre_quiz_result_title_' . $field_key, $result['nombre']),
        'descripcion' => $get_text('descubre_quiz_result_description_' . $field_key, $result['descripcion']),
    ];
}
?>
<script>
window.venzaQuizConfig = <?php echo wp_json_encode($quiz_config, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>;
</script>
<main class="quiz-page">
    <div class="container">
        <header class="quiz-header">
            <h1><?php echo esc_html($quiz_title); ?></h1>
            <?php if ($quiz_intro !== '') : ?>
                <div class="quiz-header__intro">
                    <?php echo wp_kses_post(wpautop($quiz_intro)); ?>
                </div>
            <?php endif; ?>
        </header>

        <div class="quiz-wrapper" id="quiz-app" role="form" aria-label="Quiz de tipo de piel">
            <div class="quiz-progress" aria-hidden="true">
                <div class="quiz-progress__bar" id="quiz-progress-bar" style="width: 0%"></div>
            </div>
            <p class="quiz-progress__label" id="quiz-progress-label">
                <?php echo esc_html(str_replace(['{current}', '{total}'], ['1', '6'], $quiz_config['texts']['progressLabel'])); ?>
            </p>

            <div class="quiz-steps" id="quiz-steps"></div>

            <div class="quiz-result" id="quiz-result" hidden>
                <?php if ($quiz_result_heading !== '') : ?>
                    <h2><?php echo esc_html($quiz_result_heading); ?></h2>
                <?php endif; ?>
                <div class="quiz-result__producto" id="quiz-result-producto"></div>
                <div class="quiz-result__actions">
                    <a href="#" class="btn btn--primary" id="quiz-result-link"><?php echo esc_html($quiz_config['texts']['buttons']['knowMore']); ?></a>
                    <a href="<?php echo esc_url(home_url('/productos/')); ?>" class="btn btn--primary" id="quiz-all-products"><?php echo esc_html($quiz_config['texts']['buttons']['allProducts']); ?></a>
                </div>
                <button class="btn btn--ghost quiz-result__restart" id="quiz-restart" type="button"><?php echo esc_html($quiz_config['texts']['buttons']['restart']); ?></button>
            </div>
        </div>
    </div>
</main>
<?php get_footer(); ?>
