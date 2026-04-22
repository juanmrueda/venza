<?php
$color_acento    = venza_field('producto_color_acento')    ?: '#E8F4FD';
$hero_imagen     = venza_field('producto_hero_imagen');
$hero_subtitulo  = venza_field('producto_hero_subtitulo');
$badge_texto     = venza_field('producto_badge');
?>
<section class="producto-hero" style="--producto-color: <?php echo esc_attr($color_acento); ?>">
    <?php if ($hero_imagen) : ?>
        <div class="producto-hero__bg">
            <?php echo wp_get_attachment_image($hero_imagen['ID'], 'producto-hero'); ?>
        </div>
    <?php endif; ?>
    <div class="container producto-hero__content">
        <div class="producto-hero__info">
            <?php if ($badge_texto) : ?>
                <span class="producto-hero__badge"><?php echo esc_html($badge_texto); ?></span>
            <?php endif; ?>
            <h1><?php the_title(); ?></h1>
            <?php if ($hero_subtitulo) : ?>
                <p class="producto-hero__tagline"><?php echo esc_html($hero_subtitulo); ?></p>
            <?php endif; ?>
        </div>
        <div class="producto-hero__imagen-producto">
            <?php the_post_thumbnail('producto-thumb'); ?>
        </div>
    </div>
</section>
