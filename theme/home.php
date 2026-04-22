<?php get_header(); ?>
<main class="blog-archive">
    <div class="container">
        <h1 class="section-title">Blog</h1>
        <div class="blog-list">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php get_template_part('template-parts/blog/card'); ?>
            <?php endwhile; endif; ?>
        </div>
        <?php the_posts_pagination(); ?>
    </div>
</main>
<?php get_footer(); ?>
