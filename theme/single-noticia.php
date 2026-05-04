<?php
get_header();
?>
<main class="noticias-page noticia-single-page">
    <?php if (have_posts()):
        while (have_posts()):
            the_post(); ?>
            <?php
            $intro_line = trim((string) venza_get_meta_value('noticia_intro_line'));
            if ($intro_line === '') {
                $intro_line = 'Descubre lo nuevo de Venza';
            }
            $badges = venza_get_noticia_badges(get_the_ID(), 2);
            $preview_text = venza_get_post_preview_text(get_the_ID(), 36);
            ?>
            <section class="noticia-single-page__hero">
                <div class="container">
                    <article class="noticia-single-card">
                        <div class="noticia-single-card__content">
                            <p class="noticia-single-card__kicker"><?php echo esc_html($intro_line); ?></p>
                            <h1><?php the_title(); ?></h1>
                            <?php if ($preview_text !== ''): ?>
                                <p class="noticia-single-card__excerpt"><?php echo esc_html($preview_text); ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="noticia-single-card__media">
                            <?php if (has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('large'); ?>
                            <?php else: ?>
                                <div class="noticia-single-card__placeholder"></div>
                            <?php endif; ?>

                            <?php if (!empty($badges)): ?>
                                <div class="noticia-single-card__badges">
                                    <?php foreach ($badges as $badge): ?>
                                        <?php
                                        $badge_text = isset($badge['text']) ? (string) $badge['text'] : '';
                                        $badge_icon_id = isset($badge['icon_id']) ? (int) $badge['icon_id'] : 0;
                                        $badge_position = isset($badge['position']) ? sanitize_html_class((string) $badge['position']) : 'top-right';
                                        if ($badge_text === '') {
                                            continue;
                                        }
                                        ?>
                                        <span
                                            class="noticia-single-card__badge noticia-single-card__badge--<?php echo esc_attr($badge_position); ?>">
                                            <?php if ($badge_icon_id > 0): ?>
                                                <?php
                                                $badge_icon_html = wp_get_attachment_image($badge_icon_id, 'thumbnail', false, ['class' => 'noticia-single-card__badge-icon', 'loading' => 'lazy']);
                                                if ($badge_icon_html !== '') {
                                                    echo $badge_icon_html;
                                                } elseif (!empty($badge['icon_url'])) {
                                                    echo '<img class="noticia-single-card__badge-icon" src="' . esc_url((string) $badge['icon_url']) . '" alt="" loading="lazy">';
                                                }
                                                ?>
                                            <?php elseif (!empty($badge['icon_url'])): ?>
                                                <img class="noticia-single-card__badge-icon"
                                                    src="<?php echo esc_url((string) $badge['icon_url']); ?>" alt="" loading="lazy">
                                            <?php endif; ?>
                                            <span class="noticia-single-card__badge-text"><?php echo esc_html($badge_text); ?></span>
                                        </span>
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

            <?php
            $gallery_raw = get_post_meta(get_the_ID(), '_venza_noticia_gallery_ids', true);
            $gallery_ids = $gallery_raw ? explode(',', $gallery_raw) : [];
            
            if (!empty($gallery_ids)):
                ?>
                <section class="noticia-single-page__gallery">
                    <div class="container">
                        <div class="noticia-gallery">
                            <div class="noticia-gallery__slider" id="noticia-gallery-slider">
                                <div class="noticia-gallery__viewport">
                                    <div class="noticia-gallery__track">
                                        <?php foreach ($gallery_ids as $img_id): ?>
                                            <?php 
                                            $full_url = wp_get_attachment_image_url($img_id, 'full');
                                            $thumb_url = wp_get_attachment_image_url($img_id, 'large');
                                            ?>
                                            <div class="noticia-gallery__item">
                                                <a href="<?php echo esc_url($full_url); ?>" class="noticia-gallery__link js-noticia-gallery-item">
                                                    <?php echo wp_get_attachment_image($img_id, 'large', false, ['class' => 'noticia-gallery__image', 'loading' => 'lazy']); ?>
                                                    <span class="noticia-gallery__overlay" aria-hidden="true"></span>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                
                                <?php if (count($gallery_ids) > 1): ?>
                                    <button class="noticia-gallery__arrow noticia-gallery__arrow--prev" type="button" aria-label="<?php esc_attr_e('Anterior', 'venza'); ?>"></button>
                                    <button class="noticia-gallery__arrow noticia-gallery__arrow--next" type="button" aria-label="<?php esc_attr_e('Siguiente', 'venza'); ?>"></button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
        <?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>