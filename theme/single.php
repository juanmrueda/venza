<?php
get_header();

$render_rich_text = static function ($text, $class = '') {
    $text = trim((string) $text);
    if ($text === '') {
        return;
    }

    $class_attr = $class !== '' ? ' class="' . esc_attr($class) . '"' : '';
    echo '<div' . $class_attr . '>' . wp_kses_post(wpautop($text)) . '</div>';
};

$get_image_id = static function ($key, $post_id, $use_thumbnail = false) {
    $value = venza_get_meta_value($key, $post_id);
    $image_id = is_numeric($value) ? (int) $value : 0;

    if ($image_id <= 0 && is_array($value) && isset($value['ID'])) {
        $image_id = (int) $value['ID'];
    }

    if ($image_id <= 0 && $use_thumbnail && has_post_thumbnail($post_id)) {
        $image_id = (int) get_post_thumbnail_id($post_id);
    }

    return $image_id;
};

$get_image_url = static function ($image_id, $size = 'full') {
    $image_id = (int) $image_id;
    if ($image_id <= 0) {
        return '';
    }

    $url = wp_get_attachment_image_url($image_id, $size);
    return is_string($url) ? $url : '';
};
?>
<main class="blog-single">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php
        $post_id = get_the_ID();
        $layout = trim((string) venza_get_meta_value('blog_layout_type', $post_id));
        if (!in_array($layout, ['type_1', 'type_2'], true)) {
            $layout = 'type_1';
        }

        $hero_image_id = $get_image_id('blog_hero_image_id', $post_id, true);
        $hero_intro = trim((string) venza_get_meta_value('blog_hero_intro', $post_id));
        if ($hero_intro === '') {
            $hero_intro = has_excerpt($post_id) ? get_the_excerpt($post_id) : venza_get_post_preview_text($post_id, 22);
        }

        $hero_body = trim((string) venza_get_meta_value('blog_hero_body', $post_id));
        if ($hero_body === '') {
            $hero_body = venza_get_post_preview_text($post_id, 34);
        }
        ?>

        <?php if ($layout === 'type_2') : ?>
            <?php
            $background_image_id = $get_image_id('blog_t2_background_image_id', $post_id);
            $background_url = $get_image_url($background_image_id, 'full');
            if ($background_url === '') {
                $background_url = VENZA_URI . '/assets/images/backgroundhome.png';
            }

            $callout = trim((string) venza_get_meta_value('blog_t2_callout', $post_id));
            if ($callout === '') {
                $callout = $hero_intro;
            }

            $video_poster_id = $get_image_id('blog_t2_video_poster_id', $post_id);
            if ($video_poster_id <= 0) {
                $video_poster_id = $hero_image_id;
            }
            $video_url = trim((string) venza_get_meta_value('blog_t2_video_url', $post_id));
            $videos_title = trim((string) venza_get_meta_value('blog_t2_videos_title', $post_id));
            if ($videos_title === '') {
                $videos_title = 'Videos Venza';
            }
            $cta_text = trim((string) venza_get_meta_value('blog_t2_cta_text', $post_id));
            if ($cta_text === '') {
                $cta_text = 'Visita nuestro canal de Youtube';
            }
            $cta_url = trim((string) venza_get_meta_value('blog_t2_cta_url', $post_id));
            if ($cta_url === '') {
                $cta_url = '#';
            }

            $fallback_video_titles = [
                'Manos limpias, piel protegida',
                'Deja que creen libremente, mientras Venza cuida su piel',
                'Tu piel tambien necesita su momento',
                'Entrena duro y limpia tu piel con jabones Venza',
            ];
            ?>
            <article class="blog-single-page blog-single-page--type2" style="<?php echo esc_attr('--blog-bg-image:url(' . esc_url($background_url) . ');'); ?>">
                <section class="blog-t2-hero">
                    <div class="container blog-t2-hero__container">
                        <h1><?php the_title(); ?></h1>
                        <?php if ($callout !== '') : ?>
                            <div class="blog-t2-hero__callout">
                                <?php echo wp_kses_post(wpautop($callout)); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>

                <section class="blog-t2-feature-video">
                    <?php if ($video_url !== '') : ?>
                        <a class="blog-t2-feature-video__link" href="<?php echo esc_url($video_url); ?>" target="_blank" rel="noopener">
                    <?php else : ?>
                        <div class="blog-t2-feature-video__link">
                    <?php endif; ?>
                        <?php if ($video_poster_id > 0) : ?>
                            <?php echo wp_get_attachment_image($video_poster_id, 'full', false, ['loading' => 'eager']); ?>
                        <?php else : ?>
                            <span class="blog-t2-feature-video__placeholder"></span>
                        <?php endif; ?>
                        <span class="blog-play blog-t2-feature-video__play" aria-hidden="true"></span>
                    <?php echo $video_url !== '' ? '</a>' : '</div>'; ?>
                </section>

                <section class="blog-t2-videos">
                    <div class="container blog-t2-videos__container">
                        <span class="blog-t2-videos__icon" aria-hidden="true"></span>
                        <h2><?php echo esc_html($videos_title); ?></h2>
                        <a class="blog-t2-videos__cta" href="<?php echo esc_url($cta_url); ?>"><?php echo esc_html($cta_text); ?></a>

                        <div class="blog-t2-video-strip">
                            <button class="blog-t2-video-strip__arrow blog-t2-video-strip__arrow--prev" type="button" aria-label="Anterior"></button>
                            <div class="blog-t2-video-strip__track">
                                <?php for ($i = 1; $i <= 4; $i++) : ?>
                                    <?php
                                    $card_image_id = $get_image_id('blog_t2_video_' . $i . '_image_id', $post_id);
                                    if ($card_image_id <= 0) {
                                        $card_image_id = $video_poster_id;
                                    }
                                    $card_title = trim((string) venza_get_meta_value('blog_t2_video_' . $i . '_title', $post_id));
                                    if ($card_title === '') {
                                        $card_title = $fallback_video_titles[$i - 1] ?? 'Video Venza';
                                    }
                                    $card_meta = trim((string) venza_get_meta_value('blog_t2_video_' . $i . '_meta', $post_id));
                                    if ($card_meta === '') {
                                        $card_meta = ($i * 42) . ' K visualizaciones - hace ' . ($i + 1) . ' semanas';
                                    }
                                    $card_duration = trim((string) venza_get_meta_value('blog_t2_video_' . $i . '_duration', $post_id));
                                    if ($card_duration === '') {
                                        $card_duration = '0:' . (34 + ($i * 5));
                                    }
                                    $card_url = trim((string) venza_get_meta_value('blog_t2_video_' . $i . '_url', $post_id));
                                    if ($card_url === '') {
                                        $card_url = $video_url !== '' ? $video_url : '#';
                                    }
                                    ?>
                                    <a class="blog-t2-video-card" href="<?php echo esc_url($card_url); ?>">
                                        <span class="blog-t2-video-card__media">
                                            <?php if ($card_image_id > 0) : ?>
                                                <?php echo wp_get_attachment_image($card_image_id, 'noticia-card', false, ['loading' => 'lazy']); ?>
                                            <?php else : ?>
                                                <span class="blog-t2-video-card__placeholder"></span>
                                            <?php endif; ?>
                                            <span class="blog-t2-video-card__duration"><?php echo esc_html($card_duration); ?></span>
                                        </span>
                                        <strong><?php echo esc_html($card_title); ?></strong>
                                        <small><?php echo esc_html($card_meta); ?></small>
                                    </a>
                                <?php endfor; ?>
                            </div>
                            <button class="blog-t2-video-strip__arrow blog-t2-video-strip__arrow--next" type="button" aria-label="Siguiente"></button>
                        </div>
                    </div>
                </section>
            </article>
        <?php else : ?>
            <?php
            $fallback_texts = [
                'Estos pequenos momentos en los que <strong>te apartas de las pantallas o tareas y le das un respiro a tu cuerpo</strong> aunque solo sean <strong>5 o 10 minutos</strong>, no son poca cosa: son justo lo que tu cerebro necesita para mantenerse activo y rendir mejor.',
                '<strong>Estirate, respira con la tecnica 4-7-8</strong> (inhala durante 4 segundos, reten el aire por 7 segundos y exhala durante 8), ve a tu tienda favorita por un cafe o un te de hierbas, o simplemente date el gusto de un dulce.',
                'En esos momentos, tu cerebro tiene la oportunidad de <strong>desconectarse, liberar tensiones y reorganizar las ideas.</strong><br>Si haces de estos pequenos descansos un habito, no solo notaras el cambio en tu tranquilidad y te sentiras mas relajado, sino que tambien aumentaras tu productividad.',
                'Asi que, la proxima vez que te sientas abrumado, haz una pausa: <strong>estirate, toma agua, respira hondo... y vuelve con mas energia para terminar tu dia con exito.</strong>',
            ];
            ?>
            <article class="blog-single-page blog-single-page--type1">
                <section class="blog-t1-hero">
                    <div class="container blog-t1-hero__container">
                        <div class="blog-t1-hero__copy">
                            <h1><?php the_title(); ?></h1>
                            <?php $render_rich_text($hero_intro, 'blog-t1-hero__intro'); ?>
                            <?php $render_rich_text($hero_body, 'blog-t1-hero__body'); ?>
                        </div>
                        <div class="blog-t1-hero__media">
                            <?php if ($hero_image_id > 0) : ?>
                                <?php echo wp_get_attachment_image($hero_image_id, 'blog-hero', false, ['loading' => 'eager']); ?>
                            <?php else : ?>
                                <span class="blog-t1-hero__placeholder"></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>

                <section class="blog-t1-blocks">
                    <div class="blog-t1-grid">
                        <?php for ($i = 1; $i <= 4; $i++) : ?>
                            <?php
                            $block_image_id = $get_image_id('blog_t1_block_' . $i . '_image_id', $post_id);
                            if ($block_image_id <= 0) {
                                $block_image_id = $hero_image_id;
                            }
                            $block_text = trim((string) venza_get_meta_value('blog_t1_block_' . $i . '_text', $post_id));
                            if ($block_text === '') {
                                $block_text = $fallback_texts[$i - 1] ?? '';
                            }
                            $block_style = trim((string) venza_get_meta_value('blog_t1_block_' . $i . '_style', $post_id));
                            if (!in_array($block_style, ['light', 'blue'], true)) {
                                $block_style = in_array($i, [1, 3], true) ? 'blue' : 'light';
                            }
                            $image_cell = '<div class="blog-t1-cell blog-t1-cell--image">';
                            if ($block_image_id > 0) {
                                $image_cell .= wp_get_attachment_image($block_image_id, 'full', false, ['loading' => 'lazy']);
                            } else {
                                $image_cell .= '<span class="blog-t1-cell__placeholder"></span>';
                            }
                            $image_cell .= '</div>';

                            $text_cell = '<div class="blog-t1-cell blog-t1-cell--text blog-t1-cell--' . esc_attr($block_style) . '">'
                                . wp_kses_post(wpautop($block_text))
                                . '</div>';
                            ?>
                            <?php
                            if ($i % 2 === 1) {
                                echo $image_cell; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                echo $text_cell; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            } else {
                                echo $text_cell; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                echo $image_cell; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            }
                            ?>
                        <?php endfor; ?>
                    </div>
                </section>
            </article>
        <?php endif; ?>
    <?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>
