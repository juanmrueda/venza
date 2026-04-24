<?php
get_header();
?>
<main class="noticias-page noticia-single-page">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php
        $terms = get_the_terms(get_the_ID(), 'noticia_cat');
        $category_label = (!is_wp_error($terms) && !empty($terms)) ? $terms[0]->name : 'Noticias';
        $intro_line = trim((string) venza_get_meta_value('noticia_intro_line'));
        if ($intro_line === '') {
            $intro_line = 'Descubre lo nuevo de Venza';
        }
        $badges = venza_get_noticia_badges(get_the_ID(), 4);
        $preview_text = venza_get_post_preview_text(get_the_ID(), 36);
        ?>
        <section class="noticia-single-page__hero">
            <div class="container">
                <article class="noticia-single-card">
                    <div class="noticia-single-card__content">
                        <p class="noticia-single-card__kicker"><?php echo esc_html($intro_line); ?></p>
                        <h1><?php the_title(); ?></h1>
                        <?php if ($preview_text !== '') : ?>
                            <p class="noticia-single-card__excerpt"><?php echo esc_html($preview_text); ?></p>
                        <?php endif; ?>
                        <span class="noticia-single-card__category"><?php echo esc_html($category_label); ?></span>
                    </div>

                    <div class="noticia-single-card__media">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('large'); ?>
                        <?php else : ?>
                            <div class="noticia-single-card__placeholder"></div>
                        <?php endif; ?>

                        <?php if (!empty($badges)) : ?>
                            <div class="noticia-single-card__badges">
                                <?php foreach ($badges as $badge) : ?>
                                    <span><?php echo esc_html($badge); ?></span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </article>
            </div>
        </section>

        <section class="noticia-single-page__body">
            <div class="container">
                <article class="noticia-single-body-card">
                    <?php the_content(); ?>
                </article>
            </div>
        </section>
    <?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>
