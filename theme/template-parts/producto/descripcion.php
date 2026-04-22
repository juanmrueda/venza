<section class="producto-descripcion">
    <div class="container">
        <?php
        $nombre_linea = venza_field('producto_nombre_linea');
        $descripcion  = venza_field('producto_descripcion_larga');
        $cta_texto    = venza_field('producto_cta_texto') ?: 'Compra ahora';
        $cta_url      = venza_field('producto_cta_url');
        ?>
        <?php if ($nombre_linea) : ?>
            <p class="producto-linea"><?php echo esc_html($nombre_linea); ?></p>
        <?php endif; ?>
        <h2><?php the_title(); ?></h2>
        <?php if ($descripcion) : ?>
            <div class="producto-descripcion__texto">
                <?php echo wp_kses_post($descripcion); ?>
            </div>
        <?php endif; ?>
        <?php if ($cta_url) : ?>
            <a href="<?php echo esc_url($cta_url); ?>" class="btn btn--primary" target="_blank" rel="noopener">
                <?php echo esc_html($cta_texto); ?>
            </a>
        <?php endif; ?>
    </div>
</section>
