<?php
/*
 * Template Name: Beneficios
 */

$bg_type = venza_get_meta_value('beneficios_bg_type');
$bg_image = venza_get_meta_value('beneficios_bg_image');
$bg_video = venza_get_meta_value('beneficios_bg_video');
$bg_strength_raw = venza_get_meta_value('beneficios_bg_strength');

$bg_image_id = 0;
if (is_array($bg_image) && !empty($bg_image['ID'])) {
    $bg_image_id = (int) $bg_image['ID'];
} elseif (is_numeric($bg_image)) {
    $bg_image_id = (int) $bg_image;
}

$bg_video_url = '';
if (is_array($bg_video) && !empty($bg_video['url'])) {
    $bg_video_url = (string) $bg_video['url'];
} elseif (is_string($bg_video)) {
    $bg_video_url = trim($bg_video);
}

$bg_mode = 'default';
if ($bg_type === 'video' && $bg_video_url !== '') {
    $bg_mode = 'video';
} elseif ($bg_type === 'image' && $bg_image_id > 0) {
    $bg_mode = 'image';
}

$bg_strength_int = is_numeric($bg_strength_raw) ? (int) $bg_strength_raw : 35;
$bg_strength_int = max(0, min(100, $bg_strength_int));
$bg_strength_css = number_format($bg_strength_int / 100, 2, '.', '');

get_header();
?>
<main class="beneficios-page beneficios-page--bg-<?php echo esc_attr($bg_mode); ?>" style="--beneficios-bg-strength: <?php echo esc_attr($bg_strength_css); ?>;">
    <?php if ($bg_mode === 'video') : ?>
        <div class="beneficios-page__bg beneficios-page__bg--video" aria-hidden="true">
            <video autoplay muted loop playsinline preload="auto">
                <source src="<?php echo esc_url($bg_video_url); ?>">
            </video>
        </div>
    <?php elseif ($bg_mode === 'image') : ?>
        <div class="beneficios-page__bg beneficios-page__bg--image" aria-hidden="true">
            <?php echo wp_get_attachment_image($bg_image_id, 'full'); ?>
        </div>
    <?php endif; ?>

    <section class="beneficios-page__hero">
        <div class="container">
            <header class="beneficios-page__header">
                <h1 class="beneficios-page__title"><?php echo esc_html(get_the_title()); ?></h1>
                <span class="beneficios-page__title-line" aria-hidden="true"></span>
            </header>

            <?php
            $quote = venza_get_meta_value('beneficios_quote');
            if (empty($quote)) {
                $quote = '"Venza provoca..." <strong>sensaciones que impactan tus sentidos y emociones.</strong> Se enfoca en crear ambientes realmente perceptibles en la regadera para hacerte sentir bien durante y despues del bano, ya que sus ingredientes (algunos de ellos locales), extractos de aromaterapia, texturas, colores y sonidos <strong>activan tus sentidos provocando emociones unicas.</strong>';
            }
            if (!empty($quote)) :
            ?>
                <blockquote class="beneficios-page__quote">
                    <?php echo wp_kses_post(wpautop($quote)); ?>
                </blockquote>
            <?php endif; ?>
        </div>
    </section>

    <?php
    $items = venza_field('beneficios_items');

    if (empty($items) || !is_array($items)) {
        $items = [];

        for ($i = 1; $i <= 8; $i++) {
            $title = trim((string) venza_get_meta_value('beneficios_item_' . $i . '_titulo'));
            $description = trim((string) venza_get_meta_value('beneficios_item_' . $i . '_descripcion'));
            $image = venza_get_meta_value('beneficios_item_' . $i . '_imagen');

            if ($title === '' && $description === '' && empty($image)) {
                continue;
            }

            $items[] = [
                'titulo'      => $title,
                'descripcion' => $description,
                'imagen'      => $image,
            ];
        }
    }

    if (empty($items)) {
        $base = trailingslashit(get_template_directory_uri() . '/assets/images/beneficios');
        $items = [
            [
                'titulo'      => 'Proteccion Antibacterial',
                'descripcion' => 'Para tu tranquilidad, Venza elimina el 99.9% de las bacterias con frescura extrema y proteccion total.',
                'imagen'      => $base . 'beneficio-01-proteccion.jpg',
            ],
            [
                'titulo'      => 'Formula humectante',
                'descripcion' => 'Con sus ingredientes naturales estimula la suavidad y elasticidad sin limpiar de mas tu piel.',
                'imagen'      => $base . 'beneficio-02-formula.jpg',
            ],
            [
                'titulo'      => 'Aromas agradables',
                'descripcion' => 'Elige tu favorito: Crema Humectante, Avena, Coco, Manzana Fresh, Sabila, Vitamina E y Frescura Extrema.',
                'imagen'      => $base . 'beneficio-03-aromas.jpg',
            ],
            [
                'titulo'      => 'Alto rendimiento',
                'descripcion' => 'Su formula permite mayor durabilidad y asi todos nuestros beneficios te acompanaran por mas tiempo.',
                'imagen'      => $base . 'beneficio-04-rendimiento.jpg',
            ],
            [
                'titulo'      => 'Deja la piel radiante',
                'descripcion' => 'En cada aplicacion notaras un brillo natural saludable ya que la estaras humectando, rejuveneciendo y limpiando balanceadamente.',
                'imagen'      => $base . 'beneficio-05-radiante.jpg',
            ],
            [
                'titulo'      => 'Apto para uso diario',
                'descripcion' => 'Nuestra linea de jabones no limpia de mas ni de forma abrasiva por lo cual su uso diario es recomendado para el cuidado de tu piel.',
                'imagen'      => $base . 'beneficio-06-uso-diario.jpg',
            ],
            [
                'titulo'      => 'Nutre la piel seca',
                'descripcion' => 'Con Venza, notaras que las celulas de tu piel se rejuvenecen mejorando su elasticidad y humedad, dejara de estar sin brillo y con dureza.',
                'imagen'      => $base . 'beneficio-07-nutre.jpg',
            ],
            [
                'titulo'      => 'Limpieza efectiva',
                'descripcion' => 'Nuestra linea de jabones no limpia de mas, hace un balance de nutricion a tu piel mientras descarta celulas muertas y suciedad.',
                'imagen'      => $base . 'beneficio-08-limpieza.jpg',
            ],
        ];
    }

    if (!empty($items) && is_array($items)) :
    ?>
        <section class="beneficios-page__list">
            <div class="container">
                <?php
                foreach ($items as $index => $item) :
                    $is_reverse = ($index % 2 !== 0);
                    $item_title = isset($item['titulo']) ? trim((string) $item['titulo']) : '';
                    $item_description = isset($item['descripcion']) ? trim((string) $item['descripcion']) : '';
                    $item_image = $item['imagen'] ?? null;
                    $item_image_html = '';

                    if (is_array($item_image) && !empty($item_image['ID'])) {
                        $item_image_html = wp_get_attachment_image((int) $item_image['ID'], 'large');
                    } elseif (is_array($item_image) && !empty($item_image['url'])) {
                        $item_image_html = '<img src="' . esc_url($item_image['url']) . '" alt="' . esc_attr($item_title) . '">';
                    } elseif (is_numeric($item_image)) {
                        $item_image_html = wp_get_attachment_image((int) $item_image, 'large');
                    } elseif (is_string($item_image) && $item_image !== '') {
                        $item_image_html = '<img src="' . esc_url($item_image) . '" alt="' . esc_attr($item_title) . '">';
                    }
                    ?>
                    <article class="beneficios-card <?php echo $is_reverse ? 'beneficios-card--reverse' : ''; ?>">
                        <div class="beneficios-card__media">
                            <?php if ($item_image_html !== '') : ?>
                                <?php echo $item_image_html; ?>
                            <?php endif; ?>
                        </div>
                        <div class="beneficios-card__content">
                            <?php if ($item_title !== '') : ?>
                                <h2 class="beneficios-card__title"><?php echo esc_html($item_title); ?></h2>
                            <?php endif; ?>
                            <?php if ($item_description !== '') : ?>
                                <div class="beneficios-card__description">
                                    <?php echo wp_kses_post(wpautop($item_description)); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

</main>
<?php get_footer(); ?>

