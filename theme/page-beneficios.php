<?php
/*
 * Template Name: Beneficios
 */
get_header(); ?>
<main class="beneficios-page">

    <section class="beneficios-hero">
        <div class="container">
            <blockquote class="beneficios-quote">
                <?php echo wp_kses_post(venza_field('beneficios_quote')); ?>
            </blockquote>
        </div>
    </section>

    <?php
    $items = venza_field('beneficios_items');
    if ($items) :
        foreach ($items as $index => $item) :
            $is_reverse = ($index % 2 !== 0);
    ?>
        <section class="beneficio-item <?php echo $is_reverse ? 'beneficio-item--reverse' : ''; ?>">
            <div class="beneficio-item__image">
                <?php echo wp_get_attachment_image($item['imagen']['ID'], 'large'); ?>
            </div>
            <div class="beneficio-item__content">
                <?php if ($item['icono']) : ?>
                    <div class="beneficio-item__icon">
                        <?php echo wp_get_attachment_image($item['icono']['ID'], 'thumbnail'); ?>
                    </div>
                <?php endif; ?>
                <h2><?php echo esc_html($item['titulo']); ?></h2>
                <p><?php echo esc_html($item['descripcion']); ?></p>
            </div>
        </section>
    <?php
        endforeach;
    endif;
    ?>

</main>
<?php get_footer(); ?>
