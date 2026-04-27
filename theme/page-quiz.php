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

$quiz_config = [
    'optionImages'  => [],
    'productImages' => [],
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
?>
<script>
window.venzaQuizConfig = <?php echo wp_json_encode($quiz_config, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>;
</script>
<main class="quiz-page">
    <div class="container">
        <header class="quiz-header">
            <h1>Descubre qué jabón Venza<br>es ideal para tu piel</h1>
            <p>Responde con imágenes y descubre qué jabón Venza te hace match.</p>
        </header>

        <div class="quiz-wrapper" id="quiz-app" role="form" aria-label="Quiz de tipo de piel">
            <div class="quiz-progress" aria-hidden="true">
                <div class="quiz-progress__bar" id="quiz-progress-bar" style="width: 0%"></div>
            </div>
            <p class="quiz-progress__label">Pregunta <span id="quiz-current-step">1</span> de 6</p>

            <div class="quiz-steps" id="quiz-steps"></div>

            <div class="quiz-result" id="quiz-result" hidden>
                <h2>Tu jabón ideal es</h2>
                <div class="quiz-result__producto" id="quiz-result-producto"></div>
                <a href="<?php echo esc_url(home_url('/productos/')); ?>" class="btn btn--primary">Ver todos los productos</a>
                <button class="btn btn--ghost" id="quiz-restart" type="button">Intentar de nuevo</button>
            </div>
        </div>
    </div>
</main>
<?php get_footer(); ?>
