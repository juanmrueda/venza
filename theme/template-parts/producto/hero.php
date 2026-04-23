<?php
if (is_post_type_archive('producto')) {
    $home_banner = venza_get_meta_value('producto_home_banner_imagen');
    $home_banner_id = null;

    if (is_array($home_banner) && !empty($home_banner['ID'])) {
        $home_banner_id = (int) $home_banner['ID'];
    } elseif (is_numeric($home_banner)) {
        $home_banner_id = (int) $home_banner;
    }
    ?>
    <section class="producto-hero producto-hero--home-banner">
        <?php if ($home_banner_id) : ?>
            <?php echo wp_get_attachment_image($home_banner_id, 'full', false, ['class' => 'producto-hero__home-banner-image']); ?>
        <?php else : ?>
            <img
                class="producto-hero__home-banner-image"
                src="<?php echo esc_url(get_theme_file_uri('assets/images/banners/banner_productos.png')); ?>"
                alt="<?php echo esc_attr(get_the_title()); ?>"
            />
        <?php endif; ?>
    </section>
    <?php
    return;
}

$color_acento = venza_get_meta_value('producto_color_acento') ?: '#E8F4FD';
$hero_imagen  = venza_get_meta_value('producto_hero_imagen');
$badge_texto  = venza_get_meta_value('producto_badge') ?: 'Nuevo';

$hero_subtitulo = venza_get_meta_value('producto_home_subtitulo');
if (!$hero_subtitulo) {
    $hero_subtitulo = venza_get_meta_value('producto_hero_subtitulo');
}
if (!$hero_subtitulo) {
    $hero_subtitulo = get_the_excerpt();
}

$hero_imagen_id = null;
if (is_array($hero_imagen) && !empty($hero_imagen['ID'])) {
    $hero_imagen_id = (int) $hero_imagen['ID'];
} elseif (is_numeric($hero_imagen)) {
    $hero_imagen_id = (int) $hero_imagen;
}
?>
<section class="producto-hero" style="--producto-color: <?php echo esc_attr($color_acento); ?>">
    <?php if ($hero_imagen_id) : ?>
        <div class="producto-hero__bg">
            <?php echo wp_get_attachment_image($hero_imagen_id, 'producto-hero'); ?>
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
