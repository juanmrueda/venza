<?php get_header(); ?>
<main class="productos-archive">
    <div class="container">
        <h1 class="archive-title">Productos</h1>
        <div class="productos-grid">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php get_template_part('template-parts/producto/card'); ?>
            <?php endwhile; endif; ?>
        </div>
    </div>
</main>
<?php get_footer(); ?>
