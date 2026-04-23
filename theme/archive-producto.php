<?php get_header(); ?>
<main class="productos-archive productos-archive--editable">
    <?php
    $producto_destacado = venza_get_producto_destacado_home();
    if ($producto_destacado instanceof WP_Post) :
        $GLOBALS['post'] = $producto_destacado;
        setup_postdata($producto_destacado);
        ?>

        <?php get_template_part('template-parts/producto/hero'); ?>
        <?php get_template_part('template-parts/producto/home-beneficios'); ?>
        <?php get_template_part('template-parts/producto/home-descripcion'); ?>
        <?php get_template_part('template-parts/producto/home-claim'); ?>
        <?php get_template_part('template-parts/producto/disponibilidad'); ?>
        <?php get_template_part('template-parts/producto/mas-productos'); ?>

        <?php wp_reset_postdata(); ?>
    <?php else : ?>
        <section class="productos-archive__empty">
            <div class="container">
                <h1 class="section-title">Productos</h1>
                <p>No hay productos publicados todavía.</p>
            </div>
        </section>
    <?php endif; ?>
</main>
<?php get_footer(); ?>
