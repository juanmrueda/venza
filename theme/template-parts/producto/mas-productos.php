<?php
$otros = venza_get_otros_productos(get_the_ID(), 6);
if (!$otros) {
    return;
}

$mas_subtitulo = venza_get_meta_value('producto_home_mas_productos_subtitulo');
if (!$mas_subtitulo) {
    $mas_subtitulo = 'Jabón antibacterial';
}

$titulo_principal = is_singular('producto') ? 'Productos' : 'Más productos';
if (is_singular('producto')) {
    $mas_subtitulo = '';
}

$grid_clases = 'mas-productos-grid';
if (count($otros) === 5) {
    $grid_clases .= ' mas-productos-grid--five';
}
?>
<section class="mas-productos mas-productos--venza">
    <div class="container">
        <h2 class="section-title section-title--lined"><?php echo esc_html($titulo_principal); ?></h2>
        <?php if (!empty($mas_subtitulo)) : ?>
            <p class="mas-productos__subtitle"><?php echo esc_html($mas_subtitulo); ?></p>
        <?php endif; ?>
        <div class="<?php echo esc_attr($grid_clases); ?>">
            <?php foreach ($otros as $p) : ?>
                <?php $luna_color = venza_get_producto_medialuna_color($p->ID); ?>
                <article class="mas-producto-card" style="--media-luna-color: <?php echo esc_attr($luna_color); ?>;">
                    <a href="<?php echo esc_url(get_permalink($p->ID)); ?>">
                        <div class="mas-producto-card__visual">
                            <span class="mas-producto-card__media-luna" aria-hidden="true"></span>
                            <?php echo get_the_post_thumbnail($p->ID, 'producto-thumb'); ?>
                            <h3 class="mas-producto-card__nombre"><?php echo esc_html($p->post_title); ?></h3>
                        </div>
                        <span class="btn btn--outline">Conoce más</span>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
