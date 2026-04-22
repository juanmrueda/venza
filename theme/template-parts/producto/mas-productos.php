<?php
$otros = venza_get_otros_productos(get_the_ID(), 6);
if (!$otros) return;
?>
<section class="mas-productos">
    <div class="container">
        <h2 class="section-title">Más productos</h2>
        <div class="mas-productos-grid">
            <?php foreach ($otros as $p) : ?>
                <article class="mas-producto-card">
                    <a href="<?php echo get_permalink($p->ID); ?>">
                        <?php echo get_the_post_thumbnail($p->ID, 'producto-thumb'); ?>
                        <h3><?php echo esc_html($p->post_title); ?></h3>
                        <span class="btn btn--outline">Conoce más</span>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
