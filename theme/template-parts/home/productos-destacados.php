<section class="productos-destacados">
    <div class="container">
        <h2 class="section-title">Productos</h2>

        <?php
        $productos = get_posts(['post_type' => 'producto', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC']);
        foreach ($productos as $p) :
            $subtitulo = venza_field('producto_subtitulo', $p->ID);
            $descripcion_corta = venza_field('producto_descripcion_corta', $p->ID);
        ?>
            <article class="producto-card-featured">
                <div class="producto-card-featured__image">
                    <?php echo get_the_post_thumbnail($p->ID, 'producto-thumb'); ?>
                </div>
                <div class="producto-card-featured__content">
                    <h3><?php echo esc_html($p->post_title); ?></h3>
                    <?php if ($subtitulo) : ?><p class="subtitle"><?php echo esc_html($subtitulo); ?></p><?php endif; ?>
                    <?php if ($descripcion_corta) : ?><p><?php echo esc_html($descripcion_corta); ?></p><?php endif; ?>
                    <a href="<?php echo get_permalink($p->ID); ?>" class="btn btn--primary">Conoce más</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
