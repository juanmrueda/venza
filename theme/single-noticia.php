<?php get_header(); ?>
<main class="noticia-single">
    <div class="container">
        <?php if (have_posts()) : the_post(); ?>
            <article class="noticia-article">
                <header class="noticia-header">
                    <?php $cat = get_the_terms(get_the_ID(), 'noticia_cat'); ?>
                    <?php if ($cat) : ?>
                        <span class="noticia-cat"><?php echo esc_html($cat[0]->name); ?></span>
                    <?php endif; ?>
                    <h1><?php the_title(); ?></h1>
                </header>
                <?php if (has_post_thumbnail()) : ?>
                    <div class="noticia-featured-image">
                        <?php the_post_thumbnail('noticia-card'); ?>
                    </div>
                <?php endif; ?>
                <div class="noticia-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endif; ?>
    </div>
</main>
<?php get_footer(); ?>
