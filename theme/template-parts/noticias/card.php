<article class="noticia-card">
    <a href="<?php the_permalink(); ?>" class="noticia-card__link">
        <?php if (has_post_thumbnail()) : ?>
            <div class="noticia-card__image">
                <?php the_post_thumbnail('noticia-card'); ?>
            </div>
        <?php endif; ?>
        <div class="noticia-card__content">
            <?php $cat = get_the_terms(get_the_ID(), 'noticia_cat'); ?>
            <?php if ($cat) : ?>
                <span class="noticia-card__cat"><?php echo esc_html($cat[0]->name); ?></span>
            <?php endif; ?>
            <h2><?php the_title(); ?></h2>
            <p><?php the_excerpt(); ?></p>
            <span class="btn btn--primary">Conoce más</span>
        </div>
    </a>
</article>
