<?php get_header(); ?>
<main class="noticias-archive">
    <?php get_template_part('template-parts/noticias/categorias-tabs'); ?>
    <div class="container noticias-grid">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <?php get_template_part('template-parts/noticias/card'); ?>
        <?php endwhile; endif; ?>
        <?php the_posts_pagination(); ?>
    </div>
</main>
<?php get_footer(); ?>
