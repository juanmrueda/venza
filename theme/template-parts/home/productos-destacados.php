<section class="home-productos">
    <div class="container">
        <h2 class="section-title section-title--lined">Productos</h2>

        <?php
        $productos = get_posts([
            'post_type'      => 'producto',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
            'post_status'    => 'publish',
        ]);
        foreach ($productos as $i => $p) :
            $reverse     = ($i % 2 !== 0);
            $is_alt      = ($i % 2 !== 0);
            $linea       = venza_field('producto_nombre_linea', $p->ID) ?: 'Jabon Antibacterial';
            $descripcion = wp_strip_all_tags(get_the_excerpt($p->ID));
            if (!$descripcion) {
                $descripcion = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam.';
            }
        ?>
            <article class="home-producto-row <?php echo $reverse ? 'home-producto-row--reverse' : ''; ?> <?php echo $is_alt ? 'home-producto-row--alt' : ''; ?>">
                <div class="home-producto-row__image">
                    <?php echo get_the_post_thumbnail($p->ID, 'large', ['class' => 'home-producto-row__img']); ?>
                    <p class="home-producto-row__caption"><?php echo esc_html(get_the_title($p->ID)); ?></p>
                </div>
                <div class="home-producto-row__content">
                    <h3 class="home-producto-nombre"><?php echo esc_html($linea); ?></h3>
                    <p class="home-producto-desc"><?php echo esc_html($descripcion); ?></p>
                    <a href="<?php echo esc_url(get_permalink($p->ID)); ?>" class="btn btn--primary">Conoce m&aacute;s</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
