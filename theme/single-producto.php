<?php get_header(); ?>
<main class="producto-single">
    <?php if (have_posts()) : the_post(); ?>
        <?php get_template_part('template-parts/producto/hero'); ?>
        <?php get_template_part('template-parts/producto/beneficios-pills'); ?>
        <?php get_template_part('template-parts/producto/descripcion'); ?>
        <?php get_template_part('template-parts/producto/tamanos'); ?>
        <?php get_template_part('template-parts/producto/disponibilidad'); ?>
        <?php get_template_part('template-parts/producto/mas-productos'); ?>
    <?php endif; ?>
</main>
<?php get_footer(); ?>
