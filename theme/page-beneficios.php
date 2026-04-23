<?php
/*
 * Template Name: Beneficios
 */
get_header(); ?>
<main class="beneficios-page">
    <section class="beneficios-page__hero">
        <div class="container">
            <header class="beneficios-page__header">
                <h1 class="beneficios-page__title"><?php echo esc_html(get_the_title()); ?></h1>
                <span class="beneficios-page__title-line" aria-hidden="true"></span>
            </header>

            <?php
            $quote = venza_field('beneficios_quote');
            if (empty($quote)) {
                $quote = '“Venza provoca...” <strong>sensaciones que impactan tus sentidos y emociones.</strong> Se enfoca en crear ambientes realmente perceptibles en la regadera para hacerte sentir bien durante y después del baño, ya que sus ingredientes (algunos de ellos locales), extractos de aromaterapia, texturas, colores y sonidos <strong>activan tus sentidos provocando emociones únicas.</strong>';
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
        $base = trailingslashit(get_template_directory_uri() . '/assets/images/beneficios');
        $items = [
            [
                'titulo' => 'Protección Antibacterial',
                'descripcion' => 'Para tu tranquilidad, Venza elimina el 99.9% de las bacterias con frescura extrema y protección total.',
                'imagen' => $base . 'beneficio-01-proteccion.jpg',
            ],
            [
                'titulo' => 'Fórmula humectante',
                'descripcion' => 'Con sus ingredientes naturales estimula la suavidad y elasticidad sin limpiar de más tu piel.',
                'imagen' => $base . 'beneficio-02-formula.jpg',
            ],
            [
                'titulo' => 'Aromas agradables',
                'descripcion' => 'Elige tu favorito: Crema Humectante, Avena, Coco, Manzana Fresh, Sábila, Vitamina E y Frescura Extrema.',
                'imagen' => $base . 'beneficio-03-aromas.jpg',
            ],
            [
                'titulo' => 'Alto rendimiento',
                'descripcion' => 'Su fórmula permite mayor durabilidad y así todos nuestros beneficios te acompañarán por más tiempo.',
                'imagen' => $base . 'beneficio-04-rendimiento.jpg',
            ],
            [
                'titulo' => 'Deja la piel radiante',
                'descripcion' => 'En cada aplicación notarás un brillo natural saludable ya que la estarás humectando, rejuveneciendo y limpiando balanceadamente.',
                'imagen' => $base . 'beneficio-05-radiante.jpg',
            ],
            [
                'titulo' => 'Apto para uso diario',
                'descripcion' => 'Nuestra línea de jabones no limpia de más ni de forma abrasiva por lo cual su uso diario es recomendado para el cuidado de tu piel.',
                'imagen' => $base . 'beneficio-06-uso-diario.jpg',
            ],
            [
                'titulo' => 'Nutre la piel seca',
                'descripcion' => 'Con Venza, notarás que las células de tu piel se rejuvenecen mejorando su elasticidad y humedad, dejará de estar sin brillo y con dureza.',
                'imagen' => $base . 'beneficio-07-nutre.jpg',
            ],
            [
                'titulo' => 'Limpieza efectiva',
                'descripcion' => 'Nuestra línea de jabones no limpia de más, hace un balance de nutrición a tu piel mientras descarta células muertas y suciedad.',
                'imagen' => $base . 'beneficio-08-limpieza.jpg',
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
                <?php
        endforeach;
                ?>
            </div>
        </section>
    <?php
    endif;
    ?>

</main>
<?php get_footer(); ?>
