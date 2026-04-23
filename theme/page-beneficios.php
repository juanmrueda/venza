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
