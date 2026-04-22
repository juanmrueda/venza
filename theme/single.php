<?php get_header(); ?>
<main class="blog-single">
    <div class="container">
        <?php if (have_posts()) : the_post(); ?>
            <article class="blog-article">
                <header class="blog-header">
                    <h1><?php the_title(); ?></h1>
                    <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date('j \d\e F, Y'); ?></time>
                </header>
                <?php if (has_post_thumbnail()) : ?>
                    <div class="blog-featured-image">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>
                <div class="blog-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endif; ?>
    </div>
</main>
<?php get_footer(); ?>
