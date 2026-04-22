<?php get_header(); ?>
<main class="noticias-archive noticias-categoria">
    <?php get_template_part('template-parts/noticias/categorias-tabs'); ?>
    <div class="container">
        <h1 class="categoria-title"><?php single_term_title(); ?></h1>
        <div class="noticias-grid">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php get_template_part('template-parts/noticias/card'); ?>
            <?php endwhile; endif; ?>
            <?php the_posts_pagination(); ?>
        </div>
    </div>
</main>
<?php get_footer(); ?>
