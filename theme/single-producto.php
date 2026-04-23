<?php
get_header();
$producto_obj = get_queried_object();
$producto_slug = ($producto_obj instanceof WP_Post) ? $producto_obj->post_name : '';
?>
<main class="producto-single<?php echo $producto_slug ? ' producto-single--' . esc_attr($producto_slug) : ''; ?>">
    <?php if (have_posts()) : the_post(); ?>
        <?php if (get_post_field('post_name') === 'frescura-extrema') : ?>
            <?php get_template_part('template-parts/producto/single-frescura-extrema'); ?>
        <?php else : ?>
            <?php get_template_part('template-parts/producto/hero'); ?>
            <?php get_template_part('template-parts/producto/beneficios-pills'); ?>
            <?php get_template_part('template-parts/producto/descripcion'); ?>
            <?php get_template_part('template-parts/producto/tamanos'); ?>
        <?php endif; ?>
        <?php get_template_part('template-parts/producto/disponibilidad'); ?>
        <?php get_template_part('template-parts/producto/mas-productos'); ?>
    <?php endif; ?>
</main>
<?php get_footer(); ?>
