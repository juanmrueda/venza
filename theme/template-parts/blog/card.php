<article class="blog-card">
    <?php if (has_post_thumbnail()) : ?>
        <div class="blog-card__image">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('blog-card'); ?>
            </a>
        </div>
    <?php endif; ?>
    <div class="blog-card__content">
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <p><?php the_excerpt(); ?></p>
        <a href="<?php the_permalink(); ?>" class="btn btn--primary">Conoce más</a>
    </div>
</article>
