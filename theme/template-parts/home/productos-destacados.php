<section class="productos-destacados">
    <div class="container">
        <h2 class="section-title">Productos</h2>
        <?php
        $productos = get_posts([
            'post_type'      => 'producto',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
            'post_status'    => 'publish',
        ]);
        foreach ($productos as $i => $p) :
            $reverse = ($i % 2 !== 0);
        ?>
        <article class="producto-card-featured <?php echo $reverse ? 'producto-card-featured--reverse' : ''; ?>">
            <div class="producto-card-featured__image">
                <?php echo get_the_post_thumbnail($p->ID, 'large', ['class' => 'producto-card-featured__img']); ?>
            </div>
            <div class="producto-card-featured__content">
                <span class="producto-linea-label">Jabón Antibacterial</span>
                <h3><?php echo esc_html($p->post_title); ?></h3>
                <p><?php echo esc_html($p->post_excerpt); ?></p>
                <a href="<?php echo get_permalink($p->ID); ?>" class="btn btn--primary">Conoce más</a>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
</section>
