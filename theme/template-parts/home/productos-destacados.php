<section class="home-productos">
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
        <article class="home-producto-row <?php echo $reverse ? 'home-producto-row--reverse' : ''; ?>">
            <div class="home-producto-row__image">
                <?php echo get_the_post_thumbnail($p->ID, 'large', ['class' => 'home-producto-row__img']); ?>
            </div>
            <div class="home-producto-row__content">
                <span class="home-producto-linea">Jabón Antibacterial</span>
                <h3 class="home-producto-nombre"><?php echo esc_html($p->post_title); ?></h3>
                <p class="home-producto-desc"><?php echo esc_html($p->post_excerpt); ?></p>
                <a href="<?php echo get_permalink($p->ID); ?>" class="btn btn--primary">Conoce más</a>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
</section>
